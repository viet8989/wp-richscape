<?php
/**
 * Template Name: Dự Án (Page)
 * The Projects listing page template.
 */

get_header(); ?>

<div class="pt-32">
	<section class="py-16 bg-white">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="mb-8">
				<h1 class="inline-block font-utm font-bold text-darkblue uppercase mb-3 tracking-wide pb-2 border-b-2 border-darkblue" style="font-size: 1.75rem;">DỰ ÁN</h1>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
				<?php
				$projects_query = new WP_Query( array(
					'post_type'      => 'projects',
					'posts_per_page' => -1,
					'orderby'        => 'menu_order date',
					'order'          => 'ASC',
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
		</div>
	</section>
</div>

<?php get_footer();
