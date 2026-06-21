<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPB WooCommerce Products Slider Plugin
 *
 * Template file for the Documentation admin page.
 *
 * Author: WPBean
 */

?>
<div class="wrap wpb_wps_settings">
	<div class="wpb-wps-page-header">
		<div class="wpb-wps-header-brand">
			<div class="wpb-wps-header-icon">
				<span class="dashicons dashicons-format-chat"></span>
			</div>
			<div class="wpb-wps-header-info">
				<h1><?php esc_html_e('WPB WooCommerce Products Slider', 'wpb-woocommerce-product-slider'); ?></h1>
				<div class="wpb-wps-header-meta">
					<span class="wpb-wps-plan-badge"><?php esc_html_e('FREE PLAN', 'wpb-woocommerce-product-slider'); ?></span>
					<span class="wpb-wps-version">v<?php echo esc_html(WPB_WPS_FREE_VERSION); ?></span>
					<a href="https://docs.wpbean.com/docs/wpb-woocommerce-products-slider-free-version/" target="_blank" class="wpb-wps-header-docs-link"><?php esc_html_e('Documentation', 'wpb-woocommerce-product-slider'); ?></a>
					<a href="<?php echo esc_url($this->support_url); ?>" target="_blank" class="wpb-wps-header-docs-link"><?php esc_html_e('Support', 'wpb-woocommerce-product-slider'); ?></a>
				</div>
			</div>
		</div>
		<a href="<?php echo esc_url($this->pro_url); ?>" target="_blank" class="wpb-wps-header-upgrade-btn">
			<span class="dashicons dashicons-star-filled"></span>
			<?php esc_html_e('Upgrade to Pro', 'wpb-woocommerce-product-slider'); ?>
		</a>
	</div>
	<hr class="wp-header-end">
	<div class="wpb-wps-layout-row">
		<div class="wpb-wps-col-main">
			<h2 class="nav-tab-wrapper">
				<a href="#wpb_wps_how_top_use" class="nav-tab" id="wpb_wps_how_top_use-tab"><?php esc_html_e('How to Use', 'wpb-woocommerce-product-slider'); ?></a>
				<a href="#wpb_wps_shortcode" class="nav-tab" id="wpb_wps_shortcode-tab"><?php esc_html_e('Shortcodes', 'wpb-woocommerce-product-slider'); ?></a>
				<a href="#wpb_wps_shortcode_parameters" class="nav-tab" id="wpb_wps_shortcode_parameters-tab"><?php esc_html_e('Shortcode Parameters', 'wpb-woocommerce-product-slider'); ?></a>
			</h2>

			<div class="metabox-holder">

				<!-- How to Use -->
				<div id="wpb_wps_how_top_use" class="group" style="display:none;">
					<form>
						<h2><?php esc_html_e('How to Use', 'wpb-woocommerce-product-slider'); ?></h2>
						<table class="form-table">
							<tbody>
								<tr>
									<th>
										<span class="wpb-wps-step-badge">1</span>
										<?php esc_html_e('Install the Plugin', 'wpb-woocommerce-product-slider'); ?>
									</th>
									<td>
										<strong><?php esc_html_e('Upload and activate the plugin.', 'wpb-woocommerce-product-slider'); ?></strong>
										<p class="description"><?php esc_html_e('Go to WordPress Dashboard → Plugins → Add New → Upload Plugin, then select the plugin ZIP file, install and activate it.', 'wpb-woocommerce-product-slider'); ?></p>
									</td>
								</tr>
								<tr>
									<th>
										<span class="wpb-wps-step-badge">2</span>
										<?php esc_html_e('Ensure WooCommerce is Active', 'wpb-woocommerce-product-slider'); ?>
									</th>
									<td>
										<strong><?php esc_html_e('This plugin requires WooCommerce.', 'wpb-woocommerce-product-slider'); ?></strong>
										<p class="description"><?php esc_html_e('Make sure WooCommerce is installed and activated before using this plugin. Without it, the product slider will not display any products.', 'wpb-woocommerce-product-slider'); ?></p>
									</td>
								</tr>
								<tr>
									<th>
										<span class="wpb-wps-step-badge">3</span>
										<?php esc_html_e('Configure the Settings', 'wpb-woocommerce-product-slider'); ?>
									</th>
									<td>
										<strong><?php esc_html_e('Adjust the slider to your preferences.', 'wpb-woocommerce-product-slider'); ?></strong>
										<p class="description"><?php esc_html_e('Visit Products Slider → Settings to configure the number of products, product type, ordering, colours, slider behaviour, and more.', 'wpb-woocommerce-product-slider'); ?></p>
									</td>
								</tr>
								<tr>
									<th>
										<span class="wpb-wps-step-badge">4</span>
										<?php esc_html_e('Add the Shortcode', 'wpb-woocommerce-product-slider'); ?>
									</th>
									<td>
										<strong><?php esc_html_e('Place the shortcode on any page or post.', 'wpb-woocommerce-product-slider'); ?></strong>
										<p class="description"><?php esc_html_e('Copy the shortcode from the Shortcodes tab and paste it into any page, post, or widget area where you want the product slider to appear.', 'wpb-woocommerce-product-slider'); ?></p>
										<div class="wpb-wps-shortcode-wrap" style="margin-top:10px;">
											<input type="text" readonly class="wpb-wps-shortcode-input" value='[wpb-product-slider posts="12"]'>
											<button type="button" class="wpb-wps-copy-btn" data-clipboard='[wpb-product-slider posts="12"]'>
												<span class="dashicons dashicons-clipboard"></span>
												<span class="wpb-wps-copy-label"><?php esc_html_e('Copy', 'wpb-woocommerce-product-slider'); ?></span>
											</button>
										</div>
									</td>
								</tr>
								<tr>
									<th>
										<span class="wpb-wps-step-badge">5</span>
										<?php esc_html_e('Customise via Shortcode Parameters', 'wpb-woocommerce-product-slider'); ?>
									</th>
									<td>
										<strong><?php esc_html_e('Override any setting directly in the shortcode.', 'wpb-woocommerce-product-slider'); ?></strong>
										<p class="description"><?php esc_html_e('Every setting has a corresponding shortcode parameter, letting you create multiple sliders with different configurations on the same page. See the Shortcode Parameters tab for a full reference.', 'wpb-woocommerce-product-slider'); ?></p>
									</td>
								</tr>
							</tbody>
						</table>
					</form>
				</div>

				<!-- Shortcodes -->
				<div id="wpb_wps_shortcode" class="group" style="display:none;">
					<form>
						<h2><?php esc_html_e('Shortcodes', 'wpb-woocommerce-product-slider'); ?></h2>
						<table class="form-table">
							<tbody>
								<?php
								$shortcodes = array(
									array(
										'label' => __('Basic Use', 'wpb-woocommerce-product-slider'),
										'code'  => '[wpb-product-slider posts="12"]',
										'desc'  => __('Shows the latest 12 products in a slider.', 'wpb-woocommerce-product-slider'),
									),
									array(
										'label' => __('Featured Products', 'wpb-woocommerce-product-slider'),
										'code'  => '[wpb-product-slider product_type="featured"]',
										'desc'  => '',
									),
									array(
										'label' => __('Category Products', 'wpb-woocommerce-product-slider'),
										'code'  => '[wpb-product-slider product_type="category" category="22,26,33,37"]',
										'desc'  => __('Add comma-separated product category IDs in the category parameter.', 'wpb-woocommerce-product-slider'),
									),
									array(
										'label' => __('Tag Products', 'wpb-woocommerce-product-slider'),
										'code'  => '[wpb-product-slider product_type="tags" tags="22,26,33,37"]',
										'desc'  => __('Add comma-separated product tag IDs in the tags parameter.', 'wpb-woocommerce-product-slider'),
									),
									array(
										'label' => __('Products by ID', 'wpb-woocommerce-product-slider'),
										'code'  => '[wpb-product-slider product_type="id" id="22,26,33,37"]',
										'desc'  => __('Add comma-separated product IDs in the id parameter.', 'wpb-woocommerce-product-slider'),
									),
									array(
										'label' => __('Change Theme', 'wpb-woocommerce-product-slider'),
										'code'  => '[wpb-product-slider theme="grid_no_animation"]',
										'desc'  => __('Accepted values: hover_effect, grid_no_animation.', 'wpb-woocommerce-product-slider'),
									),
									array(
										'label' => __('Order &amp; Orderby', 'wpb-woocommerce-product-slider'),
										'code'  => '[wpb-product-slider orderby="date" order="DESC"]',
										'desc'  => '',
									),
									array(
										'label' => __('Slider Options', 'wpb-woocommerce-product-slider'),
										'code'  => '[wpb-product-slider autoplay="true" loop="true" nav="true" pagination="false"]',
										'desc'  => '',
									),
									array(
										'label' => __('Responsive Columns', 'wpb-woocommerce-product-slider'),
										'code'  => '[wpb-product-slider items="4" items_desktop_small="3" items_tablet="2" items_mobile="1"]',
										'desc'  => '',
									),
								);
								foreach ($shortcodes as $shortcode) :
								?>
									<tr>
										<th><?php echo esc_html($shortcode['label']); ?></th>
										<td>
											<div class="wpb-wps-shortcode-wrap">
												<input type="text" readonly class="wpb-wps-shortcode-input" value="<?php echo esc_attr($shortcode['code']); ?>">
												<button type="button" class="wpb-wps-copy-btn" data-clipboard="<?php echo esc_attr($shortcode['code']); ?>">
													<span class="dashicons dashicons-clipboard"></span>
													<span class="wpb-wps-copy-label"><?php esc_html_e('Copy', 'wpb-woocommerce-product-slider'); ?></span>
												</button>
											</div>
											<?php if ($shortcode['desc']) : ?>
												<p class="description"><?php echo esc_html($shortcode['desc']); ?></p>
											<?php endif; ?>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</form>
				</div>

				<!-- Shortcode Parameters -->
				<div id="wpb_wps_shortcode_parameters" class="group" style="display:none;">
					<form>
						<h2><?php esc_html_e('Shortcode Parameters', 'wpb-woocommerce-product-slider'); ?></h2>
						<table class="form-table">
							<tbody>
								<tr>
									<th>title</th>
									<td><?php esc_html_e('Slider title. Accepted value: any text.', 'wpb-woocommerce-product-slider'); ?></td>
								</tr>
								<tr>
									<th>posts</th>
									<td><?php esc_html_e('Number of products to show. Default: 12.', 'wpb-woocommerce-product-slider'); ?></td>
								</tr>
								<tr>
									<th>product_type</th>
									<td><?php esc_html_e('Accepted values: latest, featured, category, tags, id. Default: latest.', 'wpb-woocommerce-product-slider'); ?></td>
								</tr>
								<tr>
									<th>theme</th>
									<td><?php esc_html_e('Accepted values: hover_effect, grid_no_animation. Default: hover_effect.', 'wpb-woocommerce-product-slider'); ?></td>
								</tr>
								<tr>
									<th>show_reviews</th>
									<td><?php esc_html_e('Show product rating. Accepted values: on, off. Default: off.', 'wpb-woocommerce-product-slider'); ?></td>
								</tr>
								<tr>
									<th>show_price</th>
									<td><?php esc_html_e('Show product price. Accepted values: on, off. Default: on.', 'wpb-woocommerce-product-slider'); ?></td>
								</tr>
								<tr>
									<th>show_cart</th>
									<td><?php esc_html_e('Show add to cart button. Accepted values: on, off. Default: on.', 'wpb-woocommerce-product-slider'); ?></td>
								</tr>
								<tr>
									<th>orderby</th>
									<td><?php esc_html_e('Accepted values: none, ID, author, title, name, date, modified, rand, menu_order. Default: date.', 'wpb-woocommerce-product-slider'); ?></td>
								</tr>
								<tr>
									<th>order</th>
									<td><?php esc_html_e('Accepted values: ASC, DESC. Default: DESC.', 'wpb-woocommerce-product-slider'); ?></td>
								</tr>
								<tr>
									<th>autoplay</th>
									<td><?php esc_html_e('Accepted values: true, false. Default: true.', 'wpb-woocommerce-product-slider'); ?></td>
								</tr>
								<tr>
									<th>loop</th>
									<td><?php esc_html_e('Accepted values: true, false. Default: true.', 'wpb-woocommerce-product-slider'); ?></td>
								</tr>
								<tr>
									<th>nav</th>
									<td><?php esc_html_e('Show navigation arrows. Accepted values: true, false. Default: true.', 'wpb-woocommerce-product-slider'); ?></td>
								</tr>
								<tr>
									<th>slideby</th>
									<td><?php esc_html_e('Items to slide per click. Use "page" to slide by page. Default: 1.', 'wpb-woocommerce-product-slider'); ?></td>
								</tr>
								<tr>
									<th>pagination</th>
									<td><?php esc_html_e('Show pagination dots. Accepted values: true, false. Default: false.', 'wpb-woocommerce-product-slider'); ?></td>
								</tr>
								<tr>
									<th>pagination_number</th>
									<td><?php esc_html_e('Show pagination numbers. Accepted values: true, false. Default: false.', 'wpb-woocommerce-product-slider'); ?></td>
								</tr>
								<tr>
									<th>items</th>
									<td><?php esc_html_e('Columns on large screens. Default: 4.', 'wpb-woocommerce-product-slider'); ?></td>
								</tr>
								<tr>
									<th>items_desktop_small</th>
									<td><?php esc_html_e('Columns on small desktop. Default: 3.', 'wpb-woocommerce-product-slider'); ?></td>
								</tr>
								<tr>
									<th>items_tablet</th>
									<td><?php esc_html_e('Columns on tablet. Default: 2.', 'wpb-woocommerce-product-slider'); ?></td>
								</tr>
								<tr>
									<th>items_mobile</th>
									<td><?php esc_html_e('Columns on mobile. Default: 1.', 'wpb-woocommerce-product-slider'); ?></td>
								</tr>
								<tr>
									<th>category</th>
									<td><?php esc_html_e('Comma-separated category IDs. Requires product_type="category".', 'wpb-woocommerce-product-slider'); ?></td>
								</tr>
								<tr>
									<th>tags</th>
									<td><?php esc_html_e('Comma-separated tag IDs. Requires product_type="tags".', 'wpb-woocommerce-product-slider'); ?></td>
								</tr>
								<tr>
									<th>id</th>
									<td><?php esc_html_e('Comma-separated product IDs. Requires product_type="id".', 'wpb-woocommerce-product-slider'); ?></td>
								</tr>
								<tr>
									<th>disable_loop_on</th>
									<td><?php esc_html_e('Disable loop when product count is ≤ this number. Default: 3.', 'wpb-woocommerce-product-slider'); ?></td>
								</tr>
							</tbody>
						</table>
					</form>
				</div>

			</div><!-- .metabox-holder -->
		</div><!-- .wpb-wps-col-main -->

		<aside class="wpb-wps-col-sidebar">
			<?php do_action('wpb_wps_settings_sidebar'); ?>
		</aside>
	</div>
</div>

<script>
	jQuery(document).ready(function($) {

		/* ---------- Tab switching ---------- */
		var activetab = '';
		if (typeof localStorage !== 'undefined') {
			activetab = localStorage.getItem('activetab');
		}
		if (activetab && $(activetab).length) {
			$(activetab).fadeIn();
		} else {
			$('.group:first').fadeIn();
		}
		if (activetab && $(activetab + '-tab').length) {
			$(activetab + '-tab').addClass('nav-tab-active');
		} else {
			$('.nav-tab-wrapper a:first').addClass('nav-tab-active');
		}
		$('.nav-tab-wrapper a').on('click', function(e) {
			e.preventDefault();
			$('.nav-tab-wrapper a').removeClass('nav-tab-active');
			$(this).addClass('nav-tab-active').blur();
			var target = $(this).attr('href');
			if (typeof localStorage !== 'undefined') {
				localStorage.setItem('activetab', target);
			}
			$('.group').hide();
			$(target).fadeIn();
		});

		/* ---------- Copy shortcode ---------- */
		$('.wpb-wps-copy-btn').on('click', function() {
			var $btn = $(this);
			var text = $btn.data('clipboard');
			var $icon = $btn.find('.dashicons');
			var $label = $btn.find('.wpb-wps-copy-label');

			if ($btn.hasClass('copied')) return;

			navigator.clipboard.writeText(text).then(function() {
				$icon.removeClass('dashicons-clipboard').addClass('dashicons-yes');
				$label.text('Copied!');
				$btn.addClass('copied');

				setTimeout(function() {
					$icon.removeClass('dashicons-yes').addClass('dashicons-clipboard');
					$label.text('Copy');
					$btn.removeClass('copied');
				}, 2000);
			});
		});

		/* ---------- Click-to-select on shortcode inputs ---------- */
		$('.wpb-wps-shortcode-input').on('click', function() {
			$(this).select();
		});
	});
</script>