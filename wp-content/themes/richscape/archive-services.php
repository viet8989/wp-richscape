<?php
/**
 * Archive template for Services CPT
 * Matches the Canva wireframe design with vertical sections and 2x2 image grids.
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

	<?php
	// Custom query to ensure proper ordering
	$services_query = new WP_Query( array(
		'post_type'      => 'services',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	) );

	$count = 0;
	if ( $services_query->have_posts() ) :
		while ( $services_query->have_posts() ) : $services_query->the_post();
			$count++;
			$sub_items = richscape_get_service_sub_items( get_the_ID() );
			$desc      = has_excerpt() ? get_the_excerpt() : '';
			?>
			<!-- Service Section <?php echo $count; ?> -->
			<section class="py-16 bg-white">
				<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

					<!-- Section Title with Teal Underline -->
					<h2 class="text-xl md:text-[21px] font-bold text-[#1eaf87] uppercase mb-1 tracking-wide">
						<?php echo richscape_service_title_html(); ?>
					</h2>
					<div class="w-full max-w-[280px] h-[2px] bg-[#1eaf87] mb-6"></div>

					<?php if ( $count === 1 && $desc ) : ?>
					<!-- Description (only for first service) -->
					<p class="text-[#21548c] text-base leading-relaxed mb-8 max-w-3xl">
						<?php echo esc_html( $desc ); ?>
					</p>
					<?php endif; ?>

					<!-- 2x2 Image Grid -->
					<?php if ( ! empty( $sub_items ) ) : ?>
					<div class="grid grid-cols-1 sm:grid-cols-2 gap-8 md:gap-10">
						<?php foreach ( array_slice( $sub_items, 0, 4 ) as $item ) :
							$img_url = $item['image_url'] ?? '';
							$caption = $item['caption'] ?? '';
							if ( ! $img_url && ! $caption ) continue;
						?>
						<div class="flex flex-col">
							<!-- Image Container -->
							<div class="relative overflow-hidden bg-gray-100" style="aspect-ratio: 3/2;">
								<?php if ( $img_url ) : ?>
								<img src="<?php echo esc_url( $img_url ); ?>"
								     alt="<?php echo esc_attr( $caption ); ?>"
								     class="w-full h-full object-cover">
								<?php else : ?>
								<div class="w-full h-full flex items-center justify-center text-gray-400">
									<span>Chưa có ảnh</span>
								</div>
								<?php endif; ?>
							</div>
							<!-- Caption -->
							<?php if ( $caption ) : ?>
							<p class="mt-4 text-center text-[#00845b] text-base font-bold uppercase tracking-wide">
								<?php echo esc_html( $caption ); ?>
							</p>
							<?php endif; ?>
						</div>
						<?php endforeach; ?>
					</div>
					<?php else : ?>
					<!-- Fallback: No sub-items, show featured image if available -->
					<?php if ( has_post_thumbnail() ) : ?>
					<div class="grid grid-cols-1 sm:grid-cols-2 gap-8 md:gap-10">
						<div class="flex flex-col">
							<div class="relative overflow-hidden bg-gray-100" style="aspect-ratio: 3/2;">
								<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-full object-cover' ) ); ?>
							</div>
						</div>
					</div>
					<?php endif; ?>
					<?php endif; ?>

				</div>
			</section>

		<?php
		endwhile;
		wp_reset_postdata();
	else :
	?>
		<section class="py-16 bg-white">
			<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
				<p class="text-gray-500">Chưa có dịch vụ nào.</p>
			</div>
		</section>
	<?php endif; ?>

</div>

<?php get_footer();
