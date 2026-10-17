<section class="pb-12 lg:pb-0">
    <div class="">
        <div class="flex items-center gap-5 pb-4 lg:pb-6">
            <h2 class="text-primary uppercase font-bold text-xl lg:text-3xl">Sản Phẩm Khác</h2>
            <span class="border-b-4 border-secondary w-16"></span>
        </div>
        <div class="flex lg:items-center relative">
            <div class="swiper related-product-swiper">
                <div class="swiper-wrapper">
                    <?php
                    // Get related products by category
                    $categories = get_the_category();
                    $args = array(
                        'post_type' => 'product',
                        'category__in' => wp_list_pluck($categories, 'term_id'),
                        'post__not_in' => array(get_the_ID()),
                        'posts_per_page' => 10,
                    );
                    $related_products = new WP_Query($args);
                    if ($related_products->have_posts()) {
                        while ($related_products->have_posts()) {
                            $related_products->the_post();
                            $product = wc_get_product(get_the_ID());
                            $percent = round(($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price() * 100);
                    ?>
                            <div class="swiper-slide">
                                <!-- product-loop-standard -->
                                <div class="group relative w-full pb-3 overflow-hidden bg-white flex flex-col border border-[#D9D9D9] rounded-xl transition-all duration-500 cursor-pointer">
                                    <div class="w-full aspect-square overflow-hidden">
                                        <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105 group-hover:brightness-90">
                                    </div>
                                    <div class="absolute top-2 right-2 bg-[#DB1907] text-white text-xs font-regular border border-none rounded-tl-full rounded-bl-full rounded-br-full w-9 h-9 flex items-center justify-center">
                                        -<?php echo $percent; ?>%
                                    </div>
                                    <a href="<?php the_permalink(); ?>" class="mt-3 mb-2 lg:mt-4 lg:mb-3 tablet:mt-3 tablet:mb-2 lg:px-5 px-3 text-base font-semibold hover:text-secondary transition duration-300 line-clamp-2">
                                        <h3><?php the_title(); ?></h3>
                                    </a>
                                    <div class="mx-2 lg:mx-4 p-3 flex items-center justify-between bg-primary/10 rounded-md">
                                        <p class="font-bold text-base line-clamp-1 text-[#DB1907]">
                                            <?php echo wc_price($product->get_sale_price()) ?>
                                        </p>
                                        <p class=" font-medium text-base line-clamp-1 line-through">
                                            <?php echo wc_price($product->get_regular_price()) ?>
                                        </p>
                                    </div>
                                    <button
                                        class="add-to-cart-btn group-hover:absolute hidden group-hover:flex items-center justify-center left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 bg-white/80 rounded-full border border-medium-gray w-12 h-12"
                                        data-product-id="<?php echo $product->get_id(); ?>"
                                        data-quantity="1">
                                        <svg width="27" height="33" viewBox="0 0 27 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.71094 7.6131C5.71094 7.91272 5.82988 8.20029 6.04217 8.41108C6.25296 8.62337 6.54053 8.74232 6.84015 8.74232H20.3907C20.3907 8.74232 21.5199 8.67757 21.5199 7.6131C21.5199 5.71636 20.7664 3.8973 19.4252 2.5561C18.084 1.2149 16.265 0.461426 14.3682 0.461426H12.8626C10.9659 0.461426 9.14681 1.2149 7.80561 2.5561C6.46442 3.8973 5.71094 5.71636 5.71094 7.6131ZM19.1305 6.48389H8.10035C8.35457 5.41201 8.96304 4.45728 9.82729 3.77418C10.6915 3.09109 11.761 2.71961 12.8626 2.71985H14.3682C15.4698 2.71961 16.5393 3.09109 17.4036 3.77418C18.2678 4.45728 18.8763 5.41201 19.1305 6.48389Z" fill="#1176A8" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M25.3699 8.9546C25.3281 8.28567 25.033 7.65779 24.5447 7.19877C24.0563 6.73976 23.4113 6.48412 22.7411 6.48389H4.49001C3.81977 6.48412 3.17482 6.73976 2.68643 7.19877C2.19805 7.65779 1.90295 8.28567 1.8612 8.9546L0.543788 30.0332C0.521157 30.3923 0.572363 30.7523 0.694244 31.0908C0.816126 31.4294 1.0061 31.7394 1.25243 32.0016C1.49877 32.2639 1.79624 32.4729 2.1265 32.6158C2.45675 32.7586 2.81277 32.8323 3.17259 32.8322H24.0585C24.4183 32.832 24.7742 32.7582 25.1043 32.6153C25.4345 32.4724 25.7319 32.2634 25.9782 32.0012C26.2244 31.7389 26.4144 31.429 26.5364 31.0906C26.6584 30.7521 26.7097 30.3923 26.6873 30.0332L25.3699 8.9546ZM14.7448 18.5288V15.1412C14.7448 14.8417 14.6258 14.5545 14.414 14.3427C14.2023 14.1309 13.915 14.012 13.6155 14.012C13.3161 14.012 13.0288 14.1309 12.8171 14.3427C12.6053 14.5545 12.4863 14.8417 12.4863 15.1412V18.5288H9.0987C8.79921 18.5288 8.51199 18.6478 8.30023 18.8596C8.08846 19.0713 7.96949 19.3585 7.96949 19.658C7.96949 19.9575 8.08846 20.2447 8.30023 20.4565C8.51199 20.6683 8.79921 20.7872 9.0987 20.7872H12.4863V24.1749C12.4863 24.4744 12.6053 24.7616 12.8171 24.9733C13.0288 25.1851 13.3161 25.3041 13.6155 25.3041C13.915 25.3041 14.2023 25.1851 14.414 24.9733C14.6258 24.7616 14.7448 24.4744 14.7448 24.1749V20.7872H18.1324C18.4319 20.7872 18.7191 20.6683 18.9309 20.4565C19.1426 20.2447 19.2616 19.9575 19.2616 19.658C19.2616 19.3585 19.1426 19.0713 18.9309 18.8596C18.7191 18.6478 18.4319 18.5288 18.1324 18.5288H14.7448Z" fill="#1176A8" />
                                        </svg>
                                    </button>
                                </div>
                                <!-- end product-loop-standard -->
                            </div>
                    <?php
                        }
                        wp_reset_postdata();
                    }
                    ?>
                </div>
            </div>
            <div class="cs-button-prev w-9 lg:w-10 h-9 lg:h-10 absolute -bottom-12 lg:bottom-auto left-0 lg:-left-16 z-10 flex items-center justify-center text-primary hover:text-white bg-white hover:bg-primary border border-medium-gray rounded-full" tabindex="0" role="button" aria-label="Previous slide" aria-controls="swiper-wrapper-3a51dfb3b7fa8d0f">
                <svg class="mr-1 w-4 lg:w-5 h-4 lg:h-5" viewBox="0 0 10 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.763157 9.225C0.348156 8.83075 0.348156 8.16925 0.763157 7.775L8.31125 0.604311C8.94823 -0.000822458 10 0.450714 10 1.32931L10 15.6707C10 16.5493 8.94823 17.0008 8.31125 16.3957L0.763157 9.225Z" fill="currentColor"></path>
                </svg>
            </div>
            <div class="cs-button-next w-9 lg:w-10 h-9 lg:h-10 absolute -bottom-12 lg:bottom-auto left-11 lg:left-auto lg:-right-16 z-10 flex items-center justify-center text-primary hover:text-white bg-white hover:bg-primary border border-medium-gray rounded-full" tabindex="0" role="button" aria-label="Next slide" aria-controls="swiper-wrapper-3a51dfb3b7fa8d0f">
                <svg class="ml-1 w-4 lg:w-5 h-4 lg:h-5" viewBox="0 0 10 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.23684 9.225C9.65184 8.83075 9.65184 8.16925 9.23684 7.775L1.68875 0.604311C1.05177 -0.000822458 -1.86571e-07 0.450714 -2.24975e-07 1.32931L-8.51857e-07 15.6707C-8.90262e-07 16.5493 1.05177 17.0008 1.68875 16.3957L9.23684 9.225Z" fill="currentColor"></path>
                </svg>
            </div>
        </div>
    </div>
</section>
<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/css/swiper-bundle.min.css" />
<script src="<?php echo get_template_directory_uri() ?>/js/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const swiper = new Swiper('.related-product-swiper', {
            loop: true,
            slidesPerView: 2,
            spaceBetween: 10,
            breakpoints: {
                768: {
                    slidesPerView: 3,
                    spaceBetween: 16
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 24,
                },
                1280: {
                    slidesPerView: 5,
                    spaceBetween: 24,
                }
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
            navigation: {
                nextEl: '.cs-button-next',
                prevEl: '.cs-button-prev',
            }
        });
    });
</script>
<script>
    var lastWidth = window.innerWidth;

    function resetButtonPositions(buttons) {
        for (var i = 0; i < buttons.length; i++) {
            buttons[i].style.left = '';
            buttons[i].style.right = '';
        }
    }

    function checkOverflow() {
        var prevButtons = document.getElementsByClassName("cs-button-prev");
        var nextButtons = document.getElementsByClassName("cs-button-next");

        if (window.innerWidth > lastWidth) {
            resetButtonPositions(prevButtons);
            resetButtonPositions(nextButtons);
        }

        checkButtons(prevButtons, "left");
        checkButtons(nextButtons, "right");

        lastWidth = window.innerWidth;
    }

    function checkButtons(buttons, side) {
        for (var i = 0; i < buttons.length; i++) {
            var rect = buttons[i].getBoundingClientRect();
            if (side === "left" && rect.left < 0) {
                var adjustment = -rect.left;
                buttons[i].style.left = (parseInt(getComputedStyle(buttons[i]).left, 10) + adjustment) + 'px';
            }
            if (side === "right" && rect.right > window.innerWidth) {
                var adjustment = rect.right - window.innerWidth;
                buttons[i].style.right = (parseInt(getComputedStyle(buttons[i]).right, 10) + adjustment) + 'px';
            }
        }
    }

    window.addEventListener('resize', checkOverflow);
    window.addEventListener('DOMContentLoaded', checkOverflow);
</script>

<script>
    function addToCartInTable(productId, quantity, btn) {
        fetch('/?wc-ajax=add_to_cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}&quantity=${quantity}`
            })
            .then(response => response.json())
            .then(data => {
                fetch("<?php echo admin_url('admin-ajax.php'); ?>?action=get_cart_count")
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('header-cart-count').textContent = data.count;
                    });
                btn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                `;
                btn.disabled = true;
                toastr.success('Đã thêm sản phẩm vào giỏ hàng');
            })
            .catch(error => {
                toastr.error('Lỗi khi thêm sản phẩm vào giỏ hàng');
                console.error(error);
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.add-to-cart-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const productId = this.getAttribute('data-product-id');
                const quantity = this.getAttribute('data-quantity') || 1;
                addToCartInTable(productId, quantity, this);
            });
        });
    });
</script>