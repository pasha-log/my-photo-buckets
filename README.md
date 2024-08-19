## WordPress My Photo Buckets Plugin
**Description**
* Designed a custom WordPress plugin using the WordPress API.
* Optimized the plugin for scalability with lazy loading and accessibility with [WCAG 2.0 AA](https://www.w3.org/WAI/WCAG2AA-Conformance) compliance.
* Integrated the fancybox.js library.
* Implemented CRUD (Create, Read, Update, Delete) functions for custom-styled photo albums. Seamlessly integrated with [WordPress’s built-in gallery](https://developer.wordpress.org/themes/functionality/media/galleries/) creation feature. Image captions can be edited through the standard media library image viewer; the plugin will automatically display it in the album page below the photo and with Fancybox's `data-caption` attribute.
* WordPress admin can update the album featured image and category description within the single album editing page.
* To view the main album directory frontend, one can visit the slug `/photo_album`. Each album box links to it's own permalink with the slug `/photo_album/name-of-your-album`.
* The photo album directory alone can be deployed anywhere with the shortcode `[album_shortcode]`.

[LIVE DEMO](https://danvillehardwood.com/photo_album/)

**Technologies Used:**
- PHP
- JavaScript
- CSS
- HTML
- [Fancybox.js](https://fancyapps.com/fancybox/)
- [WordPress Developer Resources Functions](https://developer.wordpress.org/reference/functions/)

The photo album directory.
<img src='./screenshots/Screenshot (509).png' alt=''>

---

Inside a photo album.
<img src='./screenshots/Screenshot (510).png' alt=''>

---

The Fancybox modal when active.
<img src='./screenshots/Screenshot (500).png' alt=''>

---

The archive of each photo album in the WP Dashboard.
<img src='./screenshots/Screenshot (472).png' alt=''>

---

The gallery instance that can be edited.
<img src='./screenshots/Screenshot (473).png' alt=''>

---

The photo album description that can be edited and saved with when the blue "Update" button is clicked.
<img src='./screenshots/Screenshot (511).png' alt=''>