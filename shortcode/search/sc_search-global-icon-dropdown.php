<?php

/**
 * Search Global Icon Dropdown Shortcode
 * 
 * Creates a clickable search icon that displays a dropdown search interface.
 * Supports searching both WooCommerce products and WordPress posts with real-time results.
 * 
 * Usage:
 * [sc_search-global-icon-dropdown]                                    // Basic usage
 * [sc_search-global-icon-dropdown placeholder="Search here..."]        // Custom placeholder
 * [sc_search-global-icon-dropdown search_types="product"]             // Products only
 * [sc_search-global-icon-dropdown search_types="post"]                // Posts only  
 * [sc_search-global-icon-dropdown product_limit="10" post_limit="5"]  // Custom limits
 * 
 * Parameters:
 * @param string $placeholder    - Search input placeholder text (default: "Nhập thông tin cần tìm...")
 * @param string $icon_class     - CSS classes for search icon (default: "js-search-icon-main cursor-pointer")
 * @param string $search_types   - Comma-separated list: "product,post" (default: "product,post")
 * @param int    $product_limit  - Max products to show (default: 5)
 * @param int    $post_limit     - Max posts to show (default: 8)
 */
function sc_search_global_icon_dropdown_shortcode($atts)
{
    // Generate unique ID for this instance
    $unique_id = 'search_' . wp_rand(100000, 999999) . '_' . time();

    $atts = shortcode_atts(array(
        'placeholder' => 'Nhập thông tin cần tìm...',
        'icon_class' => 'js-search-icon-main-' . $unique_id . ' cursor-pointer',
        'dropdown_id' => $unique_id . '_dropdown',
        'search_types' => 'product,post',
        'product_limit' => '4',
        'post_limit' => '4',
        'id_input_search' => $unique_id . '_input',
        'id_list_search_result' => $unique_id . '_results',
    ), $atts, 'sc_search-global-icon-dropdown');

    ob_start();
?>
    <!-- Search Icon and Dropdown Container -->
    <div class="lg:relative">
        <!-- Search Icon -->
        <div class="<?= esc_attr($atts['icon_class']) ?>">
            <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-secondary size-5 2xl:size-7 font-bold">
                <path d="M23.625 22.0781C24.0938 22.5469 24.0938 23.25 23.625 23.6719C23.4375 23.9062 23.1562 24 22.875 24C22.5469 24 22.2656 23.9062 22.0312 23.6719L15.75 17.3906C14.0625 18.75 11.9531 19.5 9.70313 19.5C4.35938 19.5 0 15.1406 0 9.75C0 4.40625 4.3125 0 9.70312 0C15.0469 0 19.4531 4.40625 19.4531 9.75C19.4531 12.0469 18.7031 14.1562 17.3438 15.7969L23.625 22.0781ZM2.25 9.75C2.25 13.9219 5.57813 17.25 9.75 17.25C13.875 17.25 17.25 13.9219 17.25 9.75C17.25 5.625 13.875 2.25 9.75 2.25C5.57812 2.25 2.25 5.625 2.25 9.75Z" fill="#F15F25" />
            </svg>
        </div>

        <!-- Search Dropdown (hidden by default) -->
        <div id="<?= esc_attr($atts['dropdown_id']) ?>" class="w-full lg:w-[400px] lg:max-w-[90vw]" style="display:none; position:absolute; top:calc(100% + 10px); right:0; transform:scaleX(0); transform-origin: right center; opacity:0; background:#f8fafc; border-radius:8px; box-shadow:0 4px 16px rgba(0,0,0,0.12); z-index:9999; padding:10px; transition: transform 0.3s cubic-bezier(.4,0,.2,1), opacity 0.3s cubic-bezier(.4,0,.2,1); font-size:16px;">
            <style>
                #<?= esc_attr($atts['dropdown_id']) ?>input[type="text"],
                #<?= esc_attr($atts['dropdown_id']) ?>input[type="search"],
                #<?= esc_attr($atts['dropdown_id']) ?>input[type="email"],
                #<?= esc_attr($atts['dropdown_id']) ?>textarea,
                #<?= esc_attr($atts['dropdown_id']) ?>select {
                    font-size: 16px !important;
                    -webkit-appearance: none;
                    -moz-appearance: none;
                    appearance: none;
                }

                .custom-scrollbar {
                    scrollbar-width: thin;
                    scrollbar-color: #CBD5E0 #F7FAFC;
                }

                .custom-scrollbar::-webkit-scrollbar {
                    width: 6px;
                }

                .custom-scrollbar::-webkit-scrollbar-track {
                    background: #F7FAFC;
                    border-radius: 3px;
                }

                .custom-scrollbar::-webkit-scrollbar-thumb {
                    background: #CBD5E0;
                    border-radius: 3px;
                }

                .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                    background: #A0AEC0;
                }

                .search-result-item.active {
                    background-color: #EBF8FF !important;
                    border-left: 3px solid #f15f25;
                }
            </style>
            <div class="absolute -top-2.5 right-16 lg:right-5 w-0 h-0 border-l-[12px] border-l-transparent border-r-[12px] border-r-transparent border-b-[12px] border-b-[#f8fafc] drop-shadow-[0_-2px_2px_rgba(0,0,0,0.08)]"></div>

            <!-- Search Form -->
            <div class="relative w-full lg:max-w-[488px]">
                <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="get" class="flex bg-white border border-[#CCCCCC] rounded-full items-center gap-2 lg:gap-5 px-5 py-[10px] w-full">
                    <input id="<?= esc_attr($atts['id_input_search']) ?>"
                        name="cs-search"
                        type="text"
                        class="bg-white placeholder:text-foreground text-[#666666] text-xs lg:text-sm w-full outline-none"
                        placeholder="<?= esc_attr($atts['placeholder']) ?>"
                        autocomplete="off">
                </form>

                <!-- Search Results -->
                <div id="<?= esc_attr($atts['id_list_search_result']) ?>"
                    class="w-full max-h-72 overflow-y-auto custom-scrollbar pt-2">
                </div>
            </div>
        </div>
    </div>

    <!-- Search Icon and Dropdown Script -->
    <script>
        (function() {
            const searchIcon = document.querySelector('.js-search-icon-main-<?= esc_js($unique_id) ?>');
            const dropdown = document.getElementById('<?= esc_js($atts['dropdown_id']) ?>');
            const searchInput = document.getElementById('<?= esc_js($atts['id_input_search']) ?>');
            const listSearchResult = document.getElementById('<?= esc_js($atts['id_list_search_result']) ?>');
            const searchTypes = '<?= esc_js($atts['search_types']) ?>';
            const productLimit = <?= intval($atts['product_limit']) ?>;
            const postLimit = <?= intval($atts['post_limit']) ?>;

            // Toggle dropdown on icon click
            searchIcon.addEventListener('click', function(e) {
                e.stopPropagation();
                if (dropdown.style.display === 'block') {
                    dropdown.style.transform = 'scaleX(0)';
                    dropdown.style.opacity = '0';
                    setTimeout(() => {
                        dropdown.style.display = 'none';
                    }, 300);
                } else {
                    dropdown.style.display = 'block';
                    setTimeout(() => {
                        dropdown.style.transform = 'scaleX(1)';
                        dropdown.style.opacity = '1';
                        searchInput.focus();
                    }, 10);
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!dropdown.contains(e.target) && !searchIcon.contains(e.target)) {
                    dropdown.style.transform = 'scaleX(0)';
                    dropdown.style.opacity = '0';
                    setTimeout(() => {
                        dropdown.style.display = 'none';
                    }, 300);
                }
            });

            function showSearchResult() {
                // Calculate max-height to fit within viewport
                const viewportHeight = window.innerHeight;
                const resultRect = listSearchResult.getBoundingClientRect();
                const availableHeight = viewportHeight - resultRect.top - 20;
                const contentHeight = listSearchResult.scrollHeight;

                // Set max-height and enable scroll if needed
                const maxHeight = Math.min(contentHeight, availableHeight, 730);
                listSearchResult.style.maxHeight = maxHeight + 'px';
                listSearchResult.style.overflowY = contentHeight > maxHeight ? 'auto' : 'hidden';

                listSearchResult.classList.remove('opacity-0');
                listSearchResult.classList.add('opacity-100');
            }

            function hideSearchResult() {
                listSearchResult.style.maxHeight = '0px';
                listSearchResult.classList.remove('opacity-100');
                listSearchResult.classList.add('opacity-0');
            }

            async function handleSearch() {
                const searchTerm = searchInput.value.trim();
                const ajax_url = "<?php echo admin_url('admin-ajax.php'); ?>";
                if (searchTerm.length === 0) {
                    return;
                }

                // Show loading state
                listSearchResult.innerHTML = '<div class="w-full h-8 flex items-center justify-center text-sm px-3"><div class="animate-spin rounded-full h-3 w-3 border-b-2 border-primary"></div><span class="ml-2 text-[#666666]">Đang tìm kiếm...</span></div>';
                showSearchResult();

                const params = new URLSearchParams({
                    action: 'search_global_content_dropdown_icon',
                    keyword: searchTerm,
                    search_types: searchTypes,
                    product_limit: productLimit,
                    post_limit: postLimit
                });

                fetch(`${ajax_url}?${params}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    listSearchResult.innerHTML = '';
                    if (data.success) {
                        let hasResults = false;

                        // Display products first
                        if (data.data.products && data.data.products.length > 0) {
                            hasResults = true;
                            listSearchResult.innerHTML += `
                            <div class="px-4 py-1 bg-gray-50 border-b border-gray-100">
                                <div class="text-xs font-semibold text-[#f15f25] uppercase tracking-wide">SẢN PHẨM</div>
                            </div>`;

                            data.data.products.forEach((item, index) => {
                                listSearchResult.innerHTML += `
                            <a href="${item.url}" class="block w-full px-3 py-2 hover:bg-gray-50 transition-colors duration-200 border-b border-gray-100 search-result-item" data-id="${item.id}" data-type="product">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg overflow-hidden flex items-center justify-center bg-gray-100 shrink-0">
                                        <img src="${item.image}" alt="${item.title}" class="w-full h-full object-cover" loading="lazy">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                    <div class="text-[13px] font-medium text-gray-900 truncate">${item.title}</div>
                                    <div class="text-[13px] mt-1">
                                        ${item.sale_price ? 
                                            `<span class="font-semibold text-[#f15f25]">${item.sale_price}</span> <span class="text-gray-400 line-through text-[13px]">${item.regular_price}</span>` 
                                            : `<span class="font-semibold text-[#f15f25]">${item.price}</span>`
                                        }
                                    </div>
                                    </div>
                                    <div class="shrink-0">
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            SP
                                        </span>
                                    </div>
                                </div>
                            </a>`;
                            });
                        }

                        // Display posts after products
                        if (data.data.posts && data.data.posts.length > 0) {
                            hasResults = true;
                            listSearchResult.innerHTML += `
                            <div class="px-4 py-1 bg-gray-50 border-b border-gray-100">
                                <div class="text-xs font-semibold text-[#f15f25] uppercase tracking-wide">BÀI VIẾT</div>
                            </div>`;

                            data.data.posts.forEach((item, index) => {
                                listSearchResult.innerHTML += `
                            <a href="${item.url}" class="block w-full px-3 py-1 hover:bg-gray-50 transition-colors duration-200 border-b border-gray-100 last:border-b-0 search-result-item" data-id="${item.id}" data-type="post">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg overflow-hidden flex items-center justify-center bg-gray-100 shrink-0">
                                        <img src="${item.image}" alt="${item.title}" class="w-full h-full object-cover" loading="lazy">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-[13px] font-medium text-gray-900 truncate">${item.title}</div>
                                       <div class="text-xs text-gray-500 mt-1 line-clamp-2">${item.excerpt}</div>
                                       <div class="text-xs text-gray-400 mt-1">${item.date}</div>
                                    </div>
                                    <div class="shrink-0">
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            BV
                                        </span>
                                    </div>
                                </div>
                            </a>`;
                            });
                        }

                        if (hasResults) {
                            showSearchResult();
                        } else {
                            listSearchResult.innerHTML = `<div class="w-full h-8 flex items-center justify-center text-sm text-gray-500 px-3">Không tìm thấy kết quả...</div>`;
                            showSearchResult();
                        }
                    } else {
                        listSearchResult.innerHTML = `<div class="w-full h-8 flex items-center justify-center text-sm text-gray-500 px-3">Không tìm thấy kết quả...</div>`;
                        showSearchResult();
                    }
                })
                .catch(error => {
                    console.error('Search error:', error);
                    listSearchResult.innerHTML = `<div class="w-full h-8 flex items-center justify-center text-sm text-red-500 px-3">Lỗi tìm kiếm! Vui lòng thử lại.</div>`;
                    showSearchResult();
                });
            }

            // Debounce function to prevent excessive API calls
            let searchTimeout;

            function debounceSearch() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(handleSearch, 300);
            }

            // Input event with debounce
            searchInput.addEventListener('input', function() {
                if (searchInput.value.trim() === '') {
                    listSearchResult.innerHTML = '';
                    hideSearchResult();
                    return;
                }
                debounceSearch();
            });

            // Enter key to search
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    handleSearch();
                }
            });

            // Focus input to show results if exists
            searchInput.addEventListener('focus', function() {
                if (listSearchResult.innerHTML.trim() !== '' && !listSearchResult.innerHTML.includes('Đang tìm kiếm')) {
                    showSearchResult();
                }
            });

            // Handle keyboard navigation in search results
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                    e.preventDefault();
                    const items = listSearchResult.querySelectorAll('.search-result-item');
                    if (items.length > 0) {
                        const currentActive = listSearchResult.querySelector('.search-result-item.active');
                        let nextIndex = 0;

                        if (currentActive) {
                            currentActive.classList.remove('active');
                            const currentIndex = Array.from(items).indexOf(currentActive);
                            nextIndex = e.key === 'ArrowDown' ?
                                Math.min(currentIndex + 1, items.length - 1) :
                                Math.max(currentIndex - 1, 0);
                        }

                        items[nextIndex].classList.add('active');
                        items[nextIndex].scrollIntoView({
                            behavior: 'smooth',
                            block: 'nearest'
                        });
                    }
                } else if (e.key === 'Enter') {
                    const activeItem = listSearchResult.querySelector('.search-result-item.active');
                    if (activeItem) {
                        e.preventDefault();
                        activeItem.click();
                    }
                }
            });

            // Add hover effects and active state management
            document.addEventListener('mouseover', function(e) {
                if (e.target.closest('.search-result-item')) {
                    // Remove active class from all items
                    listSearchResult.querySelectorAll('.search-result-item').forEach(item => {
                        item.classList.remove('active');
                    });
                    // Add active class to hovered item
                    e.target.closest('.search-result-item').classList.add('active');
                }
            });
        })();
    </script>
<?php
    return ob_get_clean();
}

// Register shortcode
add_shortcode('sc_search-global-icon-dropdown', 'sc_search_global_icon_dropdown_shortcode');

// AJAX handler for search dropdown icon
add_action('wp_ajax_search_global_content_dropdown_icon', 'handle_search_global_content_dropdown_icon');
add_action('wp_ajax_nopriv_search_global_content_dropdown_icon', 'handle_search_global_content_dropdown_icon');
function handle_search_global_content_dropdown_icon()
{
    $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
    $search_types = isset($_GET['search_types']) ? $_GET['search_types'] : 'product,post';
    $product_limit = isset($_GET['product_limit']) ? intval($_GET['product_limit']) : 5;
    $post_limit = isset($_GET['post_limit']) ? intval($_GET['post_limit']) : 5;

    if ($keyword === '') {
        wp_send_json_success(['products' => [], 'posts' => []]);
        wp_die();
    }

    $types = explode(',', $search_types);
    $results = array(
        'products' => array(),
        'posts' => array()
    );

    // Search Products
    if (in_array('product', $types)) {
        add_filter('posts_where', 'search_content_by_partial_words_dropdown_icon', 10, 2);

        $product_args = array(
            'post_type'      => 'product',
            'posts_per_page' => $product_limit,
            'post_status'    => 'publish',
            'meta_query'     => array(
                array(
                    'key'     => '_stock_status',
                    'value'   => 'instock',
                    'compare' => '='
                )
            )
        );

        $product_query = new WP_Query($product_args);

        if ($product_query->have_posts()) {
            while ($product_query->have_posts()) {
                $product_query->the_post();
                $product = wc_get_product(get_the_ID());

                // Get regular and sale prices
                $regular_price = $product ? $product->get_regular_price() : get_post_meta(get_the_ID(), '_regular_price', true);
                $sale_price = $product ? $product->get_sale_price() : get_post_meta(get_the_ID(), '_sale_price', true);

                $results['products'][] = array(
                    'id'    => get_the_ID(),
                    'title' => get_the_title(),
                    'url'   => get_permalink(),
                    'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') ?: wc_placeholder_img_src(),
                    'price' => $product ? $product->get_price_html() : wc_price($regular_price),
                    'regular_price' => $regular_price ? wc_price($regular_price) : '',
                    'sale_price' => $sale_price ? wc_price($sale_price) : '',
                    'type'  => 'product'
                );
            }
            wp_reset_postdata();
        }

        remove_filter('posts_where', 'search_content_by_partial_words_dropdown_icon', 10, 2);
    }

    // Search Posts
    if (in_array('post', $types)) {
        add_filter('posts_where', 'search_content_by_partial_words_dropdown_icon', 10, 2);

        $post_args = array(
            'post_type'      => 'post',
            'posts_per_page' => $post_limit,
            'post_status'    => 'publish'
        );

        $post_query = new WP_Query($post_args);

        if ($post_query->have_posts()) {
            while ($post_query->have_posts()) {
                $post_query->the_post();
                $results['posts'][] = array(
                    'id'      => get_the_ID(),
                    'title'   => get_the_title(),
                    'url'     => get_permalink(),
                    'image'   => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') ?: get_template_directory_uri() . '/images/default-post.jpg',
                    'excerpt' => wp_trim_words(get_the_excerpt(), 15, '...'),
                    'date'    => get_the_date('d/m/Y'),
                    'type'    => 'post'
                );
            }
            wp_reset_postdata();
        }

        remove_filter('posts_where', 'search_content_by_partial_words_dropdown_icon', 10, 2);
    }

    wp_send_json_success($results);
}

// Search function for both products and posts
function search_content_by_partial_words_dropdown_icon($where, $wp_query)
{
    global $wpdb;
    if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
        $keyword = sanitize_text_field($_GET['keyword']);
        $words = preg_split('/\s+/', $keyword);

        foreach ($words as $word) {
            if (!empty($word)) {
                $where .= $wpdb->prepare(" AND {$wpdb->posts}.post_title LIKE %s ", '%' . $wpdb->esc_like($word) . '%');
            }
        }
    }
    return $where;
}

// Legacy AJAX handler for backward compatibility
add_action('wp_ajax_search_input_global_dropdown_icon', 'handle_search_input_global_dropdown_icon');
add_action('wp_ajax_nopriv_search_input_global_dropdown_icon', 'handle_search_input_global_dropdown_icon');
function handle_search_input_global_dropdown_icon()
{
    $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;

    if ($keyword === '') {
        wp_send_json_success([]);
        wp_die();
    }

    add_filter('posts_where', 'search_product_by_partial_words_dropdown_icon', 10, 2);
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $limit,
        'post_status'    => 'publish',
        'meta_query'     => array(
            array(
                'key'     => '_stock_status',
                'value'   => 'instock',
                'compare' => '='
            )
        )
    );
    $query = new WP_Query($args);

    $results = array();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $product = wc_get_product(get_the_ID());
            $results[] = array(
                'id'    => get_the_ID(),
                'title' => get_the_title(),
                'url'   => get_permalink(),
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') ?: wc_placeholder_img_src(),
                'price' => $product ? $product->get_price_html() : wc_price(get_post_meta(get_the_ID(), '_regular_price', true)),
            );
        }
        wp_reset_postdata();
    }
    remove_filter('posts_where', 'search_product_by_partial_words_dropdown_icon', 10, 2);
    wp_send_json_success($results);
}

// Search products by title only (backward compatibility)
function search_product_by_partial_words_dropdown_icon($where, $wp_query)
{
    global $wpdb;
    if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
        $keyword = sanitize_text_field($_GET['keyword']);
        $words = preg_split('/\s+/', $keyword);

        foreach ($words as $word) {
            if (!empty($word)) {
                $where .= $wpdb->prepare(" AND {$wpdb->posts}.post_title LIKE %s ", '%' . $wpdb->esc_like($word) . '%');
            }
        }
    }
    return $where;
}
?>