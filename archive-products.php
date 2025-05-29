<?php

/**
 * The template for displaying product archive pages
 *
 * @package WordPress
 * @subpackage Ax-Brain
 * @since 1.0.0
 */

get_header();

// 表示件数の設定
$posts_per_page = wp_is_mobile() ? 8 : 12; // スマホ:8件、PC:12件

// カテゴリー一覧の取得
$categories = get_terms(array(
	'taxonomy' => 'products-cat',
	'hide_empty' => true,
	'orderby' => 'term_order',
	'order' => 'ASC'
));

// カテゴリーごとの記事を取得
$all_posts = array();
if (!empty($categories) && !is_wp_error($categories)) {
	foreach ($categories as $category) {
		$args = array(
			'post_type' => 'products',
			'posts_per_page' => -1,
			'tax_query' => array(
				array(
					'taxonomy' => 'products-cat',
					'field' => 'term_id',
					'terms' => $category->term_id
				)
			),
			'orderby' => 'menu_order',
			'order' => 'ASC'
		);
		$query = new WP_Query($args);
		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();
				$all_posts[] = get_the_ID();
			}
		}
		wp_reset_postdata();
	}
}

// ページネーション用の設定
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$total_posts = count($all_posts);
$total_pages = ceil($total_posts / $posts_per_page);
$offset = ($paged - 1) * $posts_per_page;
$current_posts = array_slice($all_posts, $offset, $posts_per_page);

// メインクエリの設定
$args = array(
	'post_type' => 'products',
	'post__in' => $current_posts,
	'orderby' => 'post__in',
	'posts_per_page' => $posts_per_page
);
$wp_query = new WP_Query($args);
?>
<div class="l-wide p-products c-products">
	<h1 class="c-h1">製品情報一覧</h1>

	<?php if (!empty($categories) && !is_wp_error($categories)) : ?>
		<ul class="c-category__list">
			<?php foreach ($categories as $category) : ?>
				<li>
					<a href="<?php echo esc_url(get_term_link($category)); ?>" class="<?php echo (get_queried_object_id() === $category->term_id) ? '-cr -' . esc_attr($category->slug) : ''; ?>">
						<?php echo esc_html($category->name); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>

		<?php if (have_posts()) : ?>
			<ul class="c-products__list">
				<?php while (have_posts()) : the_post(); ?>
					<li class="c-products__item">
						<a href="<?php the_permalink(); ?>" class="c-products__link">
							<div class="c-products__img">
								<?php if (has_post_thumbnail()) : ?>
									<?php the_post_thumbnail('full'); ?>
								<?php else : ?>
									<img src="<?php echo get_template_directory_uri(); ?>/assets/images/common/thumb.webp" alt="デフォルトサムネイル">
								<?php endif; ?>
								<?php
								$terms = get_the_terms(get_the_ID(), 'products-cat');
								if ($terms && !is_wp_error($terms)) {
									$term = $terms[0];
									echo '<span class="c-products__cat -' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</span>';
								}
								?>
							</div>
							<p class="c-products__title"><?php the_title(); ?></p>
						</a>
					</li>
				<?php endwhile; ?>
			</ul>

			<div class="c-products__pagination">
				<?php
				$big = 999999999;
				$mid_size = wp_is_mobile() ? 1 : 2; // スマホ:1、PC/タブレット:2
				echo paginate_links(array(
					'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
					'format' => '?paged=%#%',
					'current' => $paged,
					'total' => $total_pages,
					'prev_text' => '',
					'next_text' => '',
					'mid_size' => $mid_size,
					'end_size' => 1
				));
				?>
			</div>

		<?php else : ?>
			<p class="c-products__no-results">該当の製品がありません</p>
		<?php endif; ?>
	<?php endif; ?>
</div>

<?php
get_footer();
?>