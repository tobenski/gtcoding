<?php  

// Adding th Css and JS files
function gt_setup() {
    wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Roboto|Roboto+Condensed|Roboto+Slab');
    wp_enqueue_style( 'font-awesome', '//use.fontawesome.com/releases/v5.1.0/css/all.css');
    wp_enqueue_style('style', get_stylesheet_uri(), null, microtime(), 'all');
    wp_enqueue_script( "main", get_theme_file_uri( '/js/main.js' ), null, microtime(), true );
}

add_action( 'wp_enqueue_scripts', 'gt_setup' );

// Adding Theme Support

function gt_init() {
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'html5',
        array('comment-list', 'comment-form', 'search-form') 
    );
}

add_action( 'after_setup_theme', 'gt_init' );

// Projects Post Type

function gt_custom_post_type() {
    register_post_type( 'projects',
        array(
            'rewrite' => array('slug' => 'projects'),
            'labels' => array(
                'name' => 'Projects',
                'singular_name' => 'Project',
                'add_new_item' => 'Add New Project',
                'edit_item' => 'Edit Project'
            ),
            'menu-icon' => 'dashicons-clipboard', // https://developer.wordpress.org/resource/dashicons/#heart
            'public' => true,
            'has_archive' => true,
            'supports' => array(
                'title', 'thumbnail', 'editor', 'excerpt', 'comments'
            )
        )
    );
}

add_action( 'init', 'gt_custom_post_type' );

// Sidebar

function gt_widgets() {
    register_sidebar( 
        array(
            'name' => 'Main Sidebar',
            'id' => 'main_sidebar',
            'before_title' => '<h3>',
            'after_title' => '</h3>'
    ));
}

add_action( 'widgets_init', 'gt_widgets' );

// Filters

function search_filter($query) {
    if($query->is_search()) {
        $query->set('post_type', array('post', 'projects'));
    }
}

add_filter( 'pre_get_posts', 'search_filter');