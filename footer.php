</main>

<section class="l-wide p-insta">
	<h2 class="p-insta__h1">INSTAGRAM</h2>
	<div class="p-insta__inner">
		<?php echo do_shortcode('[instagram-feed feed=1]'); ?>
	</div>
</section>
<footer class="p-ftr">
	<div class="l-wide">
		<?php if (have_rows('sns_list', 'option')): ?>
			<ul class="p-ftr__sns">
				<?php while (have_rows('sns_list', 'option')): the_row();
					$sns_url = get_sub_field('sns_url');
					$sns_image = get_sub_field('sns_image');
					$sns_alt = get_sub_field('sns_alt');

					// URLと画像の両方が入力されている場合のみ表示
					if ($sns_url && $sns_image):
				?>
						<li>
							<a href="<?php echo $sns_url; ?>" target="_blank">
								<img src="<?php echo $sns_image; ?>" alt="<?php echo $sns_alt; ?>">
							</a>
						</li>
				<?php
					endif;
				endwhile;
				?>
			</ul>
		<?php endif; ?>
		<div class="p-ftr__inner">
			<div class="p-ftr__info">
				<div class="p-ftr__logo">
					<a href="<?php echo home_url(); ?>">
						<img src="<?php echo THEME_DIR_URI; ?>common/logo.svg" alt="AX BRAIN LTD.">
					</a>
				</div>

				<?php

				if (function_exists('get_field')):
					$address = get_field('company_address', 'option');
					$tel = get_field('company_tel', 'option');
					$fax = get_field('company_fax', 'option');

					// 3つのフィールドのいずれかに値が入っている場合のみ表示
					if ($address || $tel || $fax):
				?>
						<p class="p-ftr__txt">
							<?php if ($address): ?>
								<?php echo $address; ?><br>
							<?php endif; ?>
							<?php if ($tel): ?>
								TEL.<?php echo $tel; ?><br>
							<?php endif; ?>
							<?php if ($fax): ?>
								FAX.<?php echo $fax; ?>
							<?php endif; ?>
						</p>
				<?php
					endif;
				endif;
				?>
				<div class="p-ftr__tel-box">
					<p class="p-ftr__tel-box__h1">商品に関するお問い合わせ</p>
					<a href="tel:0120-222-226" class="p-ftr__tel-box__tel">0120-222-226</a>
					<p class="p-ftr__tel-box__txt">（月～金/9:00～17:00 <br>年末年始及び指定休業日を除く）</p>
				</div>
			</div>

			<div class="p-calender">
				<p class="p-calender__h1">営業日のご案内</p>
				<?php echo do_shortcode('[xo_event_calendar holidays="all" previous="1" next="1"]'); ?>
			</div>
		</div>

		<div class="p-ftr__btm-box">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer-menu',
					'container' => 'nav',
					'menu_class' => 'p-ftr__nav'
				)
			);
			?>
			<p class="p-ftr__cr">(C) 2025 AX BRAIN LTD.</p>
		</div>

	</div>
</footer>
<?php wp_footer(); ?>
</body>

</html>