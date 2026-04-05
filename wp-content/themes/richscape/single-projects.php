<?php
/**
 * Single Project template
 */

get_header(); ?>

<div class="pt-24">

<?php while ( have_posts() ) : the_post();

	richscape_increment_view_count( get_the_ID(), '_project_views' );

	$client       = function_exists( 'get_field' ) ? get_field( 'project_client' )       : '';
	$area_total   = function_exists( 'get_field' ) ? get_field( 'project_area_total' )   : '';
	$area_green   = function_exists( 'get_field' ) ? get_field( 'project_area_green' )   : '';
	$scope        = function_exists( 'get_field' ) ? get_field( 'project_scope' )        : '';
	$proj_address = function_exists( 'get_field' ) ? get_field( 'project_address' )      : '';
	$category_tag = function_exists( 'get_field' ) ? get_field( 'project_category_tag' ) : '';
	$gallery      = function_exists( 'get_field' ) ? get_field( 'project_gallery' )      : array();
	?>

	<!-- Hero Banner -->
	<?php get_template_part( 'template-parts/section-hero-banner' ); ?>

	<!-- Breadcrumb -->
	<?php
	set_query_var( 'breadcrumbs', array(
		array( 'label' => 'Trang Chủ',       'url' => home_url( '/' ) ),
		array( 'label' => 'Dự Án Tiêu Biểu', 'url' => get_post_type_archive_link( 'projects' ) ),
		array( 'label' => get_the_title() ),
	) );
	get_template_part( 'template-parts/section-breadcrumb' );
	?>

	<section class="py-16 bg-white">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="grid grid-cols-1 lg:grid-cols-3 gap-16">

				<!-- Main Content -->
				<div class="lg:col-span-2">
					<h1 class="text-4xl font-black uppercase text-darkblue mb-8 hidden md:block"><?php the_title(); ?></h1>

					<?php if ( get_the_content() ) : ?>
					<div class="prose prose-lg max-w-none font-body text-gray-700 leading-relaxed mb-12">
						<?php the_content(); ?>
					</div>
					<?php endif; ?>

					<!-- Gallery -->
					<?php if ( ! empty( $gallery ) ) : ?>
					<div class="mb-12">
						<h2 class="text-2xl font-black uppercase text-darkblue mb-6">Thư Viện Ảnh</h2>
						<div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
							<?php foreach ( $gallery as $img ) : ?>
							<a href="<?php echo esc_url( $img['url'] ); ?>" target="_blank" rel="noopener"
							   class="block rounded-xl overflow-hidden aspect-square group">
								<img src="<?php echo esc_url( $img['sizes']['medium'] ?? $img['url'] ); ?>"
								     alt="<?php echo esc_attr( $img['alt'] ); ?>"
								     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
							</a>
							<?php endforeach; ?>
						</div>
					</div>
					<?php endif; ?>
				</div>

				<!-- Sidebar: Meta -->
				<div>
					<div class="sticky top-32">
						<?php if ( $client || $area_total || $area_green || $scope || $proj_address || $category_tag ) : ?>
						<div class="rounded-2xl p-8 text-white mb-6" style="background: linear-gradient(135deg, #1A2251 0%, #2A9D8F 100%);">
							<h3 class="text-lg font-black uppercase mb-5 pb-4 border-b border-white/20">Thông Tin Dự Án</h3>
							<dl class="space-y-4 font-body text-sm">
								<?php if ( $client ) : ?>
								<div>
									<dt class="text-white/60 uppercase tracking-widest text-xs mb-1">Chủ đầu tư</dt>
									<dd class="font-semibold"><?php echo esc_html( $client ); ?></dd>
								</div>
								<?php endif; ?>
								<?php if ( $area_total ) : ?>
								<div>
									<dt class="text-white/60 uppercase tracking-widest text-xs mb-1">Quy mô tổng thể</dt>
									<dd class="font-semibold"><?php echo esc_html( $area_total ); ?> m²</dd>
								</div>
								<?php endif; ?>
								<?php if ( $area_green ) : ?>
								<div>
									<dt class="text-white/60 uppercase tracking-widest text-xs mb-1">Diện tích phủ xanh</dt>
									<dd class="font-semibold"><?php echo esc_html( $area_green ); ?> m²</dd>
								</div>
								<?php endif; ?>
								<?php if ( $scope ) : ?>
								<div>
									<dt class="text-white/60 uppercase tracking-widest text-xs mb-1">Phạm vi thực hiện</dt>
									<dd class="font-semibold"><?php echo esc_html( $scope ); ?></dd>
								</div>
								<?php endif; ?>
								<?php if ( $proj_address ) : ?>
								<div>
									<dt class="text-white/60 uppercase tracking-widest text-xs mb-1">Địa chỉ</dt>
									<dd class="font-semibold"><?php echo esc_html( $proj_address ); ?></dd>
								</div>
								<?php endif; ?>
								<?php if ( $category_tag ) : ?>
								<div>
									<dt class="text-white/60 uppercase tracking-widest text-xs mb-1">Loại dịch vụ</dt>
									<dd class="font-semibold"><?php echo esc_html( $category_tag ); ?></dd>
								</div>
								<?php endif; ?>
							</dl>
						</div>
						<?php endif; ?>

						<a href="<?php echo esc_url( get_post_type_archive_link( 'projects' ) ); ?>"
						   class="block text-center py-4 border-2 border-teal text-teal font-bold uppercase tracking-widest text-sm rounded-full hover:bg-teal hover:text-white transition-all duration-300">
							← Tất Cả Dự Án
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>

<?php endwhile; ?>

<!-- Related Projects -->
<?php
$related = new WP_Query( array(
	'post_type'      => 'projects',
	'posts_per_page' => 4,
	'post__not_in'   => array( get_the_ID() ),
	'orderby'        => 'rand',
) );
if ( $related->have_posts() ) :
?>
<section class="py-16 bg-gray-50">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="mb-10">
			<h2 class="text-3xl font-black text-darkblue uppercase mb-3">Dự Án Liên Quan</h2>
			<div class="w-16 h-1 bg-teal"></div>
		</div>
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
			<?php while ( $related->have_posts() ) : $related->the_post();
				get_template_part( 'template-parts/project-item' );
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
<?php endif; ?>

</div>

<?php get_footer();
