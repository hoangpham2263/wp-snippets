<?php
/**
 * @param array $atts
 * @param string $atts['id_render_ajax']
 */
// [sc_search-input id_render_ajax="search_id-render-ajax-1"]
function sc_search_input_shortcode($atts) {
    // Generate unique IDs for this instance
    $unique_id = uniqid('search_');
    
    $atts = shortcode_atts(array(
        'id_render_ajax' => '',
        'id_input_search' => $unique_id . '_input',
        'id_button_search' => $unique_id . '_button',
    ), $atts, 'sc_search-input');

    ob_start();
    ?>
    <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="get" class="relative">
        <input id="<?= esc_attr($atts['id_input_search']) ?>" 
               name="cs-search" 
               type="text" 
               class="w-full border border-primary rounded-[46px] bg-primary/15 py-[10px] pl-12 pr-10 placeholder:text-[#777777] placeholder:font-regular placeholder:text-sm outline-none" 
               placeholder="Tìm kiếm: Thời trang nam, Thời trang nữ, Balo, túi xách...">
        <button id="<?= esc_attr($atts['id_button_search']) ?>" 
                type="submit" 
                class="absolute left-3 top-1/2 -translate-y-1/2 bg-primary text-white rounded-full p-1 hover:bg-primary/80 transition-all duration-300 cursor-pointer">
            <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </button>
    </form>

    <script>
    (function() {
        const searchInput = document.getElementById('<?= esc_js($atts['id_input_search']) ?>');
        const searchButton = document.getElementById('<?= esc_js($atts['id_button_search']) ?>');

        function handleSearch() {
            const searchTerm = searchInput.value.trim();
            const url = new URL(window.location.href);

            if (searchTerm.length > 0) {
                url.searchParams.set('cs-search', searchTerm);
            } else {
                url.searchParams.delete('cs-search');
            }

            window.history.replaceState({}, '', url);

            const productList = document.querySelector('#<?= esc_js($atts['id_render_ajax']) ?>');
            if (productList) {
                productList.innerHTML = '<div class="flex items-center justify-center h-full"><div class="w-10 h-10 border-t-2 border-b-2 border-primary rounded-full animate-spin"></div></div>';

                fetch(url)
                    .then(response => response.text())
                    .then(data => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(data, 'text/html');
                        const newProductList = doc.getElementById('<?= esc_js($atts['id_render_ajax']) ?>');

                        if (newProductList) {
                            productList.innerHTML = newProductList.innerHTML;
                        }
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        productList.innerHTML = '<div class="text-center py-4">Có lỗi xảy ra khi tìm kiếm. Vui lòng thử lại.</div>';
                    });
            }
        }

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
    })();
    </script>
    <?php
    return ob_get_clean();
}

add_shortcode('sc_search-input', 'sc_search_input_shortcode');
?>