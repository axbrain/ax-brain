<?php

function mytheme_setup()
{
  /**
   * <title>タグを出力する
   */
  add_theme_support('title-tag');

  /**
   * HTML5のサポート
   */
  add_theme_support('html5', array(
    'style',
    'script'
  ));

  /**
   * アイキャッチ画像を使用可能にする
   */
  add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'mytheme_setup');

// サイドメニューを非表示
function remove_menus()
{
  remove_menu_page('edit-comments.php'); // コメント
}
add_action('admin_menu', 'remove_menus');

/**
 * head部分に読み込むcss,jsの設定
 */
function mytheme_enqueue()
{
  // フォント読み込み：読み込み速度を早くするためのfonts.gstatic.comなども読み込ませたいため、header.phpに直接記入。

  // スライドのCSS読み込み
  wp_enqueue_style(
    'splide',
    get_theme_file_uri('assets/css/splide-core.min.css'),
    array(),
    null
  );

  // モーダルのCSS読み込み
  wp_enqueue_style(
    'modaal',
    get_theme_file_uri('assets/css/modaal.min.css'),
    array(),
    null
  );


  // サイトオリジナルのCSS読み込み
  wp_enqueue_style(
    'style',
    get_theme_file_uri('assets/css/style.css'),
    array(),
    filemtime(get_theme_file_path('assets/css/style.css'))
  );

  // wpのデフォルトのjqueryの読み込み中止
  wp_deregister_script('jquery');

  // 新たにjqueryのver3を読み込み
  wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js');

  // スライドのライブラリ[splide.min.js]
  wp_enqueue_script(
    'splide',
    get_theme_file_uri('assets/js/vendor/splide.min.js'),
    array('jquery'),
    ''
  );

  // モーダルライブラリ[modaal.js]
  wp_enqueue_script(
    'modaal',
    get_theme_file_uri('assets/js/vendor/modaal.min.js'),
    array('jquery'),
    ''
  );

  // サイトオリジナルのJS読み込み
  wp_enqueue_script(
    'main',
    get_theme_file_uri('assets/js/main.js'),
    array('jquery'),
    filemtime(get_theme_file_path('assets/js/main.js')),
    true
  );
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue');

function register_my_menus()
{
  register_nav_menus(
    array(
      'header-menu' => __('ヘッダーメニュー'),
      'footer-menu' => __('フッターメニュー')
    )
  );
}
add_action('init', 'register_my_menus');

// SVGファイルのアップロードを許可する
function my_upload_mimes($mimes)
{
  $mimes['svg'] = 'image/svg+xml';
  $mimes['svgz'] = 'image/svg+xml';

  return $mimes;
}
add_action('upload_mimes', 'my_upload_mimes');

/**
 * 抜粋の文字数を変更
 */
function twpp_change_excerpt_length($length)
{
  return 34;
}
add_filter('excerpt_length', 'twpp_change_excerpt_length', 999);

/**
 * 固定ページで抜粋を使えるようにする
 */
add_post_type_support('page', 'excerpt');

/**
 * 抜粋の省略記号を変更
 */
function twpp_change_excerpt_more($more)
{
  return '…';
}
add_filter('excerpt_more', 'twpp_change_excerpt_more');

/**
 * 固定ページに対し、pタグやbrタグの自動挿入を禁止
 */
function disable_page_wpautop()
{
  if (is_page()) {
    remove_filter('the_content', 'wpautop');
  };
}
add_action('wp', 'disable_page_wpautop');

/**
 * テーマフォルダへのURLを定数化
 */
define('THEME_DIR_URI', get_template_directory_uri() . '/assets/images/');

/**
 * メディアファイルへのURLを定数化
 */
if (!defined('MEDIA_DIR_URI')) {
  define('MEDIA_DIR_URI', wp_upload_dir()['baseurl'] . '/');
}

/**
 * カスタム投稿タイプを追加
 */
function create_post_type()
{
  register_post_type(
    'products',
    array(
      'label' => '製品情報',
      'public' => true,
      'has_archive' => true,
      'show_in_rest' => true,
      'menu_position' => 5,
      'supports' => array(
        'title',
        'editor',
        'thumbnail',
        'revisions',
      ),
      'rewrite' => array(
        'slug' => 'products',
        'with_front' => false,
      ),
    )
  );

  register_taxonomy(
    'products-cat',
    'products',
    array(
      'label' => '製品カテゴリー',
      'hierarchical' => true,
      'public' => true,
      'show_in_rest' => true,
      'rewrite' => array(
        'slug' => 'products-cat',
        'with_front' => false,
      ),
    )
  );
}
add_action('init', 'create_post_type');

/**
 * 管理画面のカスタム投稿一覧にタクソノミー（カテゴリ）の列を表示 START
 */
// function my_preget_posts($query)
// {
//   if (is_admin() || ! $query->is_main_query()) {
//     return;
//   }
//   if ($query->is_post_type_archive('column')) {
//     $query->set('posts_per_page', -1); // コラムは全件表示
//     return;
//   }
// }
// add_action('pre_get_posts', 'my_preget_posts');

/**
 * テンプレートファイル名を指定して表示させるショートコード
 * テキストエディタに[myphp file='my-template']と入力。
 */
function shortcode_template_parts($params = array())
{
  extract(shortcode_atts(array('file' => 'default'), $params));
  ob_start();
  include(STYLESHEETPATH . "/template-parts/$file.php");
  return ob_get_clean();
}
add_shortcode('myphp', 'shortcode_template_parts');


/**
 * 不要なWordPress固有のデータ読み込みを削除
 */
// ブロックエディタのCSSを削除
add_action('wp_enqueue_scripts', function () {
  wp_dequeue_style('wp-block-library');
  wp_dequeue_style('global-styles');
});
add_action('wp_enqueue_scripts', function () {
  wp_dequeue_style('classic-theme-styles');
});
// wpemojiを削除
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles', 10);
// wlwmanifest.xmlを削除
remove_action('wp_head', 'wlwmanifest_link');
//XML-RPCの削除
remove_action('wp_head', 'rsd_link');
//WordPressのバージョン情報を削除
remove_action('wp_head', 'wp_generator');
//その他削除
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);

/**
 * すべての自動アップデートを無効化
 */
add_filter('automatic_updater_disabled', '__return_true');

/**
 * テキストエディタにカスタムボタンを追加
 */
add_action('admin_print_footer_scripts', function () {

  // 押したときに↓このクイックタグAPI(JavaScript)が呼ばれるようにするボタンを作成する
  // QTags.addButton('①ボタンのhtmlのid', 'エディタのボタンに表示する名前', '開始タグ', '終了タグ', '', 'ボタンの説明', ボタン表示順);

  if (wp_script_is('quicktags')) {

    //設定した値でQTags.addButton(JavaScript)を出力

    echo <<<EOF
      <script type="text/javascript">
        QTags.addButton('h2-button', '見出し', '<h2>', '</h2>\\n', '', '見出しを挿入したい場合に使用します', 1);
        QTags.addButton('link-button', 'リンク', '<a href="リンク先URL">リンクはこちら</a>', '', '', 'リンクを挿入したい場合に使用します', 2);
      </script>
    EOF;
  }
}, 100);

/**
 * テキストエディタのボタンを削除
 */
function custom_quicktags_settings($qtInit)
{
  //指定したボタンは残す
  $qtInit['buttons'] = 'strong,img,more,close';
  return $qtInit;
}
add_filter('quicktags_settings', 'custom_quicktags_settings');

/**
 * 使用可能なHTMLタグを追加
 * ※ユーザー権限によってタグが消去される問題への対応
 */
function customKsesAllowedHtml($tags, $context)
{
  if ($context == 'post') {
    $tags['script'] = true; //削除されたくないタグや属性を入れる
    $tags['figure'] = array(
      'class' => true
    );
    $tags['figcaption'] = array(
      'class' => true
    );
    $tags['iframe'] = true;
    $tags['source'] = array(
      'source' => true,
      'srcset' => true
    );
    $tags['style'] = true;
    $tags['span'] = array(
      'class' => true
    );
    $tags['picture'] = array(
      'class' => true
    );
    $tags['table'] = array(
      'class' => true,
    );
    $tags['tbody'] = array(
      'class' => true
    );
    $tags['tr'] = array(
      'class' => true
    );
    $tags['th'] = array(
      'class' => true
    );
    $tags['td'] = array(
      'class' => true,
      'colspan' => true
    );
  }
  return $tags;
}
add_filter('wp_kses_allowed_html', 'customKsesAllowedHtml', 10, 2);

/**
 * エディタのビジュアル・テキスト切替でコード消滅を防止
 */
function my_tiny_mce_before_init($init_array)
{
  $init_array['valid_elements']          = '*[*]';
  $init_array['extended_valid_elements'] = '*[*]';
  return $init_array;
}
add_filter('tiny_mce_before_init', 'my_tiny_mce_before_init');

/**
 * ビジュアルエディタに切り替えで、空の span タグや i タグが消されるのを防止
 */
if (!function_exists('tinymce_init')) {
  function tinymce_init($init)
  {
    $init['verify_html'] = false; // 空タグや属性なしのタグを消させない
    $initArray['valid_children'] = '+body[style], +div[div|span|a], +span[span], +table[tbody|tr|th|td]'; // 指定の子要素を消させない
    return $init;
  }
  add_filter('tiny_mce_before_init', 'tinymce_init', 100);
}

/* 固定ページ一覧にスラッグを追加する */
function add_page_column_slug_title($columns)
{
  $columns['slug'] = "スラッグ";
  return $columns;
}
function add_page_column_slug($column_name, $post_id)
{
  if ($column_name == 'slug') {
    $post = get_post($post_id);
    $slug = $post->post_name;
    echo esc_attr($slug);
  }
}
add_filter('manage_pages_columns', 'add_page_column_slug_title');
add_action('manage_pages_custom_column', 'add_page_column_slug', 10, 2);

/**
 * Contact Form 7で自動挿入されるPタグ、brタグを削除
 */
add_filter('wpcf7_autop_or_not', 'wpcf7_autop_return_false');
function wpcf7_autop_return_false()
{
  return false;
}

// カスタムウォーカークラスを作成
class Custom_Nav_Walker extends Walker_Nav_Menu
{
  function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
  {
    $classes = empty($item->classes) ? array() : (array) $item->classes;
    $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));

    // クラス名の出力
    $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

    // メニューアイテムのIDを取得
    $post_id = $item->object_id;

    // NEWタグの表示判定
    $show_new_tag = false;
    if (function_exists('get_field')) {
      $new_tag_date = get_field('gnav_new_tag', $post_id); // 日付を取得

      if ($new_tag_date) {
        // 日付を比較用のタイムスタンプに変換
        $new_tag_timestamp = strtotime($new_tag_date);
        $current_timestamp = current_time('timestamp');

        // 設定された日付が現在よりも未来の場合はNEWタグを表示
        if ($new_tag_timestamp > $current_timestamp) {
          $show_new_tag = true;
        }
      }
    }

    $output .= '<li' . $class_names . '>';

    // リンクの属性
    $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
    $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
    $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
    $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

    // メニュー項目の出力
    $item_output = $args->before;
    $item_output .= '<a' . $attributes . '>';
    $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;

    // NEWタグの表示
    if ($show_new_tag) {
      $item_output .= '<span class="p-gnav__new">NEW!</span>';
    }

    $item_output .= '</a>';
    $item_output .= $args->after;

    $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
  }
}

/**
 * 製品情報一覧とカテゴリ一覧の表示件数を設定
 */
function products_posts_per_page($query)
{
  if (!is_admin() && $query->is_main_query()) {
    // 固定ページのスラッグが'products'の場合
    if (is_page('products') || $query->is_post_type_archive('products') || $query->is_tax('products-cat')) {
      // クエリを製品情報の投稿タイプに設定
      $query->set('post_type', 'products');

      if (wp_is_mobile()) {
        $query->set('posts_per_page', 8); // スマホは8件
      } else {
        $query->set('posts_per_page', 12); // タブレット以降は12件
      }
    }
  }
  return $query;
}
add_filter('pre_get_posts', 'products_posts_per_page');

/**
 * カスタム投稿タイプのパーマリンク構造を上書き
 */
function custom_products_rewrite_rules()
{
  add_rewrite_rule(
    'products/([^/]+)/?$',
    'index.php?post_type=products&name=$matches[1]',
    'top'
  );
}
add_action('init', 'custom_products_rewrite_rules', 10);

/**
 * 製品情報一覧画面にパーマリンクとカテゴリを表示する列を追加
 */
function add_products_columns($columns)
{
  $new_columns = array();
  foreach ($columns as $key => $value) {
    if ($key === 'title') {
      $new_columns[$key] = $value;
      $new_columns['permalink'] = 'パーマリンク';
      $new_columns['category'] = 'カテゴリ';
      $new_columns['newitem'] = '新製品';  // 追加
    } else {
      $new_columns[$key] = $value;
    }
  }
  return $new_columns;
}
add_filter('manage_products_posts_columns', 'add_products_columns');

function display_products_columns($column_name, $post_id)
{
  if ($column_name === 'permalink') {
    $post = get_post($post_id);
    $permalink = get_permalink($post_id);
    echo '<a href="' . esc_url($permalink) . '" target="_blank">' . esc_html($post->post_name) . '</a>';
  } elseif ($column_name === 'category') {
    $terms = get_the_terms($post_id, 'products-cat');
    if ($terms && !is_wp_error($terms)) {
      $category_names = array();
      foreach ($terms as $term) {
        $category_names[] = $term->name;
      }
      echo esc_html(implode(', ', $category_names));
    } elseif ($column_name === 'newitem') {
      $newitem = get_field('products_newitem', $post_id);
      echo esc_html($newitem === '有効' ? '○' : '-');
    } else {
      echo '-';
    }
  }
}
add_action('manage_products_posts_custom_column', 'display_products_columns', 10, 2);

/**
 * 製品情報一覧画面にカテゴリでの絞り込み検索を追加
 */
function add_products_category_filter()
{
  global $typenow;

  if ($typenow === 'products') {
    $taxonomy = 'products-cat';
    $selected = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
    $info_taxonomy = get_taxonomy($taxonomy);

    wp_dropdown_categories(array(
      'show_option_all' => sprintf(__('すべての%s', 'ax-brain'), $info_taxonomy->label),
      'taxonomy' => $taxonomy,
      'name' => $taxonomy,
      'selected' => $selected,
      'show_count' => true,
      'hide_empty' => true,
      'value_field' => 'slug',
      'hierarchical' => true,
    ));
  }
}
add_action('restrict_manage_posts', 'add_products_category_filter');


/**
 * テキストエディタにカスタムボタンを追加
 */
add_action('admin_print_footer_scripts', function () {
  global $post;
  $post_id = $post ? $post->ID : '';
  if (wp_script_is('quicktags')) {
    echo <<<EOF
      <script type="text/javascript">
      QTags.addButton('h2-button', '見出し', '<h2 class="c-editor__title">', '</h2>\\n', '', '見出しを挿入したい場合に使用します', 1);
      QTags.addButton('h3-button', '小見出し','<h3 class="c-editor__subtitle">','</h3>\\n','', '小見出しを挿入したい場合に使用します',2);
      QTags.addButton('blockquote-button', '引用', '<blockquote class="c-editor__quotation">', '</blockquote>', '', '引用を挿入したい場合に使用します', 3);
      QTags.addButton('txt-link-button','テキストリンク','<a href="リンク先" class="c-editor__txt-link">','</a>\\n','', 'テキストリンクを挿入したい場合に使用します',4);
      QTags.addButton('txt-bold-button', '強調', '<bold class="c-editor__txt-bold">', '</bold>', '', '強調を挿入したい場合に使用します', 5);
      QTags.addButton('button-link-button','ボタンリンク','<a href="#" class="c-editor__button-link">','</a>\\n','', 'ボタンリンクを挿入したい場合に使用します',6);
      QTags.addButton('button-link-button','ボタンリンク(外部サイト)','<a href="#" class="c-editor__button-link" target="_blank">','</a>\\n','', 'ボタンリンク(外部サイト)を挿入したい場合に使用します',7);
      QTags.addButton('table_wide-button','テーブル(横幅広め)','<table class="-wide">','','', 'テーブル(横幅広め)を挿入したい場合に使用します',8);
        QTags.addButton('table_middle-button','テーブル(横幅少し広め)','<table class="-middle">','','', 'テーブル(横幅少し広め)を挿入したい場合に使用します',8);
      </script>
EOF;
  }
}, 100);


//---------------------------------------
//エディタのクイックタグボタン削除
//---------------------------------------
add_filter("quicktags_settings", function ($qt_init) {

  global $typenow;

  if ($typenow == ("products")) {
    //条件にしたい投稿タイプ名に変更 投稿=post, 固定ページ=page, 他カスタム投稿タイプ名

    //		//パターン② 全てのボタンを新しいものに入れ替える
    $qt_init["buttons"] = "b,i,strong,em,link,block,del,ins,img,ul,ol,li,code,more,spell,close,fullscreen,dfw"; //CSV入力

    //パターン② 全削除して空にする
    $qt_init["buttons"] = ","; //カンマだけ入力
  }

  return $qt_init;
});
