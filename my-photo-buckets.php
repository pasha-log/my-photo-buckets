<?php
/*
Plugin Name: My Photo Buckets
Description: This is a plugin for creating photo albums.
Version: 1.0
Author: Pasha Loguinov
*/

// Register the photo album post type
function mpb_register_photo_album_post_type() {
    $args = array(
        'public' => true,
        'label'  => 'Photo Albums',
        'supports' => array('title', 'editor', 'thumbnail'), 
        'menu_icon' => 'dashicons-format-gallery',
        'rewrite' => array('slug' => 'photo_album'),
        'has_archive' => true,
    );
    register_post_type('photo_album', $args);
}
add_action('init', 'mpb_register_photo_album_post_type');

// Load the template for the photo_album post type
function mpb_photo_album_template($archive_template) {
    global $post;

    error_log('Post type in mpb_photo_album_template: ' . $post->post_type);

    if ($post && $post->post_type == 'photo_album') {
        $archive_template = plugin_dir_path(__FILE__) . 'templates/archive-photo_album.php';
    }

    return $archive_template;
}

add_filter('archive_template', 'mpb_photo_album_template');

// Load the single template for the photo_album post type
function mpb_photo_album_single_template($single_template) {
    global $post;

    error_log('Post type in mpb_photo_album_single_template: ' . $post->post_type);

    if ($post && $post->post_type == 'photo_album') {
        $single_template = plugin_dir_path(__FILE__) . 'templates/single-photo_album.php';
    }

    return $single_template;
}

add_filter('single_template', 'mpb_photo_album_single_template');

// Generate the content for the photo albums
function generate_albums_content() {
    ob_start(); 

    $albums = array_reverse(get_posts(array(
        'post_type' => 'photo_album',
        'numberposts' => -1
    )));

    if (!empty($albums)) {
        $content = '<section class="wrapper-full tab-container effectTab-header" id="style_5">';
        $content .= '<div class="wrapper tab-item">';
        $content .= '<div class="custom-row">';
        $content .= '<div class="column-12 column-xs-12 tab">';
        $content .= '<div class="custom-row">';
        
        foreach ($albums as $album) {
            $thumbnail_url = get_the_post_thumbnail_url($album);
            $album_link = esc_url(get_permalink($album));
            $album_title = esc_html($album->post_title);
            $content .= '<div class="column-4 column-xs-12 column-sm-6 column-md-6 box-tab">';
            $content .= '<a href="' . $album_link . '" aria-label="See photo examples of ' . esc_attr($album_title) . '">';
            $content .= '<div class="effect effect-five col3-block-height" style="background-image: url(' . esc_url($thumbnail_url) . '); background-position: center;">';
            $content .= '<div class="tab-text">';
            $content .= '<h2>' . $album_title . '</h2>';
            $content .= '<p><i><strong>SEE PHOTOS</strong></i></p>';
            $content .= '</div>';
            $content .= '</div>';
            $content .= '</a>';
            $content .= '</div>';
        }
        
        $content .= '</div>';
        $content .= '</div>';
        $content .= '</div>';
        $content .= '</div>';
        $content .= '</section>';
    } else {
        $content = '<div class="no-photos-container"><h2 id="no-photos">No albums created yet.</h2></div>';
    }

    return ob_get_clean() . $content; 
}

add_action('init', function() {
    add_shortcode('album_shortcode', 'generate_albums_content');
});

// Get the gallery images with their info
function get_post_gallery_images_with_info($post) {
    $gallery = get_post_gallery($post, false);
    $images_with_info = [];

    if (!empty($gallery['ids'])) {
        $ids = explode(',', $gallery['ids']);
        foreach ($ids as $id) {
            $image_info = [];
            $image_info['url'] = wp_get_attachment_url($id);
            $image_info['caption'] = wp_get_attachment_caption($id);
            $images_with_info[] = $image_info;
        }
    }

    return $images_with_info;
}

// Enqueue necessary styles and scripts
function mpb_enqueue_scripts() {
    $script_path = plugin_dir_path(__FILE__) . 'js/portfolio-tabs.js';
    $script_version = filemtime($script_path);
    wp_enqueue_script('portfolio-tabs', plugin_dir_url(__FILE__) . 'js/portfolio-tabs.js', array('jquery'), $script_version, true);
    
    $header_script_path = plugin_dir_path(__FILE__) . 'js/header.js';
    $header_script_version = filemtime($header_script_path);
    wp_enqueue_script('header', plugin_dir_url(__FILE__) . 'js/header.js', array('jquery'), $header_script_version, true);

    wp_enqueue_script('fancybox', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js', array(), '5.0', true);

    $inline_script = '
        document.addEventListener("DOMContentLoaded", function() {
            Fancybox.bind("[data-fancybox=\"gallery\"]", {
                on: {
                    reveal: (fancybox) => {
                        const container = fancybox.container;
                        if (container) {
                            const firstFocusableElement = container.querySelector("a, button, input, [tabindex]:not([tabindex=\'-1\'])");
                            if (firstFocusableElement) {
                                firstFocusableElement.focus();
                            }
                        }
                    },
                    destroy: (fancybox) => {
                        if (fancybox.trigger) {
                        console.log("Returning focus to trigger:", fancybox.$trigger);
                            fancybox.trigger.focus();
                        }
                    }
                }
            });
        });
    ';
    wp_add_inline_script('fancybox', $inline_script);
}
add_action('wp_enqueue_scripts', 'mpb_enqueue_scripts');

function mpb_enqueue_styles() {
    $style_path = plugin_dir_path(__FILE__) . 'css/style.css';
    $style_version = filemtime($style_path);
    wp_enqueue_style('fancybox-css', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css');
    wp_enqueue_style('my-photo-buckets', plugin_dir_url(__FILE__) . 'css/style.css', array(), $style_version);
}
add_action('wp_enqueue_scripts', 'mpb_enqueue_styles');
