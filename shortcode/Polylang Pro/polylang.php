<?php
function get_flag_svg($lang_code)
{
  $flags = [
    'vi' => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g clip-path="url(#clip0_vi)">
                <path d="M24 48C37.2548 48 48 37.2548 48 24C48 10.7452 37.2548 0 24 0C10.7452 0 0 10.7452 0 24C0 37.2548 10.7452 48 24 48Z" fill="#D80027"/>
                <path d="M23.9999 12.5217L26.5901 20.4932H34.9718L28.1908 25.4198L30.7809 33.3913L23.9999 28.4647L17.219 33.3913L19.8091 25.4198L13.0282 20.4932H21.4098L23.9999 12.5217Z" fill="#FFDA44"/>
              </g>
              <defs>
                <clipPath id="clip0_vi">
                  <rect width="48" height="48" fill="white"/>
                </clipPath>
              </defs>
            </svg>',
    'en' => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g clip-path="url(#clip0_en)">
                <path d="M24 48C37.2548 48 48 37.2548 48 24C48 10.7452 37.2548 0 24 0C10.7452 0 0 10.7452 0 24C0 37.2548 10.7452 48 24 48Z" fill="#012169"/>
                <path d="M24 48C37.2548 48 48 37.2548 48 24C48 10.7452 37.2548 0 24 0C10.7452 0 0 10.7452 0 24C0 37.2548 10.7452 48 24 48Z" fill="#012169"/>
                <path d="M47.6 24H0.4C0.4 10.7452 11.1452 0 24.4 0H23.6C36.8548 0 47.6 10.7452 47.6 24Z" fill="#F0F0F0"/>
                <path d="M24 0V48M0 24H48" stroke="#F0F0F0" stroke-width="8"/>
                <path d="M24 0V48M0 24H48" stroke="#D80027" stroke-width="4.8"/>
              </g>
              <defs>
                <clipPath id="clip0_en">
                  <rect width="48" height="48" fill="white"/>
                </clipPath>
              </defs>
            </svg>',
    'ja' => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g clip-path="url(#clip0_ja)">
                <path d="M24 48C37.2548 48 48 37.2548 48 24C48 10.7452 37.2548 0 24 0C10.7452 0 0 10.7452 0 24C0 37.2548 10.7452 48 24 48Z" fill="#F0F0F0"/>
                <circle cx="24" cy="24" r="9.6" fill="#D80027"/>
              </g>
              <defs>
                <clipPath id="clip0_ja">
                  <rect width="48" height="48" fill="white"/>
                </clipPath>
              </defs>
            </svg>',
    'zh' => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g clip-path="url(#clip0_zh)">
                <path d="M24 48C37.2548 48 48 37.2548 48 24C48 10.7452 37.2548 0 24 0C10.7452 0 0 10.7452 0 24C0 37.2548 10.7452 48 24 48Z" fill="#D80027"/>
                <path d="M14.087 10.4348L16.6956 17.5652H24.4348L18.9565 21.8696L21.5652 28.9999L16.087 24.6956L10.6087 28.9999L13.2174 21.8696L7.73913 17.5652H15.4783L14.087 10.4348Z" fill="#FFDA44"/>
                <path d="M26.087 16.087L26.9565 18.7826H29.8261L27.5217 20.4348L28.3913 23.1304L26.087 21.4783L23.7826 23.1304L24.6522 20.4348L22.3478 18.7826H25.2174L26.087 16.087Z" fill="#FFDA44"/>
                <path d="M30.6087 22.087L31.4783 24.7826H34.3478L32.0435 26.4348L32.913 29.1304L30.6087 27.4783L28.3043 29.1304L29.1739 26.4348L26.8696 24.7826H29.7391L30.6087 22.087Z" fill="#FFDA44"/>
                <path d="M30.6087 32.6087L31.4783 35.3043H34.3478L32.0435 36.9565L32.913 39.6522L30.6087 38L28.3043 39.6522L29.1739 36.9565L26.8696 35.3043H29.7391L30.6087 32.6087Z" fill="#FFDA44"/>
                <path d="M26.087 38.6087L26.9565 41.3043H29.8261L27.5217 42.9565L28.3913 45.6522L26.087 44L23.7826 45.6522L24.6522 42.9565L22.3478 41.3043H25.2174L26.087 38.6087Z" fill="#FFDA44"/>
              </g>
              <defs>
                <clipPath id="clip0_zh">
                  <rect width="48" height="48" fill="white"/>
                </clipPath>
              </defs>
            </svg>',
    'ko' => '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g clip-path="url(#clip0_ko)">
                <path d="M24 48C37.2548 48 48 37.2548 48 24C48 10.7452 37.2548 0 24 0C10.7452 0 0 10.7452 0 24C0 37.2548 10.7452 48 24 48Z" fill="#F0F0F0"/>
                <circle cx="24" cy="24" r="7.2" fill="none" stroke="#000" stroke-width="1"/>
                <path d="M24 16.8C20.0235 16.8 16.8 20.0235 16.8 24C16.8 27.9765 20.0235 31.2 24 31.2" fill="#D80027"/>
                <path d="M24 31.2C27.9765 31.2 31.2 27.9765 31.2 24C31.2 20.0235 27.9765 16.8 24 16.8" fill="#0052B4"/>
              </g>
              <defs>
                <clipPath id="clip0_ko">
                  <rect width="48" height="48" fill="white"/>
                </clipPath>
              </defs>
            </svg>'
  ];

  return isset($flags[$lang_code]) ? $flags[$lang_code] : $flags['vi']; // Default to Vietnam flag
}

function get_language_name($lang_code, $current_lang_code) {
  $language_names = [
    'vi' => [
      'vi' => 'Tiếng Việt',
      'en' => 'Tiếng Anh', 
      'ja' => 'Tiếng Nhật',
      'zh' => 'Tiếng Trung',
      'ko' => 'Tiếng Hàn'
    ],
    'en' => [
      'vi' => 'Vietnamese',
      'en' => 'English',
      'ja' => 'Japanese', 
      'zh' => 'Chinese',
      'ko' => 'Korean'
    ],
    'ja' => [
      'vi' => 'ベトナム語',
      'en' => '英語',
      'ja' => '日本語',
      'zh' => '中国語', 
      'ko' => '韓国語'
    ],
    'zh' => [
      'vi' => '越南语',
      'en' => '英语',
      'ja' => '日语',
      'zh' => '中文',
      'ko' => '韩语'
    ],
    'ko' => [
      'vi' => '베트남어',
      'en' => '영어', 
      'ja' => '일본어',
      'zh' => '중국어',
      'ko' => '한국어'
    ]
  ];
  
  return isset($language_names[$current_lang_code][$lang_code]) 
    ? $language_names[$current_lang_code][$lang_code] 
    : $lang_code;
}

function custom_polylang_langswitcher()
{
  if (!function_exists('pll_the_languages')) {
    return '';
  }

  // Get all languages with raw data to access URLs and flag URLs
  $languages = pll_the_languages([
    'raw' => 1,
    'hide_if_empty' => 0
  ]);

  if (empty($languages)) {
    return '';
  }

  $current_lang = null;
  $other_langs = [];

  // Separate current language from others
  foreach ($languages as $lang) {
    if ($lang['current_lang']) {
      $current_lang = $lang;
    } else {
      $other_langs[] = $lang;
    }
  }

  ob_start();
?>
  <div class="polylang_dropdown_switcher">
    <?php if ($current_lang): ?>
      <div class="current_lang">
        <span class="lang_flag">
          <?php echo get_flag_svg($current_lang['slug']); ?>
        </span>
        <span class="dropdown_arrow">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
          </svg>
        </span>
      </div>
    <?php endif; ?>

    <?php if (!empty($other_langs)): ?>
      <ul class="lang_dropdown_menu">
        <?php foreach ($other_langs as $lang): ?>
          <li>
            <a href="<?php echo esc_url($lang['url']); ?>" class="lang_link">
              <span class="lang_flag">
                <?php echo get_flag_svg($lang['slug']); ?>
              </span>
              <span class="lang_name"><?php echo esc_html(get_language_name($lang['slug'], $current_lang['slug'])); ?></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>

  <style>
    .polylang_dropdown_switcher {
      position: relative;
      display: inline-block;
      cursor: pointer;
    }

    .polylang_dropdown_switcher .current_lang {
      display: flex;
      align-items: center;
      gap: 12px;
      transition: all 0.3s ease;
      min-width: 40px;
      justify-content: center;
    }

    .polylang_dropdown_switcher .lang_flag {
      width: 48px;
      height: 48px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .polylang_dropdown_switcher .lang_flag svg {
      width: 48px;
      height: 48px;
    }

    .polylang_dropdown_switcher .dropdown_arrow {
      display: flex;
      align-items: center;
      transition: transform 0.3s ease, opacity 0.3s ease;
    }

    .polylang_dropdown_switcher .dropdown_arrow svg {
      width: 24px;
      height: 24px;
    }

    .polylang_dropdown_switcher:hover .dropdown_arrow {
      transform: rotate(180deg);
      opacity: 1;
    }

    .polylang_dropdown_switcher .lang_dropdown_menu {
      position: absolute;
      top: calc(100% + 20px);
      right: 0;
      min-width: 100%;
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 4px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      opacity: 0;
      visibility: hidden;
      transform: translateY(-10px);
      transition: all 0.3s ease;
      z-index: 1000;
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .polylang_dropdown_switcher .lang_dropdown_menu::before {
      content: '';
      position: absolute;
      top: -10px;
      right: 20px;
      width: 10px;
      height: 10px;
      border-left: 10px solid transparent;
      border-right: 10px solid transparent;
      border-bottom: 10px solid #ddd;
    }

    .polylang_dropdown_switcher .lang_dropdown_menu::after {
      content: '';
      position: absolute;
      bottom: calc(100% - 1px);
      right: 0;
      min-width: 100%;
      height: 22px;
    }

    .polylang_dropdown_switcher:hover .lang_dropdown_menu {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }

    .polylang_dropdown_switcher .lang_dropdown_menu li {
      border-bottom: 1px solid #eee;
    }

    .polylang_dropdown_switcher .lang_dropdown_menu li:last-child {
      border-bottom: none;
    }

    .polylang_dropdown_switcher .lang_link {
      display: flex;
      align-items: center;
      gap: 5px;
      padding: 8px 12px;
      text-decoration: none;
      color: #333;
      transition: background 0.2s ease;
      white-space: nowrap;
    }

    .polylang_dropdown_switcher .lang_link:hover {
      text-decoration: underline;
      color: var(--color-primary);
    }

    .polylang_dropdown_switcher .lang_name {
      font-size: 14px;
    }

    .polylang_dropdown_switcher .lang_dropdown_menu .lang_flag {
      width: 24px;
      height: 24px;
    }

    .polylang_dropdown_switcher .lang_dropdown_menu .lang_flag svg {
      width: 24px;
      height: 24px;
    }
  </style>
<?php

  return ob_get_clean();
}
add_shortcode('polylang_langswitcher', 'custom_polylang_langswitcher');

add_action('init', function () {
  pll_register_string('hp-see-details', 'Xem chi tiết', 'HP');
});

function get_multi_lang_option($field_name)
{
  // Check if Polylang functions exist
  if (!function_exists('pll_current_language') || pll_current_language() == 'vi') {
    return get_field($field_name, 'option');
  } else {
    return get_field($field_name . '_' . pll_current_language(), 'option');
  }
  // Use example
  // echo do_shortcode('[polylang_langswitcher]');
  // echo pll_e('Xem chi tiết'); 
  // echo pll_current_language() 
  // echo get_multi_lang_option('address'); 
}