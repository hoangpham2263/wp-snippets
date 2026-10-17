<?php
function sc_view_more_products_shortcode()
{

  ob_start();
?>
  <div class="view-more-products-wrapper col-span-12 flex justify-center pt-6 pb-4">
    <button id="view-more-products-button" class="px-10 py-4 font-medium bg-primary text-white uppercase cursor-pointer" data-page="1" data-total="0">Xem thêm sản phẩm</button>
  </div>
  <script>
    jQuery(document).ready(function($) {
      const button = $('#view-more-products-button');
      let isLoading = false;
      
      // Load initial count
      $.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'POST',
        data: {
          action: 'get_initial_products_count',
          posts_per_page: 30
        },
        success: function(response) {
          if (response.success && response.data.remaining > 0) {
            button.text('Xem thêm ' + response.data.remaining + ' sản phẩm');
          }
        }
      });
      
      button.on('click', function() {
        if (isLoading) return;
        
        isLoading = true;
        const currentPage = parseInt($(this).data('page')) || 1;
        const nextPage = currentPage + 1;
        
        // Add loading state
        const originalText = $(this).text();
        $(this).text('Đang tải...').prop('disabled', true);
        
        $.ajax({
          url: '<?php echo admin_url('admin-ajax.php'); ?>',
          type: 'POST',
          data: {
            action: 'load_more_products',
            page: nextPage,
            posts_per_page: 30
          },
          success: function(response) {
            if (response.success && response.data.html) {
              // Append new products before the view more button wrapper
              $('.view-more-products-wrapper').before(response.data.html);
              
              // Update page number
              button.data('page', nextPage);
              
              // Check if there are more products
              if (!response.data.has_more) {
                button.hide();
              } else {
                // Update button text with total remaining products count
                if (response.data.total_remaining > 0) {
                  button.text('Xem thêm ' + response.data.total_remaining + ' sản phẩm').prop('disabled', false);
                } else {
                  button.text('Xem thêm sản phẩm').prop('disabled', false);
                }
              }
            } else {
              button.text(originalText).prop('disabled', false);
            }
            isLoading = false;
          },
          error: function(error) {
            console.error('Error loading products:', error);
            button.text(originalText).prop('disabled', false);
            isLoading = false;
          }
        });
      });
    });
  </script>
<?php
  return ob_get_clean();
}
add_shortcode('sc_view_more_products', 'sc_view_more_products_shortcode');

// AJAX handler for loading more products
function load_more_products() {
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 30;
    
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $posts_per_page,
        'paged' => $page,
        'post_status' => 'publish',
        'meta_query' => WC()->query->get_meta_query(),
        'tax_query' => WC()->query->get_tax_query(),
    );
    
    // Get current query vars if on shop/category page
    if (is_shop() || is_product_category() || is_product_tag()) {
        global $wp_query;
        if (isset($wp_query->query_vars['product_cat'])) {
            $args['product_cat'] = $wp_query->query_vars['product_cat'];
        }
        if (isset($wp_query->query_vars['product_tag'])) {
            $args['product_tag'] = $wp_query->query_vars['product_tag'];
        }
    }
    
    $query = new WP_Query($args);
    
    ob_start();
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            global $product;
            
            // Use WooCommerce template
            wc_get_template_part('content', 'product');
        }
    }
    
    $html = ob_get_clean();
    
    // Check if there are more products
    $has_more = ($page < $query->max_num_pages);
    
    // Calculate remaining products
    $total_products = $query->found_posts;
    $products_shown = $page * $posts_per_page;
    $total_remaining = max(0, $total_products - $products_shown);
    
    wp_reset_postdata();
    
    wp_send_json_success(array(
        'html' => $html,
        'has_more' => $has_more,
        'max_pages' => $query->max_num_pages,
        'current_page' => $page,
        'total_products' => $total_products,
        'total_remaining' => $total_remaining
    ));
}
add_action('wp_ajax_load_more_products', 'load_more_products');
add_action('wp_ajax_nopriv_load_more_products', 'load_more_products');

// AJAX handler for getting initial products count
function get_initial_products_count() {
    $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 30;
    
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 1, // We just need the total count
        'post_status' => 'publish',
        'meta_query' => WC()->query->get_meta_query(),
        'tax_query' => WC()->query->get_tax_query(),
    );
    
    $query = new WP_Query($args);
    $total = $query->found_posts;
    
    // Get number of products already shown on page
    global $wp_query;
    $already_shown = isset($wp_query->post_count) ? $wp_query->post_count : 0;
    
    $remaining = max(0, $total - $already_shown);
    
    wp_send_json_success(array(
        'total' => $total,
        'remaining' => $remaining,
        'already_shown' => $already_shown
    ));
}
add_action('wp_ajax_get_initial_products_count', 'get_initial_products_count');
add_action('wp_ajax_nopriv_get_initial_products_count', 'get_initial_products_count');

// Keep existing pre_get_posts filter
add_action('pre_get_posts', function ($query) {
  if (isset($_GET['cs-view-more-products'])) {
    $per_page = $_GET['cs-view-more-products'];
    $query->set('posts_per_page', $per_page);
  }
});
?>