<?php
/*
Plugin Name: Cocovie Custom Shortcodes
Description: Includes user links, Polylang switcher, and AJAX product sidebar for Flatsome.
Version: 1.1
Author: Cocovie Team
*/

/* -------------------- USER LINKS SHORTCODE -------------------- */
add_shortcode('user_links', 'cocovie_user_links_shortcode');
function cocovie_user_links_shortcode($atts)
{
    ob_start(); ?>
    <ul class="flex p-0 gap-4 items-center" style="list-style:none;margin:0;padding:0;display:flex;gap:10px;align-items:center;">
        <?php if (!is_user_logged_in()): ?>
            <li><a href="<?= get_permalink(17) ?>" class="text-link">Đăng nhập</a></li>
            <li><a href="<?= get_permalink(19) ?>" class="text-link">Đăng ký</a></li>
        <?php else: ?>
            <li><a href="<?= get_permalink(14) ?>" class="text-link">Tài khoản</a></li>
        <?php endif; ?>
    </ul>
<?php
    return ob_get_clean();
}


/* -------------------- POLYLANG SWITCHER SHORTCODE -------------------- */
add_shortcode('polylang_langswitcher', 'custom_polylang_langswitcher');
function custom_polylang_langswitcher()
{
    $output = '';
    if (function_exists('pll_the_languages')) {
        $args = [
            'show_flags' => 1,
            'show_names' => 0,
            'hide_if_empty' => 0,
            'hide_current' => 0,
            'echo' => 0,
        ];
        $output = '<ul class="polylang_langswitcher flex gap-2" style="display:flex;gap:8px;list-style:none;margin:0;padding:0;">' . pll_the_languages($args) . '</ul>';
    }
    return $output;
}


/* -------------------- WC PRODUCT SIDEBAR SHORTCODE -------------------- */
add_shortcode('hp_shop_page_sidebar', 'hp_shop_page_sidebar_shortcode');
function hp_shop_page_sidebar_shortcode()
{
    ob_start();

    // Detect current category
    $current_cat = get_queried_object();
    $current_cat_id = 0;
    if (isset($current_cat->term_id) && $current_cat->taxonomy === 'product_cat') {
        $current_cat_id = $current_cat->term_id;
    }

    // Get next-level child categories
    $categories = get_terms([
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
        'parent'     => $current_cat_id,
    ]);

    // Attribute terms
    $chucnang_terms = get_terms(['taxonomy' => 'pa_chuc-nang', 'hide_empty' => false]);
    $gioitinh_terms = get_terms(['taxonomy' => 'pa_gioi-tinh', 'hide_empty' => false]);
    $size_terms     = get_terms(['taxonomy' => 'pa_size', 'hide_empty' => false]);
?>
    <div class="hp_shop_page_sidebar">

        <div class="filter-section">
            <h2 class="text-sm font-medium text-zinc-800">Bộ lọc</h2>
        </div>

        <!-- Danh mục -->
        <?php if (!empty($categories)) : ?>
            <div class="filter-section">
                <h3>Danh mục</h3>
                <ul>
                    <?php foreach ($categories as $category) : ?>
                        <li><a href="<?php echo esc_url(get_term_link($category)); ?>"><?php echo esc_html($category->name); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Chức năng -->
        <?php if (!empty($chucnang_terms)) : ?>
            <div class="filter-section">
                <h3>Chức năng</h3>
                <ul>
                    <?php foreach ($chucnang_terms as $term) : ?>
                        <li><label><input type="checkbox" name="doituongsudung" value="<?php echo esc_attr($term->term_id); ?>"><?php echo esc_html($term->name); ?></label></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Giới tính -->
        <?php if (!empty($gioitinh_terms)) : ?>
            <div class="filter-section">
                <h3>Giới tính</h3>
                <ul>
                    <?php foreach ($gioitinh_terms as $term) : ?>
                        <li><label><input type="checkbox" name="gioitinh" value="<?php echo esc_attr($term->term_id); ?>"><?php echo esc_html($term->name); ?></label></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Size -->
        <?php if (!empty($size_terms)) : ?>
            <div class="filter-section">
                <h3>Size</h3>
                <ul>
                    <?php foreach ($size_terms as $term) : ?>
                        <li><label><input type="checkbox" name="size" value="<?php echo esc_attr($term->term_id); ?>"><?php echo esc_html($term->name); ?></label></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

    </div>

    <style>
        .hp_shop_page_sidebar .filter-section {
            margin-bottom: 12px;
        }

        .hp_shop_page_sidebar h2 {
            font-size: 20px;
            font-weight: 600;
            border-bottom: 1px solid #E5E7EB;
            padding-bottom: 10px;
            text-transform: uppercase;
            color: #121212;
        }

        .hp_shop_page_sidebar h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #121212;
        }

        .hp_shop_page_sidebar ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .hp_shop_page_sidebar li {
            margin-bottom: 0px;
            margin-left: 12px !important;
        }

        .hp_shop_page_sidebar a {
            font-size: 14px;
            font-weight: 400;
            color: #121212;
            text-decoration: none;
            display: block;
            transition: color 0.3s ease;
            padding: 5px 0;
        }

        .hp_shop_page_sidebar a:hover {
            color: #0AB04B;
        }

        .hp_shop_page_sidebar label {
            cursor: pointer;
            display: flex;
            align-items: center;
            font-size: 14px;
            font-weight: 400;
            color: #121212;
        }

        .hp_shop_page_sidebar input[type=checkbox] {
            margin-right: 8px;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .hp_shop_page_sidebar p {
            color: #121212;
            font-size: 14px;
            font-weight: 400;
        }

        .hp_shop_page_sidebar .filter-section-empty {
            color: #121212;
            font-size: 14px;
            font-weight: 400;
            margin-left: 12px !important;
        }

        .hp_shop_page_sidebar .filter-section-not-found {
            color: #121212;
            width: 100%;
            text-align: center;
            padding: 100px 0;
            font-weight: 400;
        }
    </style>

    <script>
        (function() {
            const sidebar = document.querySelector('.hp_shop_page_sidebar');
            if (!sidebar) return;

            // Function to get current page from URL
            function getCurrentPage() {
                const urlParams = new URLSearchParams(window.location.search);
                return parseInt(urlParams.get('paged')) || 1;
            }

            // Function to get posts per page from WooCommerce settings
            function getPostsPerPage() {
                // Try to get from Flatsome settings or default to 12
                const perPageElement = document.querySelector('.woocommerce-result-count');
                if (perPageElement) {
                    const text = perPageElement.textContent;
                    const match = text.match(/of (\d+)/);
                    if (match) return parseInt(match[1]);
                }
                return 12; // Default
            }

            // Function to load products with AJAX
            function loadProducts(page = 1) {
                let params = new URLSearchParams(window.location.search);
                
                function updateFilterParam(name) {
                    let values = [...sidebar.querySelectorAll(`input[name=${name}]:checked`)].map(i => i.value);
                    if (values.length > 0) params.set('cs' + name, values.join(','));
                    else params.delete('cs' + name);
                }

                updateFilterParam('doituongsudung');
                updateFilterParam('gioitinh');
                updateFilterParam('size');

                // Update pagination in URL
                if (page > 1) {
                    params.set('paged', page);
                } else {
                    params.delete('paged');
                }

                let newurl = window.location.pathname + '?' + params.toString();
                window.history.replaceState(null, '', newurl);

                let xhr = new XMLHttpRequest();
                let formData = new FormData();
                formData.append('action', 'filterproductssidebar');
                formData.append('paged', page);
                formData.append('posts_per_page', getPostsPerPage());
                
                params.forEach((value, key) => formData.append(key, value));

                xhr.open('POST', '<?php echo admin_url('admin-ajax.php'); ?>', true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        try {
                            let response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                // Update products
                                let productContainer = document.querySelector('.products');
                                if (productContainer && response.data.productshtml) {
                                    productContainer.innerHTML = response.data.productshtml;
                                }
                                
                                // Update pagination
                                let paginationContainer = document.querySelector('.woocommerce-pagination');
                                if (response.data.paginationhtml) {
                                    if (paginationContainer) {
                                        paginationContainer.outerHTML = response.data.paginationhtml;
                                    } else {
                                        // Add pagination after products if it doesn't exist
                                        let afterProducts = document.querySelector('.products').nextElementSibling;
                                        if (afterProducts) {
                                            afterProducts.insertAdjacentHTML('beforebegin', response.data.paginationhtml);
                                        }
                                    }
                                    
                                    // Re-bind pagination click events
                                    bindPaginationEvents();
                                } else if (paginationContainer) {
                                    paginationContainer.remove();
                                }
                            }
                        } catch (error) {
                            console.error('Error parsing AJAX response:', error);
                        }
                    } else {
                        console.error('AJAX error:', xhr.status, xhr.statusText);
                    }
                };
                xhr.send(formData);
            }

            // Function to bind pagination click events
            function bindPaginationEvents() {
                const paginationLinks = document.querySelectorAll('.woocommerce-pagination a');
                paginationLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const href = this.getAttribute('href');
                        const urlParams = new URLSearchParams(href.split('?')[1]);
                        const page = parseInt(urlParams.get('paged')) || 1;
                        loadProducts(page);
                    });
                });
            }

            // Handle filter changes
            sidebar.addEventListener('change', function(e) {
                if (e.target.matches('input[type=checkbox]')) {
                    loadProducts(1); // Reset to page 1 when filters change
                }
            });

            // Bind initial pagination events
            bindPaginationEvents();
        })();
    </script>
<?php
    return ob_get_clean();
}


/* -------------------- AJAX HANDLER -------------------- */
add_action('wp_ajax_filterproductssidebar', 'hp_filter_products_sidebar');
add_action('wp_ajax_nopriv_filterproductssidebar', 'hp_filter_products_sidebar');

function hp_filter_products_sidebar()
{
    $tax_query = ['relation' => 'AND'];

    if (!empty($_POST['csdoituongsudung'])) {
        $tax_query[] = [
            'taxonomy' => 'pa_chuc-nang',
            'field'    => 'term_id',
            'terms'    => array_map('intval', explode(',', sanitize_text_field($_POST['csdoituongsudung']))),
            'operator' => 'IN',
        ];
    }

    if (!empty($_POST['csgioitinh'])) {
        $tax_query[] = [
            'taxonomy' => 'pa_gioi-tinh',
            'field'    => 'term_id',
            'terms'    => array_map('intval', explode(',', sanitize_text_field($_POST['csgioitinh']))),
            'operator' => 'IN',
        ];
    }

    if (!empty($_POST['cssize'])) {
        $tax_query[] = [
            'taxonomy' => 'pa_size',
            'field'    => 'term_id',
            'terms'    => array_map('intval', explode(',', sanitize_text_field($_POST['cssize']))),
            'operator' => 'IN',
        ];
    }

    // Get pagination parameters
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : get_option('posts_per_page', 12);

    $args = [
        'post_type' => 'product',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'tax_query' => $tax_query,
    ];

    $query = new WP_Query($args);

    ob_start();
    if ($query->have_posts()) {
        woocommerce_product_loop_start();
        while ($query->have_posts()) {
            $query->the_post();
            wc_get_template_part('content', 'product');
        }
        woocommerce_product_loop_end();
    } else {
        echo '<p class="filter-section-not-found">Không tìm thấy sản phẩm phù hợp.</p>';
    }
    
    // Generate pagination HTML
    $pagination_html = '';
    if ($query->max_num_pages > 1) {
        $pagination_html = '<nav class="woocommerce-pagination">';
        $pagination_html .= paginate_links([
            'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
            'format' => '?paged=%#%',
            'current' => max(1, $paged),
            'total' => $query->max_num_pages,
            'prev_text' => '&larr;',
            'next_text' => '&rarr;',
            'type' => 'list',
        ]);
        $pagination_html .= '</nav>';
    }
    
    wp_reset_postdata();

    wp_send_json_success([
        'productshtml' => ob_get_clean(),
        'paginationhtml' => $pagination_html,
        'max_pages' => $query->max_num_pages
    ]);
}