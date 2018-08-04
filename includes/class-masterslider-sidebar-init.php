<?php

/**
 * @author: Codingmasster
 */
class MastersliderSidebarInit
{

    public function activate()
    {
	try
	{
	    if ( is_plugin_active( 'masterslider/masterslider.php' ) || is_plugin_active( 'master-slider/master-slider.php' ) )
	    {
		$model = new MastersliderSidebarModel();
		$model->create_sidebar_table();
	    }
	    else
	    {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		wp_die( __( 'This plugin requires <a href="https://wordpress.org/plugins/master-slider/">Master Slider</a> to be active!', 'masterslider' ) );
	    }
	}
	catch ( Exception $ex )
	{
	    wp_die( __( 'Something went wrong. Please try again.', 'masterslider-sidebar' ) );
	}
    }

    public function render_pages()
    {
	$sidebar = new MastersliderSidebar();
	$sidebar->masterslider_sidebar_settings_page();
    }

    public function register_calls()
    {
	$hooks = new MastersliderSidebarHooks();
	$hooks->register();
    }

    public function register_masterslider_sidebar_menus()
    {
	add_menu_page( 'Masterslider Sidebar Settings', 'Masterslider Sidebar', 'administrator', 'masterslider-sidebar-settings', array( 'MastersliderSidebarInit', 'render_pages' ), 'dashicons-admin-generic' );
    }

    public function register_masterslider_sidebar_admin_assets()
    {
	wp_register_script( "image-picker-js", plugins_url( "masterslider-sidebar/assets/js/image-picker.min.js" ), array( "jquery" ), "1.4" );
	wp_register_script( "sidebar-js", plugins_url( "masterslider-sidebar/assets/js/sidebar.min.js" ), array( "jquery" ), "1.4" );
	wp_register_style( "image-picker-css", plugins_url( "masterslider-sidebar/assets/css/image-picker.css" ), "1.4" );

	wp_enqueue_script( "image-picker-js" );
	wp_enqueue_script( "sidebar-js" );
	wp_enqueue_style( "image-picker-css" );
	wp_localize_script( 'sidebar-js', 'sidebar', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    }

    public function register_masterslider_sidebar_public_assets()
    {
	wp_register_script( "sidebar-js", plugins_url( "masterslider-sidebar/assets/public/sidebar.min.js" ), array( "jquery" ), "1.4" );

	wp_enqueue_script( "sidebar-js" );
    }

}
