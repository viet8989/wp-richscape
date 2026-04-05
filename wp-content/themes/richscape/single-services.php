<?php
/**
 * Single Service template
 */

get_header(); ?>

<style>
.single-service-wrap { padding-top: 137px; background: #fff; }
.service-hero { width: 100%; height: 380px; overflow: hidden; }
.service-hero img { width: 100%; height: 100%; object-fit: cover; display: block; }
.single-service-breadcrumb { background: #f9fafb; border-bottom: 1px solid #e5e7eb; padding: 10px 0; }
.single-service-breadcrumb nav { max-width: 1200px; margin: 0 auto; padding: 0 24px; font-size: 12px; font-family: 'Open Sans', sans-serif; text-transform: uppercase; letter-spacing: .05em; color: #6b7280; display: flex; flex-wrap: wrap; align-items: center; gap: 6px; }
.single-service-breadcrumb a { color: #6b7280; text-decoration: none; }
.single-service-breadcrumb a:hover { color: #2A9D8F; }
.single-service-breadcrumb .current { color: #2A9D8F; font-weight: 600; }
.single-service-body { max-width: 1200px; margin: 0 auto; padding: 40px 24px 20px; }
.single-service-body h1 { font-family: 'Montserrat', sans-serif; font-size: 2rem; font-weight: 900; text-transform: uppercase; color: #1A2251; margin: 0 0 12px; }
.service-underline { width: 60px; height: 3px; background: #2A9D8F; margin-bottom: 24px; }
.service-content { font-family: 'Open Sans', sans-serif; font-size: 14px; color: #374151; line-height: 1.8; text-align: justify; margin-bottom: 40px; }
/* Related projects section */
.service-projects-section { max-width: 1200px; margin: 0 auto; padding: 0 24px 60px; }
.service-projects-heading { font-family: 'Montserrat', sans-serif; font-size: 1.5rem; font-weight: 900; text-transform: uppercase; color: #1A2251; margin: 0 0 8px; }
.service-projects-divider { width: 50px; height: 3px; background: #2A9D8F; margin-bottom: 28px; }
.service-projects-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
@media (max-width: 900px) { .service-projects-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 560px) { .service-projects-grid { grid-template-columns: 1fr; } }
.service-project-card { position: relative; border-radius: 14px; overflow: hidden; aspect-ratio: 4/3; background: #1A2251; display: block; text-decoration: none; }
.service-project-card img { width: 100%; height: 100%; object-fit: cover; transition: transform .8s; opacity: .9; }
.service-project-card:hover img { transform: scale(1.08); opacity: 1; }
.service-project-card .overlay { position: absolute; inset: 0 0 0 0; background: linear-gradient(to top, rgba(0,0,0,.85) 0%, transparent 55%); }
.service-project-card .caption { position: absolute; bottom: 16px; left: 16px; right: 16px; }
.service-project-card .caption h3 { font-family: 'Montserrat', sans-serif; font-size: 1rem; font-weight: 900; text-transform: uppercase; color: #fff; margin: 0; }
.service-projects-empty { font-family: 'Open Sans', sans-serif; color: #9ca3af; font-size: 14px; }
</style>

<div class="single-service-wrap">

<?php while ( have_posts() ) : the_post();

	$hero_url = has_post_thumbnail()
		? get_the_post_thumbnail_url( get_the_ID(), 'full' )
		: 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?q=80&w=1600&auto=format&fit=crop';

	$service_id = get_the_ID();
?>

	<!-- Hero -->
	<div class="service-hero">
		<img src="<?php echo esc_url( $hero_url ); ?>" alt="<?php the_title_attribute(); ?>">
	</div>

	<!-- Breadcrumb -->
	<div class="single-service-breadcrumb">
		<nav>
			<a href="<?php echo esc_url( home_url('/') ); ?>">Trang Chủ</a>
			<span>/</span>
			<a href="<?php echo esc_url( get_post_type_archive_link('services') ); ?>">Dịch Vụ</a>
			<span>/</span>
			<span class="current"><?php the_title(); ?></span>
		</nav>
	</div>

	<!-- Service Body -->
	<div class="single-service-body">
		<h1><?php the_title(); ?></h1>
		<div class="service-underline"></div>

		<?php if ( get_the_content() ) : ?>
		<div class="service-content">
			<?php the_content(); ?>
		</div>
		<?php endif; ?>
	</div>

<?php endwhile; ?>

<!-- Related Projects -->
<div class="service-projects-section">
	<h2 class="service-projects-heading">Dự Án Liên Quan</h2>
	<div class="service-projects-divider"></div>

	<?php
	$related_projects = new WP_Query( array(
		'post_type'      => 'projects',
		'posts_per_page' => -1,
		'meta_query'     => array(
			array(
				'key'     => 'project_service',
				'value'   => $service_id,
				'compare' => '=',
			),
		),
	) );

	if ( $related_projects->have_posts() ) :
	?>
	<div class="service-projects-grid">
		<?php while ( $related_projects->have_posts() ) : $related_projects->the_post();
			$thumb = has_post_thumbnail()
				? get_the_post_thumbnail_url( get_the_ID(), 'large' )
				: 'https://images.unsplash.com/photo-1598257006458-087169a1f08d?q=80&w=800&auto=format&fit=crop';
		?>
		<a href="<?php the_permalink(); ?>" class="service-project-card">
			<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>">
			<div class="overlay"></div>
			<div class="caption">
				<h3><?php the_title(); ?></h3>
			</div>
		</a>
		<?php endwhile; wp_reset_postdata(); ?>
	</div>
	<?php else : ?>
	<p class="service-projects-empty">Chưa có dự án nào liên quan đến dịch vụ này.</p>
	<?php endif; ?>
</div>

</div><!-- .single-service-wrap -->

<?php get_footer();
