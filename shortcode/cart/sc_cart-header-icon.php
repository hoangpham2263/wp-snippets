<?php

/**
 * Cart Header Icon Shortcode
 * 
 * Creates a shopping cart icon that displays a dropdown menu on hover.
 * 
 * Usage:
 * [sc_cart_header_icon]
 * 
 */
function sc_cart_header_icon_shortcode($atts)
{
    $atts = shortcode_atts(array(), $atts, 'sc_cart_header_icon');
    
    // Get cart count
    $cart_count = 0;
    if (function_exists('WC')) {
        $cart_count = WC()->cart->get_cart_contents_count();
    }

    ob_start();
?>
    <div class="relative cart-icon-container" id="cart-icon-container">
        <!-- Cart Icon with Link -->
        <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="block relative">
            <div class="bg-linear-gradient-button glass-effect cursor-pointer p-2 bg-white rounded-full w-10 h-10 flex items-center justify-center relative">
                <svg width="23" height="20" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_5001_2948)">
                        <path d="M7.41031 13.393H7.41139C7.41229 13.393 7.41319 13.3929 7.41404 13.3929H19.6309C19.7773 13.3928 19.9197 13.3454 20.0366 13.2578C20.1535 13.1702 20.2385 13.0471 20.2787 12.9072L22.974 3.53219C23.0027 3.43255 23.0077 3.32766 22.9886 3.22578C22.9696 3.12389 22.927 3.0278 22.8642 2.94504C22.8014 2.86229 22.7201 2.79515 22.6267 2.74891C22.5334 2.70267 22.4305 2.67859 22.3262 2.67857H5.85633L5.37468 0.524375C5.34139 0.375638 5.25807 0.242625 5.13847 0.147291C5.01886 0.0519578 4.87012 2.05789e-06 4.7168 0L0.673828 0C0.30165 0 0 0.299777 0 0.669643C0 1.03951 0.30165 1.33929 0.673828 1.33929H4.17634C4.2616 1.72098 6.48137 11.6481 6.60913 12.2192C5.89303 12.5286 5.39062 13.2382 5.39062 14.0625C5.39062 15.1702 6.29751 16.0714 7.41211 16.0714H19.6309C20.003 16.0714 20.3047 15.7717 20.3047 15.4018C20.3047 15.0319 20.003 14.7321 19.6309 14.7321H7.41211C7.04061 14.7321 6.73828 14.4317 6.73828 14.0625C6.73828 13.6938 7.03957 13.3939 7.41031 13.393ZM21.4329 4.01786L19.1225 12.0536H7.95261L6.15573 4.01786H21.4329ZM6.73828 18.0804C6.73828 19.1881 7.64516 20.0893 8.75977 20.0893C9.87437 20.0893 10.7812 19.188 10.7812 18.0804C10.7812 16.9727 9.87437 16.0714 8.75977 16.0714C7.64516 16.0714 6.73828 16.9727 6.73828 18.0804ZM8.75977 17.4107C9.13127 17.4107 9.43359 17.7112 9.43359 18.0804C9.43359 18.4496 9.13127 18.75 8.75977 18.75C8.38826 18.75 8.08594 18.4496 8.08594 18.0804C8.08594 17.7112 8.38826 17.4107 8.75977 17.4107ZM16.2617 18.0804C16.2617 19.1881 17.1686 20.0893 18.2832 20.0893C19.3978 20.0893 20.3047 19.188 20.3047 18.0804C20.3047 16.9727 19.3978 16.0714 18.2832 16.0714C17.1686 16.0714 16.2617 16.9727 16.2617 18.0804ZM18.2832 17.4107C18.6547 17.4107 18.957 17.7112 18.957 18.0804C18.957 18.4496 18.6547 18.75 18.2832 18.75C17.9117 18.75 17.6094 18.4496 17.6094 18.0804C17.6094 17.7112 17.9117 17.4107 18.2832 17.4107Z" fill="currentColor" />
                    </g>
                    <defs>
                        <clipPath id="clip0_5001_2948">
                            <rect width="23" height="20" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
            </div>
            <!-- Cart Count Badge -->
            <span id="cart-count-badge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full min-w-[20px] h-5 px-1 flex items-center justify-center font-semibold z-10" style="display: <?php echo $cart_count > 0 ? 'flex' : 'none'; ?>;">
                <span id="cart-count-number"><?php echo esc_html($cart_count); ?></span>
            </span>
        </a>
    </div>

    <!-- Complete Cart Update System -->
    <script>
        (function() {
            // Kiểm tra xem đã init chưa để tránh duplicate
            if (window.cartSystemInitialized) {
                return;
            }
            window.cartSystemInitialized = true;

            // Global function to update cart count
            window.updateCartCount = function() {
                const ajaxUrl = "<?php echo admin_url('admin-ajax.php'); ?>";
                
                jQuery.ajax({
                    url: ajaxUrl,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        action: 'get_cart_count'
                    },
                    success: function(response) {
                        const count = response.count || 0;
                        const badge = document.getElementById('cart-count-badge');
                        const numberElement = document.getElementById('cart-count-number');
                        
                        if (badge && numberElement) {
                            numberElement.textContent = count;
                            badge.style.display = count > 0 ? 'flex' : 'none';
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to update cart count:', error);
                    }
                });
            };

            // Global function để trigger cart update event  
            window.triggerCartUpdate = function() {
                document.dispatchEvent(new CustomEvent('cart_updated'));
            };

            // Listen for custom cart update events
            document.addEventListener('cart_updated', function() {
                window.updateCartCount();
            });

            // Listen for WooCommerce events (if available)
            jQuery(document.body).on('added_to_cart removed_from_cart updated_cart_totals', function() {
                window.updateCartCount();
            });

            // Listen for HTMX events (if using HTMX)
            document.addEventListener('htmx:afterRequest', function(event) {
                // Check if the request was cart-related
                if (event.detail.requestConfig && 
                    (event.detail.requestConfig.path.includes('cart') || 
                     event.detail.requestConfig.path.includes('checkout'))) {
                    setTimeout(window.updateCartCount, 500);
                }
            });

            // Auto trigger cart update after WooCommerce AJAX operations
            jQuery(document).ajaxComplete(function(event, xhr, settings) {
                if (settings.url && settings.url.includes('admin-ajax.php') && 
                    settings.data && (
                        settings.data.includes('woocommerce_ajax_add_to_cart') || 
                        settings.data.includes('add-to-cart') ||
                        settings.data.includes('update_cart_quantity')
                    )) {
                    // Trigger cart update after successful cart operations
                    setTimeout(function() {
                        window.triggerCartUpdate();
                    }, 100);
                }
            });

            // Bind events to all buy now buttons
            function bindBuyNowButtons() {
                jQuery('[id^="js-buy-now-"]').off('click.cartUpdate').on('click.cartUpdate', function() {
                    // Trigger cart update sau khi click buy now
                    setTimeout(function() {
                        if (typeof window.triggerCartUpdate === 'function') {
                            window.triggerCartUpdate();
                        }
                    }, 500);
                });
            }

            // Initial bind
            bindBuyNowButtons();

            // Re-bind after HTMX loads new content
            document.addEventListener('htmx:afterSwap', bindBuyNowButtons);
            document.addEventListener('htmx:afterSettle', bindBuyNowButtons);

            // Re-bind after AJAX loads (for dynamic content)
            jQuery(document).ajaxComplete(function() {
                setTimeout(bindBuyNowButtons, 200);
            });

            // Manual refresh every 30 seconds (fallback)
            setInterval(window.updateCartCount, 30000);

            console.log('Cart update system initialized');
        })();
    </script>

<?php
    return ob_get_clean();
}

// Register shortcode
add_shortcode('sc_cart-header-icon', 'sc_cart_header_icon_shortcode');

// AJAX Handler for Cart Count (tự động register khi dùng shortcode)
if (!function_exists('get_cart_count_callback')) {
    add_action('wp_ajax_get_cart_count', 'get_cart_count_callback');
    add_action('wp_ajax_nopriv_get_cart_count', 'get_cart_count_callback');
    function get_cart_count_callback()
    {
        echo json_encode(['count' => WC()->cart->get_cart_contents_count()]);
        wp_die();
    }
}
?>