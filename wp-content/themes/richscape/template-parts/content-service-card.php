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
		<div class="flex items-start">
			<h3 class="flex-1 text-white font-sans font-bold uppercase text-2xl leading-tight" style="min-height: 90px; padding-right: 56px;">
				<?php the_title(); ?>
			</h3>
			<?php if ( $icon_url ) : ?>
			<div class="absolute" style="top: 24px; right: 52px; width: 44px;">
				<img src="<?php echo esc_url( $icon_url ); ?>" alt="" style="width: 44px; height: auto; object-fit: contain; opacity: 0.9;">
			</div>
			<?php endif; ?>
			<div class="absolute" style="top: 12px; right: 16px;">
				<span class="font-serif leading-none font-normal" style="font-size: 52px; color: #2A9D8F; line-height: 1;"><?php echo $count; ?></span>
			</div>
		</div>
	</div>

	<!-- Description -->
	<div class="px-5 pb-4">
		<p class="text-white/80 font-body text-sm leading-relaxed"><?php echo esc_html( $desc ); ?></p>
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
		   style="background-color: #2A9D8F; color: #1A2251; text-decoration: underline;">
			DỰ ÁN LIÊN QUAN
		</a>
	</div>
</div>
