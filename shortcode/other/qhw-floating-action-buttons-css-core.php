<?php
// Floating Action Buttons
function fab_customize_register($wp_customize)
{
  $wp_customize->add_section('fab_settings_section', array(
    'title'    => __('Floating Action Buttons', 'your-textdomain'),
    'priority' => 160,
  ));

  $wp_customize->add_setting('fab_enable', array(
    'default'           => 1,
    'sanitize_callback' => 'absint',
  ));
  $wp_customize->add_control('fab_enable', array(
    'label'   => __('Enable Floating Action Buttons', 'your-textdomain'),
    'section' => 'fab_settings_section',
    'type'    => 'checkbox',
  ));

  // Color setting for FAB buttons and ripple effect
  if (class_exists('WP_Customize_Color_Control')) {
    $wp_customize->add_setting('fab_color', array(
      'default'           => '#028090',
      'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control(
      $wp_customize,
      'fab_color',
      array(
        'label'   => __('FAB Color', 'your-textdomain'),
        'section' => 'fab_settings_section',
        'settings' => 'fab_color',
      )
    ));
  }

  for ($i = 1; $i <= 5; $i++) {
    $wp_customize->add_setting("fab_button_{$i}_status", array(
      'default'           => 1,
      'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control("fab_button_{$i}_status", array(
      'label'   => sprintf(__('Enable Button %d', 'your-textdomain'), $i),
      'section' => 'fab_settings_section',
      'type'    => 'checkbox',
    ));

    $wp_customize->add_setting("fab_button_{$i}_link", array(
      'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control("fab_button_{$i}_link", array(
      'label'   => sprintf(__('Button %d Link URL', 'your-textdomain'), $i),
      'section' => 'fab_settings_section',
      'type'    => 'url',
    ));

    $wp_customize->add_setting("fab_button_{$i}_icon", array(
      'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Cropped_Image_Control(
      $wp_customize,
      "fab_button_{$i}_icon",
      array(
        'label'    => sprintf(__('Button %d Icon', 'your-textdomain'), $i),
        'section'  => 'fab_settings_section',
        'settings' => "fab_button_{$i}_icon",
        'width'    => 48,
        'height'   => 48,
      )
    ));
  }

  $wp_customize->add_setting("fab_scroll_to_top_status", array(
    'default'           => 1,
    'sanitize_callback' => 'absint',
  ));
  $wp_customize->add_control("fab_scroll_to_top_status", array(
    'label'   => __('Enable Scroll to Top Button', 'your-textdomain'),
    'section' => 'fab_settings_section',
    'type'    => 'checkbox',
  ));

  $wp_customize->add_setting("fab_scroll_to_top_icon", array(
    'sanitize_callback' => 'absint',
  ));
  $wp_customize->add_control(new WP_Customize_Cropped_Image_Control(
    $wp_customize,
    "fab_scroll_to_top_icon",
    array(
      'label'    => __('Scroll to Top Button Icon', 'your-textdomain'),
      'section'  => 'fab_settings_section',
      'settings' => "fab_scroll_to_top_icon",
      'width'    => 48,
      'height'   => 48,
    )
  ));
}
add_action('customize_register', 'fab_customize_register');


function hp_hex_to_rgb($hex)
{
  $hex = ltrim((string) $hex, '#');
  if (strlen($hex) === 3) {
    $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
  }
  if (strlen($hex) !== 6) {
    return '0, 128, 144';
  }
  $r = hexdec(substr($hex, 0, 2));
  $g = hexdec(substr($hex, 2, 2));
  $b = hexdec(substr($hex, 4, 2));
  return $r . ', ' . $g . ', ' . $b;
}

function get_fab_buttons()
{
  $buttons = [];
  for ($i = 1; $i <= 5; $i++) {
    $status = get_theme_mod("fab_button_{$i}_status", 1);
    $link = get_theme_mod("fab_button_{$i}_link", '');
    $icon_id = get_theme_mod("fab_button_{$i}_icon");
    $icon_url = $icon_id ? wp_get_attachment_url($icon_id) : '';

    if (!$status || !$icon_url) continue;

    $buttons[] = [
      'link' => $link,
      'icon' => ['url' => $icon_url, 'alt' => ''],
    ];
  }

  $scroll_status = get_theme_mod("fab_scroll_to_top_status", 1);
  $scroll_icon_id = get_theme_mod("fab_scroll_to_top_icon");
  $scroll_icon_url = $scroll_icon_id ? wp_get_attachment_url($scroll_icon_id) : '';

  if ($scroll_status && $scroll_icon_url) {
    $buttons[] = [
      'link' => '#',
      'icon' => ['url' => $scroll_icon_url, 'alt' => 'Scroll to top'],
      'is_scroll_to_top' => true
    ];
  }

  return $buttons;
}

function hp_floating_action_buttons_shortcode()
{
  $fab_enabled = get_theme_mod('fab_enable', 1);
  if (!$fab_enabled) return '';

  $fab_color = get_theme_mod('fab_color', '#028090');
  $fab_rgb = hp_hex_to_rgb($fab_color);

  $popup_contact_settings = function_exists('get_field') ? get_field('popup_contact_settings', 'option') : null;
  $phone = function_exists('get_field') ? get_field('phone', 'option') : null;
  $network = function_exists('get_field') ? get_field('network', 'option') : null;

  $fab_buttons = get_fab_buttons();
  if (empty($popup_contact_settings) && empty($phone) && (empty($network) || empty($network['items'])) && empty($fab_buttons)) return '';

  ob_start();
?>
  <?php
  static $fab_effects_printed = false;
  if (!$fab_effects_printed) {
    $fab_effects_printed = true;
  ?>
    <style>
      .contact-item {
        position: relative;
      }

      .contact-item {
        overflow: visible;
        animation: tilt-shaking 1.5s ease-in-out infinite;
      }

      @keyframes tilt-shaking {

        0%,
        60%,
        100% {
          transform: rotate(0deg);
        }

        4% {
          transform: rotate(5deg);
        }

        8% {
          transform: rotate(0deg);
        }

        12% {
          transform: rotate(-5deg);
        }

        16% {
          transform: rotate(0deg);
        }
      }

      .contact-item::before,
      .contact-item::after,
      .contact-item .wave-effect {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 46px;
        z-index: -1;
        pointer-events: none;
      }

      .contact-item::before {
        animation: ripple 1.5s infinite linear;
      }

      .contact-item::after {
        animation: ripple 1.5s 0.5s infinite linear;
      }

      .contact-item .wave-effect {
        animation: ripple 1.5s 1.0s infinite linear;
      }

      @keyframes ripple {
        0% {
          box-shadow: 0 0 0 0 rgba(var(--ripple-color, 0, 128, 144), 1);
        }

        33% {
          box-shadow: 0 0 0 6px rgba(var(--ripple-color, 0, 128, 144), 0.7);
        }

        66% {
          box-shadow: 0 0 0 9px rgba(var(--ripple-color, 0, 128, 144), 0.5);
        }

        100% {
          box-shadow: 0 0 0 12px rgba(var(--ripple-color, 0, 128, 144), 0);
        }
      }

      @media screen and (max-width: 768px) {

        .contact-item {
          display: flex !important;
          align-items: center;
          justify-content: center;
          border-radius: 46px;
          overflow: visible !important;
          position: relative;
          z-index: 10;
          opacity: 1 !important;
          visibility: visible !important;
        }

        .contact-item-container {
          position: relative;
          height: 40px;
          margin-bottom: 10px;
        }
      }


      .network-toggle-btn {
        cursor: pointer;
        transition: transform 0.3s ease;
      }

      .network-toggle-btn:hover {
        transform: scale(1.1);
      }

      .network-toggle-btn.active {
        transform: rotate(45deg);
      }

      .social-icons-container {
        position: absolute;
        bottom: 12%;
        right: 100%;
        display: flex;
        flex-direction: row;
        gap: 15px;
        margin-right: 15px;
        opacity: 0;
        visibility: hidden;
        transform: translateX(50px) translateY(50%);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        pointer-events: none;
      }

      .social-icons-container.show {
        opacity: 1;
        visibility: visible;
        transform: translateX(0) translateY(50%);
        pointer-events: all;
      }

      .social-icon-item {
        transform: translateX(30px) scale(0.8);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        opacity: 0;
      }

      .social-icons-container.show .social-icon-item {
        transform: translateX(0) scale(1);
        opacity: 1;
      }

      .social-icons-container.show .social-icon-item:nth-child(1) {
        transition-delay: 0.1s;
      }

      .social-icons-container.show .social-icon-item:nth-child(2) {
        transition-delay: 0.2s;
      }

      .social-icons-container.show .social-icon-item:nth-child(3) {
        transition-delay: 0.3s;
      }

      .social-icons-container.show .social-icon-item:nth-child(4) {
        transition-delay: 0.4s;
      }

      .social-icons-container.show .social-icon-item:nth-child(5) {
        transition-delay: 0.5s;
      }

      @media screen and (max-width: 768px) {
        .social-icons-container {
          flex-direction: column;
          gap: 16px;
          margin-right: 10px;
          max-height: 120px;
          flex-wrap: wrap;
          align-content: flex-start;
          width: auto;
          bottom: 30%;
          right: 450%;
        }

        .social-icons-container .social-icon-item {
          flex: 0 0 auto;
        }
      }

      @media screen and (max-width: 768px) {
        .entry-post-content p:has(img) {
          display: flex !important;
          flex-direction: column !important;
          gap: 10px !important;
        }
      }

      @media screen and (min-width: 768px) {
        .entry-post-content p:has(img) {
          display: flex !important;
          gap: 16px !important;
        }
      }

      /* Tailwind Classes Converted to Pure CSS */
      .fab-container {
        position: fixed;
        bottom: 1.25rem;
        right: 1.25rem;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        z-index: 50;
      }

      @media screen and (min-width: 768px) {
        .fab-container {
          bottom: 1.5rem;
          right: 1.5rem;
        }
      }

      .contact-item {
        border: 1px solid;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 3rem;
        height: 3rem;
        cursor: pointer;
      }

      .contact-item img {
        width: 1.5rem;
        height: 1.5rem;
      }

      @media screen and (max-width: 768px) {
        .fab-container {
          right: 12px;
          bottom: calc(12px + env(safe-area-inset-bottom, 0));
          gap: 22px;
        }
        .contact-item {
          width: 36px;
          height: 36px;
        }
        .contact-item img {
          width: 20px;
          height: 20px;
        }
      }
    </style>
  <?php }
  ?>
  <div class="fab-container" style="--ripple-color: <?php echo esc_attr($fab_rgb); ?>;">
    <?php if (empty($popup_contact_settings) && empty($phone) && (empty($network) || empty($network['items'])) && !empty($fab_buttons)): ?>
      <?php foreach ($fab_buttons as $button): ?>
        <?php if (isset($button['is_scroll_to_top']) && $button['is_scroll_to_top']): ?>
          <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="contact-item" style="background-color: <?php echo esc_attr($fab_color); ?>; border-color: <?php echo esc_attr($fab_color); ?>;">
            <span class="wave-effect"></span>
            <img src="<?php echo esc_url($button['icon']['url']); ?>" alt="<?php echo esc_attr($button['icon']['alt']); ?>" />
          </button>
        <?php else: ?>
          <a href="<?php echo esc_url($button['link'] ?: '#'); ?>" class="contact-item" style="background-color: <?php echo esc_attr($fab_color); ?>; border-color: <?php echo esc_attr($fab_color); ?>;" target="_blank">
            <span class="wave-effect"></span>
            <img src="<?php echo esc_url($button['icon']['url']); ?>" alt="<?php echo esc_attr($button['icon']['alt']); ?>" />
          </a>
        <?php endif; ?>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
  <?php
  static $fab_toggle_js_printed = false;
  if (!$fab_toggle_js_printed) {
    $fab_toggle_js_printed = true;
  ?>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const networkToggleBtn = document.getElementById('networkToggleBtn');
        const socialIconsContainer = document.getElementById('socialIconsContainer');

        if (networkToggleBtn && socialIconsContainer) {
          let isOpen = false;

          networkToggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            isOpen = !isOpen;
            if (isOpen) {
              networkToggleBtn.classList.add('active');
              socialIconsContainer.classList.add('show');
            } else {
              networkToggleBtn.classList.remove('active');
              socialIconsContainer.classList.remove('show');
            }
          });

          document.addEventListener('click', function(e) {
            if (isOpen && !networkToggleBtn.contains(e.target) && !socialIconsContainer.contains(e.target)) {
              isOpen = false;
              networkToggleBtn.classList.remove('active');
              socialIconsContainer.classList.remove('show');
            }
          });

          document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && isOpen) {
              isOpen = false;
              networkToggleBtn.classList.remove('active');
              socialIconsContainer.classList.remove('show');
            }
          });
        }
      });
    </script>
  <?php }
  ?>
<?php
  return ob_get_clean();
}
add_shortcode('hp_fab', 'hp_floating_action_buttons_shortcode');