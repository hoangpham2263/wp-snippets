<?php

/**
 * Account Header Icon Shortcode
 * 
 * Desktop: Hover icon để hiển thị dropdown menu
 * Mobile: Click icon để mở side sheet từ trái
 * 
 * Usage:
 * [sc_account_header_icon]
 * [sc_account_header_icon logged_out_items="login,register"]
 * 
 * @param string $logged_out_items - Comma-separated list of menu items for logged-out users
 */
function sc_account_header_icon_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'logged_out_items' => 'login,register',
    ), $atts, 'sc_account_header_icon');

    $is_logged_in = is_user_logged_in();
    $current_user = wp_get_current_user();

    ob_start();
?>
    <div class="relative account-icon-container">
        <!-- Desktop: Icon hiển thị, hover để mở dropdown -->
        <div class="hidden lg:flex items-center justify-center account-icon cursor-pointer p-2 bg-white rounded-full bg-linear-gradient-button w-10 h-10">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 0C7.09223 0 4.72656 2.36566 4.72656 5.27344C4.72656 8.18121 7.09223 10.5469 10 10.5469C12.9078 10.5469 15.2734 8.18121 15.2734 5.27344C15.2734 2.36566 12.9078 0 10 0ZM10 9.375C7.7384 9.375 5.89844 7.53504 5.89844 5.27344C5.89844 3.01184 7.7384 1.17188 10 1.17188C12.2616 1.17188 14.1016 3.01184 14.1016 5.27344C14.1016 7.53504 12.2616 9.375 10 9.375ZM16.5612 13.992C15.1174 12.5261 13.2035 11.7188 11.1719 11.7188H8.82812C6.79656 11.7188 4.88258 12.5261 3.43883 13.992C2.00215 15.4507 1.21094 17.3763 1.21094 19.4141C1.21094 19.7377 1.47328 20 1.79688 20H18.2031C18.5267 20 18.7891 19.7377 18.7891 19.4141C18.7891 17.3763 17.9979 15.4507 16.5612 13.992ZM2.40859 18.8281C2.70215 15.5045 5.46918 12.8906 8.82812 12.8906H11.1719C14.5308 12.8906 17.2979 15.5045 17.5914 18.8281H2.40859Z" fill="#212121" />
            </svg>
        </div>
        <!-- Mobile: Icon hiển thị, click để mở side sheet -->
        <div class="lg:hidden account-icon account-icon-mobile cursor-pointer p-2 rounded-full w-10 h-10 flex items-center justify-center">
            <img src="<?php echo esc_url( get_stylesheet_directory_uri() . "/images/user.png" ); ?>" alt="user" class="h-5 w-auto">
        </div>

        <!-- Dropdown/Sheet Menu -->
        <div class="account-dropdown absolute right-0 top-full w-64 bg-white shadow-lg border border-gray-200 opacity-0 invisible transition-all duration-200 z-50">
            <!-- Mobile: Header với nút đóng -->
            <div class="mobile-sheet-header">
                <h3 class="text-lg font-semibold">Tài khoản</h3>
                <button class="mobile-sheet-close">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 1L1 13M1 1L13 13" stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
            <?php if ($is_logged_in): ?>
                <!-- User Info Header -->
                <div class="px-4 py-3 border-b border-gray-200">
                    <p class="text-sm font-semibold text-gray-900"><?php echo esc_html($current_user->display_name); ?></p>
                    <p class="text-xs text-gray-500 mt-1"><?php echo esc_html($current_user->user_email); ?></p>
                </div>

                <!-- Menu Items -->
                <ul class="py-2">
                    <?php
                    $menu_items = wc_get_account_menu_items();
                    $menu_icons = array(
                        'dashboard' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>',
                        'orders' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>',
                        'downloads' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>',
                        'edit-address' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>',
                        'edit-account' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>',
                        'customer-logout' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>',
                        'payment-methods' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>',
                        'subscriptions' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>',
                        'bookings' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>'
                    );
                    $default_icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>';

                    foreach ($menu_items as $endpoint => $label):
                        $is_logout = ($endpoint === 'customer-logout');
                        $link_classes = $is_logout ?
                            'flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors' :
                            'flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors';
                        $li_classes = $is_logout ? 'border-t border-gray-200 mt-2 pt-2' : '';
                        $icon_path = isset($menu_icons[$endpoint]) ? $menu_icons[$endpoint] : $default_icon;
                    ?>
                        <li class="<?php echo $li_classes; ?>">
                            <a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>" class="<?php echo $link_classes; ?>">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <?php echo $icon_path; ?>
                                </svg>
                                <?php echo esc_html($label); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <!-- Menu Items cho người chưa đăng nhập -->
                <ul class="py-2">
                    <?php
                    $logged_out_items = explode(',', $atts['logged_out_items']);
                    foreach ($logged_out_items as $item):
                        $item = trim($item);
                        switch ($item):
                            case 'login':
                    ?>
                                <li>
                                    <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                        </svg>
                                        Đăng nhập
                                    </a>
                                </li>
                            <?php break;
                            case 'register': ?>
                                <li>
                                    <a href="<?php echo esc_url(add_query_arg('action', 'register', wc_get_page_permalink('myaccount'))); ?>" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                        </svg>
                                        Đăng ký
                                    </a>
                                </li>
                    <?php
                                break;
                        endswitch;
                    endforeach;
                    ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>

    <!-- Mobile: Overlay background -->
    <div class="mobile-overlay"></div>

    <style>
        .account-icon-container {
            position: relative;
        }

        /* Desktop: Hover để hiển thị dropdown */
        @media (min-width: 1024px) {
            .account-icon-container:hover .account-dropdown {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }
        }

        .account-dropdown {
            transform: translateY(-10px);
            min-width: 240px;
        }

        .account-dropdown::before {
            content: '';
            position: absolute;
            top: -6px;
            right: 20px;
            width: 12px;
            height: 12px;
            background: white;
            border-left: 1px solid #e5e7eb;
            border-top: 1px solid #e5e7eb;
            transform: rotate(45deg);
        }

        .account-icon svg {
            transition: color 0.2s;
        }

        .account-icon:hover svg {
            color: #F15F25;
        }

        /* Mobile: Side sheet từ trái */
        @media (max-width: 1023px) {
            .account-dropdown {
                position: fixed;
                top: var(--header-height);
                left: 0;
                bottom: 0;
                width: 320px;
                max-width: 85vw;
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                height: 100vh;
                overflow-y: auto;
                z-index: 9999;
            }

            .account-dropdown.active {
                transform: translateX(0);
                opacity: 1;
                visibility: visible;
            }

            .account-dropdown.hiding {
                transform: translateX(-100%);
                opacity: 0;
                transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94), opacity 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            }

            .account-dropdown::before {
                display: none;
            }

            .mobile-sheet-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 20px 16px 16px;
                border-bottom: 1px solid #e5e7eb;
                position: sticky;
                top: 0;
                background: white;
                z-index: 10;
            }

            .mobile-sheet-close {
                width: 32px;
                height: 32px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                background: #f3f4f6;
                cursor: pointer;
                transition: background 0.2s;
            }

            .mobile-sheet-close:hover {
                background: #e5e7eb;
            }

            .mobile-overlay {
                position: fixed;
                top: var(--header-height);
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.7);
                backdrop-filter: blur(4px);
                -webkit-backdrop-filter: blur(4px);
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 9998;
                cursor: pointer;
            }

            .mobile-overlay.active {
                opacity: 1;
                visibility: visible;
            }

            body.sheet-open {
                overflow: hidden;
            }
        }

        /* Desktop: Ẩn các element mobile */
        @media (min-width: 1024px) {

            .mobile-sheet-header,
            .mobile-overlay {
                display: none !important;
            }
        }
    </style>

    <script>
        function setHeaderHeight() {
            const header = document.querySelector('header');
            if (header) {
                const headerHeight = header.offsetHeight;
                console.log(headerHeight, "headerHeight");
                // Set CSS custom property
                document.documentElement.style.setProperty('--header-height', headerHeight + 'px');
            }
        }

        // Wait for DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            setHeaderHeight();
        });

        // Also wait for all resources (CSS, images) to load
        window.addEventListener('load', function() {
            setHeaderHeight();
        });

        // Update on window resize
        window.addEventListener('resize', function() {
            setHeaderHeight();
        });



        (function() {
            function initAccountDropdown() {
                // Sử dụng jQuery nếu có
                if (typeof jQuery !== 'undefined') {
                    jQuery(document).ready(function($) {
                        $('.account-icon-container').each(function() {
                            var $container = $(this);
                            var $mobileIcon = $container.find('.account-icon-mobile');
                            var $dropdown = $container.find('.account-dropdown');
                            var $overlay = $('.mobile-overlay');
                            var $closeButton = $dropdown.find('.mobile-sheet-close');

                            // Mobile: Mở sheet
                            function openSheet() {
                                $dropdown.addClass('active');
                                $overlay.addClass('active');
                                $('body').addClass('sheet-open');
                            }

                            // Mobile: Đóng sheet
                            function closeSheet() {
                                $dropdown.addClass('hiding');
                                $overlay.removeClass('active');
                                
                                // Remove active class and hiding class after animation
                                setTimeout(function() {
                                    $dropdown.removeClass('active hiding');
                                    $('body').removeClass('sheet-open');
                                }, 400);
                            }

                            // Mobile: Click icon để mở
                            $mobileIcon.on('click', function(e) {
                                e.preventDefault();
                                e.stopPropagation();
                                openSheet();
                            });

                            // Mobile: Click nút X để đóng
                            $closeButton.on('click', function(e) {
                                e.preventDefault();
                                e.stopPropagation();
                                closeSheet();
                            });

                            // Mobile: Click overlay để đóng
                            $overlay.on('click', function(e) {
                                e.preventDefault();
                                e.stopPropagation();
                                closeSheet();
                            });

                            // Mobile: Phím Escape để đóng
                            $(document).on('keydown', function(e) {
                                if (e.key === 'Escape' && $dropdown.hasClass('active')) {
                                    closeSheet();
                                }
                            });

                            $dropdown.on('click', function(e) {
                                e.stopPropagation();
                            });
                        });
                    });
                } else {
                    // Fallback vanilla JS nếu không có jQuery
                    document.addEventListener('DOMContentLoaded', function() {
                        setTimeout(function() {
                            var containers = document.querySelectorAll('.account-icon-container');

                            containers.forEach(function(container) {
                                var mobileIcon = container.querySelector('.account-icon-mobile');
                                var dropdown = container.querySelector('.account-dropdown');
                                var overlay = document.querySelector('.mobile-overlay');
                                var closeButton = dropdown ? dropdown.querySelector('.mobile-sheet-close') : null;

                                if (!mobileIcon || !dropdown) {
                                    return;
                                }

                                // Mobile: Mở sheet
                                function openSheet() {
                                    dropdown.classList.add('active');
                                    if (overlay) overlay.classList.add('active');
                                    document.body.classList.add('sheet-open');
                                }

                                // Mobile: Đóng sheet
                                function closeSheet() {
                                    dropdown.classList.add('hiding');
                                    if (overlay) overlay.classList.remove('active');
                                    
                                    // Remove active class and hiding class after animation
                                    setTimeout(function() {
                                        dropdown.classList.remove('active', 'hiding');
                                        document.body.classList.remove('sheet-open');
                                    }, 400);
                                }

                                // Mobile: Click icon để mở
                                mobileIcon.addEventListener('click', function(e) {
                                    e.preventDefault();
                                    e.stopPropagation();
                                    openSheet();
                                });

                                // Mobile: Click nút X để đóng
                                if (closeButton) {
                                    closeButton.addEventListener('click', function(e) {
                                        e.preventDefault();
                                        e.stopPropagation();
                                        closeSheet();
                                    });
                                }

                                // Mobile: Click overlay để đóng
                                if (overlay) {
                                    overlay.addEventListener('click', function(e) {
                                        e.preventDefault();
                                        e.stopPropagation();
                                        closeSheet();
                                    });
                                }

                                // Mobile: Phím Escape để đóng
                                document.addEventListener('keydown', function(e) {
                                    if (e.key === 'Escape' && dropdown.classList.contains('active')) {
                                        closeSheet();
                                    }
                                });

                                dropdown.addEventListener('click', function(e) {
                                    e.stopPropagation();
                                });
                            });
                        }, 200);
                    });
                }
            }

            initAccountDropdown();
        })();
    </script>
<?php
    return ob_get_clean();
}

add_shortcode('sc_account-header-icon', 'sc_account_header_icon_shortcode');
?>