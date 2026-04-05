<?php
/**
 * Template Name: Thông Tin - Bản Tin
 * The News listing page template.
 */

get_header(); ?>

<div class="pt-32">

	<?php
	set_query_var( 'breadcrumbs', array(
		array( 'label' => 'Trang Chủ', 'url' => home_url( '/' ) ),
		array( 'label' => 'Thông Tin - Bản Tin' ),
	) );
	get_template_part( 'template-parts/section-breadcrumb' );
	?>

	<section class="py-16 bg-white">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="mb-12">
				<h1 class="text-4xl md:text-5xl font-black text-darkblue uppercase mb-3">Thông Tin - Bản Tin</h1>
				<div class="w-20 h-1 bg-teal"></div>
			</div>

			<?php
			$paged      = max( 1, get_query_var( 'paged' ) );
			$news_query = new WP_Query( array(
				'post_type'      => 'post',
				'posts_per_page' => 10,
				'paged'          => $paged,
				'post_status'    => 'publish',
			) );
			?>

			<?php if ( $news_query->have_posts() ) : ?>
			<div class="space-y-10">
				<?php while ( $news_query->have_posts() ) : $news_query->the_post();
					$thumb = has_post_thumbnail()
						? get_the_post_thumbnail_url( get_the_ID(), 'medium_large' )
						: 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=600&auto=format&fit=crop';
				?>
				<article class="flex flex-col sm:flex-row gap-8 pb-10 border-b border-gray-200 group">
					<a href="<?php the_permalink(); ?>"
					   class="flex-shrink-0 block rounded-xl overflow-hidden bg-gray-100"
					   style="width: 280px; height: 200px; min-width: 280px;">
						<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>"
						     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
					</a>
					<div class="flex-1 py-2">
						<div class="flex items-center gap-3 text-xs text-gray-400 font-body mb-3 uppercase tracking-widest">
							<time datetime="<?php echo get_the_date( 'Y-m-d' ); ?>"><?php echo get_the_date( 'd/m/Y' ); ?></time>
							<?php if ( has_category() ) : ?>
							<span>•</span>
							<span><?php echo get_the_category_list( ', ' ); ?></span>
							<?php endif; ?>
						</div>
						<h2 class="text-2xl font-black text-darkblue mb-3 group-hover:text-teal transition-colors duration-300">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>
						<p class="text-gray-600 font-body text-sm leading-relaxed mb-4"><?php the_excerpt(); ?></p>
						<a href="<?php the_permalink(); ?>"
						   class="inline-flex items-center text-teal font-bold text-sm uppercase tracking-widest hover:text-darkblue transition-colors duration-300">
							Đọc tiếp
							<svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
							</svg>
						</a>
					</div>
				</article>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>

			<?php if ( $news_query->max_num_pages > 1 ) : ?>
			<div class="mt-12 flex justify-center">
				<?php
				echo paginate_links( array(
					'total'     => $news_query->max_num_pages,
					'current'   => $paged,
					'format'    => '?paged=%#%',
					'prev_text' => '&larr; Trước',
					'next_text' => 'Tiếp &rarr;',
				) );
				?>
			</div>
			<?php endif; ?>

			<?php else : ?>
			<p class="text-gray-500">Chưa có bài viết nào.</p>
			<?php endif; ?>
		</div>
	</section>
</div>

<?php get_footer();
