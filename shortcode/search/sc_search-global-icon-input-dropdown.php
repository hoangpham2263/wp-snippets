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
function sc_search_global_input_shortcode($atts)
{
    // Generate unique ID for this instance
    $unique_id = 'search_' . wp_rand(100000, 999999) . '_' . time();

    $atts = shortcode_atts(array(
        'placeholder' => 'Nhập thông tin cần tìm...',
        'icon_class' => 'js-search-icon-main-' . $unique_id . ' cursor-pointer',
        'dropdown_id' => $unique_id . '_dropdown',
        'search_types' => 'product,post,property',
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
            <svg class="size-8 lg:size-7 2xl:size-9" width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_847_2276)">
                    <path d="M14.8384 29.6492C6.66406 29.6492 0.0137939 22.9989 0.0137939 14.8246C0.0137939 6.65027 6.66406 0 14.8384 0C23.0127 0 29.663 6.65027 29.663 14.8246C29.663 22.9989 23.0127 29.6492 14.8384 29.6492ZM14.8384 2.81035C8.21369 2.81035 2.82414 8.19989 2.82414 14.8246C2.82414 21.4493 8.21369 26.8388 14.8384 26.8388C21.4631 26.8388 26.8526 21.4493 26.8526 14.8246C26.8526 8.19989 21.4631 2.81035 14.8384 2.81035ZM35.5747 35.5884C36.1235 35.0396 36.1235 34.1499 35.5747 33.6012L29.2866 27.313C28.7378 26.7642 27.848 26.7642 27.2993 27.313C26.7506 27.8618 26.7506 28.7515 27.2993 29.3003L33.5875 35.5884C33.8618 35.8628 34.2215 35.9999 34.5811 35.9999C34.9408 35.9999 35.3003 35.8628 35.5747 35.5884Z" fill="#0F1A41" />
                </g>
                <defs>
                    <clipPath id="clip0_847_2276">
                        <rect width="36" height="36" fill="white" />
                    </clipPath>
                </defs>
            </svg>
        </div>
        <!-- Search Dropdown (hidden by default) -->
        <div id="<?= esc_attr($atts['dropdown_id']) ?>" class="w-full min-w-full lg:w-[400px] lg:max-w-[90vw] search-dropdown">
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

                .search-dropdown {
                    display: none;
                    position: absolute;
                    top: calc(100% + 32px);
                    left: -15px;
                    transform: scaleX(0);
                    transform-origin: left center;
                    opacity: 0;
                    background: #fff;
                    border-radius: 8px;
                    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
                    z-index: 9999;
                    padding: 5px;
                    transition: transform 0.3s cubic-bezier(.4, 0, .2, 1),
                        opacity 0.3s cubic-bezier(.4, 0, .2, 1);
                    font-size: 16px;
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
                    border-left: 3px solid #A40033;
                }
            </style>
            <div class="absolute -top-2.5 left-3 lg:left-5 w-0 h-0 border-l-[12px] border-l-transparent border-r-[12px] border-r-transparent border-b-[12px] border-b-[#f8fafc] drop-shadow-[0_-2px_2px_rgba(0,0,0,0.08)]"></div>

            <!-- Search Form -->
            <div class="relative w-full lg:max-w-[488px]">
                <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="get" class="flex bg-white border border-[#CCCCCC] rounded-full items-center gap-2 lg:gap-5 px-5 py-[10px] w-full">
                    <input id="<?= esc_attr($atts['id_input_search']) ?>"
                        name="cs-search"
                        type="text"
                        class="bg-white placeholder:text-foreground text-[#666666] text-base lg:text-sm w-full outline-none"
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
                const baseUrl = "<?= esc_url(home_url('/')) ?>";
                if (searchTerm.length === 0) {
                    return;
                }

                // Show loading state
                listSearchResult.innerHTML = '<div class="w-full h-8 flex items-center justify-center text-sm px-3"><div class="animate-spin rounded-full h-3 w-3 border-b-2 border-primary"></div><span class="ml-2 text-[#666666]">Đang tìm kiếm...</span></div>';
                showSearchResult();

                const params = new URLSearchParams({
                    action: 'search_global_content',
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
                            <div class="px-4 py-1   border-b border-gray-100">
                                <div class="text-xs font-semibold text-primary uppercase tracking-wide">SẢN PHẨM</div>
                            </div>`;

                                data.data.products.forEach((item, index) => {
                                    listSearchResult.innerHTML += `
                            <a href="${item.url}" class="block w-full px-3 py-2 hover:  transition-colors duration-200 border-b border-gray-100 search-result-item" data-id="${item.id}" data-type="product">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg overflow-hidden flex items-center justify-center bg-gray-100 shrink-0">
                                        <img src="${item.image}" alt="${item.title}" class="w-full h-full object-cover" loading="lazy">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                    <div class="text-[13px] font-medium text-gray-900 truncate">${item.title}</div>
                                    <div class="text-[13px] mt-1">
                                        ${item.sale_price ? 
                                            `<span class="font-semibold text-primary">${item.sale_price}</span> <span class="text-gray-400 line-through text-[13px]">${item.regular_price}</span>` 
                                            : `<span class="font-semibold text-primary">${item.price}</span>`
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

                                // "Xem thêm sản phẩm" if we likely have more
                                if (data.data.products.length >= productLimit) {
                                    const moreProductsUrl = `${baseUrl}?s=${encodeURIComponent(searchTerm)}`;
                                    listSearchResult.innerHTML += `
                            <div class="px-3 py-2 bg-white">
                                <a href="${moreProductsUrl}" class="block w-full text-center text-[13px] font-medium text-primary hover:underline">
                                    Xem thêm sản phẩm
                                </a>
                            </div>`;
                                }
                            }

                            // Display posts after products
                            if (data.data.posts && data.data.posts.length > 0) {
                                hasResults = true;
                                listSearchResult.innerHTML += `
                            <div class="px-4 py-1   border-b border-gray-100">
                                <div class="text-xs font-semibold text-primary uppercase tracking-wide">BÀI VIẾT</div>
                            </div>`;

                                data.data.posts.forEach((item, index) => {
                                    listSearchResult.innerHTML += `
                            <a href="${item.url}" class="block w-full px-3 py-1 hover:  transition-colors duration-200 border-b border-gray-100 last:border-b-0 search-result-item" data-id="${item.id}" data-type="post">
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

                                // "Xem thêm bài viết" if we likely have more
                                if (data.data.posts.length >= postLimit) {
                                    const morePostsUrl = `${baseUrl}?s=${encodeURIComponent(searchTerm)}`;
                                    listSearchResult.innerHTML += `
                            <div class="px-3 py-2 bg-white">
                                <a href="${morePostsUrl}" class="block w-full text-center text-[13px] font-medium text-primary hover:underline">
                                    Xem thêm bài viết
                                </a>
                            </div>`;
                                }
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
                    e.preventDefault();
                    const activeItem = listSearchResult.querySelector('.search-result-item.active');
                    if (activeItem) {
                        // Có item đang được chọn -> click vào item (giữ nguyên hành vi navigate)
                        activeItem.click();
                    } else {
                        // Không có item nào được chọn -> chuyển hướng đến trang tìm kiếm
                        const searchTerm = searchInput.value.trim();
                        if (searchTerm) {
                            const baseUrl = "<?= esc_url(home_url('/')) ?>";
                            window.location.href = baseUrl + '?s=' + encodeURIComponent(searchTerm);
                        }
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
add_shortcode('sc_search-global-input', 'sc_search_global_input_shortcode');
add_shortcode('sc_search-global-input', 'sc_search_global_input_shortcode');

// AJAX handler for search dropdown icon - now uses Algolia (100% same as desktop)
// This handler is kept for backward compatibility but now uses the same Algolia logic as desktop
add_action('wp_ajax_search_global_input', 'handle_search_global_input');
add_action('wp_ajax_nopriv_search_global_input', 'handle_search_global_input');
function handle_search_global_input()
{
    // Use exact same Algolia logic as desktop for 100% consistency
    $keyword = isset($_GET['keyword']) ? sanitize_text_field(wp_unslash($_GET['keyword'])) : '';
    $limit   = isset($_GET['limit']) ? max(1, intval($_GET['limit'])) : 10;
    $debug_enabled = defined('WP_DEBUG') && WP_DEBUG;

    if ('' === $keyword) {
        wp_send_json_success(array());
        return;
    }

    if (!class_exists('Algolia_Plugin_Factory')) {
        wp_send_json_error(array('message' => __('Algolia Search plugin is not available.', 'wp-search-with-algolia')), 500);
        return;
    }

    $plugin    = Algolia_Plugin_Factory::create();
    $index_raw = isset($_GET['index']) ? sanitize_text_field(wp_unslash($_GET['index'])) : 'searchable_posts';
    $index_id  = sanitize_key($index_raw);
    $index     = $plugin->get_index($index_id);

    if (!$index && $index_raw !== $index_id) {
        $indices = $plugin->get_indices();
        foreach ($indices as $candidate) {
            if ($candidate->get_name() === $index_raw) {
                $index    = $candidate;
                $index_id = $candidate->get_id();
                break;
            }
        }
    }

    if (!$index) {
        wp_send_json_error(array('message' => __('Requested Algolia index is not enabled.', 'wp-search-with-algolia')), 400);
        return;
    }

    $params = array(
        'hitsPerPage'          => $limit,
        'attributesToRetrieve' => array('post_id', 'post_title', 'permalink', 'images', 'post_type', 'post_type_label', 'content'),
        'attributesToSnippet'  => array('content:30'),
        'highlightPreTag'      => '__ais-highlight__',
        'highlightPostTag'     => '__/ais-highlight__',
    );

    $search_types_param = '';
    if (!empty($_GET['search_types'])) {
        $search_types_param = sanitize_text_field(wp_unslash($_GET['search_types']));
    } elseif (!empty($_GET['types'])) {
        $search_types_param = sanitize_text_field(wp_unslash($_GET['types']));
    }

    $search_types = !empty($search_types_param) ? array_filter(array_map('sanitize_key', explode(',', $search_types_param))) : array('product', 'post');

    $type_limits = array(
        'product' => isset($_GET['product_limit']) ? max(1, intval($_GET['product_limit'])) : $limit,
        'post'    => isset($_GET['post_limit']) ? max(1, intval($_GET['post_limit'])) : $limit,
    );


    $results = array(
        'products' => array(),
        'posts'    => array(),
    );

    foreach ($search_types as $type) {
        $type_limit = isset($type_limits[$type]) ? $type_limits[$type] : $limit;
        if ($type_limit <= 0) {
            continue;
        }

        $type_params = $params;
        $type_params['hitsPerPage'] = $type_limit;

        $post_type_obj   = get_post_type_object($type);
        $post_type_label = $post_type_obj ? $post_type_obj->labels->name : '';
        if ($post_type_label) {
            $type_params['filters'] = sprintf('post_type_label:"%s"', addslashes($post_type_label));
        } else {
            $type_params['filters'] = sprintf('post_type:"%s"', $type);
        }
        try {
            $response = $index->search($keyword, $type_params);
        } catch (Exception $exception) {
            wp_send_json_error(array('message' => $exception->getMessage()), 500);
            return;
        }

        if (empty($response['hits'])) {
            continue;
        }

        foreach ($response['hits'] as $hit) {
            $post_id = isset($hit['post_id']) ? absint($hit['post_id']) : 0;
            if (!$post_id) {
                continue;
            }

            $post = get_post($post_id);
            if (!$post || $post->post_type !== $type) {
                continue;
            }

            $thumbnail = '';
            if (isset($hit['images']['thumbnail']['url'])) {
                $thumbnail = esc_url_raw($hit['images']['thumbnail']['url']);
            }
            if (!$thumbnail) {
                $thumbnail = get_the_post_thumbnail_url($post_id, 'thumbnail') ?: '';
            }

            $snippet = '';
            if (isset($hit['_snippetResult']['content']['value'])) {
                $snippet = str_replace(
                    array('__ais-highlight__', '__/ais-highlight__'),
                    array('<em>', '</em>'),
                    $hit['_snippetResult']['content']['value']
                );
                $snippet = wp_kses_post($snippet);
            } else {
                $snippet = esc_html(wp_trim_words(wp_strip_all_tags($hit['content'] ?? $post->post_content), 20, '...'));
            }

            if ('product' === $type) {
                $formatted = array(
                    'id'    => $post_id,
                    'title' => get_the_title($post),
                    'url'   => get_permalink($post),
                    'image' => $thumbnail ?: (function_exists('wc_placeholder_img_src') ? wc_placeholder_img_src() : ''),
                    'type'  => 'product',
                );

                if (function_exists('wc_get_product')) {
                    $product = wc_get_product($post_id);
                    if ($product) {
                        $price_value   = $product->get_price();
                        $regular_price = $product->get_regular_price();
                        $sale_price    = $product->get_sale_price();

                        $formatted['price']         = $price_value ? 'Từ ' . number_format(floatval($price_value), 0, ',', '.') . ' VND' : '';
                        $formatted['regular_price'] = $regular_price ? 'Từ ' . number_format(floatval($regular_price), 0, ',', '.') . ' VND' : '';
                        $formatted['sale_price']    = $sale_price ? 'Từ ' . number_format(floatval($sale_price), 0, ',', '.') . ' VND' : '';
                    }
                }

                $results['products'][] = $formatted;
                continue;
            }

            $results['posts'][] = array(
                'id'      => $post_id,
                'title'   => get_the_title($post),
                'url'     => get_permalink($post),
                'image'   => $thumbnail ?: get_template_directory_uri() . '/images/default-post.jpg',
                'excerpt' => wp_strip_all_tags($snippet),
                'date'    => get_the_date('d/m/Y', $post),
                'type'    => $type,
            );
        }
    }

    wp_send_json_success($results);
}

// Legacy AJAX handler for backward compatibility - use common search function
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

    $query = new WP_Query([
        'post_type' => 'product',
        's' => $keyword,
        'posts_per_page' => $limit,
    ]);

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
                'price' => $product ? 'Từ ' . number_format($product->get_price(), 0, ',', '.') . ' VND' : 'Từ ' . number_format(get_post_meta(get_the_ID(), '_regular_price', true), 0, ',', '.') . ' VND',
            );
        }
        wp_reset_postdata();
    }
    wp_send_json_success($results);
}
?>