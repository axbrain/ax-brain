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
      <?php if ($products_name) : ?><span class="p-pro_single__h1-value"><?php echo esc_html($products_name); ?><?php if (get_field('products_newitem') === '有効'): ?><span class="c-new-badge p-pro_single__h1-new">【NEW】</span><?php endif; ?></span><?php endif; ?>
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
          $has_valid_images = false;
          if (have_rows('products_productimages', $post_id)):
            while (have_rows('products_productimages', $post_id)) : the_row();
              $thumb = get_sub_field('products_productimages_thumb');
              if ($thumb) {
                $has_valid_images = true;
                break;
              }
            endwhile;
            reset_rows();

            if ($has_valid_images):
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
              // サムネイルが空の場合のデフォルト画像を表示
              $default_thumb = get_template_directory_uri() . '/assets/images/common/thumb.webp';
            ?>
              <ul class="splide__list">
                <li>
                  <img src="<?php echo esc_url($default_thumb); ?>" alt="">
                </li>
              </ul>
            <?php
            endif;
          else:
            // フィールドグループが存在しない場合のデフォルト画像を表示
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
      <?php if ($products_name) : ?><span class="p-pro_single__h1-value"><?php echo esc_html($products_name); ?><?php if (get_field('products_newitem') === '有効'): ?><span class="c-new-badge p-pro_single__h1-new">【NEW】</span><?php endif; ?></span><?php endif; ?>
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
        <?php echo wpautop($products_Introduction); ?>
      </div>
    <?php endif; ?>

    <?php
    $description = get_field('product_description');

    if ($description) :
    ?>
      <h2 class="p-pro_single__contentbox__h2">商品説明</h2>
      <?php
      // 全てのthタグにcellnowrapクラスを追加
      $description = preg_replace('/<th([^>]*)>/', '<th$1 class="-cellnowrap">', $description);

      // 既存のクラス（-middleや-wide）を一旦削除
      $description = preg_replace('/<table[^>]*class=["\']([^"\']*)["\'][^>]*>/', '<table>', $description);

      // テーブルの構造を判定して適切なクラスを追加
      $first_row = '';
      if (preg_match('/<table[^>]*>.*?<tr[^>]*>(.*?)<\/tr>/is', $description, $matches)) {
        $first_row = $matches[1];
      }

      if (preg_match('/<th[^>]*>.*?<td[^>]*>/is', $first_row)) {
        // 1列目が見出し列の場合（th-tdのパターン）
        // まず-vertical-tableクラスを追加
        $description = preg_replace('/<table([^>]*)>/', '<table$1 class="-vertical-table">', $description);

        // 1行2列でthとtdの組み合わせかチェック
        $is_single_row = substr_count($description, '<tr>') === 1;
        $has_th_td = preg_match('/<th[^>]*>.*?<td[^>]*>/is', $first_row);

        // 1行2列でthとtdの組み合わせの場合は-narrow-tableクラスも追加
        if ($is_single_row && $has_th_td) {
          // 既存のクラスを保持したまま-narrow-tableを追加
          $description = preg_replace('/<table([^>]*)class=["\']([^"\']*)["\']([^>]*)>/', '<table$1class="$2 -narrow-table"$3>', $description);
        }
      } elseif (preg_match('/<th[^>]*>.*?<th[^>]*>/is', $first_row)) {
        // 1行目が見出し行の場合（th-thのパターン）
        // 列数をカウント
        $th_count = substr_count($first_row, '<th');

        // まず-horizontal-tableクラスを追加
        $description = preg_replace('/<table([^>]*)>/', '<table$1 class="-horizontal-table">', $description);

        // 5列以下の場合は-narrow-tableクラスも追加
        if ($th_count <= 3) {
          // 既存のクラスを保持したまま-narrow-tableを追加
          $description = preg_replace('/<table([^>]*)class=["\']([^"\']*)["\']([^>]*)>/', '<table$1class="$2 -narrow-table"$3>', $description);
        }
      }

      // テーブルの行数をカウント
      $row_count = substr_count($description, '<tr>');

      // デバイス判定と行数に応じてクラスを追加
      $additional_classes = '';

      if (wp_is_mobile()) {
        // スマホの場合
        if ($row_count >= 9) {
          $additional_classes = ' -sp -heightover';
        }
      } else {
        // PCまたはタブレットの場合
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($user_agent, 'iPad') !== false || strpos($user_agent, 'Android') !== false) {
          // タブレットの場合
          if ($row_count >= 11) {
            $additional_classes = ' -tb -heightover';
          }
        } else {
          // PCの場合
          if ($row_count >= 13) {
            $additional_classes = ' -pc -heightover';
          }
        }
      }

      // rowspanを持つthタグを検索
      preg_match_all('/<tr>\s*<th[^>]*rowspan=["\'](\d+)["\'][^>]*>.*?<\/tr>/is', $description, $matches, PREG_SET_ORDER);

      foreach ($matches as $match) {
        $rowspan = intval($match[1]);
        $trStart = strpos($description, $match[0]);
        $trEnd = strpos($description, '</tr>', $trStart);

        // 現在のtr以降のtrタグを検索
        $offset = $trEnd;
        $currentRow = 0;

        while ($currentRow < $rowspan - 1) {
          // 次のtrタグを見つける
          $nextTrStart = strpos($description, '<tr>', $offset);
          if ($nextTrStart === false) break;

          $nextTrEnd = strpos($description, '</tr>', $nextTrStart);
          if ($nextTrEnd === false) break;

          // そのtr内のtdタグを見つける
          $tdStart = strpos($description, '<td', $nextTrStart);
          if ($tdStart === false || $tdStart > $nextTrEnd) break;

          $tdEnd = strpos($description, '>', $tdStart);
          if ($tdEnd === false) break;

          // tdタグを取得
          $tdTag = substr($description, $tdStart, $tdEnd - $tdStart + 1);

          // 2行目以降に-mergedcellクラスを追加
          $currentRow++;
          if ($currentRow > 0) {
            if (strpos($tdTag, 'class=') !== false) {
              if (strpos($tdTag, '-mergedcell') === false) {
                $newTdTag = preg_replace('/class=(["\'])(.*?)\1/', 'class=\1\2 -mergedcell\1', $tdTag);
              } else {
                $newTdTag = $tdTag;
              }
            } else {
              $newTdTag = substr($tdTag, 0, -1) . ' class="-mergedcell">';
            }

            // 修正したタグで置換
            $description = substr_replace($description, $newTdTag, $tdStart, strlen($tdTag));
          }

          $offset = $nextTrEnd;
        }
      }

      // colspanを持つtdタグを検索
      preg_match_all('/<td[^>]*colspan=["\'](\d+)["\'][^>]*>/is', $description, $colspanMatches, PREG_SET_ORDER);

      foreach ($colspanMatches as $match) {
        $tdTag = $match[0];
        $tdStart = strpos($description, $tdTag);

        // クラスを追加
        if (strpos($tdTag, 'class=') !== false) {
          if (strpos($tdTag, '-centercell') === false) {
            $newTdTag = preg_replace('/class=(["\'])(.*?)\1/', 'class=\1\2 -centercell\1', $tdTag);
          } else {
            $newTdTag = $tdTag;
          }
        } else {
          $newTdTag = substr($tdTag, 0, -1) . ' class="-centercell">';
        }

        // 修正したタグで置換
        $description = substr_replace($description, $newTdTag, $tdStart, strlen($tdTag));
      }

      // 「品番」のthタグに-centercellクラスを追加
      $offset = 0;
      while (($thStart = strpos($description, '<th', $offset)) !== false) {
        $thEnd = strpos($description, '>', $thStart);
        if ($thEnd !== false) {
          $thTag = substr($description, $thStart, $thEnd - $thStart + 1);
          $thContent = substr($description, $thEnd + 1, strpos($description, '</th>', $thEnd) - $thEnd - 1);

          if (trim($thContent) === '品番') {
            // クラスを追加
            if (strpos($thTag, 'class=') !== false) {
              if (strpos($thTag, '-centercell') === false) {
                $newThTag = str_replace('class="', 'class="-centercell ', $thTag);
                $newThTag = str_replace("class='", "class='-centercell ", $newThTag);
              } else {
                $newThTag = $thTag;
              }
            } else {
              $newThTag = substr($thTag, 0, -1) . ' class="-centercell">';
            }

            // 修正したタグで置換
            $description = substr_replace($description, $newThTag, $thStart, strlen($thTag));
          }

          $offset = $thEnd + 1;
        } else {
          break;
        }
      }

      // colspanを持つthタグの直後のtr内のthタグに-sticky-noneクラスを追加
      preg_match_all('/<th[^>]*colspan=["\'](\d+)["\'][^>]*>.*?<\/th>/is', $description, $colspanThMatches, PREG_SET_ORDER);

      foreach ($colspanThMatches as $match) {
        $thTag = $match[0];
        $thEnd = strpos($description, '</th>', strpos($description, $thTag)) + 5;

        // 次のtrタグを探す
        $nextTrStart = strpos($description, '<tr>', $thEnd);
        if ($nextTrStart !== false) {
          // そのtr内の全てのthタグを処理
          $trEnd = strpos($description, '</tr>', $nextTrStart);
          if ($trEnd !== false) {
            $trContent = substr($description, $nextTrStart, $trEnd - $nextTrStart);

            // tr内の全てのthタグを検索
            $offset = 0;
            while (($thStart = strpos($trContent, '<th', $offset)) !== false) {
              $thEnd = strpos($trContent, '>', $thStart);
              if ($thEnd !== false) {
                $thTag = substr($trContent, $thStart, $thEnd - $thStart + 1);

                // クラスを追加
                if (strpos($thTag, 'class=') !== false) {
                  if (strpos($thTag, '-sticky-none') === false) {
                    $newThTag = str_replace('class="', 'class="-sticky-none ', $thTag);
                    $newThTag = str_replace("class='", "class='-sticky-none ", $newThTag);
                  } else {
                    $newThTag = $thTag;
                  }
                } else {
                  $newThTag = substr($thTag, 0, -1) . ' class="-sticky-none">';
                }

                // 修正したタグで置換
                $trContent = substr_replace($trContent, $newThTag, $thStart, strlen($thTag));
                $offset = $thStart + strlen($newThTag);
              } else {
                break;
              }
            }

            // 修正したtrの内容で置換
            $description = substr_replace($description, $trContent, $nextTrStart, $trEnd - $nextTrStart);
          }
        }
      }

      // クラスの確認
      $has_horizontal = strpos($description, '-horizontal-table') !== false;
      $has_vertical = strpos($description, '-vertical-table') !== false;
      $has_narrow = strpos($description, '-narrow-table') !== false;

      // -horizontal-table のみが存在する場合のみスクロール誘導用のdivを表示
      $show_scroll_induction = $has_horizontal && !$has_narrow && !$has_vertical;

      if ($show_scroll_induction) {
        echo '<div class="p-pro_single__contentbox__scroll__induction"></div>';
      }

      echo '<div class="p-pro_single__contentbox__description' . $additional_classes . '">';
      echo $description;
      echo '</div>';

      if ($show_scroll_induction) {
        echo '<div class="p-pro_single__contentbox__scroll__induction -bottom"></div>';
      }
      ?>
    <?php endif; ?>

    <?php
    $products_attention = get_field('products_attention');
    if ($products_attention) : // 値が空でない場合のみ表示
    ?>
      <div class="p-pro_single__contentbox__attention">
        <?php echo wpautop($products_attention); ?>
      </div>
    <?php endif; ?>

    <?php
    $products_warning = get_field('products_warning');
    if ($products_warning) : // 値が空でない場合のみ表示
    ?>
      <div class="p-pro_single__contentbox__warning">
        <?php echo wpautop($products_warning); ?>
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