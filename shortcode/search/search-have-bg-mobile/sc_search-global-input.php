<?php
// Global search shortcode with AJAX functionality
// Usage: [sc_search-global-input] or [sc_search-global-input placeholder="..." mobile_product_limit="4" mobile_post_limit="4" search_types="product,post"]
function sc_search_global_shortcode($atts)
{
    $unique_id = uniqid('search_');

    $atts = shortcode_atts(array(
        'placeholder' => 'Nhập thông tin cần tìm...',
        'class' => 'relative w-full lg:max-w-[488px] order-2 border border-[#CCCCCC] lg:border-none rounded-sm',
        'results_limit' => '10',
        'search_types' => 'product,post',
        'product_limit' => '5',
        'post_limit' => '5',
        'mobile_product_limit' => '4',
        'mobile_post_limit' => '4',
        'form_class' => 'relative bg-white rounded-sm w-full lg:min-w-[488px]',
        'input_class' => 'bg-white rounded-sm pl-15 py-[11px] lg:py-4 w-full lg:min-w-[488px] font-sans text-[#666666] placeholder:text-[#666666] outline-none',
        'button_class' => 'absolute left-5 top-1/2 -translate-y-1/2',
        'results_class' => 'w-full max-h-0 opacity-0 overflow-hidden transition-all duration-500 ease-in-out custom-scrollbar',
        'id_input_search' => $unique_id . '_input',
        'id_button_search' => $unique_id . '_button',
        'id_list_search_result' => $unique_id . '_results',
    ), $atts, 'sc_search-global');

    ob_start();
?>
    <style>
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

        .custom-scrollbar {
            scroll-behavior: smooth;
        }

        .search-result-item.active {
            background-color: #EBF8FF !important;
            border-left: 3px solid #E4BC6C;
        }
    </style>

    <div class="<?= esc_attr($atts['class']) ?>">
        <div class="bg-white p-[10px]">
            <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="get" class="<?= esc_attr($atts['form_class']) ?>">
                <button id="<?= esc_attr($atts['id_button_search']) ?>"
                    type="submit"
                    class="<?= esc_attr($atts['button_class']) ?>">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19.8102 18.9119L14.6466 13.8308C15.9988 12.3616 16.8296 10.4187 16.8296 8.28069C16.829 3.7071 13.0618 0 8.41448 0C3.76713 0 0 3.7071 0 8.28069C0 12.8543 3.76713 16.5614 8.41448 16.5614C10.4225 16.5614 12.2641 15.8668 13.7107 14.7122L18.8944 19.8134C19.147 20.0622 19.5571 20.0622 19.8097 19.8134C19.8697 19.7547 19.9175 19.6846 19.9501 19.6073C19.9827 19.5299 19.9996 19.4468 19.9996 19.3628C19.9997 19.2788 19.9829 19.1957 19.9504 19.1182C19.9179 19.0408 19.8702 18.9707 19.8102 18.9119ZM8.41448 15.2873C4.48232 15.2873 1.29469 12.1504 1.29469 8.28069C1.29469 4.41101 4.48232 1.27403 8.41448 1.27403C12.3467 1.27403 15.5343 4.41101 15.5343 8.28069C15.5343 12.1504 12.3467 15.2873 8.41448 15.2873Z" fill="#E4BC6C" />
                    </svg>
                </button>

                <input id="<?= esc_attr($atts['id_input_search']) ?>"
                    name="cs-search"
                    type="text"
                    class="<?= esc_attr($atts['input_class']) ?> rounded-lg border border-[#CCCCCC] outline-none"
                    placeholder="<?= esc_attr($atts['placeholder']) ?>"
                    autocomplete="off">
            </form>

            <div id="<?= esc_attr($atts['id_list_search_result']) ?>"
                class="<?= esc_attr($atts['results_class']) ?>">
            </div>
        </div>
    </div>

    <script>
        (function() {
            const searchInput = document.getElementById('<?= esc_js($atts['id_input_search']) ?>');
            const searchButton = document.getElementById('<?= esc_js($atts['id_button_search']) ?>');
            const listSearchResult = document.getElementById('<?= esc_js($atts['id_list_search_result']) ?>');
            const searchTypes = '<?= esc_js($atts['search_types']) ?>';
            const productLimit = <?= intval($atts['product_limit']) ?>;
            const postLimit = <?= intval($atts['post_limit']) ?>;
            const mobileProductLimit = <?= intval($atts['mobile_product_limit']) ?>;
            const mobilePostLimit = <?= intval($atts['mobile_post_limit']) ?>;
            
            function isMobile() {
                return window.innerWidth <= 768 || /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            }

            function showSearchResult() {
                const viewportHeight = window.innerHeight;
                const resultRect = listSearchResult.getBoundingClientRect();
                const availableHeight = viewportHeight - resultRect.top - 20;
                const contentHeight = listSearchResult.scrollHeight;

                const maxHeight = Math.min(contentHeight, availableHeight, 762);
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

                listSearchResult.innerHTML = '<div class="w-full h-8 flex items-center justify-center text-sm px-3"><div class="animate-spin rounded-full h-3 w-3 border-b-2 border-[#E4BC6C]"></div><span class="ml-2 text-[#666666]">Đang tìm kiếm...</span></div>';
                showSearchResult();

                const currentProductLimit = isMobile() ? mobileProductLimit : productLimit;
                const currentPostLimit = isMobile() ? mobilePostLimit : postLimit;

                jQuery.ajax({
                    url: ajax_url,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        action: 'search_global_content',
                        keyword: searchTerm,
                        search_types: searchTypes,
                        product_limit: currentProductLimit,
                        post_limit: currentPostLimit
                    },
                    success: function(response) {
                        listSearchResult.innerHTML = '';
                        if (response.success) {
                            let hasResults = false;

                            if (response.data.products && response.data.products.length > 0) {
                                hasResults = true;
                                listSearchResult.innerHTML += `
                                <div class="mt-2 px-4 py-1 bg-gray-50 border-b border-gray-100">
                                    <div class="text-xs font-semibold text-[#333333] uppercase tracking-wide">SẢN PHẨM</div>
                                </div>`;

                                response.data.products.forEach((item, index) => {
                                    listSearchResult.innerHTML += `
                                <a hx-boost='true' 
                                   hx-target='#htmx-main-content' 
                                   hx-select='#htmx-main-content'
                                   hx-swap='innerHTML show:#htmx-on-top:top' 
                                   hx-push-url='true'
                                   href="${item.url}" 
                                   class="block w-full px-3 py-2 hover:bg-gray-50 transition-colors duration-200 border-b border-gray-100 search-result-item" 
                                   data-id="${item.id}" 
                                   data-type="product">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg overflow-hidden flex items-center justify-center bg-gray-100 shrink-0">
                                            <img src="${item.image}" alt="${item.title}" class="w-full h-full object-cover" loading="lazy">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                                                        <div class="text-xs font-medium text-gray-900 truncate">${item.title}</div>
                            <div class="text-xs mt-1">
                                ${item.sale_price ? 
                                    `<span class="font-semibold text-[#E4BC6C]">${item.sale_price}</span> <span class="text-gray-400 line-through text-[10px]">${item.regular_price}</span>` 
                                    : `<span class="font-semibold text-[#E4BC6C]">${item.price}</span>`
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

                            if (response.data.posts && response.data.posts.length > 0) {
                                hasResults = true;
                                listSearchResult.innerHTML += `
                                <div class="px-4 py-1 bg-gray-50 border-b border-gray-100">
                                    <div class="text-xs font-semibold text-[#333333] uppercase tracking-wide">BÀI VIẾT</div>
                                </div>`;

                                response.data.posts.forEach((item, index) => {
                                    listSearchResult.innerHTML += `
                                <a hx-boost='true' 
                                   hx-target='#htmx-main-content' 
                                   hx-select='#htmx-main-content'
                                   hx-swap='innerHTML show:#htmx-on-top:top' 
                                   hx-push-url='true'
                                   href="${item.url}" 
                                   class="block w-full px-3 py-1 hover:bg-gray-50 transition-colors duration-200 border-b border-gray-100 last:border-b-0 search-result-item" 
                                   data-id="${item.id}" 
                                   data-type="post">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg overflow-hidden flex items-center justify-center bg-gray-100 shrink-0">
                                            <img src="${item.image}" alt="${item.title}" class="w-full h-full object-cover" loading="lazy">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                                                        <div class="text-sm font-medium text-gray-900 truncate">${item.title}</div>
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
                                if (typeof htmx !== 'undefined') {
                                    htmx.process(listSearchResult);
                                }
                            } else {
                                listSearchResult.innerHTML = `<div class="w-full h-8 flex items-center justify-center text-sm text-gray-500 px-3">Không tìm thấy kết quả...</div>`;
                                showSearchResult();
                            }
                        } else {
                            listSearchResult.innerHTML = `<div class="w-full h-8 flex items-center justify-center text-sm text-gray-500 px-3">Không tìm thấy kết quả...</div>`;
                            showSearchResult();
                        }
                    },
                    error: function() {
                        listSearchResult.innerHTML = `<div class="w-full h-8 flex items-center justify-center text-sm text-red-500 px-3">Lỗi tìm kiếm! Vui lòng thử lại.</div>`;
                        showSearchResult();
                    }
                });
            }

            let searchTimeout;

            function debounceSearch() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(handleSearch, 300);
            }

            searchInput.addEventListener('input', function() {
                if (searchInput.value.trim() === '') {
                    listSearchResult.innerHTML = '';
                    hideSearchResult();
                    return;
                }
                debounceSearch();
            });

            searchButton.addEventListener('click', function(e) {
                e.preventDefault();
                handleSearch();
            });

            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    handleSearch();
                }
            });

            document.addEventListener('click', function(e) {
                if (!listSearchResult.contains(e.target) &&
                    !searchInput.contains(e.target) &&
                    !searchButton.contains(e.target)) {
                    hideSearchResult();
                }
            });

            searchInput.addEventListener('focus', function() {
                if (listSearchResult.innerHTML.trim() !== '' && !listSearchResult.innerHTML.includes('Đang tìm kiếm')) {
                    showSearchResult();
                }
            });

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

            document.addEventListener('mouseover', function(e) {
                if (e.target.closest('.search-result-item')) {
                    listSearchResult.querySelectorAll('.search-result-item').forEach(item => {
                        item.classList.remove('active');
                    });
                    e.target.closest('.search-result-item').classList.add('active');
                }
            });

            document.addEventListener('click', function(e) {
                if (e.target.closest('.search-result-item')) {
                    hideSearchResult();
                }
            });

            window.addEventListener('resize', function() {
                if (listSearchResult.innerHTML.trim() !== '' && 
                    !listSearchResult.innerHTML.includes('Đang tìm kiếm') &&
                    searchInput.value.trim() !== '') {
                    debounceSearch();
                }
            });
        })();
    </script>
<?php
    return ob_get_clean();
}

add_shortcode('sc_search-global-input', 'sc_search_global_shortcode');

add_action('wp_ajax_search_global_content', 'handle_search_global_content');
add_action('wp_ajax_nopriv_search_global_content', 'handle_search_global_content');
function handle_search_global_content()
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

    if (in_array('product', $types)) {
        add_filter('posts_where', 'search_content_by_partial_words', 10, 2);

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

        remove_filter('posts_where', 'search_content_by_partial_words', 10, 2);
    }

    if (in_array('post', $types)) {
        add_filter('posts_where', 'search_content_by_partial_words', 10, 2);

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

        remove_filter('posts_where', 'search_content_by_partial_words', 10, 2);
    }

    wp_send_json_success($results);
}

function search_content_by_partial_words($where, $wp_query)
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

add_action('wp_ajax_search_input_global', 'handle_search_input_global');
add_action('wp_ajax_nopriv_search_input_global', 'handle_search_input_global');
function handle_search_input_global()
{
    $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;

    if ($keyword === '') {
        wp_send_json_success([]);
        wp_die();
    }

    add_filter('posts_where', 'search_product_by_partial_words', 10, 2);
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
    remove_filter('posts_where', 'search_product_by_partial_words', 10, 2);
    wp_send_json_success($results);
}

function search_product_by_partial_words($where, $wp_query)
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