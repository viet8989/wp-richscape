<?php
/**
 * Archive template for Services CPT
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

			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
				<?php
				$count = 1;
				if ( have_posts() ) :
					while ( have_posts() ) : the_post();
						set_query_var( 'service_count', $count );
						get_template_part( 'template-parts/content-service-card' );
						$count++;
					endwhile;
				else :
					echo '<p class="text-gray-500 col-span-4">Chưa có dịch vụ nào.</p>';
				endif;
				?>
			</div>
		</div>
	</section>
</div>

<?php get_footer();
