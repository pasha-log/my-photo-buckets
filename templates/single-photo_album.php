<?php
// File: single-photo_album.php

function wp_get_attachment( $attachment_id ) {
    $attachment = get_post( $attachment_id );
    return array(
        'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
        'caption' => $attachment->post_excerpt,
        'description' => $attachment->post_content,
        'href' => get_permalink( $attachment->ID ),
        'src' => $attachment->guid,
        'title' => $attachment->post_title
    );
}

get_header();

echo '<div class="album-page-single">';

// Title bar
echo '<div class="title-bar">';
echo '<h1 id="album-name" aria-label="the name of the presented service">' . get_the_title() . '</h1>';
echo '</div>';

echo '<nav class="tab-bar" role="navigation" aria-label="Photo Albums Navigation">';
echo '<div class="toggle-container">';
echo '<span class="menu-text-portfolio">Services Menu</span>';
echo '<button class="accordion-toggle" aria-controls="album-menu" aria-expanded="false" aria-label="toggle services menu">';
echo '<svg class="arrow-down" width="2rem" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M5.70711 9.71069C5.31658 10.1012 5.31658 10.7344 5.70711 11.1249L10.5993 16.0123C11.3805 16.7927 12.6463 16.7924 13.4271 16.0117L18.3174 11.1213C18.708 10.7308 18.708 10.0976 18.3174 9.70708C17.9269 9.31655 17.2937 9.31655 16.9032 9.70708L12.7176 13.8927C12.3271 14.2833 11.6939 14.2832 11.3034 13.8927L7.12132 9.71069C6.7308 9.32016 6.09763 9.32016 5.70711 9.71069Z" fill="#6b4c29"></path> </g></svg>';
echo '<svg class="arrow-up" width="2rem" style="display: none;" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M18.2929 15.2893C18.6834 14.8988 18.6834 14.2656 18.2929 13.8751L13.4007 8.98766C12.6195 8.20726 11.3537 8.20757 10.5729 8.98835L5.68257 13.8787C5.29205 14.2692 5.29205 14.9024 5.68257 15.2929C6.0731 15.6835 6.70626 15.6835 7.09679 15.2929L11.2824 11.1073C11.673 10.7168 12.3061 10.7168 12.6966 11.1073L16.8787 15.2893C17.2692 15.6798 17.9024 15.6798 18.2929 15.2893Z" fill="#6b4c29"></path> </g></svg>';
echo '</button>';
echo '</div>';

echo '<div id="album-menu" class="album-menu">';

$current_url = get_permalink();

echo '<a href="https://danvillehardwood.com/photo_album/">Back to Services</a>';

// Query for all categories and add them to the navbar
$args = array(
    'post_type' => 'photo_album',
    'posts_per_page' => -1
);

$photo_albums = array_reverse(get_posts($args));

foreach ($photo_albums as $photo_album) {
    $link = get_permalink($photo_album);
    echo '<a href="' . esc_url($link) . '"' . ($link == $current_url ? ' class="current"' : '') . '>' . esc_html($photo_album->post_title) . '</a>';
}

echo '</div>';
echo '</nav>';

// Check if there is a gallery in the post content
$gallery = get_post_gallery_images_with_info($post);
if ($gallery) {

    echo '<div class="gallery" role="region" aria-label="Photo Gallery">';
        foreach( $gallery as $image_obj ) {  
            echo '<div id="image-container">';
            echo '<a id="fancybox-wrapper" data-fancybox="gallery" href="' . esc_url($image_obj['url']) . '" data-caption="' . $image_obj['caption'] . '" aria-label="Zoom in on image: ' . esc_attr($image_obj['caption']) . '">';
            echo '<img id="fancybox-image" decoding="async" src="' . esc_url($image_obj['url']) . '" alt="' . esc_attr($image_obj['caption']) . '" loading="lazy">';
            echo '</a>';
            echo '<p class="image-label-portfolio" aria-label="image caption">' . esc_html($image_obj['caption']) . '</p>';
            echo '</div>';
        }
    echo '</div>';
} else {
    echo '<div class="no-photos-container"><h2 id="no-photos">No photos in this album yet.</h2></div>';
}

echo '</div>';

get_footer();