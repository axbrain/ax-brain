<?php

/**
 * The template for displaying product category archive pages
 *
 * @package WordPress
 * @subpackage Ax-Brain
 * @since 1.0.0
 */

get_header();
?>
<div class="l-wide p-category c-products">

	<h1 class="c-h1">
		<?php
		$term = get_queried_object();
		printf(
			/* translators: %s: Category name. */
			esc_html__('カテゴリー: %s', 'ax-brain'),
			'<span class="p-products__category-name">' . esc_html($term->name) . '</span>'
		);
		?>
	</h1>
	<?php
	// カテゴリー一覧の表示
	$categories = get_terms(array(
		'taxonomy' => 'products-cat',
		'hide_empty' => true,
	));

	if (!empty($categories) && !is_wp_error($categories)) :
	?>
		<ul class="c-category__list">
			<?php foreach ($categories as $category) : ?>
				<li class="<?php echo (get_queried_object_id() === $category->term_id) ? '-cr' : ''; ?>">
					<a href="<?php echo esc_url(get_term_link($category)); ?>">
						<?php echo esc_html($category->name); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
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
						</div>
						<p class="c-products__title"><?php the_title(); ?></p>
					</a>
				</li>
			<?php endwhile; ?>
		</ul>

		<div class="c-products__pagination">
			<?php
			$big = 999999999;
			echo paginate_links(array(
				'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
				'format' => '?paged=%#%',
				'current' => max(1, get_query_var('paged')),
				'total' => $wp_query->max_num_pages,
				'prev_text' => '',
				'next_text' => '',
			));
			?>
		</div>

	<?php else : ?>
		<p class="c-products__no-results">該当の製品がありません</p>
	<?php endif; ?>
</div>

<?php
get_footer();
?>