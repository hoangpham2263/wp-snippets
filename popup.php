<?php
$popup_settings = get_field('popup_settings', 'option');
$popup = get_multi_lang_option($popup_settings, 'popup');
?>

<div id="popup-contact" class="popup-contact-overlay" data-popup="contact">
    <div class="popup-contact-container bg-white mx-4">
        <div class="relative w-full h-full">
            <button class="absolute top-2.5 lg:top-5 right-2.5 lg:right-5 z-60 cursor-pointer popup-close-btn" type="button" aria-label="Đóng popup">
                <svg class="size-7 lg:size-9" width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M27 9L9 27" stroke="#0F1A41" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M9 9L27 27" stroke="#0F1A41" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
            <div class="py-10 lg:py-15 px-5 lg:px-10">
                <p class="text-2xl lg:text-3xl 2xl:text-[32px] font-bold uppercase text-center text-primary mb-5 lg:mb-7.5">
                    <?php echo $popup['title']; ?>
                </p>
                <div id="popup-contact-form" class="mb-2.5 lg:mb-5">
                    <?php echo do_shortcode('[contact-form-7 id="11a57c0" title="Promotion Contact"]'); ?>
                </div>
                <div class="flex flex-col gap-2.5 mb-5 lg:mb-7.5">
                    <p class="text-sm lg:text-base font-medium text-primary">
                        <?php echo $popup['title_promotion']; ?>
                    </p>
                    <ul class="flex flex-col gap-2.5 list-disc list-inside">
                        <?php foreach ($popup['promotion'] as $item) : ?>
                            <li class="text-sm lg:text-base text-primary">
                                <?php echo esc_html($item['title']); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <button class="popup-submit-trigger py-2.5 lg:py-2.5 px-4 lg:px-4 bg-secondary cursor-pointer flex items-center justify-center gap-2 rounded-full w-fit mx-auto" type="button">
                    <span class="text-sm text-white"><?php pll_e('Gửi', 'HP'); ?></span>
                    <svg class="text-white" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.30078 15.2937C9.18998 15.2966 9.08069 15.2674 8.98608 15.2097C8.70738 15.0381 8.62248 14.6655 8.79018 14.3871C8.80428 14.3625 10.556 11.4393 13.8998 9.59968H0.900781C0.569881 9.59968 0.300781 9.33058 0.300781 8.99968C0.300781 8.66878 0.569881 8.39968 0.900781 8.39968H13.8998C10.5746 6.57058 8.80308 3.63448 8.78568 3.60508C8.62158 3.32488 8.71248 2.95198 8.99238 2.78608C9.27618 2.61778 9.64998 2.71528 9.81948 3.00058C10.0922 3.43558 12.6494 7.33528 17.2361 8.41438C17.5106 8.48188 17.7008 8.72218 17.7008 8.99998C17.7008 9.27778 17.5118 9.51868 17.2412 9.58438C12.635 10.6674 10.0865 14.5722 9.81108 15.0141C9.70308 15.1872 9.50328 15.2898 9.30078 15.2937Z" fill="currentcolor" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* CSS cho Popup Contact */
    .popup-contact-overlay {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-color: rgba(0, 0, 0, 0.8);
        z-index: 50;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease-in-out;
        box-sizing: border-box;
    }

    .popup-contact-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .popup-contact-container {
        overflow-y: auto;
        position: relative;
        transform: scale(0.8);
        transition: transform 0.3s ease-in-out;
        border-radius: 20px;
        margin: 1px;
        width: 100%;
        height: fit-content;
        max-width: 752px;
        max-height: 667px;
        border: 1px solid var(--color-primary);
    }

    @media(max-width:768px) {
        .popup-contact-container {
            border-radius: 12px;
            max-width: 90%;
        }
    }

    .popup-contact-overlay.active .popup-contact-container {
        transform: scale(1);
    }

    #popup-contact-form {
        width: 100%;
    }

    #popup-contact-form form {
        background-color: #fff;
        flex-direction: column;
        gap: 20px;
        display: flex
    }

    #popup-contact-form label {
        font-weight: 500;
        color: #0F1A41;
    }

    #popup-contact-form form>div>p {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    #popup-contact-form input,
    #popup-contact-form textarea,
    #popup-contact-form select {
        background-color: #fff;
        border: 1px solid #0F1A41;
        outline: none;
        width: 100%
    }

    #popup-contact-form input,
    #popup-contact-form select {
        border-radius: 99px;
        margin: 0;
        padding: 15px 30px
    }


    #popup-contact-form .button-contact {
        display: none;
    }


    @media(max-width:768px) {
        #popup-contact-form p {
            width: 100%
        }

        #popup-contact-form label,
        #popup-contact-form input,
        #popup-contact-form select,
        #popup-contact-form textarea,
        #popup-contact-form input[type=submit] {
            font-size: 16px
        }

        #popup-contact-form input,
        #popup-contact-form select {
            margin: 0;
            padding: 7.5px 15px
        }
    }

    .wpcf7-spinner {
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
    }

    #popup-contact-form .wpcf7-response-output {
        margin: -10px 0 0 0 !important;
    }
</style>


<script>
    // JavaScript cho Popup Contact
    (function() {
        'use strict';

        // Đợi DOM load xong
        document.addEventListener('DOMContentLoaded', function() {
            initPopupContact();
        });

        function initPopupContact() {
            const popup = document.getElementById('popup-contact');
            const triggerButtons = document.querySelectorAll('.popup-trigger-btn, [data-popup-trigger="contact"]');
            const closeButton = popup ? popup.querySelector('.popup-close-btn') : null;

            if (!popup) {
                console.warn('Popup contact element not found');
                return;
            }

            // Khởi tạo popup ở trạng thái ẩn
            popup.classList.remove('active');

            // Event listeners cho các nút mở popup
            triggerButtons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    openPopup();
                });
            });

            // Event listener cho nút đóng
            if (closeButton) {
                closeButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    closePopup();
                });
            }

            // Đóng popup khi click overlay
            popup.addEventListener('click', function(e) {
                if (e.target === popup) {
                    closePopup();
                }
            });

            // Đóng popup khi nhấn ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && popup.classList.contains('active')) {
                    closePopup();
                }
            });

            // Event listener cho button trigger submit form
            const submitTriggerBtn = popup.querySelector('.popup-submit-trigger');
            if (submitTriggerBtn) {
                submitTriggerBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Tìm button submit của Contact Form 7
                    const submitBtn = popup.querySelector('.button-contact .my-submit-btn');
                    if (submitBtn) {
                        // Trigger click vào button submit
                        submitBtn.click();
                    } else {
                        console.warn('Submit button not found');
                    }
                });
            }

            // Hàm mở popup
            function openPopup() {
                popup.classList.add('active');
                document.body.style.overflow = 'hidden';

                // Focus vào input đầu tiên sau khi popup mở
                setTimeout(function() {
                    const firstInput = popup.querySelector('input, textarea');
                    if (firstInput) {
                        firstInput.focus();
                    }
                }, 300);
            }

            // Hàm đóng popup
            function closePopup() {
                popup.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
    })();
</script>