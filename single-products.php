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

    <div class="p-pro_single__splide-wrapper">
      <div class="p-pro_single__splide splide">
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
                  <li class="splide__slide">
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
      <?php

      if (have_rows('products_productimages', $post_id)):
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
              <li class="splide__slide">
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
        <?php echo esc_html($products_catchphrase); ?>
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

    <h2 class="p-pro_single__contentbox__h2">商品説明</h2>

    <?php
    if (have_rows('product_description_laserequipment')) :
      $row_count = 0;
      $rows = [];

      while (have_rows('product_description_laserequipment')) : the_row();
        $th = get_sub_field('product_description_table_th');
        $td = get_sub_field('product_description_table_td');
        if ($th || $td) {
          $rows[] = [
            'th' => $th,
            'td' => $td
          ];
        }
      endwhile;

      $show_accordion = count($rows) > 5;
    ?>
      <div class="p-pro_single__contentbox__table-wrapper">
        <table class="p-pro_single__contentbox__table">
          <?php
          foreach ($rows as $index => $row) :
            $is_hidden = $index >= 5;
          ?>
            <tr class="<?php echo $is_hidden ? 'js-accordion-content' : ''; ?>">
              <th><?php echo wp_kses_post($row['th']); ?></th>
              <td><?php echo wp_kses_post($row['td']); ?></td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
      <?php if (count($rows) > 5) : ?>
        <button type="button" class="p-pro_single__contentbox__table-more js-accordion-trigger">
          <span class="more-text">▼ MORE</span>
        </button>
      <?php endif; ?>
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
          $relatedproducts_thumb = get_sub_field('products_relatedproducts_thumb');
          $relatedproducts_name = get_sub_field('products_relatedproducts_name');

        ?>
          <li>
            <?php if ($relatedproducts_thumb) : ?>
              <?php
              // 画像配列の場合
              if (is_array($relatedproducts_thumb)) : ?>
                <img src="<?php echo esc_url($relatedproducts_thumb['url']); ?>" alt="<?php echo esc_attr($relatedproducts_name); ?>">
              <?php
              // 画像URLの場合
              else : ?>
                <img src="<?php echo esc_url($relatedproducts_thumb); ?>" alt="<?php echo esc_attr($relatedproducts_name); ?>">
              <?php endif; ?>
            <?php endif; ?>
            <?php if ($relatedproducts_name) : ?>
              <p><?php echo esc_html($relatedproducts_name); ?></p>
            <?php endif; ?>
          </li>
        <?php
        endwhile;
        ?>
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