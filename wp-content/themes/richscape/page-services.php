<?php
/**
 * Template Name: Dịch Vụ (Page)
 * The Services landing page template.
 */

get_header(); ?>

<div class="pt-32">

	<?php
	set_query_var( 'breadcrumbs', array(
		array( 'label' => 'Trang Chủ', 'url' => home_url( '/' ) ),
		array( 'label' => 'Dịch Vụ' ),
	) );
	get_template_part( 'template-parts/section-breadcrumb' );
	?>

	<section class="py-16 bg-white">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="mb-16">
				<h1 class="text-4xl md:text-5xl font-black text-darkblue uppercase mb-3">Dịch Vụ</h1>
				<div class="w-20 h-1 bg-teal"></div>
			</div>

			<?php
			$services_query = new WP_Query( array(
				'post_type'      => 'services',
				'posts_per_page' => -1,
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
			) );

			$count = 1;
			if ( $services_query->have_posts() ) :
				while ( $services_query->have_posts() ) : $services_query->the_post();
					$sub_images = function_exists( 'get_field' ) ? get_field( 'service_sub_images' ) : array();
					$icon       = function_exists( 'get_field' ) ? get_field( 'service_icon' ) : null;
					$icon_url   = $icon['url'] ?? '';
					$desc       = has_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_content(), 40 );
					$img_url    = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'large' ) : '';
					$is_even    = ( $count % 2 === 0 );
					?>
					<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start mb-20 <?php echo $is_even ? 'lg:grid-flow-col-dense' : ''; ?>">

						<!-- Info Column -->
						<div class="<?php echo $is_even ? 'lg:col-start-2' : ''; ?>">
							<div class="flex items-center gap-4 mb-6">
								<span class="font-serif text-6xl text-teal font-normal leading-none opacity-60"><?php echo $count; ?></span>
								<?php if ( $icon_url ) : ?>
								<img src="<?php echo esc_url( $icon_url ); ?>" alt="" class="h-12 w-auto opacity-80">
								<?php endif; ?>
							</div>
							<h2 class="text-3xl font-black uppercase text-darkblue mb-4"><?php the_title(); ?></h2>
							<p class="text-gray-600 font-body leading-relaxed mb-6"><?php echo esc_html( $desc ); ?></p>
							<?php if ( get_the_content() ) : ?>
							<div class="prose max-w-none font-body text-gray-700 leading-relaxed mb-8">
								<?php the_content(); ?>
							</div>
							<?php endif; ?>
							<a href="<?php echo esc_url( get_post_type_archive_link( 'projects' ) ); ?>"
							   class="inline-flex items-center px-8 py-3 bg-teal text-white font-bold uppercase tracking-widest text-sm rounded-full hover:bg-darkblue transition-colors duration-300">
								DỰ ÁN LIÊN QUAN
							</a>
						</div>

						<!-- Images Column -->
						<div class="<?php echo $is_even ? 'lg:col-start-1' : ''; ?>">
							<?php if ( ! empty( $sub_images ) ) : ?>
							<div class="grid grid-cols-2 gap-4">
								<?php foreach ( array_slice( $sub_images, 0, 4 ) as $item ) :
									$sub_url     = $item['sub_image']['url'] ?? '';
									$sub_caption = $item['sub_caption'] ?? '';
									if ( ! $sub_url ) continue;
								?>
								<div class="relative rounded-xl overflow-hidden" style="aspect-ratio: 4/3;">
									<img src="<?php echo esc_url( $sub_url ); ?>"
									     alt="<?php echo esc_attr( $sub_caption ); ?>"
									     class="w-full h-full object-cover">
									<?php if ( $sub_caption ) : ?>
									<div class="absolute bottom-0 left-0 right-0 bg-darkblue/70 py-2 px-3">
										<span class="text-white font-bold uppercase text-xs tracking-widest"><?php echo esc_html( $sub_caption ); ?></span>
									</div>
									<?php endif; ?>
								</div>
								<?php endforeach; ?>
							</div>
							<?php elseif ( $img_url ) : ?>
							<div class="rounded-2xl overflow-hidden" style="aspect-ratio: 4/3;">
								<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php the_title_attribute(); ?>"
								     class="w-full h-full object-cover">
							</div>
							<?php else : ?>
							<div class="rounded-2xl bg-gray-100 flex items-center justify-center" style="aspect-ratio: 4/3;">
								<span class="text-gray-400 font-body text-sm">Chưa có ảnh</span>
							</div>
							<?php endif; ?>
						</div>
					</div>
					<?php if ( $services_query->current_post < $services_query->post_count - 1 ) : ?>
					<hr class="border-gray-200 mb-20">
					<?php endif; ?>
					<?php
					$count++;
				endwhile;
				wp_reset_postdata();
			else :
				echo '<p class="text-gray-500">Chưa có dịch vụ nào.</p>';
			endif;
			?>
		</div>
	</section>
</div>

<?php get_footer();
