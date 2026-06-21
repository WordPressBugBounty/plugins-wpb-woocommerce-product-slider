<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPB WooCommerce Product slider
 * By WpBean
 */



/**
 * Adding the widgets
 */

add_action('widgets_init', 'register_wpb_woo_product_slider_widget');

if (!function_exists('register_wpb_woo_product_slider_widget')) {
	function register_wpb_woo_product_slider_widget()
	{
		register_widget('wpb_woo_product_slider_Widget');
	}
}


/**
 * Products Slider Widget
 */

if (!class_exists('wpb_woo_product_slider_Widget')) {

	class wpb_woo_product_slider_Widget extends wp_widget
	{

		function __construct()
		{
			parent::__construct(
				'wpb_woo_product_slider_widget',
				esc_html__('WPB WooCommerce Product Slider', 'wpb-woocommerce-product-slider'),
				array('description' => esc_html__('Dispay WooCommerce products slider.', 'wpb-woocommerce-product-slider'),)
			);
		}

		public function form($instance)
		{
			extract($instance);
			$title 				= $title ? $title : '';
			$number_of_product 	= $number_of_product ? $number_of_product : 12;
			$product_type 		= $product_type ? $product_type : 'latest';
			$theme 				= $theme ? $theme : 'grid cs-style-3';
			$product_category 	= $product_category ? $product_category : '';
			$product_tag 		= $product_tag ? $product_tag : '';
			$product_id 		= $product_id ? $product_id : '';
			$navigation 		= $navigation ? $navigation : 'off';
			$pagination 		= $pagination ? $pagination : 'off';
			$orderby 			= $orderby ? $orderby : 'date';
			$order 				= $order ? $order : 'DESC';
?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'wpb-woocommerce-product-slider'); ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php if (isset($title)) echo esc_attr($title); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id('number_of_product')); ?>"><?php esc_html_e('Number of Products:', 'wpb-woocommerce-product-slider'); ?></label>
				<input style="max-width:30%;display:block;" class="widefat" type="number" min="1" id="<?php echo esc_attr($this->get_field_id('number_of_product')); ?>" name="<?php echo esc_attr($this->get_field_name('number_of_product')); ?>" value="<?php echo esc_attr($number_of_product); ?>" />
			</p>

			<p>
				<input class="checkbox" type="checkbox" id="<?php echo esc_attr($this->get_field_id('navigation')); ?>" name="<?php echo esc_attr($this->get_field_name('navigation')); ?>" value="on" <?php checked($navigation, 'on'); ?>>
				<label for="<?php echo esc_attr($this->get_field_id('navigation')); ?>"><?php esc_html_e('Slider Navigation. Default On.', 'wpb-woocommerce-product-slider'); ?></label>
			</p>

			<p>
				<input class="checkbox" type="checkbox" id="<?php echo esc_attr($this->get_field_id('pagination')); ?>" name="<?php echo esc_attr($this->get_field_name('pagination')); ?>" value="on" <?php checked($pagination, 'on'); ?>>
				<label for="<?php echo esc_attr($this->get_field_id('pagination')); ?>"><?php esc_html_e('Slider Pagination. Default On.', 'wpb-woocommerce-product-slider'); ?></label>
			</p>

			<p class="wpb-product-type">
				<label for="<?php echo esc_attr($this->get_field_id('product_type')); ?>"><?php esc_html_e('Product Slider Type:', 'wpb-woocommerce-product-slider'); ?></label>
				<select class="widefat" id="<?php echo esc_attr($this->get_field_id('product_type')); ?>" name="<?php echo esc_attr($this->get_field_name('product_type')); ?>">
					<option value="latest" <?php selected($product_type, 'latest'); ?>><?php esc_html_e('Latest Products', 'wpb-woocommerce-product-slider'); ?></option>
					<option value="featured" <?php selected($product_type, 'featured'); ?>><?php esc_html_e('Featured Products', 'wpb-woocommerce-product-slider'); ?></option>
					<option value="category" <?php selected($product_type, 'category'); ?>><?php esc_html_e('By Product Categories', 'wpb-woocommerce-product-slider'); ?></option>
					<option value="tags" <?php selected($product_type, 'tags'); ?>><?php esc_html_e('By Product Tags', 'wpb-woocommerce-product-slider'); ?></option>
					<option value="id" <?php selected($product_type, 'id'); ?>><?php esc_html_e('By Product IDs', 'wpb-woocommerce-product-slider'); ?></option>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id('theme')); ?>"><?php esc_html_e('Slider Theme:', 'wpb-woocommerce-product-slider'); ?></label>
				<select class="widefat" id="<?php echo esc_attr($this->get_field_id('theme')); ?>" name="<?php echo esc_attr($this->get_field_name('theme')); ?>">
					<option value="grid cs-style-3" <?php selected($theme, 'grid cs-style-3'); ?>><?php esc_html_e('Theme Hover Effect', 'wpb-woocommerce-product-slider'); ?></option>
					<option value="grid_no_animation" <?php selected($theme, 'grid_no_animation'); ?>><?php esc_html_e('Theme Box', 'wpb-woocommerce-product-slider'); ?></option>
				</select>
			</p>

			<p class="wpb-product-category wpb-variable-field">
				<label for="<?php echo esc_attr($this->get_field_id('product_category')); ?>"><?php esc_html_e('Product Categories:', 'wpb-woocommerce-product-slider'); ?></label>
				<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('product_category')); ?>" name="<?php echo esc_attr($this->get_field_name('product_category')); ?>" value="<?php echo esc_attr($product_category); ?>" />
				<span class="wpb_widget_help"><?php esc_html_e('Comma separated product category ids.', 'wpb-woocommerce-product-slider'); ?></span>
			</p>

			<p class="wpb-product-tags wpb-variable-field">
				<label for="<?php echo esc_attr($this->get_field_id('product_tag')); ?>"><?php esc_html_e('Product Tags:', 'wpb-woocommerce-product-slider'); ?></label>
				<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('product_tag')); ?>" name="<?php echo esc_attr($this->get_field_name('product_tag')); ?>" value="<?php echo esc_attr($product_tag); ?>" />
				<span class="wpb_widget_help"><?php esc_html_e('Comma separated product tag ids.', 'wpb-woocommerce-product-slider'); ?></span>
			</p>

			<p class="wpb-product-id wpb-variable-field">
				<label for="<?php echo esc_attr($this->get_field_id('product_id')); ?>"><?php esc_html_e('Product IDs:', 'wpb-woocommerce-product-slider'); ?></label>
				<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('product_id')); ?>" name="<?php echo esc_attr($this->get_field_name('product_id')); ?>" value="<?php echo esc_attr($product_id); ?>" />
				<span class="wpb_widget_help"><?php esc_html_e('Comma separated product ID\'s.', 'wpb-woocommerce-product-slider'); ?></span>
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id('orderby')); ?>"><?php esc_html_e('Products Orderby:', 'wpb-woocommerce-product-slider'); ?></label>
				<select class="widefat" id="<?php echo esc_attr($this->get_field_id('orderby')); ?>" name="<?php echo esc_attr($this->get_field_name('orderby')); ?>">
					<option value="none" <?php selected($orderby, 'none') ?>><?php esc_html_e('None', 'wpb-woocommerce-product-slider'); ?></option>
					<option value="ID" <?php selected($orderby, 'ID') ?>><?php esc_html_e('ID', 'wpb-woocommerce-product-slider'); ?></option>
					<option value="author" <?php selected($orderby, 'author') ?>><?php esc_html_e('Author', 'wpb-woocommerce-product-slider'); ?></option>
					<option value="title" <?php selected($orderby, 'title') ?>><?php esc_html_e('Title', 'wpb-woocommerce-product-slider'); ?></option>
					<option value="name" <?php selected($orderby, 'name') ?>><?php esc_html_e('Name', 'wpb-woocommerce-product-slider'); ?></option>
					<option value="date" <?php selected($orderby, 'date') ?>><?php esc_html_e('Date', 'wpb-woocommerce-product-slider'); ?></option>
					<option value="rand" <?php selected($orderby, 'rand') ?>><?php esc_html_e('Rand', 'wpb-woocommerce-product-slider'); ?></option>
					<option value="menu_order" <?php selected($orderby, 'menu_order') ?>><?php esc_html_e('Menu order', 'wpb-woocommerce-product-slider'); ?></option>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id('order')); ?>"><?php esc_html_e('Products order:', 'wpb-woocommerce-product-slider'); ?></label>
				<select class="widefat" id="<?php echo esc_attr($this->get_field_id('order')); ?>" name="<?php echo esc_attr($this->get_field_name('order')); ?>">
					<option value="ASC" <?php selected($order, 'ASC') ?>><?php esc_html_e('Ascending', 'wpb-woocommerce-product-slider'); ?></option>
					<option value="DESC" <?php selected($order, 'DESC') ?>><?php esc_html_e('Descending', 'wpb-woocommerce-product-slider'); ?></option>
				</select>
			</p>
<?php
		}


		public function widget($args, $instance)
		{

			extract($args);
			extract($instance);

			echo $before_widget; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $before_title . esc_html($title) . $after_title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo do_shortcode('[wpb-product-slider items="1" items_desktop_small="1" items_tablet="1" items_mobile="1" posts="' . $number_of_product . '" product_type="' . $product_type . '" theme="' . $theme . '" category="' . $product_category . '" tags="' . $product_tag . '" id="' . $product_id . '" nav="' . ($navigation == 'on' ? 'true' : 'false') . '" pagination="' . ($pagination == 'on' ? 'true' : 'false') . '"]'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $after_widget; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update($new_instance, $old_instance)
		{
			$instance = array();
			$instance['title'] 	= (! empty($new_instance['title'])) ? wp_strip_all_tags($new_instance['title']) : '';
			$instance['number_of_product'] 	= (! empty($new_instance['number_of_product'])) ? wp_strip_all_tags($new_instance['number_of_product']) : '';
			$instance['navigation'] 		= (! empty($new_instance['navigation'])) ? wp_strip_all_tags($new_instance['navigation']) : 'off';
			$instance['pagination'] 		= (! empty($new_instance['pagination'])) ? wp_strip_all_tags($new_instance['pagination']) : 'off';
			$instance['product_type'] 		= (! empty($new_instance['product_type'])) ? wp_strip_all_tags($new_instance['product_type']) : 'latest';
			$instance['theme'] 		= (! empty($new_instance['theme'])) ? wp_strip_all_tags($new_instance['theme']) : 'grid cs-style-3';
			$instance['product_category'] 		= (! empty($new_instance['product_category'])) ? wp_strip_all_tags($new_instance['product_category']) : '';
			$instance['product_tag'] 		= (! empty($new_instance['product_tag'])) ? wp_strip_all_tags($new_instance['product_tag']) : '';
			$instance['product_id'] 		= (! empty($new_instance['product_id'])) ? wp_strip_all_tags($new_instance['product_id']) : '';
			$instance['orderby'] 		= (! empty($new_instance['orderby'])) ? wp_strip_all_tags($new_instance['orderby']) : 'date';
			$instance['order'] 		= (! empty($new_instance['order'])) ? wp_strip_all_tags($new_instance['order']) : 'DESC';

			return $instance;
		}
	}
}
