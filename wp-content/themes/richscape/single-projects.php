<?php
/**
 * Single Project template
 */

get_header(); ?>

<style>
/* Single project layout — not relying on Tailwind compilation */
.single-project-wrap { padding-top: 137px; background: #fff; }
.project-hero { width: 100%; height: 420px; overflow: hidden; }
.project-hero img { width: 100%; height: 100%; object-fit: cover; display: block; }
.single-project-breadcrumb { background: #f9fafb; border-bottom: 1px solid #e5e7eb; padding: 10px 0; }
.single-project-breadcrumb nav { max-width: 1200px; margin: 0 auto; padding: 0 24px; font-size: 12px; font-family: 'Open Sans', sans-serif; text-transform: uppercase; letter-spacing: .05em; color: #6b7280; display: flex; flex-wrap: wrap; align-items: center; gap: 6px; }
.single-project-breadcrumb a { color: #6b7280; text-decoration: none; }
.single-project-breadcrumb a:hover { color: #2A9D8F; }
.single-project-breadcrumb .current { color: #2A9D8F; font-weight: 600; }
.single-project-body { max-width: 1200px; margin: 0 auto; padding: 40px 24px 60px; display: grid; grid-template-columns: 1fr 340px; gap: 40px; }
@media (max-width: 1024px) { .single-project-body { grid-template-columns: 1fr; } }
/* Main column */
.project-main h1 { font-family: 'Montserrat', sans-serif; font-size: 2rem; font-weight: 900; text-transform: uppercase; color: #1A2251; margin: 0 0 16px; }
.project-meta { display: flex; flex-wrap: wrap; align-items: center; gap: 20px; font-family: 'Open Sans', sans-serif; font-size: 13px; color: #9ca3af; margin-bottom: 16px; }
.project-meta span { display: flex; align-items: center; gap: 5px; }
.project-cat { font-family: 'Open Sans', sans-serif; font-size: 14px; font-weight: 700; color: #374151; margin-bottom: 8px; }
.project-address { font-family: 'Open Sans', sans-serif; font-size: 13px; color: #6b7280; margin-bottom: 20px; }
.project-address strong { color: #374151; }
.project-info-block { margin-bottom: 20px; }
.project-info-block h2 { font-family: 'Montserrat', sans-serif; font-size: 14px; font-weight: 900; text-transform: uppercase; color: #1A2251; border-bottom: 2px solid #1A2251; display: inline-block; padding-bottom: 4px; margin: 0 0 12px; }
.project-info-block p { font-family: 'Open Sans', sans-serif; font-size: 13px; color: #374151; margin: 4px 0; }
.project-content { font-family: 'Open Sans', sans-serif; font-size: 14px; color: #374151; line-height: 1.75; text-align: justify; margin-bottom: 24px; }
.project-watermark { text-align: center; padding: 20px 0; font-family: 'Montserrat', sans-serif; font-size: 2.5rem; font-weight: 900; text-transform: uppercase; letter-spacing: .4em; color: #e5e7eb; user-select: none; }
.project-gallery-full { max-width: 1200px; margin: 0 auto 60px; padding: 0 24px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
.project-gallery-full a { display: block; overflow: hidden; aspect-ratio: 4/3; }
.project-gallery-full img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .5s; }
.project-gallery-full a:hover img { transform: scale(1.05); }
@media (max-width: 640px) { .project-gallery-full { grid-template-columns: repeat(2, 1fr); } }
/* Sidebar */
.project-sidebar-box { border: 1px solid #e5e7eb; border-radius: 10px; padding: 20px; }
.sidebar-heading { font-family: 'Montserrat', sans-serif; font-size: 1.1rem; font-weight: 700; color: #2A9D8F; margin: 0 0 4px; }
.sidebar-divider { height: 2px; background: #2A9D8F; margin-bottom: 16px; }
.related-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px; }
.related-item { display: block; text-decoration: none; }
.related-item img { width: 100%; aspect-ratio: 4/3; object-fit: cover; transition: transform .4s; display: block; }
.related-item:hover img { transform: scale(1.05); }
.related-caption { font-family: 'Montserrat', sans-serif; font-size: 11px; font-weight: 700; text-transform: uppercase; color: #374151; text-align: center; padding: 6px 4px 0; line-height: 1.3; }
.related-item:hover .related-caption { color: #2A9D8F; }
.xem-them-wrap { text-align: center; padding-top: 4px; }
.xem-them-btn { display: inline-block; font-family: 'Montserrat', sans-serif; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; color: #6b7280; border: 1px solid #d1d5db; padding: 8px 24px; border-radius: 4px; text-decoration: none; transition: all .2s; }
.xem-them-btn:hover { color: #2A9D8F; border-color: #2A9D8F; }
</style>

<div class="single-project-wrap">

<?php while ( have_posts() ) : the_post();

	richscape_increment_view_count( get_the_ID(), '_project_views' );

	$client       = function_exists( 'get_field' ) ? get_field( 'project_client' )       : '';
	$area_total   = function_exists( 'get_field' ) ? get_field( 'project_area_total' )   : '';
	$area_green   = function_exists( 'get_field' ) ? get_field( 'project_area_green' )   : '';
	$scope        = function_exists( 'get_field' ) ? get_field( 'project_scope' )        : '';
	$proj_address = function_exists( 'get_field' ) ? get_field( 'project_address' )      : '';
	$category_tag = function_exists( 'get_field' ) ? get_field( 'project_category_tag' ) : '';
	$gallery      = function_exists( 'richscape_get_project_gallery' ) ? richscape_get_project_gallery( get_the_ID() ) : array();
	$views        = (int) get_post_meta( get_the_ID(), '_project_views', true );
	?>

	<!-- Hero Image -->
	<?php
	$hero_url = has_post_thumbnail()
		? get_the_post_thumbnail_url( get_the_ID(), 'full' )
		: 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?q=80&w=1600&auto=format&fit=crop';
	?>
	<div class="project-hero">
		<img src="<?php echo esc_url( $hero_url ); ?>" alt="<?php the_title_attribute(); ?>">
	</div>

	<!-- Breadcrumb -->
	<div class="single-project-breadcrumb">
		<nav>
			<a href="<?php echo esc_url( home_url('/') ); ?>">Trang Chủ</a>
			<span>/</span>
			<a href="<?php echo esc_url( get_post_type_archive_link('projects') ); ?>">Dự Án</a>
			<span>/</span>
			<a href="<?php echo esc_url( get_post_type_archive_link('projects') ); ?>">Dự Án Đã Thi Công</a>
			<span>/</span>
			<span class="current"><?php the_title(); ?></span>
		</nav>
	</div>

	<!-- Body -->
	<div class="single-project-body">

		<!-- Left: Main Content -->
		<div class="project-main">

			<h1><?php the_title(); ?></h1>

			<!-- Meta -->
			<div class="project-meta">
				<span>
					<svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" stroke-width="2"/><line x1="16" y1="2" x2="16" y2="6" stroke-width="2"/><line x1="8" y1="2" x2="8" y2="6" stroke-width="2"/><line x1="3" y1="10" x2="21" y2="10" stroke-width="2"/></svg>
					<?php echo get_the_date('d/m/Y'); ?>
				</span>
				<span><?php echo get_the_date('h:i A'); ?></span>
				<span>
					<svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
					<?php echo $views; ?> Lượt xem
				</span>
			</div>

			<?php if ( $category_tag ) : ?>
			<p class="project-cat"><?php echo esc_html( $category_tag ); ?></p>
			<?php endif; ?>

			<?php if ( $proj_address ) : ?>
			<p class="project-address"><strong>Địa chỉ : </strong><?php echo esc_html( $proj_address ); ?></p>
			<?php endif; ?>

			<!-- THÔNG TIN DỰ ÁN -->
			<?php if ( $client || $area_total || $area_green || $scope ) : ?>
			<div class="project-info-block">
				<h2>Thông Tin Dự Án</h2>
				<div>
					<?php if ( $client ) : ?>
					<p>Chủ đầu tư: <?php echo esc_html( $client ); ?></p>
					<?php endif; ?>
					<?php if ( $area_total ) : ?>
					<p>Quy mô tổng thể: <?php echo esc_html( $area_total ); ?> m²</p>
					<?php endif; ?>
					<?php if ( $area_green ) : ?>
					<p>Diện tích phủ xanh: <?php echo esc_html( $area_green ); ?> m²</p>
					<?php endif; ?>
					<?php if ( $scope ) : ?>
					<p>Phạm vi thực hiện: <?php echo esc_html( $scope ); ?></p>
					<?php endif; ?>
				</div>
			</div>
			<?php endif; ?>

			<!-- Body content -->
			<?php if ( get_the_content() ) : ?>
			<div class="project-content">
				<?php the_content(); ?>
			</div>
			<?php endif; ?>

			<!-- Watermark -->
			<div class="project-watermark">Landscape Creator</div>

		</div>

		<!-- Right: Sidebar -->
		<div>
			<div class="project-sidebar-box">
				<h3 class="sidebar-heading">Dự án liên quan</h3>
				<div class="sidebar-divider"></div>

				<?php
				$related = new WP_Query( array(
					'post_type'      => 'projects',
					'posts_per_page' => 4,
					'post__not_in'   => array( get_the_ID() ),
					'orderby'        => 'rand',
				) );
				if ( $related->have_posts() ) :
				?>
				<div class="related-grid">
					<?php while ( $related->have_posts() ) : $related->the_post();
						$thumb = has_post_thumbnail()
							? get_the_post_thumbnail_url( get_the_ID(), 'medium' )
							: 'https://images.unsplash.com/photo-1598257006458-087169a1f08d?q=80&w=400&auto=format&fit=crop';
					?>
					<a href="<?php the_permalink(); ?>" class="related-item">
						<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>">
						<p class="related-caption"><?php the_title(); ?></p>
					</a>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
				<div class="xem-them-wrap">
					<a href="<?php echo esc_url( get_post_type_archive_link('projects') ); ?>" class="xem-them-btn">Xem Thêm</a>
				</div>
				<?php endif; ?>
			</div>
		</div>

	</div><!-- .single-project-body -->

	<!-- Gallery – full width below 2-col layout -->
	<?php if ( ! empty( $gallery ) ) : ?>
	<div class="project-gallery-full">
		<?php foreach ( $gallery as $img ) : ?>
		<a href="<?php echo esc_url( $img['url'] ); ?>" target="_blank" rel="noopener">
			<img src="<?php echo esc_url( $img['sizes']['medium_large'] ?? $img['url'] ); ?>"
			     alt="<?php echo esc_attr( $img['alt'] ); ?>">
		</a>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>

<?php endwhile; ?>

</div><!-- .single-project-wrap -->

<?php get_footer();
