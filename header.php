<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1p:wght@400;500;700&display=swap" rel="stylesheet">

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <header class="p-hdr">
    <div class="p-hdr__slide">
      <?php if (have_rows('announcement_list', 'option')): ?>
        <div class="splide" id="announcement-slider">
          <div class="splide__track">
            <ul class="splide__list">
              <?php while (have_rows('announcement_list', 'option')): the_row(); ?>
                <li class="splide__slide">
                  <?php echo esc_html(get_sub_field('announcement_list-txt')); ?>
                </li>
              <?php endwhile; ?>
            </ul>
          </div>
        </div>
      <?php endif; ?>
    </div>
    <div class="l-wide p-hdr__inner">
      <?php if (is_front_page()): ?>
        <h1 class="p-hdr__logo">
        <?php else: ?>
          <p class="p-hdr__logo">
          <?php endif; ?>
          <a href="<?php echo home_url(); ?>"><img src="<?php echo THEME_DIR_URI; ?>common/logo.svg" alt="AX BRAIN LTD."></a>
          <?php if (is_front_page()): ?>
        </h1>
      <?php else: ?>
        </p>
      <?php endif; ?>

      <?php
      wp_nav_menu(
        array(
          'theme_location' => 'header-menu',
          'container' => 'nav',
          'menu_class' => 'p-gnav',
          'walker' => new Custom_Nav_Walker()
        )
      );
      ?>

      <div class="p-hdr__search">
        <form method="get" id="searchform" action="<?php bloginfo('url'); ?>" class="p-search-form">
          <input type="text" name="s" id="s" placeholder="サイト内検索" />
          <input type="hidden" name="post_type" value="products" />
          <button type="submit"></button>
        </form>
        <button type="button" class="js-search-header-close text-link site-header__search-btn">
          <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-close" viewBox="0 0 64 64">
            <path d="M19 17.61l27.12 27.13m0-27.12L19 44.74"></path>
          </svg>
          <span class="icon__fallback-text">"閉じる (esc)"</span>
        </button>
      </div>

      <div class="p-hdr__site-nav">

        <a href="/search" class="site-nav__link site-nav__link--icon js-search-header">
          <svg viewBox="0 0 22.15 23.4" xmlns="http://www.w3.org/2000/svg" class="icon icon-search">
            <g fill="none" stroke="#4d4d4d" stroke-miterlimit="10" stroke-width="1.2">
              <circle cx="10.8" cy="10.8" r="10.2" />
              <path d="m17.51 18.47 4.04 4.33" stroke-linecap="round" />
            </g>
          </svg>
          <span class="icon__fallback-text">検索</span>
        </a>

        <button type="button" class="site-nav__link site-nav__link--icon js-drawer-open-nav medium-up--hide" aria-controls="NavDrawer" aria-expanded="false">
          <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-hamburger" viewBox="0 0 64 64">
            <path d="M7 15h51M7 32h43M7 49h51" stroke="#4d4d4d" stroke-width="2" fill="none" />
          </svg>
          <span class="icon__fallback-text ">メニュー</span>
        </button>
      </div>
      <!-- <input type="checkbox" id="drawer">
      <label for="drawer" class="open"></label>
      <label for="drawer" class="close"></label> -->
    </div>

  </header>

  <div class="p-gnav__bg"></div>

  <!-- 検索オーバーレイを修正 -->
  <div class="p-search-overlay js-search-overlay">
    <div class="p-search-overlay__content">
      <form action="<?php bloginfo('url'); ?>" method="get" class="p-search-overlay__form">
        <button type="submit" class="p-search-overlay__submit">
          <svg viewBox="0 0 22.15 23.4" xmlns="http://www.w3.org/2000/svg" class="icon icon-search">
            <g fill="none" stroke="#4d4d4d" stroke-miterlimit="10" stroke-width="1.2">
              <circle cx="10.8" cy="10.8" r="10.2" />
              <path d="m17.51 18.47 4.04 4.33" stroke-linecap="round" />
            </g>
          </svg>
        </button>
        <input type="search" name="s" class="p-search-overlay__input" placeholder="キーワードを入力" aria-label="サイト内検索">
        <input type="hidden" name="post_type" value="products" />
        <button type="button" class="p-search-overlay__close">
          <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-close" viewBox="0 0 64 64">
            <path d="M19 17.61l27.12 27.13m0-27.12L19 44.74" stroke="#000000" stroke-width="2"></path>
          </svg>
        </button>
      </form>
    </div>
  </div>

  <main <?php if (is_front_page()): ?> class="p-fp" <?php endif; ?>>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        new Splide('#announcement-slider', {
          // type: 'loop',
          height: '3em', // スライドの高さ
          autoplay: true,
          interval: 8000, // 3秒間隔
          arrows: false, // 矢印ボタンを非表示
          pagination: false, // ページネーションを非表示
          speed: 1000, // スライド速度
          pauseOnHover: true, // ホバー時に一時停止
          wheel: false, // マウスホイールでのスライド無効
          drag: false, // ドラッグでのスライド無効
          classes: {
            root: 'splide announcement-splide',
            track: 'splide__track announcement-track',
            list: 'splide__list announcement-list',
            slide: 'splide__slide announcement-slide',
          }
        }).mount();
      });
    </script>

    <div class="p-drawer">
      <div class="p-drawer__inner">
        <div class="p-drawer__close"></div>
        <nav class="p-drawer__nav">
          <?php
          wp_nav_menu(
            array(
              'theme_location' => 'header-menu',
              'container' => false,
              'menu_class' => '',
              'walker' => new Custom_Nav_Walker()
            )
          );
          ?>
        </nav>
        <div class="p-drawer__search">
          <form method="get" id="drawer-searchform" action="<?php bloginfo('url'); ?>" class="p-drawer__search-form">
            <input type="text" name="s" placeholder="サイト内検索" />
            <button type="submit" class="p-drawer__search-submit">
              <svg viewBox="0 0 22.15 23.4" xmlns="http://www.w3.org/2000/svg" class="icon icon-search">
                <g fill="none" stroke="#4d4d4d" stroke-miterlimit="10" stroke-width="1.2">
                  <circle cx="10.8" cy="10.8" r="10.2" />
                  <path d="m17.51 18.47 4.04 4.33" stroke-linecap="round" />
                </g>
              </svg>
            </button>
          </form>
        </div>
        <div class="p-drawer__sns">
          <?php if (have_rows('sns_list', 'option')): ?>
            <ul>
              <?php while (have_rows('sns_list', 'option')): the_row();
                $sns_url = get_sub_field('sns_url');
                $sns_image = get_sub_field('sns_image');
                $sns_alt = get_sub_field('sns_alt');

                // URLと画像の両方が入力されている場合のみ表示
                if ($sns_url && $sns_image):
              ?>
                  <li>
                    <a href="<?php echo $sns_url; ?>" target="_blank">
                      <img src="<?php echo $sns_image; ?>" alt="<?php echo $sns_alt; ?>">
                    </a>
                  </li>
              <?php
                endif;
              endwhile;
              ?>
            </ul>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="p-drawer-bg"></div>

    <script>
      // 検索オーバーレイの制御
      (function() {
        const searchHeader = document.querySelector('.js-search-header');
        const searchOverlay = document.querySelector('.js-search-overlay');
        const searchClose = document.querySelector('.p-search-overlay__close'); // 閉じるボタンの要素を取得
        const searchInput = searchOverlay?.querySelector('input[type="search"]');
        let searchBg;

        if (!searchHeader || !searchOverlay || !searchClose) return; // searchCloseのチェックを追加

        // 背景オーバーレイを動的に追加
        function createOverlayBg() {
          searchBg = document.createElement('div');
          searchBg.className = 'p-search-overlay-bg';
          document.body.appendChild(searchBg);
        }
        createOverlayBg();

        function openSearch(e) {
          e.preventDefault();
          searchOverlay.classList.add('is-active');
          searchBg.classList.add('is-active');
          // フォーカスを検索入力欄に移動
          setTimeout(() => {
            searchInput?.focus();
          }, 400);
        }

        function closeSearch() {
          searchOverlay.classList.remove('is-active');
          searchBg.classList.remove('is-active');
        }

        // 背景クリックで閉じる
        function handleBgClick(e) {
          if (e.target === searchBg) {
            closeSearch();
          }
        }

        // ESCキーでも閉じられるように
        function handleEscape(e) {
          if (e.key === 'Escape' && searchOverlay.classList.contains('is-active')) {
            closeSearch();
          }
        }

        searchHeader.addEventListener('click', openSearch);
        searchClose.addEventListener('click', closeSearch); // 閉じるボタンのクリックイベントを追加
        searchBg.addEventListener('click', handleBgClick);
        document.addEventListener('keydown', handleEscape);
      })();

      document.addEventListener('DOMContentLoaded', function() {
        const searchForm = document.querySelector('#searchform');
        const searchInput = document.querySelector('#s');

        if (searchForm && searchInput) {
          searchForm.addEventListener('submit', function(e) {
            if (!searchInput.value.trim()) {
              e.preventDefault();
              return false;
            }
          });
        }
      });

      document.addEventListener('DOMContentLoaded', function() {
        // オーバーレイ検索フォームの送信制御
        const overlayForm = document.querySelector('.p-search-overlay__form');
        const overlayInput = document.querySelector('.p-search-overlay__input');
        const overlaySubmit = document.querySelector('.p-search-overlay__submit');

        if (overlayForm && overlayInput && overlaySubmit) {
          overlayForm.addEventListener('submit', function(e) {
            if (!overlayInput.value.trim()) {
              e.preventDefault();
              return false;
            }
          });
        }
      });

      document.addEventListener('DOMContentLoaded', function() {
        // ドロワー検索フォームの送信制御
        const drawerForm = document.querySelector('.p-drawer__search-form');
        const drawerInput = drawerForm ? drawerForm.querySelector('input[name="s"]') : null;

        if (drawerForm && drawerInput) {
          drawerForm.addEventListener('submit', function(e) {
            if (!drawerInput.value.trim()) {
              e.preventDefault();
              return false;
            }
          });
        }
      });
    </script>