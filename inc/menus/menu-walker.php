<?php
/**
 * Menu Walker
 * 
 * Custom Walker for 3-level menu display
 * 
 * @package D_Theme
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

/**
 * Custom Walker for desktop menu (3 levels)
 */
class D_Theme_Menu_Walker extends Walker_Nav_Menu {
    
    /**
     * شروع سطح منو
     */
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        
        if ($depth === 0) {
            $output .= "\n$indent<ul class=\"submenu\">\n";
        } elseif ($depth === 1) {
            $output .= "\n$indent<ul class=\"submenu-level-2\">\n";
        } elseif ($depth === 2) {
            $output .= "\n$indent<ul class=\"submenu-level-3\">\n";
        }
    }
    
    /**
     * پایان سطح منو
     */
    public function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
    
    /**
     * Start menu item
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        if (!isset($item) || !is_object($item)) {
            return;
        }
        
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        // Item classes
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        
        // Add class based on depth
        if ($depth === 0) {
            $classes[] = 'nav-item';
        } elseif ($depth === 1) {
            $classes[] = 'submenu-item';
        } elseif ($depth === 2) {
            $classes[] = 'submenu-item';
        }
        
        // If item has submenu
        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'has-submenu';
        }
        
        // Active class for current page
        if (in_array('current-menu-item', $classes) || in_array('current-page-ancestor', $classes)) {
            $classes[] = 'active';
        }
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $output .= $indent . '<li' . $class_names . '>';
        
        // Item link
        $atts = array();
        $atts['title'] = !empty($item->attr_title) ? esc_attr($item->attr_title) : '';
        $atts['target'] = !empty($item->target) ? esc_attr($item->target) : '';
        $atts['rel'] = !empty($item->xfn) ? esc_attr($item->xfn) : '';
        $atts['href'] = !empty($item->url) ? esc_url($item->url) : '#';
        
        // Link class based on depth
        if ($depth === 0) {
            $atts['class'] = 'nav-link';
        } elseif ($depth >= 1) {
            $atts['class'] = 'submenu-link';
        }
        
        // Add aria-current for current page
        if (in_array('current-menu-item', $classes)) {
            $atts['aria-current'] = 'page';
        }
        
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
        
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        
        // Use item title directly to avoid N+1 query issue
        // Only apply nav_menu_item_title filter which is menu-specific
        $title = apply_filters('nav_menu_item_title', $item->title, $item, $args, $depth);
        
        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= (isset($args->link_before) ? $args->link_before : '') . $title . (isset($args->link_after) ? $args->link_after : '');
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

/**
 * Custom Walker برای منوی موبایل
 */
class D_Theme_Mobile_Menu_Walker extends Walker_Nav_Menu {
    
    /**
     * شروع سطح منو
     */
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);

        if ($depth === 0) {
            $output .= "\n$indent<div class=\"mobile-submenu\">\n";
        } elseif ($depth === 1) {
            $output .= "\n$indent<div class=\"mobile-submenu-level-2\">\n";
        } elseif ($depth === 2) {
            $output .= "\n$indent<div class=\"mobile-submenu-level-3\">\n";
        }
    }

    /**
     * پایان سطح منو
     */
    public function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</div>\n";
    }
    
    /**
     * شروع آیتم منو
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;

        // اضافه کردن کلاس بر اساس سطح
        if ($depth === 0) {
            $classes[] = 'mobile-menu-item';
        } elseif ($depth === 1) {
            $classes[] = 'mobile-submenu-item';
        } elseif ($depth === 2) {
            $classes[] = 'mobile-submenu-level-2-item';
        } elseif ($depth === 3) {
            $classes[] = 'mobile-submenu-level-3-item';
        }

        $has_children = in_array('menu-item-has-children', $classes);

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= $indent . '<div' . $class_names . '>';

        // Get title once to avoid multiple filter calls
        $title = apply_filters('nav_menu_item_title', $item->title, $item, $args, $depth);
        
        // Link or button (if has submenu)
        if ($has_children && $depth === 0) {
            $output .= '<div class="mobile-menu-link">';
            $output .= '<span>' . esc_html($title) . '</span>';
            $output .= '<span class="mobile-menu-icon" aria-hidden="true">◀</span>';
            $output .= '</div>';
        } elseif ($has_children && $depth === 1) {
            $output .= '<div class="mobile-submenu-link">';
            $output .= '<span>' . esc_html($title) . '</span>';
            $output .= '<span class="mobile-menu-icon" aria-hidden="true">◀</span>';
            $output .= '</div>';
        } elseif ($has_children && $depth === 2) {
            $output .= '<div class="mobile-submenu-level-2-link">';
            $output .= '<span>' . esc_html($title) . '</span>';
            $output .= '<span class="mobile-menu-icon" aria-hidden="true">◀</span>';
            $output .= '</div>';
        } else {
            // Link without submenu
            if ($depth === 0) {
                $link_class = 'mobile-menu-link';
            } elseif ($depth === 1) {
                $link_class = 'mobile-submenu-link';
            } elseif ($depth === 2) {
                $link_class = 'mobile-submenu-level-2-link';
            } else {
                $link_class = 'mobile-submenu-level-3-link';
            }

            // Attributes
            $atts = array(
                'href' => !empty($item->url) ? esc_url($item->url) : '#',
                'class' => $link_class,
                'title' => !empty($item->attr_title) ? esc_attr($item->attr_title) : '',
                'target' => !empty($item->target) ? esc_attr($item->target) : '',
                'rel' => !empty($item->xfn) ? esc_attr($item->xfn) : ''
            );

            // aria-current for current page
            if (in_array('current-menu-item', $classes)) {
                $atts['aria-current'] = 'page';
            }

            $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

            $attributes = '';
            foreach ($atts as $attr => $value) {
                if (!empty($value)) {
                    $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            // Title already retrieved above, reuse it
            $output .= '<a' . $attributes . '>';

            if ($depth >= 3) {
                $output .= esc_html($title);
            } else {
                $output .= '<span>' . esc_html($title) . '</span>';
            }

            $output .= '</a>';
        }
    }
    
    /**
     * پایان آیتم منو
     */
    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</div>\n";
    }
}
