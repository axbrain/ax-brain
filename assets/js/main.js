/*jslint node: true */
'use strict';

jQuery(function ($) {

  //現在のページURLのハッシュ部分を取得
  const hash = location.hash;

  //ハッシュ部分がある場合の条件分岐
  if (hash) {
    if ($(hash).length > 0) {
      //ページ遷移後のスクロール位置指定
      $('html, body').stop().scrollTop(0);
      $(window).on('load', function () {
        //リンク先を取得
        const target = $(hash);
        //リンク先までの距離を取得
        const scrollPosition = target.offset().top - $('header').innerHeight();
        $('html, body').animate({
          scrollTop: scrollPosition
        }, 500, 'swing');
        return false;
      });
    }
  }

  //ページ内移動
  $('a[href^="#"]').not('a.js-modal-button-target').click(function () {
    var href = $(this).attr('href'),
      target = $(href === "#" || href === "" ? 'html' : href);
    $('body,html').animate({
      scrollTop: target.offset().top - $('header').innerHeight()
    }, 500, 'swing');
    return false;
  });

  // カレンダーのプラグイン「XO Event Calendar」の今日の日付を灰色背景にしたいため、
  // 目印となるカスタムCSSクラスを付与。
  $('.xo-event-calendar table.xo-month .month-dayname td div.today').parent().addClass('custom-today');

});



// テーブルアコーディオン
(function ($) {
  // DOM読み込み完了後に実行
  $(document).ready(function () {
    // スマートフォンの判定（768px未満）
    function isSmartPhone() {
      return window.matchMedia('(max-width: 767px)').matches;
    }

    // アコーディオンの設定
    function setupAccordion() {
      var $accordionTrigger = $('.js-accordion-trigger');
      var $accordionContents = $('.js-accordion-content');
      var $moreText = $('.more-text');

      // PCの場合
      if (!isSmartPhone()) {
        $accordionContents.removeClass('js-accordion-content').css('display', ''); // クラスと非表示を除去
        $accordionTrigger.hide();
        return;
      }

      // スマートフォンの場合
      var isOpen = false;
      $accordionContents.addClass('js-accordion-content').hide(); // クラスを追加して非表示
      $accordionTrigger.show();

      // クリックイベントを一旦解除して再設定
      $accordionTrigger.off('click').on('click', function (e) {
        if (!isSmartPhone()) return;

        e.preventDefault();
        isOpen = !isOpen;

        $accordionContents.slideToggle(400, function () {
          $moreText.text(isOpen ? '▲ CLOSE' : '▼ MORE');
        });
      });
    }

    // 初期設定
    setupAccordion();

    // リサイズ時の処理
    var resizeTimer;
    $(window).on('resize', function () {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function () {
        setupAccordion();
      }, 200);
    });
  });
})(jQuery);

// ドロワーメニュー
(function ($) {
  const $drawer = $('.p-drawer');
  const $drawerBg = $('.p-drawer-bg');
  const $drawerOpen = $('.js-drawer-open-nav');
  const $drawerClose = $('.p-drawer__close');

  // ドロワーを開く
  $drawerOpen.on('click', function () {
    $drawer.addClass('is-active');
    $drawerBg.addClass('is-active');
    $('body').css('overflow', 'hidden');
  });

  // ドロワーを閉じる
  function closeDrawer() {
    $drawer.removeClass('is-active');
    $drawerBg.removeClass('is-active');
    $('body').css('overflow', '');
  }

  $drawerClose.on('click', closeDrawer);
  $drawerBg.on('click', closeDrawer);
})(jQuery);