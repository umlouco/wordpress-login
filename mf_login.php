<?php

/**
 * Plugin Name:       MF Login
 * Plugin URI:        https://www.mario-flores.com/
 * Description:       Custom login form with redirects
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      5.6
 * Author:            Mario Flores
 * Author URI:        https://mario-flores.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mf_manager
 * Domain Path:       /languages
 */

add_action('admin_menu', 'mf_add_admin_menu');

function mf_add_admin_menu()
{
    add_options_page('MF Login Settings', 'MF Login', 'manage_options', 'mf-login-settings', 'mf_login_settings');
}
function mf_login_settings()
{
    include(plugin_dir_path(__FILE__) . 'views/settings.php');
}


add_action('admin_init', 'mf_login_admin_init');
function mf_login_admin_init()
{
    add_settings_section('mf_login_settings', 'MF Login', '', 'mf-login-settings');
    register_setting('mf_login_settings', 'mf_login_settings');
    add_settings_field('mf_login_menu', 'Menu to add login button', 'mf_login_menu_input', 'mf-login-settings', 'mf_login_settings');
    add_settings_field('mf_login_profile', 'Edit profile page', 'mf_login_profile_input', 'mf-login-settings', 'mf_login_settings');
    add_settings_field('mf_login_logout', 'Page to redirect after log out', 'mf_login_logout_input', 'mf-login-settings', 'mf_login_settings');
    add_settings_field('mf_login_register', 'Registration Page', 'mf_login_register_input', 'mf-login-settings', 'mf_login_settings');
}

function mf_login_register_input(){
    $settings = get_option('mf_login_settings');
    $register = $settings['register'];
    $pages = get_pages(array('post_type' => 'page')); 
    $html = '<select name="mf_login_settings[register]">'; 
    $html .= '<option value="">-</option>'; 
    foreach($pages as $p){
        $html .= '<option value="'.$p->ID.'"'; 
        if($register == $p->ID){
            $html .= ' selected '; 
        }
        $html .= '>'.$p->post_title.'</option>'; 
    }
    $html .= '</select>'; 
    echo $html;  
}

function mf_login_profile_input(){
    $settings = get_option('mf_login_settings');
    $profile = $settings['profile'];
    $pages = get_pages(array('post_type' => 'page')); 
    $html = '<select name="mf_login_settings[profile]">'; 
    $html .= '<option value="">-</option>'; 
    foreach($pages as $p){
        $html .= '<option value="'.$p->ID.'"'; 
        if($profile == $p->ID){
            $html .= ' selected '; 
        }
        $html .= '>'.$p->post_title.'</option>'; 
    }
    $html .= '</select>'; 
    echo $html;  
}
function mf_login_logout_input(){
    $settings = get_option('mf_login_settings');
    $logout = $settings['logout'];
    $pages = get_pages(array('post_type' => 'page')); 
    $html = '<select name="mf_login_settings[logout]">'; 
    $html .= '<option value="">-</option>'; 
    foreach($pages as $p){
        $html .= '<option value="'.$p->ID.'"'; 
        if($logout == $p->ID){
            $html .= ' selected '; 
        }
        $html .= '>'.$p->post_title.'</option>'; 
    }
    $html .= '</select>'; 
    echo $html;  
}
function mf_login_menu_input()
{
    $settings = get_option('mf_login_settings');
    $menu = $settings['menu'];
    $menus = get_registered_nav_menus(); 
    $html = '<select name="mf_login_settings[menu]">'; 
    $html .= '<option value="">-</option>'; 
    foreach($menus as $key => $m){
        $html .= '<option value="'.$key.'"'; 
        if($menu == $key){
            $html .= ' selected '; 
        }
        $html .= '>'.$m.'</option>'; 
    }
    $html .= '</select>'; 
    echo $html; 
}

function add_search_form($items, $args)
{

    $settings = get_option('mf_login_settings');
    $menu = $settings['menu'];
    $profile = $settings['profile']; 
    $logout = $settings['logout']; 
    if ($args->theme_location == $menu) {
        if (is_user_logged_in()) {
            $items .= '<li class="menu-item"><a href="'.get_permalink($profile).'">Edit Profile</a></li>';
            $items .= '<li class="menu-item"><a href="'.wp_logout_url(get_permalink($logout)).'">Log out</a></li>';
        } else {
            $items .= '<li class="menu-item"><a href="#"  data-toggle="modal" data-target="#loginModal">Login</a></li>';
        }
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'add_search_form', 10, 2);

add_action('wp_footer', 'mf_login_model');
function mf_login_model()
{
    $settings = get_option('mf_login_settings');
    $register = $settings['register']; 
    $redirect = get_permalink(get_the_ID());
    include(plugin_dir_path(__FILE__) . 'views/login_modal.php');
}

add_shortcode('mf_login', 'mf_login_form_func');
function mf_login_form_func($atts)
{
    $settings = get_option('mf_login_settings');
    $register = $settings['register']; 
    $redirect = get_permalink(get_the_ID());
    ob_start();
    include(plugin_dir_path(__FILE__) . 'views/login_form.php');
    return  ob_get_clean(); 
}
