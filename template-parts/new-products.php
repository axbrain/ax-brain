<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$posts_per_page = isset($args['posts_per_page']) ? $args['posts_per_page'] : (wp_is_mobile() ? 8 : 12);

$query_args = array(
	'post_type' => 'products',
	'posts_per_page' => $posts_per_page,
	'paged' => $paged,
	'orderby' => 'date',
	'order' => 'DESC',
	'meta_query' => array(
		array(
			'key' => 'products_newitem',
			'value' => '有効',
			'compare' => '='
		)
	)
);

$query = new WP_Query($query_args);
?>

<?php if ($query->have_posts()) : ?>
	<ul class="c-products__list">
		<?php while ($query->have_posts()) : $query->the_post(); ?>
			<li class="c-products__item">
				<a href="<?php the_permalink(); ?>" class="c-products__link">
					<?php if (has_post_thumbnail()) : ?>
						<div class="c-products__img">
							<?php the_post_thumbnail('full'); ?>
						</div>
					<?php endif; ?>
					<h3 class="c-products__title"><?php the_title(); ?></h3>
				</a>
			</li>
		<?php endwhile; ?>
	</ul>

	<?php if (!isset($args['hide_pagination']) || !$args['hide_pagination']) : ?>
		<div class="c-products__pagination">
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
	<?php endif; ?>

<?php else : ?>
	<p>新製品はありません。</p>
<?php endif; ?>

<?php wp_reset_postdata(); ?>