<?php
/**
 * Template Part: Service Card
 * Used in: front-page.php, archive-services.php
 * Context: inside a WP_Query loop (the_post() already called)
 * Receives: service_count via set_query_var('service_count', $n)
 */

$count    = (int) get_query_var( 'service_count', 1 );
$icon     = function_exists( 'get_field' ) ? get_field( 'service_icon' ) : null;
$icon_url = $icon['url'] ?? '';
$desc     = has_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_content(), 25 );

$fallback_imgs = array(
	'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=600&auto=format&fit=crop',
	'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&auto=format&fit=crop',
	'https://images.unsplash.com/photo-1576941089067-2de3c901e126?w=600&auto=format&fit=crop',
	'https://images.unsplash.com/photo-1585320806297-9794b3e4aaae?w=600&auto=format&fit=crop',
);
$img_url = has_post_thumbnail()
	? get_the_post_thumbnail_url( get_the_ID(), 'medium_large' )
	: $fallback_imgs[ ( $count - 1 ) % 4 ];
?>
<div class="group relative overflow-hidden flex flex-col border border-white/20 transition-transform duration-300 hover:-translate-y-1"
     style="background: linear-gradient(135deg, #1A2251 0%, #2A9D8F 100%); min-height: 500px; border-radius: 28px;">

	<!-- Top: title left, icon+number right -->
	<div class="relative pt-6 px-5 pb-3">
		<h3 class="text-white font-sans font-bold uppercase leading-tight"
		    style="font-size: clamp(1.25rem, 2vw, 1.75rem); min-height: 95px; padding-right: 80px;">
			<?php the_title(); ?>
		</h3>
		<?php if ( $icon_url ) : ?>
		<!-- Icon PNG uploaded in wp-admin › Services › Biểu tượng dịch vụ -->
		<div class="absolute" style="top: 22px; right: 40px; width: 56px;">
			<img src="<?php echo esc_url( $icon_url ); ?>"
			     alt=""
			     style="width: 56px; height: auto; max-height: 52px; object-fit: contain; opacity: 0.92;">
		</div>
		<?php endif; ?>
		<!-- Number badge overlaps icon right edge -->
		<div class="absolute" style="top: 10px; right: 10px; line-height: 1;">
			<span class="font-sans font-normal"
			      style="font-size: 56px; color: #1EAF87; line-height: 1;"><?php echo $count; ?></span>
		</div>
	</div>

	<!-- Description -->
	<div class="px-5 pb-4">
		<p class="text-white/85 font-body leading-relaxed" style="font-size: 0.9rem;"><?php echo esc_html( $desc ); ?></p>
	</div>

	<!-- Photo -->
	<div class="mx-2 mb-1 rounded-2xl overflow-hidden flex-grow" style="min-height: 240px;">
		<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php the_title_attribute(); ?>"
		     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
	</div>

	<!-- CTA -->
	<div class="flex justify-center py-4">
		<a href="<?php the_permalink(); ?>"
		   class="font-sans font-bold text-xs uppercase tracking-widest px-6 py-2 rounded-full hover:opacity-80 transition-opacity duration-300"
		   style="background-color: #1EAF87; color: #21548C; text-decoration: underline;">
			DỰ ÁN LIÊN QUAN
		</a>
	</div>
</div>
