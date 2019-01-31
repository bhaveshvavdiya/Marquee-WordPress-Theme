<?php

/* Load CSS */
function load_css()
{
    wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), false, 'all');
    wp_enqueue_style('bootstrap');

    wp_register_style('style', get_template_directory_uri() . '/style.css', array(), false, 'all');
    wp_enqueue_style('style');
} 
add_action('wp_enqueue_scripts', 'load_css');


/* Load jQuery */
function include_jquery()
{
    wp_deregister_script('jquery');
    wp_register_script('jquery', get_template_directory_uri() . '/js/jquery-3.3.1.min.js', '', 1, true);
    wp_enqueue_script('jquery');

}
add_action('wp_enqueue_scripts', 'include_jquery');


/* Load js */
function load_js()
{

    wp_register_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', '', false, true);
    wp_enqueue_script('bootstrap');

    wp_register_script('popper', get_template_directory_uri() . '/js/popper.min.js', '', false, true);
    wp_enqueue_script('popper');

    wp_register_script('comman', get_template_directory_uri() . '/js/comman.js', '', 1, true);
    wp_enqueue_script('comman');
}
add_action('wp_enqueue_scripts', 'load_js');

/* Base URL*/
function base_url(){
  return sprintf(
    "%s://%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME']
  );
}
	


add_theme_support( 'custom-header' );

add_theme_support('menus');

add_theme_support('post-thumbnails');

register_nav_menus(
	array(
		'top-menu' => __('Top Menu', 'theme'),
		'footer-menu' => __('Footer Menu', 'theme')
	)
);


add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class($classes, $item){
     if( in_array('current-menu-item', $classes) ){
         $classes[] = 'nav-item active ';
     } else {
         $classes[] = 'nav-item ';     	
     }
     return $classes;
}

function wpdocs_add_menu_parent_class( $items ) {
    $parents = array();
 
    // Collect menu items with parents.
    foreach ( $items as $item ) {
        if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
            $parents[] = $item->menu_item_parent;
        }
    }
 
    // Add class.
    foreach ( $items as $item ) {
        if ( in_array( $item->ID, $parents ) ) {
            $item->classes[] = 'dropdown mega-dropdown';
        }
    }
    return $items;
}
add_filter( 'wp_nav_menu_objects', 'wpdocs_add_menu_parent_class' );

add_filter( 'nav_menu_link_attributes', 'wpse156165_menu_add_class', 10, 3 );

function wpse156165_menu_add_class( $atts, $item, $args ) {
    $class = 'nav-link dropdown-toggle'; // or something based on $item
    $atts['class'] = $class;
    $atts['role'] = 'button';
    $atts['data-toggle'] = 'dropdown';
    $atts['aria-haspopup'] = 'true';
    $atts['aria-expanded'] = 'false';
    return $atts;
}
class WPSE_78121_Sublevel_Walker extends Walker_Nav_Menu
{
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class='dropdown-menu mega-dropdown-menu' aria-labelledby='navbarDropdown'><div class='container'><ul class='sub-menu'>\n";                            
    }
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul></div></div>\n";
    }
}
add_theme_support( 'title-tag' );

add_image_size('smallest', 300, 300, true);
add_image_size('largest', 800, 800, true);

/* Footer Code */

register_sidebar( 
        array(
            'name'         => __( 'Footer Area Four', 'twentyeleven' ),
            'id'          => 'sidebar-6',
            'description'      => __( 'An optional widget area for your site footer', 'twentyeleven' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => "</aside>",
            'before_title'  => '<h3 class="widget-title">',
            'after_title'      => '</h3>',
        )
);
 
function twentyeleven_footer_sidebar_class() {
    $count = 0;
    if ( is_active_sidebar( 'sidebar-3' ) )
        $count++;
    if ( is_active_sidebar( 'sidebar-4' ) )
        $count++;
    if ( is_active_sidebar( 'sidebar-5' ) )
        $count++;
    if ( is_active_sidebar( 'sidebar-6' ) )
        $count++;
    $class = '';
 
    switch ( $count ) {
        case '1':
            $class = 'one';
            break;
        case '2':
            $class = 'two';
            break;
        case '3':
            $class = 'three';
            break;
        case '4':
            $class = 'four';
            break;
    }
	if ( $class )
	    echo 'class="' . $class . '"';
}


if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name' => 'Footer Left',
        'id'   => 'footer-left-widget',
        'description'   => 'Left Footer widget position.',
        'before_widget' => '<div id="%1$s">',
        'after_widget'  => '</div>'
    ));

    register_sidebar(array(
        'name' => 'Footer Right',
        'id'   => 'footer-right-widget',
        'description'   => 'Right Footer widget position.',
        'before_widget' => '<div id="%1$s">',
        'after_widget'  => '</div>'
    ));


}


// Setup the WordPress core custom background feature.
/*add_theme_support( 'custom-background', apply_filters( 'colormag_custom_background_args', array(
    'default-color' => 'eaeaea',
) ) );*/

function marquee_customize_register( $wp_customize ) {
    $wp_customize->add_setting('mq_theme_color', array(
        'default' => '#0f465a',
        'transport' => 'refresh',
    ));
    $wp_customize->add_setting('mq_theme_footer_color', array(
        'default' => '#26586a',
        'transport' => 'refresh',
    ));
    $wp_customize->add_section('mq_standard_color', array(
        'title' => __('Standard Color', 'Marquee'),
        'priority' => 30,
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mq_theme_color_control', array(
            'label' => __('Theme Color', 'Marquee'),
            'section' => 'mq_standard_color',
            'settings' => 'mq_theme_color',
    )));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mq_theme_footer_color_control', array(
            'label' => __('Theme Footer Color', 'Marquee'),
            'section' => 'mq_standard_color',
            'settings' => 'mq_theme_footer_color',
    )));

    // Support anaytics
    $wp_customize->add_setting('mq_theme_tracking_id', array(
        'default' => ''
    ));
    $wp_customize->add_setting('mq_theme_tag_manager_id', array(
        'default' => ''
    ));
    $wp_customize->add_section('mq_standard_analytics', array(
        'title' => __('Analytics', 'Marquee'),
        'priority' => 30,
    ));
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'mq_theme_tracking_id_control', array(
            'label' => __('Google Analytic Tracking ID', 'Marquee'),
            'section' => 'mq_standard_analytics',
            'settings' => 'mq_theme_tracking_id',
    )));
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'mq_theme_tag_manager_id_control', array(
            'label' => __('Tag Manager ID', 'Marquee'),
            'section' => 'mq_standard_analytics',
            'settings' => 'mq_theme_tag_manager_id',
    )));
}

add_action('customize_register', 'marquee_customize_register');


function marquee_render_customize_css() { ?>
    <style>
        
        :root {
          --main-theme-color: <?php echo get_theme_mod('mq_theme_color');?>; 
          --main-theme-footer-color: <?php echo get_theme_mod('mq_theme_footer_color');?>; 
        }
    </style>
<?php }
add_action('wp_head', 'marquee_render_customize_css');


function marquee_render_customize_analytics() { ?>
    <?php 
    $mq_theme_tracking_id =  get_theme_mod('mq_theme_tracking_id');
    if(!empty($mq_theme_tracking_id)) { 
    ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $mq_theme_tracking_id; ?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', '<?php echo $mq_theme_tracking_id; ?>');
    </script>
    <?php } ?>

    <?php 
    $mq_theme_tag_manager_id =  get_theme_mod('mq_theme_tag_manager_id');
    if(!empty($mq_theme_tag_manager_id)) { 
    ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','<?php echo $mq_theme_tag_manager_id; ?>');</script>
    <!-- End Google Tag Manager -->
    <?php } ?>

<?php }
add_action('wp_head', 'marquee_render_customize_analytics', 2);



function marquee_render_customize_analytics_body() { ?>
    <?php 
    $mq_theme_tag_manager_id =  get_theme_mod('mq_theme_tag_manager_id');
    if(!empty($mq_theme_tag_manager_id)) { 
    ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $mq_theme_tag_manager_id; ?>"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php } ?>
<?php }

add_action( 'shutdown', 'marquee_render_customize_analytics_body', -537 );

?>