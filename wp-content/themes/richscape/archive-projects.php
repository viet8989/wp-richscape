<?php
/**
 * Archive template for Projects CPT
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
			<div class="mb-16">
				<h1 class="text-4xl md:text-5xl font-black text-darkblue uppercase mb-3">Dự Án Tiêu Biểu</h1>
				<div class="w-20 h-1 bg-teal"></div>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) : the_post();
						get_template_part( 'template-parts/project-item' );
					endwhile;
				else :
					echo '<p class="text-gray-500 col-span-3">Chưa có dự án nào.</p>';
				endif;
				?>
			</div>

			<div class="mt-12">
				<?php the_posts_pagination( array(
					'mid_size'  => 2,
					'prev_text' => '&larr; Trước',
					'next_text' => 'Tiếp &rarr;',
				) ); ?>
			</div>
		</div>
	</section>
</div>

<?php get_footer();
