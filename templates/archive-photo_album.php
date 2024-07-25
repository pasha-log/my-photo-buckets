<?php
// File: archive-photo_album.php

get_header();

// Title bar
echo '<div class="main-album-archive">';
echo '<div class="title-bar">';
echo '<h1 id="album-name" aria-label="our services examples">Our Services</h1>';
echo '<h2 id="album-subtitle">SEE REAL LIFE EXAMPLES</h2>';
echo '</div>';

echo generate_albums_content();

echo '</div>';

get_footer();