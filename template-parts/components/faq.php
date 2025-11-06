<?php
/**
 * Template Part: FAQ Section
 * 
 * بخش سوالات متداول با Schema FAQPage
 * 
 * @package D_Theme
 * @version 1.0.0
 */

global $post;

if (!$post) {
    return;
}

$faqs = get_post_meta($post->ID, 'd_theme_faq_items', true);

if (empty($faqs) || !is_array($faqs)) {
    return;
}

// Schema data برای JSON-LD
$schema_data = array(
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => array(),
);

?>
<section class="faq-section" id="faq-section" aria-label="سوالات متداول">
    <div class="faq-container">
        <h2 class="faq-title">سوالات متداول</h2>
        
        <div class="faq-list" role="list">
            <?php foreach ($faqs as $index => $faq) : 
                $question = esc_html($faq['question']);
                $answer = wp_kses_post($faq['answer']);
                $faq_id = 'faq-' . $post->ID . '-' . $index;
                
                // اضافه کردن به schema
                $schema_data['mainEntity'][] = array(
                    '@type' => 'Question',
                    'name' => $question,
                    'acceptedAnswer' => array(
                        '@type' => 'Answer',
                        'text' => wp_strip_all_tags($answer),
                    ),
                );
            ?>
                <div class="faq-item" role="listitem">
                    <button 
                        class="faq-question" 
                        id="<?php echo esc_attr($faq_id); ?>-question"
                        aria-expanded="false"
                        aria-controls="<?php echo esc_attr($faq_id); ?>-answer"
                        type="button"
                    >
                        <span class="faq-question-text"><?php echo $question; ?></span>
                        <span class="faq-icon" aria-hidden="true">▼</span>
                    </button>
                    <div 
                        class="faq-answer" 
                        id="<?php echo esc_attr($faq_id); ?>-answer"
                        aria-labelledby="<?php echo esc_attr($faq_id); ?>-question"
                        role="region"
                    >
                        <div class="faq-answer-content">
                            <?php echo $answer; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php
// خروجی Schema JSON-LD
if (!empty($schema_data['mainEntity'])) {
    echo '<script type="application/ld+json">' . wp_json_encode($schema_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}
?>

