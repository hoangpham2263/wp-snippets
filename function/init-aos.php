<?php 
add_action('wp_enqueue_scripts', function () {
  wp_enqueue_style('aos-style', 'https://unpkg.com/aos@2.3.1/dist/aos.css', array(), '2.3.1');
  wp_enqueue_script('aos-script', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array(), '2.3.1', true);
});

// Initialize AOS in footer
add_action('wp_footer', function () {
?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      AOS.init({
        duration: 800,
        once: true,
        offset: 100
      });
    });
  </script>
<?php
});
?>