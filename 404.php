<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Ax-Brain
 * @since 1.0.0
 */

get_header();
?>

<main class="p-404">
	<div class="p-404__inner">
		<h1 class="p-404__title">404</h1>
		<p class="p-404__text">お探しのページが見つかりませんでした。</p>
		<div class="p-404__button">
			<a href="<?php echo esc_url(home_url('/')); ?>" class="p-404__link">トップページへ戻る</a>
		</div>
	</div>
</main>

<?php
get_footer();
?>