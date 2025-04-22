<?php
// template name:お問い合わせ
get_header();
?>

<div class="l-base p-contact">
  <h1 class="p-contact-h1 c-h1 -bdb">お問い合わせ</h1>

  <div class="p-contact__form">

    <p class="p-contact__form-text c-bold">以下のフォームにお問い合わせの内容を入力してください。</p>
    <p class="p-contact__form-att">※お問い合わせ内容は、平日9:00～20:00 / 土日祝日9:00～17:00 (弊社指定休業日を除く) に確認させていただいております。<br>上記時間内に順次対応させていただいておりますが、内容により返信までにお時間をいただく場合や、お返事を差し上げられない場合がございます。<br>あらかじめご了承くださいますようお願い申し上げます。</p>


    <?php echo do_shortcode('[contact-form-7 id="592ef18" title="お問い合わせ"]'); ?>
  </div>

</div>

<!-- <?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>

    <?php the_content(); ?>

  <?php endwhile; ?>
<?php endif; ?> -->

<?php get_footer(); ?>