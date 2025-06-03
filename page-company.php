<?php
// template name: 会社案内
get_header();
?>

<div class="l-base p-company">
  <h1 class="p-company-h1 c-h1 -bdb">会社案内</h1>

  <dl class=" p-company__dl">
    <dt>社名</dt>
    <dd>アックスブレーン　株式会社<br class="u-sp">（AX BRAIN LTD.）</dd>
    <dt>本社所在地</dt>
    <dd>
      <p>〒550-0012/大阪市西区立売堀3-4-24</p>
      <p>TEL: 06-6534-7665（代）<br class="u-sp">FAX: 06-6534-5526</p>
      <p>E-mail: <a class="c-link-txt" href="mailto:info@axbrain.com" target="_blank">info@axbrain.com</a></p>
    </dd>

    <dt>代表者</dt>
    <dd>代表取締役　小野　慶士</dd>

    <dt>創立</dt>
    <dd>1995年12月</dd>

    <dt>資本金</dt>
    <dd>1,000万円</dd>

    <dt>取引銀行</dt>
    <dd>三菱UFJ銀行　大阪西支店</dd>

    <dt>主力商品</dt>
    <dd>レーザー墨出し器（LASERMAN・G-Liner）<br>
      高級勾配水平器（AX MASTER）<br>
      ハイパワークリーナー（DUSTMAN）<br>
      ファスニング（マルチドリルビス・エフプラグ・マルチドリルビス）</dd>
  </dl>
</div>

<!-- <?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>

    <?php the_content(); ?>

  <?php endwhile; ?>
<?php endif; ?> -->

<?php get_footer(); ?>