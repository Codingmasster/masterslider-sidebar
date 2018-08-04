<?php

/**
 * Master Slider - Sidebar WordPress Plugin.
 *
 * Plugin Name:       Master Slider Sidebar
 * Description:       This Plugin will help you to add custom side bar along with master slider.
 * Version:           1.0
 * Author:            Codingmasster
 * Tested up to:      4.3.1
 */
if ( !defined( 'ABSPATH' ) )
{
    exit;
}

// Abort loading if WordPress is upgrading
if ( defined( 'WP_INSTALLING' ) && WP_INSTALLING )
{
    return;
}

/* * *************************** */
include_once( plugin_dir_path( __FILE__ ) . 'models/class-masterslider-sidebar-model.php');
include_once( plugin_dir_path( __FILE__ ) . 'includes/class-masterslider-sidebar.php');
include_once( plugin_dir_path( __FILE__ ) . 'includes/class-masterslider-sidebar-hooks.php');
include_once( plugin_dir_path( __FILE__ ) . 'includes/class-masterslider-sidebar-init.php');

register_activation_hook( __FILE__, array( 'MastersliderSidebarInit', 'activate' ) );
add_action( 'init', array( 'MastersliderSidebarInit', 'register_calls' ) );
add_action( 'admin_menu', array( 'MastersliderSidebarInit', 'register_masterslider_sidebar_menus' ) );
add_action( 'admin_enqueue_scripts', array( 'MastersliderSidebarInit', 'register_masterslider_sidebar_admin_assets' ) );
add_action( 'wp_enqueue_scripts', array( 'MastersliderSidebarInit', 'register_masterslider_sidebar_public_assets' ) );

/******************************/
