<?php

/**
 * Template Name: 製品情報一覧
 * 
 * @package WordPress
 * @subpackage Ax-Brain
 * @since 1.0.0
 */

get_header();

// 製品情報のクエリを設定
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$posts_per_page = wp_is_mobile() ? 8 : 12;

$args = array(
	'post_type' => 'products',
	'posts_per_page' => $posts_per_page,
	'paged' => $paged,
	'orderby' => 'date',
	'order' => 'DESC'
);

$query = new WP_Query($args);
?>

<div class="l-wide p-products c-products">
	<h1 class="p-products__h1">製品情報一覧</h1>

	<?php
	// カテゴリー一覧の表示
	$categories = get_terms(array(
		'taxonomy' => 'products-cat',
		'hide_empty' => true,
	));

	if (!empty($categories) && !is_wp_error($categories)) :
	?>
		<div class="p-products__categories">
			<ul class="p-products__category-list">
				<?php foreach ($categories as $category) : ?>
					<li class="p-products__category-item">
						<a href="<?php echo esc_url(get_term_link($category)); ?>" class="p-products__category-link">
							<?php echo esc_html($category->name); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>

	<?php if ($query->have_posts()) : ?>
		<ul class="p-new-products__list">
			<?php while ($query->have_posts()) : $query->the_post(); ?>
				<li class="p-new-products__item">
					<a href="<?php the_permalink(); ?>" class="p-new-products__link">
						<?php if (has_post_thumbnail()) : ?>
							<div class="p-new-products__img">
								<?php the_post_thumbnail('full'); ?>
							</div>
						<?php endif; ?>
						<h3 class="p-new-products__title"><?php the_title(); ?></h3>
					</a>
				</li>
			<?php endwhile; ?>
		</ul>

		<div class="p-new-products__pagination">
			<?php
			$big = 999999999;
			echo paginate_links(array(
				'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
				'format' => '?paged=%#%',
				'current' => max(1, $paged),
				'total' => $query->max_num_pages,
				'prev_text' => '',
				'next_text' => '',
			));
			?>
		</div>

	<?php else : ?>
		<p class="c-products__no-results">該当の製品がありません</p>
	<?php endif; ?>

	<?php wp_reset_postdata(); ?>
</div>

<?php
get_footer();
?>