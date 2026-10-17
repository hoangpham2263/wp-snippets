<?php 
// ========== Polylang ==========
function get_flag_svg($lang_code)
{
  $flags = [
    'vi' => '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><circle cx="256" cy="256" r="256" fill="#d80027" opacity="1" data-original="#d80027"></circle><path fill="#ffda44" d="m256 133.565 27.628 85.029h89.405l-72.331 52.55 27.628 85.03L256 303.623l-72.33 52.551 27.628-85.03-72.33-52.55h89.404z" opacity="1" data-original="#ffda44"></path></g></svg>',
    'en' => '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 480 480" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><g data-name="Layer 2"><g data-name="United Kingdom"><path fill="#ffffff" d="M480 240c0 132.51-107.39 239.94-239.89 240h-2.59a242.26 242.26 0 0 1-34.74-2.87 236 236 0 0 1-27.9-6.06A240.08 240.08 0 0 1 0 240C0 107.47 107.42 0 240 0h.11a239.26 239.26 0 0 1 174.34 75.17A239.79 239.79 0 0 1 480 240z" opacity="1" data-original="#ffffff"></path><path fill="#c8102e" d="M179.43 168.62v10.8h-34.89l-98-81.49a239 239 0 0 1 19.7-23.48zM433.77 98.37l-97.43 81h-35.77v-10.02l113.58-94.49.3.31A236.65 236.65 0 0 1 432.79 97zM179.43 300.56v10.8L66.24 405.55c-1-1-2-2.08-2.94-3.13a238.48 238.48 0 0 1-16.75-20.35l98-81.51zM433.78 381.62a240 240 0 0 1-19.62 23.51l-113.59-94.5v-10.07h35.77z" opacity="1" data-original="#c8102e"></path><g fill="#012169"><path d="M95.85 179.42H7.71a237.85 237.85 0 0 1 22-55.07zM93.86 300.56 29 354.5a238 238 0 0 1-21.29-53.94zM179.43 351.28v121c-1.52-.39-3-.8-4.55-1.23a239.12 239.12 0 0 1-86.09-44.68zM179.43 7.71v119.1L90.14 52.53a239.16 239.16 0 0 1 89.29-44.82zM391.23 53.65l-90.66 75.15V7.72l1.37.35a239 239 0 0 1 89.29 45.58zM472.29 179.42h-86L451 125.58a238.17 238.17 0 0 1 21.29 53.84zM392 425.78a239.25 239.25 0 0 1-91.38 46.51V349.76zM472.29 300.56a238.61 238.61 0 0 1-20.65 52.71l-63.35-52.71z" fill="#012169" opacity="1" data-original="#012169" class=""></path></g><path fill="#c8102e" d="M480 237.49v4.79a242.25 242.25 0 0 1-2.63 33.43H275.71v201.65a242.45 242.45 0 0 1-33.22 2.64h-5a240.78 240.78 0 0 1-33.23-2.65V275.71H2.64A243 243 0 0 1 0 242.45v-4.73a242.4 242.4 0 0 1 2.63-33.44h201.66V2.64A243.84 243.84 0 0 1 235.91 0h7.74a240.26 240.26 0 0 1 30.19 2.34l1.87.28v201.66h201.65a242.31 242.31 0 0 1 2.64 33.21z" opacity="1" data-original="#c8102e"></path></g></g></g></svg>',
    'ja' => '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><circle cx="256" cy="256" r="256" fill="#f0f0f0" opacity="1" data-original="#f0f0f0" class=""></circle><circle cx="256" cy="256" r="111.304" fill="#d80027" opacity="1" data-original="#d80027" class=""></circle></g></svg>',
    'zh' => '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g transform="matrix(0.9981602513834851,0,0,0.9981602513834851,50.380827963618515,-139.26961979924363)"><circle cx="207" cy="397" r="256" fill="#d80027" opacity="1" data-original="#d80027" class=""></circle><g fill="#ffda44"><path d="m91.1 296.8 22.1 68h71.5l-57.8 42.1 22.1 68-57.9-42-57.9 42 22.2-68-57.9-42.1H69zM254.5 537.5l-16.9-20.8-25 9.7 14.5-22.5-16.9-20.9 25.9 6.9 14.6-22.5 1.4 26.8 26 6.9-25.1 9.6zM288.1 476.5l8-25.6-21.9-15.5 26.8-.4 7.9-25.6 8.7 25.4 26.8-.3-21.5 16 8.6 25.4-21.9-15.5zM333.4 328.9 321.6 353l19.2 18.7-26.5-3.8-11.8 24-4.6-26.4-26.6-3.8 23.8-12.5-4.6-26.5 19.2 18.7zM255.2 255.9l-2 26.7 24.9 10.1-26.1 6.4-1.9 26.8-14.1-22.8-26.1 6.4 17.3-20.5-14.2-22.7 24.9 10.1z" fill="#ffda44" opacity="1" data-original="#ffda44" class=""></path></g></g></svg>',
    'ko' => '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><circle cx="16" cy="16" r="16" fill="#f2f2f2" opacity="1" data-original="#f2f2f2" class=""></circle><g fill="#28292b"><path d="m4.269 10.316 3.35-3.522.749.778-3.35 3.523zM5.346 11.461l3.349-3.523.75.778-3.349 3.523zM6.391 12.557 9.74 9.035l.75.777-3.35 3.523zM23.432 20.174l1.315-1.385.75.779-1.317 1.388zM22.147 23.09l-.751-.778 1.289-1.356.747.78zM24.521 21.307l1.303-1.372.749.778-1.306 1.375zM23.226 24.234l-.75-.779 1.297-1.367.748.781zM26.317 23.178l-.748-.781 1.299-1.366.748.778zM24.271 25.332l-.749-.779 1.302-1.371.748.78zM26.406 8.795l1.325 1.375-.745.784-1.327-1.378zM23.616 7.451l.746-.783 1.297 1.346-.747.781zM22.523 8.579l.745-.784 3.367 3.499-.744.784zM23.531 11.81l.748-.781 1.308 1.356-.745.784zM21.472 9.672l.744-.784 1.313 1.362-.748.781zM6.434 19.518l.745-.783 3.371 3.502-.745.783zM8.141 21.999l1.313 1.363-.745.783-1.316-1.364zM5.341 20.646l.745-.784 1.307 1.357-.747.78zM4.29 21.739l.744-.783 3.371 3.497-.745.783z" fill="#28292b" opacity="1" data-original="#28292b"></path></g><path fill="#2e4593" d="M21.71 16a5.827 5.827 0 0 1-5.695 5.952A5.827 5.827 0 0 1 10.321 16a5.827 5.827 0 0 1 5.694-5.953A5.828 5.828 0 0 1 21.71 16z" opacity="1" data-original="#2e4593"></path><path fill="#db2e2e" d="M21.68 16a5.709 5.709 0 0 1-.057.832c-.165-1.179-.781-3.306-3.114-3.347a2.444 2.444 0 0 0-2.649 1.727c-.521 1.351-.577 3-2.867 3a2.56 2.56 0 0 1-2.7-2.121.648.648 0 0 1 0-.088 6.139 6.139 0 0 1 .667-2.8 5.669 5.669 0 0 1 5.03-3.159A5.829 5.829 0 0 1 21.68 16z" opacity="1" data-original="#db2e2e"></path></g></svg>'
  ];
  return isset($flags[$lang_code]) ? $flags[$lang_code] : $flags['vi'];
}

function get_language_name($lang_code, $current_lang_code)
{
  $language_names = [
    'vi' => ['vi' => 'Tiếng Việt', 'en' => 'Tiếng Anh', 'ja' => 'Tiếng Nhật', 'zh' => 'Tiếng Trung', 'ko' => 'Tiếng Hàn'],
    'en' => ['vi' => 'Vietnamese', 'en' => 'English', 'ja' => 'Japanese', 'zh' => 'Chinese', 'ko' => 'Korean'],
    'ja' => ['vi' => 'ベトナム語', 'en' => '英語', 'ja' => '日本語', 'zh' => '中国語', 'ko' => '韓国語'],
    'zh' => ['vi' => '越南语', 'en' => '英语', 'ja' => '日语', 'zh' => '中文', 'ko' => '韩语'],
    'ko' => ['vi' => '베트남어', 'en' => '영어', 'ja' => '일본어', 'zh' => '중국어', 'ko' => '한국어']
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

  $languages = pll_the_languages([
    'raw' => 1,
    'hide_if_empty' => 0
  ]);

  if (empty($languages)) {
    return '';
  }

  $current_lang = null;
  $other_langs = [];

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

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const switcher = document.querySelector('.polylang_dropdown_switcher');
      if (!switcher) return;

      const currentLang = switcher.querySelector('.current_lang');
      const dropdownMenu = switcher.querySelector('.lang_dropdown_menu');

      if (!currentLang || !dropdownMenu) return;

      const isMobile = window.matchMedia('(max-width: 768px)').matches;

      if (isMobile) {
        switcher.classList.add('is-mobile');

        currentLang.addEventListener('click', function(e) {
          e.stopPropagation();
          switcher.classList.toggle('active');
        });

        document.addEventListener('click', function(e) {
          if (!switcher.contains(e.target)) {
            switcher.classList.remove('active');
          }
        });

        const langLinks = dropdownMenu.querySelectorAll('.lang_link');
        langLinks.forEach(link => {
          link.addEventListener('click', function(e) {
            e.stopPropagation();
          });
        });
      }

      let resizeTimer;
      let lastWidth = window.innerWidth;
      let lastHeight = window.innerHeight;

      window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
          const currentWidth = window.innerWidth;
          const currentHeight = window.innerHeight;

          const widthChange = Math.abs(currentWidth - lastWidth);
          const heightChange = Math.abs(currentHeight - lastHeight);

          if (widthChange > 100 || heightChange > 200) {
            location.reload();
          }

          lastWidth = currentWidth;
          lastHeight = currentHeight;
        }, 500);
      });
    });
  </script>

  <style>
    .polylang_dropdown_switcher {
      position: relative;
      display: inline-block;
      cursor: pointer;
    }

    .polylang_dropdown_switcher .current_lang {
      display: flex;
      align-items: center;
      gap: 8px;
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

      @media (max-width: 768px) {
        width: 40px;
        height: 40px;
      }
    }

    .polylang_dropdown_switcher .lang_flag svg {
      width: 48px;
      height: 48px;

      @media (max-width: 768px) {
        width: 40px;
        height: 40px;
      }
    }

    .polylang_dropdown_switcher .dropdown_arrow {
      display: flex;
      align-items: center;
      transition: transform 0.3s ease, opacity 0.3s ease;
    }

    .polylang_dropdown_switcher .dropdown_arrow svg {
      width: 24px;
      height: 24px;

      @media (max-width: 768px) {
        width: 20px;
        height: 20px;
      }
    }

    @media (min-width: 769px) {
      .polylang_dropdown_switcher:hover .dropdown_arrow {
        transform: rotate(180deg);
      }
    }

    .polylang_dropdown_switcher.active .dropdown_arrow {
      transform: rotate(180deg);
    }

    .polylang_dropdown_switcher .lang_dropdown_menu {
      position: absolute;
      top: calc(100% + 20px);
      right: 0;
      min-width: 100%;
      background: #FFFFFF;
      border: 1px solid #ddd;
      border-radius: 10px 0px 10px 10px;
      box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.35);
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

    @media (min-width: 769px) {
      .polylang_dropdown_switcher:hover .lang_dropdown_menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
      }
    }

    @media (max-width: 768px) {
      .polylang_dropdown_switcher.active .lang_dropdown_menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
      }

      .polylang_dropdown_switcher.is-mobile:hover .lang_dropdown_menu {
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
      }

      .polylang_dropdown_switcher.is-mobile.active .lang_dropdown_menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
      }
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
      gap: 12px;
      padding: 12px 12px;
      text-decoration: none;
      transition: background 0.2s ease;
      white-space: nowrap;
    }

    .polylang_dropdown_switcher .lang_link:hover {
      text-decoration: underline;
      color: var(--color-primary);
    }

    .polylang_dropdown_switcher .lang_name {
      font-size: 16px;

      @media (max-width: 768px) {
        font-size: 14px;
      }
    }

    .polylang_dropdown_switcher .lang_dropdown_menu .lang_flag {
      width: 24px;
      height: 24px;

      @media (max-width: 768px) {
        width: 20px;
        height: 20px;
      }
    }

    .polylang_dropdown_switcher .lang_dropdown_menu .lang_flag svg {
      width: 24px;
      height: 24px;

      @media (max-width: 768px) {
        width: 20px;
        height: 20px;
      }
    }
  </style>
<?php
  return ob_get_clean();
}
add_shortcode('polylang_langswitcher', 'custom_polylang_langswitcher');

add_action('init', function () {
  pll_register_string('hp-see-details', 'Xem chi tiết', 'HP');
  pll_register_string('hp-copyright', 'Copyright', 'HP');
  pll_register_string('hp-brand-name', 'Brand name', 'HP');
  pll_register_string('hp-see-more', 'Xem thêm', 'HP');
  pll_register_string('hp-collapse', 'Thu gọn', 'HP');
  pll_register_string('hp-view-all', 'Xem tất cả', 'HP');
});

function get_multi_lang_option($field_name)
{
  if (!function_exists('pll_current_language') || pll_current_language() == 'vi') {
    return get_field($field_name, 'option');
  } else {
    return get_field($field_name . '_' . pll_current_language(), 'option');
  }
  // echo do_shortcode('[polylang_langswitcher]');
  // echo pll_e('Xem chi tiết'); 
  // echo pll_current_language() 
  // echo get_multi_lang_option('address'); 
}

add_filter('rank_math/frontend/breadcrumb/strings', function ($strings) {
	$home_text = 'Trang chủ';
	if (pll_current_language() === 'en') {
		$home_text = 'Home';
	} elseif (pll_current_language() === 'zh') {
		$home_text = '家';
	} elseif (pll_current_language() === 'ko') {
		$home_text = '집';
	} elseif (pll_current_language() === 'ja') {
		$home_text = '家';
	}

	$modified_strings = array_merge($strings, [
		'home' => $home_text
	]);

	return $modified_strings;
})
?>