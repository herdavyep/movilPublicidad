<?php
/**
 * Info setup
 *
 * @package wpparallax
 */

if ( ! function_exists( 'wpparallax_details_setup' ) ) :

    /**
     * Info setup.
     *
     * 
     */
    function wpparallax_details_setup() {

        $config = array(

            // Welcome content.
            'welcome-texts' => sprintf( esc_html__( 'Howdy %1$s, we would like to thank you for installing and activating %2$s theme for your precious site. All of the features provided by the theme are now ready to use. Here, we have gathered all of the essential details and helpful links for you and your better experience with %2$s. Once again, Thanks for using our theme!', 'wpparallax' ), get_bloginfo('name'), 'wpparallax' ),

            // Tabs.
            'tabs' => array(
                'getting-started' => esc_html__( 'Getting Started', 'wpparallax' ),
                'support'         => esc_html__( 'Support', 'wpparallax' ),
                'useful-plugins'  => esc_html__( 'Useful Plugins', 'wpparallax' ),
                'demo-content'    => esc_html__( 'Demo Content', 'wpparallax' ),
                'upgrade-to-pro'  => esc_html__( 'View More Themes', 'wpparallax' ),
            ),

            // Quick links.
            'quick_links' => array(
                'theme_url' => array(
                    'text' => esc_html__( 'Theme Details', 'wpparallax' ),
                    'url'  => 'https://wpoperation.com/themes/wpparallax/',
                ),
                'demo_url' => array(
                    'text' => esc_html__( 'View Demo', 'wpparallax' ),
                    'url'  => 'http://demo.wpoperation.com/wpparallax',
                ),
                'documentation_url' => array(
                    'text' => esc_html__( 'View Documentation', 'wpparallax' ),
                    'url'  => 'https://doc.wpoperation.com/wpparallax/',
                ),
                'rating_url' => array(
                    'text' => esc_html__( 'Rate This Theme','wpparallax' ),
                    'url'  => 'https://wordpress.org/support/theme/wpparallax/reviews/#new-post',
                ),
            ),

            // Getting started.
            'getting_started' => array(
                'one' => array(
                    'title'       => esc_html__( 'Theme Documentation', 'wpparallax' ),
                    'icon'        => 'dashicons dashicons-format-aside',
                    'description' => esc_html__( 'Please check our full documentation for detailed information on how to setup and customize the theme.', 'wpparallax' ),
                    'button_text' => esc_html__( 'View Documentation', 'wpparallax' ),
                    'button_url'  => 'https://doc.wpoperation.com/wpparallax/',
                    'button_type' => 'link',
                    'is_new_tab'  => true,
                ),
                'two' => array(
                    'title'       => esc_html__( 'Static Front Page', 'wpparallax' ),
                    'icon'        => 'dashicons dashicons-admin-generic',
                    'description' => esc_html__( 'To achieve custom home page other than blog listing, you need to create and set static front page & assign "Home" template from page attributes.', 'wpparallax' ),
                    'button_text' => esc_html__( 'Static Front Page', 'wpparallax' ),
                    'button_url'  => admin_url( 'customize.php?autofocus[section]=static_front_page' ),
                    'button_type' => 'primary',
                ),
                'three' => array(
                    'title'       => esc_html__( 'Theme Options', 'wpparallax' ),
                    'icon'        => 'dashicons dashicons-admin-customizer',
                    'description' => esc_html__( 'Theme uses Customizer API for theme options. Using the Customizer you can easily customize different aspects of the theme.', 'wpparallax' ),
                    'button_text' => esc_html__( 'Customize', 'wpparallax' ),
                    'button_url'  => wp_customize_url(),
                    'button_type' => 'primary',
                ),
                'four' => array(
                    'title'       => esc_html__( 'Widgets', 'wpparallax' ),
                    'icon'        => 'dashicons dashicons-welcome-widgets-menus',
                    'description' => esc_html__( 'Theme uses Wedgets API for widget options. Using the Widgets you can easily customize different aspects of the theme.', 'wpparallax' ),
                    'button_text' => esc_html__( 'Widgets', 'wpparallax' ),
                    'button_url'  => admin_url('widgets.php'),
                    'button_type' => 'primary',
                ),
                'five' => array(
                    'title'       => esc_html__( 'Demo Content', 'wpparallax' ),
                    'icon'        => 'dashicons dashicons-layout',
                    'description' => sprintf( esc_html__( 'To import sample demo content, %1$s plugin should be installed and activated. After plugin is activated, visit WPOp Demo Importer menu under Appearance.', 'wpparallax' ), esc_html__( 'Operation Demo Importer', 'wpparallax' ) ),
                    'button_text' => esc_html__( 'Demo Content', 'wpparallax' ),
                    'button_url'  => admin_url( 'themes.php?page=wpparallax-details&tab=demo-content' ),
                    'button_type' => 'secondary',
                ),
                'six' => array(
                    'title'       => esc_html__( 'Fix Image Sizes', 'wpparallax' ),
                    'icon'        => 'dashicons dashicons-format-gallery',
                    'description' => esc_html__( 'If you have already images on your site then all image might not align as expected, to fix this there is handy plugin which will help you', 'wpparallax' ),
                    'button_text' => esc_html__( 'Fix Images Now', 'wpparallax' ),
                    'button_url'  => 'https://wordpress.org/plugins/regenerate-thumbnails/',
                    'button_type' => 'link',
                    'is_new_tab'  => true,
                ),
            ),

            // Support.
            'support' => array(
                'one' => array(
                    'title'       => esc_html__( 'Contact Support', 'wpparallax' ),
                    'icon'        => 'dashicons dashicons-sos',
                    'description' => esc_html__( 'Got theme support question or found bug or got some feedbacks? Best place to ask your query is the dedicated Support forum for the theme.', 'wpparallax' ),
                    'button_text' => esc_html__( 'Contact Support', 'wpparallax' ),
                    'button_url'  => 'https://wpoperation.com/support/support/free-themes/wpparallax/',
                    'button_type' => 'link',
                    'is_new_tab'  => true,
                ),
                'two' => array(
                    'title'       => esc_html__( 'Theme Documentation', 'wpparallax' ),
                    'icon'        => 'dashicons dashicons-format-aside',
                    'description' => esc_html__( 'Please check our full documentation for detailed information on how to setup and customize the theme.', 'wpparallax' ),
                    'button_text' => esc_html__( 'View Documentation', 'wpparallax' ),
                    'button_url'  => 'https://doc.wpoperation.com/wpparallax/',
                    'button_type' => 'link',
                    'is_new_tab'  => true,
                ),
                'three' => array(
                    'title'       => esc_html__( 'Child Theme', 'wpparallax' ),
                    'icon'        => 'dashicons dashicons-admin-tools',
                    'description' => esc_html__( 'For advanced theme customization, it is recommended to use child theme rather than modifying the theme file itself. Using this approach, you wont lose the customization after theme update.', 'wpparallax' ),
                    'button_text' => esc_html__( 'Learn More', 'wpparallax' ),
                    'button_url'  => 'https://developer.wordpress.org/themes/advanced-topics/child-themes/',
                    'button_type' => 'link',
                    'is_new_tab'  => true,
                ),
            ),

            //Useful plugins.
            'useful_plugins' => array(
                'description' => esc_html__( 'Theme supports some helpful WordPress plugins to enhance your site. But, please enable only those plugins which you need in your site. For example, enable WooCommerce only if you are using e-commerce.', 'wpparallax' ),
            ),

            //Demo content.
            'demo_content' => array(
                'description' => sprintf( esc_html__( 'To import demo content for this theme, %1$s plugin is needed. Please make sure plugin is installed and activated. After plugin is activated, you will see WPop Demo Importer menu under Appearance.', 'wpparallax' ), '<a href="https://wordpress.org/plugins/operation-demo-importer/" target="_blank">' . esc_html__( 'Operation Demo Importer', 'wpparallax' ) . '</a>' ),
            ),


            // Upgrade content.
            'upgrade_to_pro' => array(
                'description' => esc_html__( 'If you would like to view more themes from us then please visit us.', 'wpparallax' ),
                'button_text' => esc_html__( 'View Themes', 'wpparallax' ),
                'button_url'  => 'https://wpoperation.com/themes',
                'button_type' => 'primary',
                'is_new_tab'  => true,
            ),
        );

        Wpparallax_Info::init( $config );
    }

endif;

add_action( 'after_setup_theme', 'wpparallax_details_setup' );