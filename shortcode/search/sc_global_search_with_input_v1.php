<?php
/**
 * GLOBAL SEARCH WITH INPUT V1 (FULL CONFIG - NO ICON)
 * Shortcode: [global_search_with_input_v1]
 */

/*
 * ==============================================================================
 * 1. SEARCH CONFIGURATION
 * ==============================================================================
 */
function get_gswi_v1_config() {
    $enable_polylang = true; 
    $current_lang = ($enable_polylang && function_exists('pll_current_language')) ? pll_current_language() : 'vi';
    $is_vi = ($current_lang === 'vi');

    return [
        // 1. Cấu hình Bật/Tắt các section
        'active_sections' => [
            'product_cat'    => false, // Danh mục
            'berocket_brand' => false, // Thương hiệu
            'product'        => false, // Sản phẩm
            'post'           => true,  // Bài viết
            'property'       => true,  // Bất động sản
        ],

        // 2. Thứ tự hiển thị
        'order' => [
            'product',
            'product_cat',
            'berocket_brand',
            'property',
            'post'
        ],

        // 3. Giới hạn số lượng
        'limits' => [
            'product_cat'    => 3,
            'berocket_brand' => 3,
            'product'        => 5,
            'property'       => 5,
            'post'           => 5,
        ],

        // 4. Các cấu hình giao diện
        'result_size' => 'normal',          
        'prevent_enter_search' => true,     
        'width_class' => 'w-full max-w-[488px]',
        'enable_badges' => false,            // Bật/Tắt Badges

        // 5. Polylang & Labels
        'enable_polylang' => $enable_polylang,
        'current_lang'    => $current_lang,
        'labels' => [
            'placeholder' => $is_vi ? 'Tìm kiếm...' : 'Search...',
            'searching'   => $is_vi ? 'Đang tìm kiếm...' : 'Searching...',
            'no_results'  => $is_vi ? 'Không tìm thấy kết quả...' : 'No results found...',
            'view_all'    => $is_vi ? 'Xem tất cả' : 'View all',
            'headers'     => [
                'product_cat'    => $is_vi ? 'DANH MỤC' : 'CATEGORIES',
                'berocket_brand' => $is_vi ? 'THƯƠNG HIỆU' : 'BRANDS',
                'product'        => $is_vi ? 'SẢN PHẨM' : 'PRODUCTS',
                'property'       => $is_vi ? 'BẤT ĐỘNG SẢN' : 'PROPERTIES',
                'post'           => $is_vi ? 'BÀI VIẾT' : 'POSTS',
            ]
        ],
        'badges' => [
            'product'        => $is_vi ? 'SP' : 'PROD',
            'property'       => $is_vi ? 'BĐS' : 'REAL',
            'post'           => $is_vi ? 'BV' : 'NEWS',
            'product_cat'    => $is_vi ? 'DM' : 'CAT',
            'berocket_brand' => $is_vi ? 'HÃNG' : 'BRAND',
        ]
    ];
}

/*
 * ==============================================================================
 * 2. SHORTCODE HANDLER
 * ==============================================================================
 */
function gswi_v1_shortcode($atts) {
    $unique_id = uniqid('gswi_v1_');
    $config = get_gswi_v1_config();

    $atts = shortcode_atts(array(
        'placeholder' => $config['labels']['placeholder'],
        'class'       => 'relative ' . $config['width_class'],
        'form_class'  => 'flex bg-white border-b border-[#1B1D1F] items-center gap-2 lg:gap-3 py-[11.5px] w-full',
        'input_class' => 'bg-white w-full outline-none font-light placeholder:text-gray-400',
        'button_class'=> 'w-5 lg:w-5 aspect-square rounded-full flex items-center justify-center shrink-0 cursor-pointer',
        'results_class' => 'absolute z-[999] top-[calc(100%+4px)] left-0 w-full bg-white max-h-0 opacity-0 overflow-hidden transition-all duration-300 ease-in-out shadow-xl rounded-lg border border-gray-200 custom-scrollbar',
        'id_input'    => $unique_id . '_input',
        'id_button'   => $unique_id . '_button',
        'id_results'  => $unique_id . '_results',
    ), $atts, 'global_search_with_input_v1');

    ob_start();
?>
    <style>
        .custom-scrollbar { scrollbar-width: thin; scrollbar-color: #CBD5E0 #FFFFFF; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #FFFFFF; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #CBD5E0; border-radius: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #A0AEC0; }
        .gswi-item.active { background-color: #F7FAFC !important; border-left: 3px solid #1B1D1F; }
    </style>

    <div class="<?= esc_attr($atts['class']) ?>">
        <form action="<?= esc_url(home_url('/')); ?>" method="get" class="<?= esc_attr($atts['form_class']) ?>" id="<?= $unique_id ?>_form">
            <button id="<?= esc_attr($atts['id_button']) ?>" type="submit" class="<?= esc_attr($atts['button_class']) ?>">
                <svg class="flex-shrink-0" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21 21L16.66 16.66" stroke="#1B1D1F" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#1B1D1F" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
            <input id="<?= esc_attr($atts['id_input']) ?>" name="s" type="text" class="<?= esc_attr($atts['input_class']) ?>" placeholder="<?= esc_attr($atts['placeholder']) ?>" autocomplete="off">
            <?php if($config['enable_polylang']): ?><input type="hidden" name="lang" value="<?= esc_attr($config['current_lang']) ?>"><?php endif; ?>
        </form>
        <div id="<?= esc_attr($atts['id_results']) ?>" class="<?= esc_attr($atts['results_class']) ?>"></div>
    </div>

    <script>
        (function() {
            const searchInput = document.getElementById('<?= esc_js($atts['id_input']) ?>');
            const searchButton = document.getElementById('<?= esc_js($atts['id_button']) ?>');
            const listSearchResult = document.getElementById('<?= esc_js($atts['id_results']) ?>');
            const config = <?php echo json_encode($config); ?>;
            const homeUrl = '<?php echo home_url(); ?>';
            const ajaxUrl = '<?php echo admin_url('admin-ajax.php'); ?>';

            const sizeStyles = {
                small: { itemPadding: 'px-3 py-2', imgContainer: 'w-8 h-8', titleSize: 'text-xs', metaSize: 'text-xs', headerSize: 'text-xs', viewAllSize: 'text-xs', gap: 'gap-2' },
                normal: { itemPadding: 'px-4 py-3', imgContainer: 'w-12 h-12', titleSize: 'text-sm', metaSize: 'text-xs', headerSize: 'text-xs', viewAllSize: 'text-xs', gap: 'gap-3' },
                large: { itemPadding: 'px-5 py-4', imgContainer: 'w-16 h-16', titleSize: 'text-base', metaSize: 'text-sm', headerSize: 'text-xs', viewAllSize: 'text-xs', gap: 'gap-4' }
            };
            const currentStyle = sizeStyles[config.result_size] || sizeStyles.normal;

            function toggleResults(show) {
                if (show) {
                    listSearchResult.style.maxHeight = '450px';
                    listSearchResult.style.overflowY = 'auto';
                    listSearchResult.classList.remove('opacity-0', 'max-h-0');
                    listSearchResult.classList.add('opacity-100');
                } else {
                    listSearchResult.style.maxHeight = '0px';
                    listSearchResult.classList.remove('opacity-100');
                    listSearchResult.classList.add('opacity-0', 'max-h-0');
                }
            }

            async function handleSearch() {
                const searchTerm = searchInput.value.trim();
                if (searchTerm.length === 0) { toggleResults(false); return; }

                listSearchResult.innerHTML = `<div class="w-full h-12 flex items-center justify-center text-sm px-3"><div class="animate-spin rounded-full h-4 w-4 border-b-2 border-gray-800 mr-2"></div><span>${config.labels.searching}</span></div>`;
                toggleResults(true);

                try {
                    const params = new URLSearchParams({
                        action: 'gswi_v1_ajax_search',
                        keyword: searchTerm,
                        lang: config.current_lang,
                        polylang_enabled: config.enable_polylang
                    });
                    const response = await fetch(ajaxUrl + '?' + params);
                    const data = await response.json();
                    if (data.success) { renderResults(data.data, searchTerm); } 
                    else { listSearchResult.innerHTML = `<div class="p-4 text-center text-sm">${config.labels.no_results}</div>`; }
                } catch (e) { console.error("Search Error", e); }
            }

            function renderResults(data, searchTerm) {
                listSearchResult.innerHTML = '';
                let hasResults = false;

                function renderSection(key, items) {
                    if (!config.active_sections[key] || !items || items.length === 0) return;
                    hasResults = true;

                    const title = config.labels.headers[key] || key.toUpperCase();
                    let viewAllUrl = `${homeUrl}/?s=${encodeURIComponent(searchTerm)}`;
                    
                    if (key === 'product' || key === 'product_cat' || key === 'berocket_brand') { viewAllUrl += '&post_type=product'; } 
                    else if (key === 'property') { viewAllUrl += '&post_type=property'; } 
                    else { viewAllUrl += '&post_type=post'; }
                    if(config.enable_polylang) viewAllUrl += `&lang=${config.current_lang}`;

                    listSearchResult.innerHTML += `
                    <div class="px-4 py-2 bg-gray-50 border-b border-gray-100 flex justify-between items-center group">
                        <div class="${currentStyle.headerSize} font-bold uppercase tracking-wider">${title}</div>
                        <a href="${viewAllUrl}" class="${currentStyle.viewAllSize} text-blue-600 hover:text-blue-800 hover:underline opacity-0 group-hover:opacity-100 transition-opacity">${config.labels.view_all}</a>
                    </div>`;

                    items.forEach(item => {
                        let metaHtml = '';
                        let badgeClass = 'bg-gray-100 text-gray-900'; 

                        if (key === 'product') {
                            metaHtml = item.sale_price 
                                ? `<span class="font-semibold text-red-600">${item.sale_price}</span> <span class="text-gray-900 line-through scale-90 inline-block ml-1">${item.regular_price}</span>` 
                                : `<span class="font-semibold text-gray-900">${item.price}</span>`;
                            badgeClass = 'bg-blue-100 text-blue-800';
                        } 
                        else if (key === 'property') {
                            // ĐÃ BỎ ICON 📍 Ở ĐÂY
                            metaHtml = `<span class="truncate block mt-0.5 text-xs">${item.location || '---'}</span>`;
                            badgeClass = 'bg-purple-100 text-purple-800'; 
                        } 
                        else if (key === 'product_cat' || key === 'berocket_brand') {
                             metaHtml = '';
                             badgeClass = 'bg-yellow-100 text-yellow-800';
                        }
                        else {
                            metaHtml = `<span class="text-gray-900">${item.date}</span>`;
                            badgeClass = 'bg-green-100 text-green-800';
                        }

                        // Badge Toggle
                        const showBadge = config.enable_badges && config.badges[key];
                        const badge = showBadge ? `<span class="text-xs font-bold px-1.5 py-0.5 ${badgeClass} rounded ml-2 uppercase">${config.badges[key]}</span>` : '';

                        listSearchResult.innerHTML += `
                        <a href="${item.url}" class="block w-full ${currentStyle.itemPadding} hover:bg-gray-50 transition-colors duration-200 border-b border-gray-100 gswi-item group">
                            <div class="flex items-center ${currentStyle.gap}">
                                <div class="${currentStyle.imgContainer} rounded overflow-hidden flex items-center justify-center bg-gray-100 shrink-0 border border-gray-100">
                                    <img src="${item.image}" alt="${item.title}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="${currentStyle.titleSize} font-medium text-gray-900 truncate flex items-center justify-between">
                                        <span>${item.title}</span>
                                    </div>
                                    <div class="${currentStyle.metaSize} flex justify-between items-center mt-0.5">
                                        <div class="flex-1 truncate">${metaHtml}</div>
                                        ${badge}
                                    </div>
                                </div>
                            </div>
                        </a>`;
                    });
                }

                const keyMap = { 'product': 'products', 'property': 'properties', 'post': 'posts', 'product_cat': 'product_cats', 'berocket_brand': 'brands' };
                if (config.order && Array.isArray(config.order)) {
                    config.order.forEach(type => {
                        let dataKey = keyMap[type] || type + 's';
                        renderSection(type, data[dataKey]);
                    });
                }

                if (!hasResults) listSearchResult.innerHTML = `<div class="w-full h-12 flex items-center justify-center text-sm px-3">${config.labels.no_results}</div>`;
            }

            // Events
            let timeoutId;
            searchInput.addEventListener('input', () => { clearTimeout(timeoutId); timeoutId = setTimeout(handleSearch, 300); });
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') { if (config.prevent_enter_search) { e.preventDefault(); handleSearch(); } }
            });
            searchButton.addEventListener('click', function(e) {
                if (config.prevent_enter_search && searchInput.value.trim() !== '') { e.preventDefault(); handleSearch(); }
            });
            searchInput.addEventListener('focus', () => { if (listSearchResult.innerHTML.trim() !== '') toggleResults(true); });
            document.addEventListener('click', (e) => {
                if (!listSearchResult.contains(e.target) && !searchInput.contains(e.target) && !searchButton.contains(e.target)) { toggleResults(false); }
            });
            searchInput.addEventListener('keydown', (e) => {
                const items = listSearchResult.querySelectorAll('.gswi-item');
                if (items.length === 0) return;
                if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                    e.preventDefault();
                    const current = listSearchResult.querySelector('.gswi-item.active');
                    let nextIndex = 0;
                    if (current) {
                        current.classList.remove('active');
                        const currentIndex = Array.from(items).indexOf(current);
                        nextIndex = e.key === 'ArrowDown' ? (currentIndex + 1) % items.length : (currentIndex - 1 + items.length) % items.length;
                    } else if (e.key === 'ArrowUp') { nextIndex = items.length - 1; }
                    items[nextIndex].classList.add('active');
                    items[nextIndex].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                } else if (e.key === 'Enter') {
                    const current = listSearchResult.querySelector('.gswi-item.active');
                    if (current) { e.preventDefault(); current.click(); }
                }
            });
        })();
    </script>
<?php
    return ob_get_clean();
}
add_shortcode('global_search_with_input_v1', 'gswi_v1_shortcode');

/*
 * ==============================================================================
 * 3. AJAX HANDLER
 * ==============================================================================
 */
add_action('wp_ajax_gswi_v1_ajax_search', 'gswi_v1_handle_ajax');
add_action('wp_ajax_nopriv_gswi_v1_ajax_search', 'gswi_v1_handle_ajax');

function gswi_v1_handle_ajax() {
    $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
    $config = get_gswi_v1_config();
    
    if (empty($keyword)) { 
        wp_send_json_success([
            'products' => [], 'properties' => [], 'posts' => [], 'product_cats' => [], 'brands' => []
        ]); 
        wp_die(); 
    }

    $results = [];
    $base_args = ['post_status' => 'publish', 's' => $keyword];
    if (isset($_GET['polylang_enabled']) && $_GET['polylang_enabled'] == '1' && isset($_GET['lang'])) {
        $base_args['lang'] = sanitize_text_field($_GET['lang']);
    }

    // 1. PRODUCT CATS
    if ($config['active_sections']['product_cat']) {
        $cat_args = ['taxonomy' => 'product_cat', 'hide_empty' => false, 'name__like' => $keyword, 'number' => $config['limits']['product_cat']];
        $cats = get_terms($cat_args);
        $items = [];
        if (!empty($cats) && !is_wp_error($cats)) {
            foreach ($cats as $cat) {
                $thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
                $image = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : wc_placeholder_img_src();
                $items[] = ['id' => $cat->term_id, 'title' => $cat->name, 'url' => get_term_link($cat), 'image' => $image];
            }
        }
        $results['product_cats'] = $items;
    }

    // 2. BRANDS
    if ($config['active_sections']['berocket_brand']) {
        $brand_args = ['taxonomy' => 'berocket_brand', 'hide_empty' => false, 'name__like' => $keyword, 'number' => $config['limits']['berocket_brand']];
        $brands = get_terms($brand_args);
        $items = [];
        if (!empty($brands) && !is_wp_error($brands)) {
            foreach ($brands as $brand) {
                $image_url = get_term_meta($brand->term_id, 'brand_image_url', true);
                if (!$image_url) {
                    $thumbnail_id = get_term_meta($brand->term_id, 'thumbnail_id', true);
                    $image_url = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : wc_placeholder_img_src();
                }
                $items[] = ['id' => $brand->term_id, 'title' => $brand->name, 'url' => get_term_link($brand), 'image' => $image_url];
            }
        }
        $results['brands'] = $items;
    }

    // 3. PRODUCT
    if ($config['active_sections']['product']) {
        add_filter('posts_where', 'gswi_v1_partial_search', 10, 2);
        $args = array_merge($base_args, [
            'post_type' => 'product', 'posts_per_page' => $config['limits']['product'],
            'meta_query' => [ ['key' => '_stock_status', 'value' => 'instock', 'compare' => '='] ]
        ]);
        $query = new WP_Query($args); $items = [];
        while($query->have_posts()) { $query->the_post(); $product = wc_get_product(get_the_ID());
            $items[] = [
                'title' => get_the_title(), 'url' => get_permalink(),
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') ?: wc_placeholder_img_src(),
                'price' => $product ? $product->get_price_html() : '',
                'regular_price' => ($product && $product->get_regular_price()) ? wc_price($product->get_regular_price()) : '',
                'sale_price' => ($product && $product->get_sale_price()) ? wc_price($product->get_sale_price()) : '',
            ];
        }
        $results['products'] = $items; wp_reset_postdata();
        remove_filter('posts_where', 'gswi_v1_partial_search', 10, 2);
    }

    // 4. PROPERTY
    if ($config['active_sections']['property']) {
        add_filter('posts_where', 'gswi_v1_partial_search', 10, 2);
        $args = array_merge($base_args, ['post_type' => 'property', 'posts_per_page' => $config['limits']['property']]);
        $query = new WP_Query($args); $items = [];
        while($query->have_posts()) { $query->the_post();
            $location = get_post_meta(get_the_ID(), 'property_address', true);
            $items[] = [
                'title' => get_the_title(), 'url' => get_permalink(),
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') ?: 'https://via.placeholder.com/150',
                'location' => $location ? $location : wp_trim_words(get_the_excerpt(), 10, '...'),
            ];
        }
        $results['properties'] = $items; 
        wp_reset_postdata();
        remove_filter('posts_where', 'gswi_v1_partial_search', 10, 2);
    }

    // 5. POST
    if ($config['active_sections']['post']) {
        add_filter('posts_where', 'gswi_v1_partial_search', 10, 2);
        $args = array_merge($base_args, ['post_type' => 'post', 'posts_per_page' => $config['limits']['post']]);
        $query = new WP_Query($args); $items = [];
        while($query->have_posts()) { $query->the_post();
            $items[] = [
                'title' => get_the_title(), 'url' => get_permalink(),
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') ?: get_template_directory_uri() . '/images/default.jpg',
                'date' => get_the_date('d/m/Y')
            ];
        }
        $results['posts'] = $items; wp_reset_postdata();
        remove_filter('posts_where', 'gswi_v1_partial_search', 10, 2);
    }

    wp_send_json_success($results);
}

function gswi_v1_partial_search($where, $wp_query) {
    global $wpdb;
    if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
        $keyword = sanitize_text_field($_GET['keyword']);
        $words = explode(' ', $keyword); $search_sql = "";
        foreach ($words as $word) { $word = trim($word); if (!empty($word)) {
            $like = '%' . $wpdb->esc_like($word) . '%';
            $search_sql .= $wpdb->prepare(" AND ({$wpdb->posts}.post_title LIKE %s OR {$wpdb->posts}.post_excerpt LIKE %s)", $like, $like);
        }}
        $where .= $search_sql;
    }
    return $where;
}
?>