<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPB WooCommerce Product Slider Settings
 * By WPBean
 */

if (!class_exists('wpb_wps_lite_settings')):
    class wpb_wps_lite_settings
    {

        /**
         * Settings API instance.
         *
         * @since 1.0.0
         *
         * @var WeDevs_Settings_API
         */
        private $settings_api;

        /**
         * Pro plugin purchase URL with UTM parameters.
         *
         * Built once in the constructor and reused across admin menu and settings page.
         *
         * @since 1.0.0
         *
         * @var string
         */
        private $pro_url;

        /**
         * Support URL with UTM parameters.
         *
         * Built once in the constructor and reused across admin menu and settings page.
         *
         * @since 1.0.0
         *
         * @var string
         */
        private $support_url;

        /**
         * Constructor.
         *
         * Initializes the settings API instance, builds the Pro and Support URLs, and registers admin hooks.
         *
         * @since 1.0.0
         */
        public function __construct()
        {
            $this->settings_api = new WeDevs_Settings_API;

            $this->pro_url = esc_url(add_query_arg(
                array(
                    'utm_source'   => 'wp-admin',
                    'utm_medium'   => 'admin-menu',
                    'utm_campaign' => 'upgrade-to-pro',
                    'utm_content'  => 'wpb-wps-lite',
                ),
                'https://wpbean.com/downloads/wpb-woocommerce-product-slider-pro/'
            ));

            $this->support_url = esc_url(add_query_arg(
                array(
                    'utm_source'   => 'wp-admin',
                    'utm_medium'   => 'admin-menu',
                    'utm_campaign' => 'support',
                    'utm_content'  => 'wpb-wps-lite',
                ),
                'https://wpbean.com/support'
            ));

            add_action('admin_init', array($this, 'admin_init'));
            add_action('admin_menu', array($this, 'admin_menu'));
            add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
            add_action('admin_head', array($this, 'admin_upgrade_pro_styles'));
            add_action('wpb_wps_settings_sidebar', array($this, 'wpb_wps_settings_page_sidebar'));
        }

        /**
         * Initializes plugin settings sections and fields.
         *
         * Fires on the `admin_init` hook. Passes section and field definitions
         * to the settings API and triggers its own initialization routine.
         *
         * @since 1.0.0
         *
         * @return void
         */
        public function admin_init()
        {
            $this->settings_api->set_sections($this->get_settings_sections());
            $this->settings_api->set_fields($this->get_settings_fields());

            $this->settings_api->admin_init();
        }

        /**
         * Registers the plugin's top-level and submenu admin pages.
         *
         * Fires on the `admin_menu` hook. Adds the main Products Slider settings
         * page and submenu pages for Settings, Documentation, Support, and Upgrade to Pro.
         *
         * @since 1.0.0
         *
         * @return void
         */
        public function admin_menu()
        {
            add_menu_page(
                esc_html__('WPB WooCommerce Products Slider Settings', 'wpb-woocommerce-product-slider'),
                esc_html__('Products Slider', 'wpb-woocommerce-product-slider'),
                apply_filters('wpb_wps_settings_user_capability', 'manage_options'),
                'wpb-woocommerce-product-slider-settings',
                array($this, 'wpb_wps_plugin_page'),
                'data:image/svg+xml;base64,' . base64_encode( '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><rect x="4" y="4" width="12" height="9" rx="1" fill="#a7aaad"/><rect x="1.5" y="5.5" width="3" height="6" rx="0.5" fill="#a7aaad" opacity="0.5"/><rect x="15.5" y="5.5" width="3" height="6" rx="0.5" fill="#a7aaad" opacity="0.5"/><circle cx="8.5" cy="16" r="1" fill="#a7aaad"/><circle cx="10" cy="16" r="1" fill="#a7aaad" opacity="0.5"/><circle cx="11.5" cy="16" r="1" fill="#a7aaad" opacity="0.5"/></svg>' )
            );

            add_submenu_page(
                'wpb-woocommerce-product-slider-settings',
                esc_html__('WPB WooCommerce Products Slider Settings', 'wpb-woocommerce-product-slider'),
                esc_html__('Settings', 'wpb-woocommerce-product-slider'),
                apply_filters('wpb_wps_settings_user_capability', 'manage_options'),
                'wpb-woocommerce-product-slider-settings',
                array($this, 'wpb_wps_plugin_page'),
            );

            add_submenu_page(
                'wpb-woocommerce-product-slider-settings',
                esc_html__('WPB WooCommerce Products Slider Documentation', 'wpb-woocommerce-product-slider'),
                esc_html__('How to Use', 'wpb-woocommerce-product-slider'),
                apply_filters('wpb_wps_settings_user_capability', 'manage_options'),
                'wpb-woocommerce-product-slider' . '-about',
                array($this, 'wpb_wps_get_menu_page'),
            );

            global $submenu;
            $submenu['wpb-woocommerce-product-slider-settings'][] = array(
                esc_html__('Support', 'wpb-woocommerce-product-slider'),
                apply_filters('wpb_wps_settings_user_capability', 'manage_options'),
                $this->support_url,
            );

            $submenu['wpb-woocommerce-product-slider-settings'][] = array(
                esc_html__('Upgrade to Pro', 'wpb-woocommerce-product-slider'),
                apply_filters('wpb_wps_settings_user_capability', 'manage_options'),
                $this->pro_url,
            );
        }

        /**
         * Enqueues the settings page stylesheet.
         *
         * Fires on the `admin_enqueue_scripts` hook. Loads the stylesheet only on
         * the plugin's own settings screen to avoid polluting other admin pages.
         *
         * @since 1.0.0
         *
         * @param string $hook_suffix The current admin page hook suffix.
         *
         * @return void
         */
        public function admin_enqueue_scripts($hook_suffix)
        {
            $plugin_pages = array(
                'toplevel_page_wpb-woocommerce-product-slider-settings',
                'products-slider_page_wpb-woocommerce-product-slider-about',
            );

            if (! in_array($hook_suffix, $plugin_pages, true)) {
                return;
            }

            wp_enqueue_style(
                'wpb-wps-settings',
                plugins_url('admin/assets/css/wpb-wps-settings.css', WPB_WPS_PLUGIN_DIR_FILE),
                array(),
                WPB_WPS_FREE_VERSION
            );
        }

        /**
         * Outputs inline CSS to render the "Upgrade to Pro" submenu item as a button.
         *
         * Fires on the `admin_head` hook. Styles the link as a crimson rounded button
         * with white bold text, matching the convention used by other premium plugins.
         * Targets the Pro link by URL prefix so UTM parameter changes have no effect.
         *
         * @since 1.0.0
         *
         * @return void
         */
        public function admin_upgrade_pro_styles()
        {
?>
            <style>
                #adminmenu a[href^="https://wpbean.com/downloads/wpb-woocommerce-product-slider-pro/"] {
                    display: block !important;
                    margin: 6px 12px !important;
                    padding: 7px 10px !important;
                    background-color: #8b1a4a !important;
                    color: #fff !important;
                    font-weight: 500 !important;
                    font-size: 13px !important;
                    text-align: center !important;
                    border-radius: 4px !important;
                    text-decoration: none !important;
                    line-height: 1.4 !important;
                }

                #adminmenu a[href^="https://wpbean.com/downloads/wpb-woocommerce-product-slider-pro/"]:hover {
                    background-color: #6e1239 !important;
                    color: #fff !important;
                    box-shadow: unset;
                }
            </style>
        <?php
        }

        /**
         * Renders the Documentation admin page.
         *
         * Callback for the Documentation submenu page registered in `admin_menu()`.
         * Includes the admin-page template file.
         *
         * @since 1.0.0
         *
         * @return void
         */
        public function wpb_wps_get_menu_page()
        {
            include_once(WPB_WPS_PLUGIN_DIR . 'admin/admin-page.php');
        }

        /**
         * Returns the settings tab sections.
         *
         * Each section maps to a tab displayed on the settings page.
         *
         * @since 1.0.0
         *
         * @return array {
         *     Indexed array of section definitions.
         *
         *     @type string $id    Unique section identifier used as the option group name.
         *     @type string $title Human-readable section title displayed as the tab label.
         * }
         */
        private function get_settings_sections()
        {
            $sections = array(
                array(
                    'id'    => 'wpb_wps_general',
                    'title' => esc_html__('General Settings', 'wpb-woocommerce-product-slider')
                ),
                array(
                    'id'    => 'wpb_wps_slider_settings',
                    'title' => esc_html__('Slider Settings', 'wpb-woocommerce-product-slider')
                ),
                array(
                    'id'    => 'wpb_wps_style',
                    'title' => esc_html__('Style Settings', 'wpb-woocommerce-product-slider')
                ),
                array(
                    'id'    => 'wpb_wps_advanced',
                    'title' => esc_html__('Advanced Settings', 'wpb-woocommerce-product-slider')
                )
            );
            return $sections;
        }

        /**
         * Returns all settings fields grouped by section.
         *
         * Defines every field rendered on the settings page across the General,
         * Slider, Style, and Advanced tabs.
         *
         * @since 1.0.0
         *
         * @return array {
         *     Associative array keyed by section ID.
         *
         *     @type array[] $wpb_wps_general         General settings fields (product count, type, order, theme, display toggles).
         *     @type array[] $wpb_wps_slider_settings  Slider behaviour fields (columns, autoplay, loop, navigation, pagination).
         *     @type array[] $wpb_wps_style            Style fields (primary and secondary colour pickers).
         *     @type array[] $wpb_wps_advanced         Advanced fields (priority script loading toggle).
         * }
         */
        private function get_settings_fields()
        {
            $settings_fields = array(
                'wpb_wps_general' => array(
                    array(
                        'name'      => 'wpb_wps_number',
                        'label'     => esc_html__('Number of Products', 'wpb-woocommerce-product-slider'),
                        'desc'      => esc_html__('Number of Product to show in slider. Default 12.', 'wpb-woocommerce-product-slider'),
                        'type'      => 'number',
                        'default'   => 12
                    ),
                    array(
                        'name'    => 'wpb_wps_product_type',
                        'label'   => esc_html__('Product Type', 'wpb-woocommerce-product-slider'),
                        'desc'    => esc_html__('Select product type for slider.', 'wpb-woocommerce-product-slider'),
                        'type'    => 'select',
                        'default' => 'latest',
                        'options' => array(
                            'latest'    => esc_html__('Latest Products', 'wpb-woocommerce-product-slider'),
                            'featured'  => esc_html__('Featured Products', 'wpb-woocommerce-product-slider'),
                            'category'  => esc_html__('Category Products', 'wpb-woocommerce-product-slider'),
                            'tags'      => esc_html__('Tag Products', 'wpb-woocommerce-product-slider'),
                            'id'        => esc_html__('Products From ID', 'wpb-woocommerce-product-slider'),
                        )
                    ),
                    array(
                        'name'    => 'wpb_wps_orderby',
                        'label'   => esc_html__('Product Orderby', 'wpb-woocommerce-product-slider'),
                        'desc'    => esc_html__('Select product orderby for slider. Default: Date.', 'wpb-woocommerce-product-slider'),
                        'type'    => 'select',
                        'default' => 'date',
                        'options' => array(
                            'none'          => esc_html__('None', 'wpb-woocommerce-product-slider'),
                            'date'          => esc_html__('Date', 'wpb-woocommerce-product-slider'),
                            'ID'            => esc_html__('ID', 'wpb-woocommerce-product-slider'),
                            'author'        => esc_html__('Author', 'wpb-woocommerce-product-slider'),
                            'title'         => esc_html__('Title', 'wpb-woocommerce-product-slider'),
                            'name'          => esc_html__('Name', 'wpb-woocommerce-product-slider'),
                            'rand'          => esc_html__('Rand', 'wpb-woocommerce-product-slider'),
                            'menu_order'    => esc_html__('Menu Order', 'wpb-woocommerce-product-slider'),
                            'modified'      => esc_html__('Modified', 'wpb-woocommerce-product-slider'),
                        )
                    ),
                    array(
                        'name'    => 'wpb_wps_order',
                        'label'   => esc_html__('Product Order', 'wpb-woocommerce-product-slider'),
                        'desc'    => esc_html__('Select product order for slider. Default: DESC.', 'wpb-woocommerce-product-slider'),
                        'type'    => 'select',
                        'default' => 'DESC',
                        'options' => array(
                            'ASC'          => esc_html__('ASC', 'wpb-woocommerce-product-slider'),
                            'DESC'         => esc_html__('DESC', 'wpb-woocommerce-product-slider'),
                        )
                    ),
                    array(
                        'name'    => 'wpb_wps_slider_theme',
                        'label'   => esc_html__('Slider Theme', 'wpb-woocommerce-product-slider'),
                        'desc'    => esc_html__('Select a theme for slider.', 'wpb-woocommerce-product-slider'),
                        'type'    => 'select',
                        'default' => 'hover_effect',
                        'options' => array(
                            'hover_effect'          => esc_html__('Theme Hover Effect', 'wpb-woocommerce-product-slider'),
                            'grid_no_animation'     => esc_html__('Theme Box', 'wpb-woocommerce-product-slider'),
                        )
                    ),
                    array(
                        'name'      => 'wpb_wps_show_reviews',
                        'label'     => esc_html__('Show Product Review in Slider', 'wpb-woocommerce-product-slider'),
                        'desc'      => esc_html__('Yes Please!', 'wpb-woocommerce-product-slider'),
                        'type'      => 'checkbox',
                    ),
                    array(
                        'name'      => 'wpb_wps_show_price',
                        'label'     => esc_html__('Show Product Price in Slider', 'wpb-woocommerce-product-slider'),
                        'desc'      => esc_html__('Yes Please!', 'wpb-woocommerce-product-slider'),
                        'type'      => 'checkbox',
                        'default'   => 'on'
                    ),
                    array(
                        'name'      => 'wpb_wps_show_cart',
                        'label'     => esc_html__('Show Add to Cart button in Slider', 'wpb-woocommerce-product-slider'),
                        'desc'      => esc_html__('Yes Please!', 'wpb-woocommerce-product-slider'),
                        'type'      => 'checkbox',
                        'default'   => 'on'
                    ),
                    array(
                        'name'              => 'wpb_wps_categories',
                        'label'             => esc_html__('Product Categories', 'wpb-woocommerce-product-slider'),
                        'desc'              => esc_html__('Comma separated product category ids.', 'wpb-woocommerce-product-slider'),
                        'placeholder'       => esc_html__('20,23,27', 'wpb-woocommerce-product-slider'),
                        'type'              => 'text',
                    ),
                    array(
                        'name'              => 'wpb_wps_tags',
                        'label'             => esc_html__('Product Tags', 'wpb-woocommerce-product-slider'),
                        'desc'              => esc_html__('Comma separated product tag ids.', 'wpb-woocommerce-product-slider'),
                        'placeholder'       => esc_html__('20,23,27', 'wpb-woocommerce-product-slider'),
                        'type'              => 'text',
                    ),
                    array(
                        'name'              => 'wpb_wps_ids',
                        'label'             => esc_html__('Product IDs', 'wpb-woocommerce-product-slider'),
                        'desc'              => esc_html__('Comma separated product ids.', 'wpb-woocommerce-product-slider'),
                        'placeholder'       => esc_html__('20,23,27', 'wpb-woocommerce-product-slider'),
                        'type'              => 'text',
                    ),
                ),

                'wpb_wps_slider_settings' => array(
                    array(
                        'name'      => 'wpb_wps_items',
                        'label'     => esc_html__('Number of Column', 'wpb-woocommerce-product-slider'),
                        'desc'      => esc_html__('Slider number of columns in large screen. Default: 4', 'wpb-woocommerce-product-slider'),
                        'type'      => 'number',
                        'default'   => 4
                    ),
                    array(
                        'name'      => 'wpb_wps_items_desktop_small',
                        'label'     => esc_html__('Number of Columns Small Desktop', 'wpb-woocommerce-product-slider'),
                        'desc'      => esc_html__('Slider number of columns in small desktop. Default: 3', 'wpb-woocommerce-product-slider'),
                        'type'      => 'number',
                        'default'   => 3
                    ),
                    array(
                        'name'      => 'wpb_wps_items_tablet',
                        'label'     => esc_html__('Number of Columns Tablet', 'wpb-woocommerce-product-slider'),
                        'desc'      => esc_html__('Slider number of columns in tablet. Default: 2', 'wpb-woocommerce-product-slider'),
                        'type'      => 'number',
                        'default'   => 2
                    ),
                    array(
                        'name'      => 'wpb_wps_items_mobile',
                        'label'     => esc_html__('Number of Columns Mobile', 'wpb-woocommerce-product-slider'),
                        'desc'      => esc_html__('Slider number of columns in mobile. Default: 1', 'wpb-woocommerce-product-slider'),
                        'type'      => 'number',
                        'default'   => 1
                    ),
                    array(
                        'name'      => 'wpb_slider_autoplay',
                        'label'     => esc_html__('Slider Auto Play', 'wpb-woocommerce-product-slider'),
                        'desc'      => esc_html__('Yes Please!', 'wpb-woocommerce-product-slider'),
                        'type'      => 'checkbox',
                        'default'   => 'on'
                    ),
                    array(
                        'name'      => 'wpb_slider_loop',
                        'label'     => esc_html__('Slider Loop', 'wpb-woocommerce-product-slider'),
                        'desc'      => esc_html__('Yes Please!', 'wpb-woocommerce-product-slider'),
                        'type'      => 'checkbox',
                        'default'   => 'on'
                    ),
                    array(
                        'name'      => 'wpb_slider_navigation',
                        'label'     => esc_html__('Slider Navigation', 'wpb-woocommerce-product-slider'),
                        'desc'      => esc_html__('Yes Please!', 'wpb-woocommerce-product-slider'),
                        'type'      => 'checkbox',
                        'default'   => 'on'
                    ),
                    array(
                        'name'              => 'wpb_slider_slideby',
                        'label'             => esc_html__('Number of items to slide on Navigation click', 'wpb-woocommerce-product-slider'),
                        'desc'              => esc_html__('Navigation slide by x. "page" string can be set to slide by page. Default: 1', 'wpb-woocommerce-product-slider'),
                        'default'           => esc_html__('1', 'wpb-woocommerce-product-slider'),
                        'type'              => 'text',
                    ),
                    array(
                        'name'      => 'wpb_slider_pagination',
                        'label'     => esc_html__('Slider Pagination', 'wpb-woocommerce-product-slider'),
                        'desc'      => esc_html__('Yes Please!', 'wpb-woocommerce-product-slider'),
                        'type'      => 'checkbox',
                    ),
                    array(
                        'name'      => 'wpb_slider_pagination_number',
                        'label'     => esc_html__('Slider Pagination Number Counting', 'wpb-woocommerce-product-slider'),
                        'desc'      => esc_html__('Yes Please!', 'wpb-woocommerce-product-slider'),
                        'type'      => 'checkbox',
                    ),

                ),
                'wpb_wps_style' => array(
                    array(
                        'name'      => 'wpb_wps_primary_color',
                        'label'     => esc_html__('Primary Color', 'wpb-woocommerce-product-slider'),
                        'type'      => 'color',
                        'default'   => '#1abc9c'
                    ),
                    array(
                        'name'      => 'wpb_wps_primary_color_dark',
                        'label'     => esc_html__('Primary Color Dark', 'wpb-woocommerce-product-slider'),
                        'type'      => 'color',
                        'default'   => '#16a085'
                    ),
                    array(
                        'name'      => 'wpb_wps_primary_color_light',
                        'label'     => esc_html__('Primary Color Light', 'wpb-woocommerce-product-slider'),
                        'type'      => 'color',
                        'default'   => '#8BCFC2'
                    ),
                    array(
                        'name'      => 'wpb_wps_secondary_color',
                        'label'     => esc_html__('Secondary Color', 'wpb-woocommerce-product-slider'),
                        'type'      => 'color',
                        'default'   => '#999999'
                    ),
                    array(
                        'name'      => 'wpb_wps_secondary_color_light',
                        'label'     => esc_html__('Secondary Color Light', 'wpb-woocommerce-product-slider'),
                        'type'      => 'color',
                        'default'   => '#cccccc'
                    ),
                ),
                'wpb_wps_advanced' => array(
                    array(
                        'name'      => 'wpb_wps_force_scripts_loading',
                        'label'     => esc_html__('Priority Scripts Loading', 'wpb-woocommerce-product-slider'),
                        'desc'      => esc_html__('Yes Please!', 'wpb-woocommerce-product-slider'),
                        'type'      => 'checkbox',
                    ),
                ),
            );
            return $settings_fields;
        }

        /**
         * Renders the main plugin settings page.
         *
         * Callback for the top-level admin menu page registered in `admin_menu()`.
         * Fires the `wpb_wps_before_settings` and `wpb_wps_after_settings` action
         * hooks and outputs the settings navigation and forms via the settings API.
         *
         * @since 1.0.0
         *
         * @return void
         */
        public function wpb_wps_plugin_page()
        {
        ?>
            <?php do_action('wpb_wps_before_settings'); ?>
            <div class="wpb_wps_settings_area">
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
                            <?php
                            settings_errors();
                            $this->settings_api->show_navigation();
                            $this->settings_api->show_forms();
                            ?>
                        </div>
                        <aside class="wpb-wps-col-sidebar">
                            <?php do_action('wpb_wps_settings_sidebar'); ?>
                        </aside>
                    </div>
                </div>
                <div class="wpb_wps_settings_content">
                    <?php do_action('wpb_wps_settings_content'); ?>
                </div>
            </div>
            <?php do_action('wpb_wps_after_settings'); ?>
        <?php
        }

        /**
         * Renders the Pro upgrade sidebar card.
         *
         * Hooked onto the `wpb_wps_settings_sidebar` action, which is fired on
         * both the Settings page and the Documentation page, making the sidebar
         * available site-wide to any admin template that calls that action.
         *
         * Feature items are defined in a filterable array so third-party code
         * can add or remove entries via the `wpb_wps_pro_sidebar_features` filter.
         *
         * @since 1.0.0
         *
         * @return void
         */
        public function wpb_wps_settings_page_sidebar()
        {
            $pro_features = apply_filters('wpb_wps_pro_sidebar_features', array(
                __('Six modern and professionally designed slider layouts.', 'wpb-woocommerce-product-slider'),
                __('Display products from selected categories and tags.', 'wpb-woocommerce-product-slider'),
                __('Create sliders using specific product SKUs.', 'wpb-woocommerce-product-slider'),
                __('Showcase products currently on sale.', 'wpb-woocommerce-product-slider'),
                __('Filter products by selected attributes.', 'wpb-woocommerce-product-slider'),
                __('Exclude out-of-stock products from sliders.', 'wpb-woocommerce-product-slider'),
                __('Advanced shortcode generator with a user-friendly interface.', 'wpb-woocommerce-product-slider'),
                __('Custom Visual Composer element for easy page builder integration.', 'wpb-woocommerce-product-slider'),
            ));
        ?>
            <div class="wpb-wps-pro-sidebar-card">
                <div class="wpb-wps-pro-card-header">
                    <span class="wpb-wps-pro-card-crown dashicons dashicons-star-filled"></span>
                    <h3><?php esc_html_e('Upgrade to Pro', 'wpb-woocommerce-product-slider'); ?></h3>
                    <p><?php esc_html_e('Unlock powerful features for your store', 'wpb-woocommerce-product-slider'); ?></p>
                </div>
                <div class="wpb-wps-pro-card-body">
                    <ul class="wpb-wps-pro-features-list">
                        <?php foreach ($pro_features as $feature) : ?>
                            <li><?php echo esc_html($feature); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="<?php echo esc_url($this->pro_url); ?>" target="_blank" rel="noopener noreferrer" class="wpb-wps-pro-card-cta">
                        <span class="dashicons dashicons-cart"></span>
                        <?php esc_html_e('Upgrade to Pro', 'wpb-woocommerce-product-slider'); ?>
                    </a>
                </div>
            </div>
<?php
        }

        /**
         * Returns all published pages as an ID-to-title map.
         *
         * Retrieves every WordPress page via `get_pages()` and builds an
         * associative array suitable for use in a select field's `options` key.
         *
         * @since 1.0.0
         *
         * @return array {
         *     Associative array of page options.
         *
         *     @type string $ID Page title keyed by the page's integer post ID.
         * }
         */
        private function get_pages()
        {
            $pages = get_pages();
            $pages_options = array();
            if ($pages) {
                foreach ($pages as $page) {
                    $pages_options[$page->ID] = $page->post_title;
                }
            }
            return $pages_options;
        }
    }
endif;

$settings = new wpb_wps_lite_settings();
