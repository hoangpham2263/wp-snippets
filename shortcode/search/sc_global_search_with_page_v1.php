<?php

/**
 * Global Search Shortcode V1 (Vanilla JS & AJAX)
 * Usage: [global_search_with_page_v1]
 */

// 1. Shortcode Registration
function gswp_v1_render_search_form($atts)
{
    // Unique ID to allow multiple search bars on one page
    $unique_id = uniqid('gswp_v1_');

    $atts = shortcode_atts(array(
        'placeholder'    => 'Search...',
        'class'          => 'relative w-full max-w-[488px] group gswp-v1-container',
        'search_types'   => 'product,post,property,document,quiz',
        'product_limit'  => '5',
        'post_limit'     => '5',
        'property_limit' => '5',
        'document_limit' => '5',
        'quiz_limit'     => '5',

        // CSS Classes
        'form_class'     => 'flex px-5 bg-white border border-[#1B1D1F] rounded-full items-center gap-2 lg:gap-3 py-[9.7px] w-full transition-colors duration-300 focus-within:border-primary',
        'input_class'    => 'bg-white w-full outline-none font-light appearance-none rounded-none placeholder:text-[#1B1D1F]',
        'button_class'   => 'w-5 lg:w-5 aspect-square rounded-full flex items-center justify-center shrink-0 cursor-pointer',
        'results_class'  => 'absolute z-[999] top-[calc(100%+4px)] left-0 w-full bg-white max-h-0 opacity-0 overflow-hidden transition-all duration-300 ease-in-out shadow-xl rounded-lg border border-[#1B1D1F] custom-scrollbar-v1',
    ), $atts, 'global_search_with_page_v1');

    ob_start();
?>
    <div class="<?php echo esc_attr($atts['class']); ?>" id="<?php echo esc_attr($unique_id); ?>">

        <form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="<?php echo esc_attr($atts['form_class']); ?>">
            <input type="text"
                name="s"
                class="<?php echo esc_attr($atts['input_class']); ?>"
                placeholder="<?php echo esc_attr($atts['placeholder']); ?>"
                autocomplete="off">
            <button type="submit" class="<?php echo esc_attr($atts['button_class']); ?>" aria-label="Search">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.795 16.8053L13.4021 12.4126C14.494 11.0995 15.1519 9.41337 15.1519 7.57617C15.1519 3.39865 11.7533 0 7.57599 0C3.39856 0 0 3.39865 0 7.57617C0 11.7534 3.39856 15.1518 7.57599 15.1518C9.41309 15.1518 11.0993 14.494 12.4124 13.4021L16.8053 17.795C16.8702 17.8601 16.9474 17.9117 17.0323 17.9469C17.1172 17.9821 17.2083 18.0001 17.3002 18C17.4386 18.0001 17.574 17.9591 17.6891 17.8822C17.8042 17.8053 17.894 17.696 17.947 17.5681C17.9999 17.4402 18.0138 17.2994 17.9867 17.1637C17.9597 17.0279 17.893 16.9032 17.795 16.8053ZM1.39966 7.57617C1.39966 4.17043 4.17033 1.39966 7.57599 1.39966C10.9815 1.39966 13.7521 4.17043 13.7521 7.57617C13.7521 10.9816 10.9815 13.7521 7.57599 13.7521C4.17033 13.7521 1.39966 10.9816 1.39966 7.57617Z" fill="#1B1D1F" />
                </svg>
            </button>
        </form>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('global_search_with_page_v1', 'gswp_v1_render_search_form');
