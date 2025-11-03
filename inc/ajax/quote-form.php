<?php
/**
 * AJAX Quote Form Handler
 * 
 * @package Eghbal_Steel_Theme
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle Quote Request Form
 */
function eghbal_handle_quote_request() {
    // Check nonce
    check_ajax_referer('quote_request_nonce', 'quote_nonce');
    
    // Sanitize inputs
    $customer_name = sanitize_text_field($_POST['customer_name']);
    $customer_phone = sanitize_text_field($_POST['customer_phone']);
    $customer_email = sanitize_email($_POST['customer_email']);
    $required_quantity = sanitize_text_field($_POST['required_quantity']);
    $required_size = sanitize_text_field($_POST['required_size']);
    $message = sanitize_textarea_field($_POST['message']);
    $alloy_code = sanitize_text_field($_POST['alloy_code']);
    $alloy_name = sanitize_text_field($_POST['alloy_name']);
    
    // Validate required fields
    if (empty($customer_name) || empty($customer_phone)) {
        wp_send_json_error(array(
            'message' => 'لطفاً فیلدهای الزامی را پر کنید'
        ));
    }
    
    // Prepare email content
    $to = get_option('admin_email'); // یا ایمیل دلخواه
    $subject = 'درخواست قیمت جدید: ' . $alloy_name;
    
    $body = "درخواست قیمت جدید دریافت شد:\n\n";
    $body .= "آلیاژ: {$alloy_name} ({$alloy_code})\n\n";
    $body .= "نام مشتری: {$customer_name}\n";
    $body .= "شماره تماس: {$customer_phone}\n";
    $body .= "ایمیل: {$customer_email}\n";
    $body .= "مقدار مورد نیاز: {$required_quantity}\n";
    $body .= "سایز/شکل: {$required_size}\n";
    $body .= "توضیحات: {$message}\n\n";
    $body .= "تاریخ: " . current_time('Y-m-d H:i:s') . "\n";
    $body .= "IP: " . $_SERVER['REMOTE_ADDR'];
    
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <noreply@' . $_SERVER['HTTP_HOST'] . '>'
    );
    
    // Send email
    $mail_sent = wp_mail($to, $subject, $body, $headers);
    
    // Save to database (optional)
    global $wpdb;
    $table_name = $wpdb->prefix . 'quote_requests';
    
    // Insert record
    $wpdb->insert(
        $table_name,
        array(
            'customer_name' => $customer_name,
            'customer_phone' => $customer_phone,
            'customer_email' => $customer_email,
            'alloy_code' => $alloy_code,
            'alloy_name' => $alloy_name,
            'required_quantity' => $required_quantity,
            'required_size' => $required_size,
            'message' => $message,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
        ),
        array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
    );
    
    if ($mail_sent || $wpdb->insert_id) {
        wp_send_json_success(array(
            'message' => 'درخواست شما با موفقیت ارسال شد'
        ));
    } else {
        wp_send_json_error(array(
            'message' => 'خطا در ارسال درخواست'
        ));
    }
}

add_action('wp_ajax_submit_quote_request', 'eghbal_handle_quote_request');
add_action('wp_ajax_nopriv_submit_quote_request', 'eghbal_handle_quote_request');

/**
 * Create DB table for quote requests on theme switch (single-time)
 */
function eghbal_quote_requests_create_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'quote_requests';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        customer_name varchar(255) NOT NULL,
        customer_phone varchar(20) NOT NULL,
        customer_email varchar(255),
        alloy_code varchar(50),
        alloy_name varchar(255),
        required_quantity varchar(100),
        required_size varchar(100),
        message text,
        ip_address varchar(45),
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
add_action('after_switch_theme', 'eghbal_quote_requests_create_table');
