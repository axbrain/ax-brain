<?php
// template name:お問い合わせ
get_header();
// 投稿IDを取得
$post_id = get_the_ID();
?>

<div class="l-wide p-pro_single">
  <div class="p-pro_single__imgbox">
    <h1 class="p-pro_single__h1">
      <?php
      $products_partnumber = get_field('products_partnumber');
      $products_name = get_field('products_name');
      if ($products_partnumber) : // 値が空でない場合のみ表示
      ?>
        <span class="p-pro_single__h1-label"><?php echo esc_html($products_partnumber); ?></span>
      <?php endif; ?>
      <?php
      if ($products_name) : // 値が空でない場合のみ表示
      ?>
        <span class="p-pro_single__h1-value"><?php echo esc_html($products_name); ?></span>
      <?php endif; ?>
    </h1>

    <?php
    if (have_rows('products_features_list', $post_id)):
    ?>
      <ul class="p-pro_single__features">
        <?php
        while (have_rows('products_features_list', $post_id)) : the_row();
          $features_ltem = get_sub_field('products_features_item');
          if ($features_ltem) :
        ?>
            <li>
              <?php echo esc_html($features_ltem); ?>
            </li>
        <?php
          endif;
        endwhile;
        ?>
      </ul>
    <?php
    endif;
    ?>
    <?php
    $standardprice = get_field('products_standardprice');
    if ($standardprice) : // 価格が存在する場合のみ表示
    ?>
      <div class="p-pro_single__price">
        <span class="p-pro_single__price-label">標準価格：</span><span class="p-pro_single__price-value"><?php echo esc_html(number_format($standardprice)); ?>円</span><span class="p-pro_single__price-value-tax">（税込<?php echo esc_html(number_format($standardprice * 1.1)); ?>円）</span>
      </div>
    <?php endif; ?>
    <?php
    $jancode = get_field('products_jancode');
    if ($jancode) : // JANコードが存在する場合のみ表示
    ?>
      <div class="p-pro_single__jan">
        <span class="p-pro_single__jan-label">JAN CODE：</span><span class="p-pro_single__jan-value"><?php echo esc_html($jancode); ?></span>
      </div>
    <?php endif; ?>

    <?php
    // 画像の総数をカウント
    $image_count = 0;
    if (have_rows('products_productimages', $post_id)) {
      while (have_rows('products_productimages', $post_id)) : the_row();
        if (get_sub_field('products_productimages_thumb')) {
          $image_count++;
        }
      endwhile;
      reset_rows(); // ポインタをリセット
    }
    ?>
    <div class="p-pro_single__splide-wrapper">
      <div class="p-pro_single__splide<?php echo $image_count > 1 ? ' splide' : ''; ?>">
        <div class="splide__track">
          <?php
          if (have_rows('products_productimages', $post_id)):
          ?>
            <ul class="splide__list">
              <?php
              while (have_rows('products_productimages', $post_id)) : the_row();
                $thumb = get_sub_field('products_productimages_thumb');
                if ($thumb) :
              ?>
                  <li class="<?php echo $image_count > 1 ? 'splide__slide' : ''; ?>">
                    <img src="<?php echo esc_url($thumb); ?>" alt="">
                  </li>
              <?php
                endif;
              endwhile;
              ?>
            </ul>
          <?php
          else:
            // 画像が0枚の場合のデフォルト画像を表示
            $default_thumb = get_template_directory_uri() . '/assets/images/common/thumb.webp';
          ?>
            <ul class="splide__list">
              <li>
                <img src="<?php echo esc_url($default_thumb); ?>" alt="">
              </li>
            </ul>
          <?php
          endif;
          ?>
        </div>
      </div>
      <?php
      // 画像が2枚以上ある場合のみサムネイル一覧を表示
      if ($image_count > 1):
        $first_image = true; // 1枚目かどうかを判定するフラグ
      ?>
        <ul class="p-pro_single__productimages">
          <?php
          while (have_rows('products_productimages', $post_id)) : the_row();
            if ($first_image) {
              $first_image = false; // 1枚目をスキップ
              continue;
            }
            $thumb = get_sub_field('products_productimages_thumb');
            if ($thumb) :
          ?>
              <li class="">
                <img src="<?php echo esc_url($thumb); ?>" alt="">
              </li>
          <?php
            endif;
          endwhile;
          ?>
        </ul>
      <?php
      endif;
      ?>
    </div>
  </div>

  <div class="p-pro_single__contentbox">

    <h1 class="p-pro_single__h1">
      <?php
      $products_partnumber = get_field('products_partnumber');
      $products_name = get_field('products_name');
      if ($products_partnumber) : // 値が空でない場合のみ表示
      ?>
        <span class="p-pro_single__h1-label"><?php echo esc_html($products_partnumber); ?></span>
      <?php endif; ?>
      <?php
      if ($products_name) : // 値が空でない場合のみ表示
      ?>
        <span class="p-pro_single__h1-value"><?php echo esc_html($products_name); ?></span>
      <?php endif; ?>
    </h1>

    <?php
    if (have_rows('products_features_list', $post_id)):
    ?>
      <ul class="p-pro_single__features">
        <?php
        while (have_rows('products_features_list', $post_id)) : the_row();
          $features_ltem = get_sub_field('products_features_item');
          if ($features_ltem) :
        ?>
            <li>
              <?php echo esc_html($features_ltem); ?>
            </li>
        <?php
          endif;
        endwhile;
        ?>
      </ul>
    <?php
    endif;
    ?>
    <?php
    $standardprice = get_field('products_standardprice');
    if ($standardprice) : // 価格が存在する場合のみ表示
    ?>
      <div class="p-pro_single__price">
        <span class="p-pro_single__price-label">標準価格：</span><span class="p-pro_single__price-value"><?php echo esc_html(number_format($standardprice)); ?>円</span><span class="p-pro_single__price-value-tax">（税込<?php echo esc_html(number_format($standardprice * 1.1)); ?>円）</span>
      </div>
    <?php endif; ?>
    <?php
    $jancode = get_field('products_jancode');
    if ($jancode) : // JANコードが存在する場合のみ表示
    ?>
      <div class="p-pro_single__jan">
        <span class="p-pro_single__jan-label">JAN CODE：</span><span class="p-pro_single__jan-value"><?php echo esc_html($jancode); ?></span>
      </div>
    <?php endif; ?>






    <?php
    $products_catchphrase = get_field('products_catchphrase');
    if ($products_catchphrase) : // 値が空でない場合のみ表示
    ?>
      <div class="p-pro_single__contentbox__catchphrase">
        <?php echo wpautop($products_catchphrase); ?>
      </div>
    <?php endif; ?>

    <?php
    $products_Introduction = get_field('products_Introduction');
    if ($products_Introduction) : // 値が空でない場合のみ表示
    ?>
      <div class="p-pro_single__contentbox__introduction">
        <?php echo esc_html($products_Introduction); ?>
      </div>
    <?php endif; ?>

    <?php
    $description_irregular = get_field('product_description_irregular');
    $description = get_field('product_description');

    if ($description_irregular || $description) : // どちらかのデータが存在する場合のみ表示
    ?>
      <h2 class="p-pro_single__contentbox__h2">商品説明</h2>
      <?php
      // テーブルの-wideクラスの有無をチェック
      $has_wide_class = false;
      if ($description) {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8">' . $description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $tables = $dom->getElementsByTagName('table');
        if ($tables->length > 0) {
          $table = $tables->item(0);
          $class = $table->getAttribute('class');
          $has_wide_class = strpos($class, '-wide') !== false || strpos($class, '-middle') !== false;
        }
      }

      // -wideクラスがない場合のみ誘導表示を出力
      if ($has_wide_class) {
        echo '<div class="p-pro_single__contentbox__scroll__induction"></div>';
      }

      if ($description_irregular) {
        echo '<div class="p-pro_single__contentbox__description">';
        echo $description_irregular;
        echo '</div>';
      } else {
        echo '<div class="p-pro_single__contentbox__description">';
        echo $description;
        echo '</div>';
      }

      // -wideクラスがない場合のみ誘導表示を出力
      if ($has_wide_class) {
        echo '<div class="p-pro_single__contentbox__scroll__induction -bottom"></div>';
      }
      ?>
    <?php endif; ?>

    <?php
    $products_attention = get_field('products_attention');
    if ($products_attention) : // 値が空でない場合のみ表示
    ?>
      <div class="p-pro_single__contentbox__attention">
        <?php echo esc_html($products_attention); ?>
      </div>
    <?php endif; ?>

    <?php
    $products_warning = get_field('products_warning');
    if ($products_warning) : // 値が空でない場合のみ表示
    ?>
      <div class="p-pro_single__contentbox__warning">
        警告：<?php echo esc_html($products_warning); ?>
      </div>
    <?php endif; ?>

    <?php
    $products_pamphlet = get_field('products_pamphlet');
    if ($products_pamphlet) : // 値が空でない場合のみ表示
    ?>
      <div class="p-pro_single__contentbox__pamphlet">
        <a href="<?php echo esc_url($products_pamphlet); ?>" target="_blank">パンフレットをダウンロードする
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/common/icon_pdf.svg" alt="ダウンロード">
        </a>
      </div>
    <?php endif; ?>
    <?php

    if (have_rows('products_relatedproducts', $post_id)):
    ?>
      <h2 class="p-pro_single__contentbox__relatedproducts__h2">関連する商品</h2>
      <ul class="p-pro_single__contentbox__relatedproducts">
        <?php
        while (have_rows('products_relatedproducts', $post_id)) : the_row();
          $relatedproducts_link = get_sub_field('products_relatedproducts_link');

          // URLからスラッグを取得
          $slug = basename(parse_url($relatedproducts_link, PHP_URL_PATH));

          // スラッグから投稿を取得
          $linked_post = get_page_by_path($slug, OBJECT, 'products');
          $linked_post_title = $linked_post ? $linked_post->post_title : '';

          // アイキャッチ画像のURLを取得
          $thumb_url = get_the_post_thumbnail_url($linked_post, 'full');
          // アイキャッチ画像がない場合のデフォルト画像
          $default_thumb = get_template_directory_uri() . '/assets/images/common/thumb.webp';
        ?>
          <li>
            <a href="<?php echo esc_url($relatedproducts_link); ?>">
              <img src="<?php echo esc_url($thumb_url ? $thumb_url : $default_thumb); ?>" alt="<?php echo esc_attr($linked_post_title); ?>">
              <?php if ($linked_post_title) : ?>
                <p><?php echo esc_html($linked_post_title); ?></p>
              <?php endif; ?>
            </a>
          </li>
        <?php endwhile; ?>
      </ul>
    <?php
    endif;
    ?>
  </div>
</div>

<?php
// Splideの初期化スクリプトをフッターに追加
add_action('wp_footer', function () {
?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const splide = new Splide('.p-pro_single__splide', {
        type: 'loop',
        autoplay: true,
        interval: 5000,
        arrows: true,
        pagination: false, // ページネーションを表示に変更
        speed: 1000,
        pauseOnHover: true,
        wheel: false,
        drag: true, // ドラッグを有効に変更
        rewind: true, // スライドの巻き戻しを有効化
      });

      // エラーハンドリングを追加
      try {
        splide.mount();
      } catch (e) {
        console.error('Splide initialization error:', e);
      }
    });

    (function($) {
      $(document).ready(function() {
        // テーブルアコーディオン
        if ($('.js-accordion-trigger').length) {
          var $accordionTrigger = $('.js-accordion-trigger');
          var $accordionContents = $('.js-accordion-content');
          var $moreText = $('.more-text');
          var isOpen = false;

          // 初期状態で6行目以降を非表示に
          $accordionContents.hide();

          $accordionTrigger.on('click', function() {
            isOpen = !isOpen;

            // コンテンツの表示/非表示を切り替え
            $accordionContents.slideToggle(400);

            // ボタンのテキストを切り替え
            $moreText.text(isOpen ? '▲ CLOSE' : '▼ MORE');
          });
        }
      });
    })(jQuery);
  </script>
<?php
}, 20);


get_footer();
?>
?>