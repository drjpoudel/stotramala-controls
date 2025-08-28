<?php
/*
Plugin Name: Stotramala Theme Controls
Description: A plugin to manage the header and footer content for the ShreeVaishnav Stotramala theme.
Version: 1.0
Author: Your Name
*/

// 1. Add Admin Menu
function stotramala_add_admin_menu() {
    add_menu_page(
        'Theme Options',          // Page Title
        'Theme Controls',         // Menu Title
        'manage_options',         // Capability
        'stotramala_theme_options', // Menu Slug
        'stotramala_theme_options_page', // Callback function
        'dashicons-admin-generic',// Icon
        60                        // Position
    );
}
add_action('admin_menu', 'stotramala_add_admin_menu');

// 2. Create the Theme Options Page
function stotramala_theme_options_page() {
    ?>
    <div class="wrap">
        <h1>Theme Controls</h1>
        <form method="post" action="options.php">
            <?php
                settings_fields('stotramala_options_group');
                do_settings_sections('stotramala_theme_options');
                submit_button();
            ?>
        </form>
    </div>
    <?php
}

// 3. Register Settings, Sections, and Fields
function stotramala_settings_init() {
    // Register a setting group
    register_setting('stotramala_options_group', 'stotramala_theme_settings');

    // Header Section
    add_settings_section(
        'stotramala_header_section',
        'Header Settings',
        'stotramala_header_section_callback',
        'stotramala_theme_options'
    );

    add_settings_field(
        'header_text',
        'Header Title',
        'stotramala_header_text_render',
        'stotramala_theme_options',
        'stotramala_header_section'
    );

    // Footer Section
    add_settings_section(
        'stotramala_footer_section',
        'Footer Settings',
        'stotramala_footer_section_callback',
        'stotramala_theme_options'
    );

    add_settings_field(
        'footer_text',
        'Footer Copyright Text',
        'stotramala_footer_text_render',
        'stotramala_theme_options',
        'stotramala_footer_section'
    );
}
add_action('admin_init', 'stotramala_settings_init');

// 4. Section and Field Callback Functions
function stotramala_header_section_callback() {
    echo 'Customize the header of your theme.';
}

function stotramala_footer_section_callback() {
    echo 'Customize the footer of your theme.';
}

function stotramala_header_text_render() {
    $options = get_option('stotramala_theme_settings');
    ?>
    <input type='text' name='stotramala_theme_settings[header_text]' value='<?php echo esc_attr($options['header_text']); ?>'>
    <?php
}

function stotramala_footer_text_render() {
    $options = get_option('stotramala_theme_settings');
    ?>
    <input type='text' name='stotramala_theme_settings[footer_text]' value='<?php echo esc_attr($options['footer_text']); ?>' size='50'>
    <?php
}
