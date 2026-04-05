<?php
/**
 * Single Post template (Blog / News)
 */

get_header(); ?>

<div class="pt-24">

<?php while ( have_posts() ) : the_post();

	richscape_increment_view_count( get_the_ID(), '_post_views' );
	?>

	<!-- Hero Banner -->
	<?php get_template_part( 'template-parts/section-hero-banner' ); ?>

	<!-- Breadcrumb -->
	<?php
	$news_page = get_page_by_path( 'news' );
	set_query_var( 'breadcrumbs', array(
		array( 'label' => 'Trang Chủ',         'url' => home_url( '/' ) ),
		array( 'label' => 'Thông Tin - Bản Tin','url' => $news_page ? get_permalink( $news_page->ID ) : home_url( '/news/' ) ),
		array( 'label' => get_the_title() ),
	) );
	get_template_part( 'template-parts/section-breadcrumb' );
	?>

	<section class="py-16 bg-white">
		<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

			<!-- Post Meta -->
			<div class="flex items-center gap-3 text-xs text-gray-400 font-body mb-6 uppercase tracking-widest">
				<time datetime="<?php echo get_the_date( 'Y-m-d' ); ?>"><?php echo get_the_date( 'd/m/Y' ); ?></time>
				<?php if ( has_category() ) : ?>
				<span>•</span>
				<span><?php echo get_the_category_list( ', ' ); ?></span>
				<?php endif; ?>
			</div>

			<h1 class="text-4xl font-black text-darkblue mb-8 hidden md:block"><?php the_title(); ?></h1>

			<!-- Post Content -->
			<div class="prose prose-lg max-w-none font-body text-gray-700 leading-relaxed">
				<?php the_content(); ?>
			</div>

			<!-- Tags -->
			<?php if ( has_tag() ) : ?>
			<div class="mt-10 pt-6 border-t border-gray-200 flex flex-wrap gap-2">
				<?php foreach ( get_the_tags() as $tag ) : ?>
				<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>"
				   class="px-4 py-1 bg-gray-100 text-gray-600 text-xs font-bold uppercase tracking-wide rounded-full hover:bg-teal hover:text-white transition-colors duration-300">
					#<?php echo esc_html( $tag->name ); ?>
				</a>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>

			<!-- Author & Share -->
			<div class="mt-10 pt-6 border-t border-gray-200 flex items-center justify-between">
				<div class="flex items-center gap-3">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 40, '', '', array( 'class' => 'rounded-full' ) ); ?>
					<div>
						<p class="text-xs text-gray-400 uppercase tracking-widest">Tác giả</p>
						<p class="font-bold text-darkblue text-sm"><?php the_author(); ?></p>
					</div>
				</div>
				<a href="<?php echo esc_url( $news_page ? get_permalink( $news_page->ID ) : home_url( '/news/' ) ); ?>"
				   class="inline-flex items-center text-teal font-bold text-sm uppercase tracking-widest hover:text-darkblue transition-colors duration-300">
					← Tất Cả Bài Viết
				</a>
			</div>
		</div>
	</section>

<?php endwhile; ?>

<!-- Related Posts -->
<?php
$cats    = get_the_category( get_the_ID() );
$cat_ids = wp_list_pluck( $cats, 'term_id' );
$related = new WP_Query( array(
	'post_type'      => 'post',
	'posts_per_page' => 4,
	'post__not_in'   => array( get_the_ID() ),
	'category__in'   => $cat_ids,
	'orderby'        => 'rand',
	'post_status'    => 'publish',
) );
if ( $related->have_posts() ) :
?>
<section class="py-16 bg-gray-50">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="mb-10">
			<h2 class="text-3xl font-black text-darkblue uppercase mb-3">Bài Viết Liên Quan</h2>
			<div class="w-16 h-1 bg-teal"></div>
		</div>
		<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
			<?php while ( $related->have_posts() ) : $related->the_post();
				$thumb = has_post_thumbnail()
					? get_the_post_thumbnail_url( get_the_ID(), 'medium_large' )
					: 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=400&auto=format&fit=crop';
			?>
			<article class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300 group">
				<a href="<?php the_permalink(); ?>" class="block overflow-hidden" style="height: 200px;">
					<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>"
					     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
				</a>
				<div class="p-5">
					<p class="text-xs text-gray-400 font-body mb-2"><?php echo get_the_date( 'd/m/Y' ); ?></p>
					<h3 class="font-black text-darkblue text-base leading-snug group-hover:text-teal transition-colors duration-300">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h3>
				</div>
			</article>
			<?php endwhile;
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
<?php endif; ?>

</div>

<?php get_footer();
