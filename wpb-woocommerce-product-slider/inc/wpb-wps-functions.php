<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPB WooCommerce Product slider
 * By WpBean
 */



/**
 * Getting settings
 */

if (!function_exists('wpb_wps_get_option')) {
	function wpb_wps_get_option($option, $section, $default = '')
	{

		$options = get_option($section);

		if (isset($options[$option])) {
			return $options[$option];
		}

		return $default;
	}
}


/**
 * Text Widget Shortcode Support
 */

add_filter('widget_text', 'do_shortcode');


/**
 * Cart Button
 */


if (!function_exists('wpb_wps_cart_button')) {
	function wpb_wps_cart_button()
	{
		echo '<div class="wpb_cart_button">';
		woocommerce_template_loop_add_to_cart();
		echo '</div>';
	}
}

/**
 * Settings Dynamic Style
 */

if (!function_exists('wpb_wps_adding_dynamic_styles')):
	function wpb_wps_adding_dynamic_styles()
	{

		$wpb_wps_primary_color 			= wpb_wps_get_option('wpb_wps_primary_color', 'wpb_wps_style', '#1abc9c');
		$wpb_wps_primary_color_dark 	= wpb_wps_get_option('wpb_wps_primary_color_dark', 'wpb_wps_style', '#16a085');
		$wpb_wps_secondary_color 		= wpb_wps_get_option('wpb_wps_secondary_color', 'wpb_wps_style', '#999999');
		$wpb_wps_secondary_color_light 	= wpb_wps_get_option('wpb_wps_secondary_color_light', 'wpb_wps_style', '#cccccc');

		$custom_css = 	".wpb-woo-products-slider figcaption a.button,
		.wpb-woo-products-slider.owl-theme .owl-dots .owl-dot.active span,
		.wpb-woo-products-slider figure .stock,
		.wpb-woo-products-slider.woocommerce .wpb-wps-slider-item span.onsale,
		.wpb-woo-products-slider.owl-theme .owl-dots .owl-dot:hover span {
			background:  $wpb_wps_primary_color
		}";

		$custom_css .= 	".grid_no_animation .pro_price_area {
			color:  $wpb_wps_primary_color
		}";

		$custom_css .= 	".wpb-woo-products-slider figcaption a.button:hover {
			background:  $wpb_wps_primary_color_dark
		}";

		$custom_css .= 	".wpb-woo-products-slider.owl-theme .owl-dots .owl-dot span,
		.wpb-woo-products-slider.owl-theme .owl-nav [class*=owl-] {
			background:  $wpb_wps_secondary_color_light
		}";

		$custom_css .= 	".wpb-woo-products-slider.owl-theme .owl-nav [class*=owl-]:hover, .wpb-woo-products-slider.owl-theme .owl-nav [class*=owl-]:focus {
			background:  $wpb_wps_secondary_color
		}";



		wp_add_inline_style('wpb_wps_main_style', $custom_css);
	}
endif;
add_action('wp_enqueue_scripts', 'wpb_wps_adding_dynamic_styles');


/**
 * Data attribute Array to data types
 */

if (!function_exists('wpb_wps_data_attributes')) {
	function wpb_wps_data_attributes($array)
	{
		if (!empty($array)) {
			foreach ($array as $key => $value) {
				echo 'data-' . esc_attr($key) . '="' . esc_attr($value) . '" ';
			}
		}
	}
}

/**
 * Show review
 */

if (!function_exists('wpb_wps_show_product_review')) {
	function wpb_wps_show_product_review()
	{
		global $woocommerce, $product;

		if ($woocommerce->version >= '3.0') {
			if (wc_get_rating_html($product->get_average_rating()) && get_option('woocommerce_enable_review_rating') == 'yes') {
				echo wp_kses_post(wc_get_rating_html($product->get_average_rating()));
			}
		} else {
			if ($product->get_rating_html() && get_option('woocommerce_enable_review_rating') == 'yes') {
				echo wp_kses_post($product->get_rating_html());
			}
		}
	}
}


/**
 * bottom left admin text
 */

if (!function_exists('wpb_wps_wp_admin_bottom_left_text')) {
	function wpb_wps_wp_admin_bottom_left_text($text)
	{
		$screen = get_current_screen();

		if ($screen->base == 'toplevel_page_wpb-wps-about' || $screen->base == 'woo-slider_page_wpb-wps-settings') {
			$text = 'If you like <strong>WPB WooCommerce Products Slider</strong> please leave us a <a href="https://wordpress.org/support/plugin/wpb-woocommerce-product-slider/reviews?rate=5#new-post" target="_blank" class="wpb-wcs-rating-link" data-rated="Thanks :)">★★★★★</a> rating. A huge thanks in advance!';
		}

		return $text;
	}
}
add_filter('admin_footer_text', 'wpb_wps_wp_admin_bottom_left_text');
