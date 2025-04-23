<?php
// template name:投稿
get_header();
// 投稿IDを取得
$post_id = get_the_ID();
?>

<div class="l-base p-news_single">
  <h1 class="p-news_single__h1">
    <?php the_title(); ?>
  </h1>
  <div class="p-news_single__content">
    <?php the_content(); ?>
  </div>
</div>
<?php
get_footer();
?>