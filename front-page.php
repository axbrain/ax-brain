<?php

/**
 * Front Page Template
 */

get_header();
?>
<div class="p-fp">

	<div class="p-fp__mv__splide splide">
		<div class="splide__track">
			<ul class="splide__list">
				<?php
				if ($mv_items = get_field('mv')) :
					foreach ($mv_items as $item) :
						$pc_image = $item['mv_img-pc'];
						$sp_image = $item['mv_img-sp'];
						$link = $item['mv_img-link'];
						// ページリンクフィールドから投稿オブジェクトを取得（itemの中から直接取得）
						$post_object = $item['mv_img-link'];
						$link_title = '';
						if (is_array($post_object) && isset($post_object['post_title'])) {
							$link_title = $post_object['post_title'];
						} elseif (is_object($post_object) && isset($post_object->post_title)) {
							$link_title = $post_object->post_title;
						}
				?>
						<li class="splide__slide">
							<?php
							// URLから投稿IDを取得し、そこからタイトルを取得
							$post_id = url_to_postid($item['mv_img-link']);
							$link_title = get_the_title($post_id);

							if ($link) : ?>
								<a href="<?php echo esc_url($link); ?>">
								<?php endif; ?>
								<picture>
									<source media="(min-width: 768px)" srcset="<?php echo esc_url($pc_image); ?>">
									<img src="<?php echo esc_url($sp_image); ?>" alt="<?php echo esc_attr($link_title); ?>">
								</picture>
								<?php if ($link) : ?>
								</a>
							<?php endif; ?>
						</li>
				<?php
					endforeach;
				endif;
				?>
			</ul>
		</div>
	</div>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			new Splide('.p-fp__mv__splide', {
				type: 'slide',
				rewind: true,
				autoplay: true,
				interval: 5000,
				arrows: true,
				pagination: false,
				speed: 800,
				pauseOnHover: true,
				mediaQuery: 'min',
				classes: {
					root: 'splide frontpage-splide',
					track: 'splide__track frontpage-track',
					list: 'splide__list frontpage-list',
					slide: 'splide__slide frontpage-slide',
				},
				transition: 'slide',
				breakpoints: {
					768: {
						autoplay: true, // 自動再生
						type: "loop", // ループ
						padding: "20%", // スライダーの左右の余白
						gap: 20, // スライド間の余白
					}
				}
			}).mount();
		});
	</script>


	<!-- 新製品一覧セクション -->
	<section class="l-wide p-fp__newproducts">
		<h2 class="p-fp__newproducts__title">新製品</h2>
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
			<!-- PCとスマホで異なるマークアップを使用 -->
			<?php if (wp_is_mobile()) : ?>
				<!-- スマホ版：Splideスライダー -->
				<div class="c-products-mobile-slider splide p-fp__newproducts__splide" id="new-products-slider">
					<div class="splide__track">
						<ul class="splide__list">
							<?php while ($query->have_posts()) : $query->the_post(); ?>
								<li class="splide__slide c-products__item">
									<a href="<?php the_permalink(); ?>" class="c-products__link">
										<div class="c-products__img">
											<?php
											$thumb_id = get_post_thumbnail_id();
											$thumb_alt = get_the_title();
											$thumb_args = array(
												'alt' => $thumb_alt
											);
											if (has_post_thumbnail()) :
												the_post_thumbnail('full', $thumb_args);
											else :
												echo '<img src="' . esc_url(get_template_directory_uri()) . '/assets/images/common/thumb.webp" alt="' . esc_attr($thumb_alt) . '">';
											endif;
											?>
										</div>
										<p class="c-products__title"><?php the_title(); ?></p>
									</a>
								</li>
							<?php endwhile; ?>
						</ul>
					</div>
				</div>
				<script>
					document.addEventListener('DOMContentLoaded', function() {
						new Splide('#new-products-slider', {
							type: "loop", // ループを有効化
							perPage: 2, // 一度に2つの記事を表示
							perMove: 1, // 1つずつスライド
							gap: '1rem', // スライド間の間隔
							padding: {},
							arrows: true,
							pagination: false,
							speed: 800,
							classes: {
								root: 'splide new-products-splide',
								track: 'splide__track new-products-track',
								list: 'splide__list new-products-list',
								slide: 'splide__slide new-products-slide',
								mediaQuery: 'min',
							},
							breakpoints: {
								480: {
									perPage: 2,
								},
								768: {
									perPage: 4,
								}
							}
						}).mount();
					});
				</script>
			<?php else : ?>
				<!-- PC版：通常のグリッドレイアウト -->
				<ul class="c-products__list p-fp__newproducts__list">
					<?php while ($query->have_posts()) : $query->the_post(); ?>
						<li class="c-products__item">
							<a href="<?php the_permalink(); ?>" class="c-products__link">
								<div class="c-products__img">
									<?php
									$thumb_id = get_post_thumbnail_id();
									$thumb_alt = get_the_title();
									$thumb_args = array(
										'alt' => $thumb_alt
									);
									if (has_post_thumbnail()) :
										the_post_thumbnail('full', $thumb_args);
									else :
										echo '<img src="' . esc_url(get_template_directory_uri()) . '/assets/images/common/thumb.webp" alt="' . esc_attr($thumb_alt) . '">';
									endif;
									?>
								</div>
								<h3 class="c-products__title"><?php the_title(); ?></h3>
							</a>
						</li>
					<?php endwhile; ?>
				</ul>
			<?php endif; ?>

		<?php else : ?>
			<p>新製品はありません。</p>
		<?php endif; ?>

		<?php wp_reset_postdata(); ?>
		<div class="p-fp__newproducts__more">
			<a href="<?php echo home_url('/new-products'); ?>">▶　新製品をもっと見る</a>
		</div>

	</section>


	<section class="l-wide p-fp__products ">
		<h2 class="p-fp__products__title">製品情報</h2>

		<div class="p-fp__products__list">
			<ul>
				<?php
				$taxonomies = get_object_taxonomies('products', 'objects');

				foreach ($taxonomies as $taxonomy) {
					$terms = get_terms([
						'taxonomy' => $taxonomy->name,
						'parent' => 0,
						'hide_empty' => true
					]);

					if (!is_wp_error($terms) && !empty($terms)) {
						foreach ($terms as $term) {
				?>
							<li>
								<em class="accordion-trigger"><?php echo esc_html($term->name); ?></em>
								<ul class="accordion-content">
									<?php
									$args = array(
										'post_type' => 'products',
										'posts_per_page' => -1,
										'tax_query' => array(
											array(
												'taxonomy' => $taxonomy->name,
												'terms' => $term->term_id,
												'include_children' => true
											)
										),
										'orderby' => 'title',
										'order' => 'ASC'
									);

									$products_query = new WP_Query($args);

									if ($products_query->have_posts()) :
										while ($products_query->have_posts()) : $products_query->the_post();
											$products_name = get_field('products_name');
											$products_partnumber = get_field('products_partnumber');
											$products_newitem = get_field('products_newitem');

											if ($products_name || $products_partnumber) :
									?>
												<li>
													<a href="<?php the_permalink(); ?>">
														<?php
														if ($products_partnumber) {
															echo esc_html($products_partnumber) . ' ';
														}
														if ($products_name) {
															echo esc_html($products_name);
														}
														if ($products_newitem === '有効') {
															echo ' <span class="c-new-badge">【NEW】</span>';
														}
														?>
													</a>
												</li>
									<?php
											endif;
										endwhile;
										wp_reset_postdata();
									endif;
									?>
								</ul>
							</li>
				<?php
						}
					}
				}
				?>
			</ul>
		</div>

		<script>
			document.addEventListener('DOMContentLoaded', function() {
				// アコーディオントリガーの取得
				const triggers = document.querySelectorAll('.p-fp__products__list .accordion-trigger');

				// 各トリガーにクリックイベントを設定
				triggers.forEach(trigger => {
					trigger.addEventListener('click', function() {
						// アクティブクラスの切り替え
						this.classList.toggle('is-active');

						// 対応するコンテンツを取得
						const content = this.nextElementSibling;

						// コンテンツの表示/非表示を切り替え
						if (content.style.maxHeight) {
							content.style.maxHeight = null;
						} else {
							content.style.maxHeight = content.scrollHeight + "px";
						}
					});
				});
			});
		</script>
	</section>

</div>
<?php get_footer(); ?>