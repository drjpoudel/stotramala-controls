<?php
/*
Plugin Name: Stotramala Admin
Description: The central control panel for the ShreeVaishnav Stotramala Theme. Manages styling, content, and layout.
Version: 1.0
Author: Your Name
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// 1. Create the Admin Menu
function stotramala_admin_add_menu() {
    add_menu_page(
        'Stotramala Options',
        'Stotramala Admin',
        'manage_options',
        'stotramala-options',
        'stotramala_admin_page_html',
        'dashicons-admin-customizer',
        20
    );
}
add_action('admin_menu', 'stotramala_admin_add_menu');

// 2. Build the Admin Page HTML
function stotramala_admin_page_html() {
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('stotramala_options_group');
            do_settings_sections('stotramala-options');
            submit_button('Save Settings');
            ?>
        </form>
    </div>
    <?php
}

// 3. Register all Settings, Sections, and Fields
function stotramala_admin_settings_init() {
    // Register one setting group to hold all options in a single array
    register_setting('stotramala_options_group', 'stotramala_settings');

    // SECTION: Header
    add_settings_section('stotramala_header_section', 'Header Settings', null, 'stotramala-options');
    add_settings_field('header_notice', 'Header Notice Text', 'stotramala_field_render', 'stotramala-options', 'stotramala_header_section', ['type' => 'text', 'id' => 'header_notice', 'desc' => 'Text for the notice bar at the top.']);
    add_settings_field('header_bg_color', 'Header Background Color', 'stotramala_field_render', 'stotramala-options', 'stotramala_header_section', ['type' => 'color', 'id' => 'header_bg_color']);
    add_settings_field('header_font_color', 'Header Font Color', 'stotramala_field_render', 'stotramala-options', 'stotramala_header_section', ['type' => 'color', 'id' => 'header_font_color']);

    // SECTION: Footer
    add_settings_section('stotramala_footer_section', 'Footer Settings', null, 'stotramala-options');
    add_settings_field('footer_widgets', 'Number of Footer Widget Columns', 'stotramala_field_render', 'stotramala-options', 'stotramala_footer_section', ['type' => 'select', 'id' => 'footer_widgets', 'options' => [1, 2, 3, 4]]);
    add_settings_field('footer_copyright', 'Footer Copyright Text', 'stotramala_field_render', 'stotramala-options', 'stotramala_footer_section', ['type' => 'text', 'id' => 'footer_copyright', 'desc' => 'Example: &copy; 2025 Your Site Name']);
    add_settings_field('footer_bg_color', 'Footer Background Color', 'stotramala_field_render', 'stotramala-options', 'stotramala_footer_section', ['type' => 'color', 'id' => 'footer_bg_color']);
    add_settings_field('footer_font_color', 'Footer Font Color', 'stotramala_field_render', 'stotramala-options', 'stotramala_footer_section', ['type' => 'color', 'id' => 'footer_font_color']);

    // SECTION: Typography (Fonts)
    add_settings_section('stotramala_typography_section', 'Typography Settings', null, 'stotramala-options');
    $fonts = ['Arial', 'Verdana', 'Helvetica', 'Tahoma', 'Trebuchet MS', 'Georgia', 'Times New Roman', 'Courier New', 'Roboto', 'Open Sans', 'Lato', 'Montserrat', 'Poppins', 'Nunito', 'Merriweather', 'Playfair Display', 'Oswald', 'Raleway', 'Ubuntu', 'Noto Sans'];
    add_settings_field('heading_font', 'Heading Font', 'stotramala_field_render', 'stotramala-options', 'stotramala_typography_section', ['type' => 'select', 'id' => 'heading_font', 'options' => $fonts]);
    add_settings_field('body_font', 'Body/Paragraph Font', 'stotramala_field_render', 'stotramala-options', 'stotramala_typography_section', ['type' => 'select', 'id' => 'body_font', 'options' => $fonts]);
    add_settings_field('body_font_size', 'Body Font Size (px)', 'stotramala_field_render', 'stotramala-options', 'stotramala_typography_section', ['type' => 'number', 'id' => 'body_font_size']);

    // SECTION: Colors & Styling
    add_settings_section('stotramala_styling_section', 'General Colors & Styling', null, 'stotramala-options');
    add_settings_field('site_background_color', 'Site Background Color', 'stotramala_field_render', 'stotramala-options', 'stotramala_styling_section', ['type' => 'color', 'id' => 'site_background_color']);
    add_settings_field('grid_item_bg_color', 'Grid Item Background Color', 'stotramala_field_render', 'stotramala-options', 'stotramala_styling_section', ['type' => 'color', 'id' => 'grid_item_bg_color']);
    add_settings_field('grid_item_border_color', 'Grid Item Border Color', 'stotramala_field_render', 'stotramala-options', 'stotramala_styling_section', ['type' => 'color', 'id' => 'grid_item_border_color']);
    add_settings_field('grid_item_font_color', 'Grid Item Font Color', 'stotramala_field_render', 'stotramala-options', 'stotramala_styling_section', ['type' => 'color', 'id' => 'grid_item_font_color']);
    add_settings_field('link_color', 'Link Color', 'stotramala_field_render', 'stotramala-options', 'stotramala_styling_section', ['type' => 'color', 'id' => 'link_color']);
}
add_action('admin_init', 'stotramala_admin_settings_init');

// 4. Universal Field Rendering Function
function stotramala_field_render($args) {
    $options = get_option('stotramala_settings');
    $value = isset($options[$args['id']]) ? $options[$args['id']] : '';
    $type = $args['type'];
    $id = $args['id'];
    
    switch ($type) {
        case 'text':
            echo "<input type='text' id='$id' name='stotramala_settings[$id]' value='" . esc_attr($value) . "' class='regular-text'>";
            break;
        case 'number':
            echo "<input type='number' id='$id' name='stotramala_settings[$id]' value='" . esc_attr($value) . "'>";
            break;
        case 'color':
            echo "<input type='color' id='$id' name='stotramala_settings[$id]' value='" . esc_attr($value) . "'>";
            break;
        case 'select':
            echo "<select id='$id' name='stotramala_settings[$id]'>";
            foreach ($args['options'] as $option) {
                echo "<option value='$option' " . selected($value, $option, false) . ">$option</option>";
            }
            echo "</select>";
            break;
    }
    if (!empty($args['desc'])) {
        echo "<p class='description'>" . esc_html($args['desc']) . "</p>";
    }
}

// 5. Create Custom Post Type for Grid Items
function stotramala_create_grid_cpt() {
    register_post_type('stotramala_grid_item',
        [
            'labels' => ['name' => 'Grid Items', 'singular_name' => 'Grid Item'],
            'public' => true,
            'has_archive' => true,
            'supports' => ['title', 'editor', 'thumbnail'],
            'menu_icon' => 'dashicons-layout',
        ]
    );
}
add_action('init', 'stotramala_create_grid_cpt');

// 6. Register Footer Widget Areas
function stotramala_register_widgets() {
    $options = get_option('stotramala_settings');
    $footer_cols = isset($options['footer_widgets']) ? intval($options['footer_widgets']) : 4;
    for ($i = 1; $i <= $footer_cols; $i++) {
        register_sidebar([
            'name'          => "Footer Column {$i}",
            'id'            => "footer_{$i}",
            'before_widget' => '<div class="widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ]);
    }
}
add_action('widgets_init', 'stotramala_register_widgets');

// 7. Generate Dynamic CSS
function stotramala_dynamic_css() {
    $options = get_option('stotramala_settings');
    if (empty($options)) return;
    
    echo '<style>';
    // Fonts
    if(!empty($options['heading_font'])) echo "h1, h2, h3, h4, h5, h6 { font-family: '" . esc_html($options['heading_font']) . "', sans-serif; }";
    if(!empty($options['body_font'])) echo "body { font-family: '" . esc_html($options['body_font']) . "', sans-serif; }";
    if(!empty($options['body_font_size'])) echo "body { font-size: " . intval($options['body_font_size']) . "px; }";
    
    // Colors
    if(!empty($options['site_background_color'])) echo "body { background-color: " . esc_html($options['site_background_color']) . "; }";
    if(!empty($options['link_color'])) echo "a { color: " . esc_html($options['link_color']) . "; }";
    
    // Header
    if(!empty($options['header_bg_color'])) echo ".site-header { background-color: " . esc_html($options['header_bg_color']) . "; }";
    if(!empty($options['header_font_color'])) echo ".site-header, .site-header a, .site-title a { color: " . esc_html($options['header_font_color']) . "; }";
    
    // Footer
    if(!empty($options['footer_bg_color'])) echo ".site-footer { background-color: " . esc_html($options['footer_bg_color']) . "; }";
    if(!empty($options['footer_font_color'])) echo ".site-footer, .site-footer a, .site-footer .widget-title { color: " . esc_html($options['footer_font_color']) . "; }";

    // Grid Items
    if(!empty($options['grid_item_bg_color'])) echo ".grid-item { background-color: " . esc_html($options['grid_item_bg_color']) . "; }";
    if(!empty($options['grid_item_border_color'])) echo ".grid-item { border-color: " . esc_html($options['grid_item_border_color']) . "; }";
    if(!empty($options['grid_item_font_color'])) echo ".grid-item h2 { color: " . esc_html($options['grid_item_font_color']) . "; }";

    echo '</style>';
}
add_action('wp_head', 'stotramala_dynamic_css');

// 8. Enqueue Google Fonts
function stotramala_enqueue_google_fonts() {
    $options = get_option('stotramala_settings');
    $heading_font = $options['heading_font'] ?? 'Roboto';
    $body_font = $options['body_font'] ?? 'Open Sans';
    $fonts_url = 'https://fonts.googleapis.com/css?family=' . str_replace(' ', '+', $heading_font) . ':400,700|' . str_replace(' ', '+', $body_font) . ':400,700';
    wp_enqueue_style('stotramala-google-fonts', $fonts_url, [], null);
}
add_action('wp_enqueue_scripts', 'stotramala_enqueue_google_fonts');
