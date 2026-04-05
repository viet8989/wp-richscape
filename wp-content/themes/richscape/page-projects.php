<?php
/**
 * Template Name: Dự Án (Page)
 * The Projects listing page template.
 */

get_header(); ?>

<div class="pt-32">

	<?php
	set_query_var( 'breadcrumbs', array(
		array( 'label' => 'Trang Chủ', 'url' => home_url( '/' ) ),
		array( 'label' => 'Dự Án Tiêu Biểu' ),
	) );
	get_template_part( 'template-parts/section-breadcrumb' );
	?>

	<section class="py-16 bg-white">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="mb-12">
				<h1 class="text-4xl md:text-5xl font-black text-darkblue uppercase mb-3">Dự Án Tiêu Biểu</h1>
				<div class="w-20 h-1 bg-teal"></div>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
				<?php
				$projects_query = new WP_Query( array(
					'post_type'      => 'projects',
					'posts_per_page' => 9,
				) );

				if ( $projects_query->have_posts() ) :
					while ( $projects_query->have_posts() ) : $projects_query->the_post();
						get_template_part( 'template-parts/project-item' );
					endwhile;
					wp_reset_postdata();
				else :
					echo '<p class="text-gray-500 col-span-3">Chưa có dự án nào.</p>';
				endif;
				?>
			</div>

			<div class="mt-12 text-center">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'projects' ) ); ?>"
				   class="inline-flex items-center px-10 py-4 border-2 border-teal text-teal font-bold uppercase tracking-widest text-sm rounded-full hover:bg-teal hover:text-white transition-all duration-300">
					Xem Tất Cả Dự Án
				</a>
			</div>
		</div>
	</section>
</div>

<?php get_footer();
