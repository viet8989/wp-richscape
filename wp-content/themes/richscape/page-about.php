<?php
/**
 * Template Name: Về Chúng Tôi
 * The About Us page template.
 */

get_header(); ?>

<div class="pt-32">

	<!-- About Card + Intro -->
	<section class="py-16 bg-white">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="mb-8 inline-block">
				<h1 class="text-4xl font-black text-teal uppercase mb-3">Về Chúng Tôi</h1>
				<div class="h-1 bg-teal w-full"></div>
			</div>
			<?php get_template_part( 'template-parts/section-about-card-page' ); ?>
		</div>
	</section>

	<!-- Vision Mission Core Values -->
	<?php get_template_part( 'template-parts/section-vision-mission' ); ?>

	<!-- Leaders Section -->
	<?php
	$leaders = function_exists( 'get_field' ) ? get_field( 'leaders' ) : array();
	if ( ! empty( $leaders ) ) :
	?>
	<section class="py-20 bg-white">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="mb-12">
				<h2 class="text-4xl font-black text-darkblue uppercase mb-3">Ban Lãnh Đạo</h2>
				<div class="w-20 h-1 bg-teal"></div>
			</div>
			<div class="grid grid-cols-1 md:grid-cols-2 gap-12">
				<?php foreach ( $leaders as $leader ) :
					$portrait    = $leader['leader_portrait']['url'] ?? '';
					$bg_photo    = $leader['leader_bg_photo']['url'] ?? '';
					$bg_photo_url = $bg_photo ?: 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=800&auto=format&fit=crop';
				?>
				<div class="relative rounded-2xl overflow-hidden shadow-xl" style="min-height: 420px;">
					<img src="<?php echo esc_url( $bg_photo_url ); ?>" alt="" class="absolute inset-0 w-full h-full object-cover">
					<div class="absolute inset-0 bg-gradient-to-t from-darkblue/90 via-darkblue/40 to-transparent"></div>
					<div class="absolute bottom-0 left-0 right-0 p-8 flex items-end gap-6">
						<?php if ( $portrait ) : ?>
						<img src="<?php echo esc_url( $portrait ); ?>" alt="<?php echo esc_attr( $leader['leader_name'] ); ?>"
						     class="w-20 h-20 rounded-full object-cover border-2 border-teal flex-shrink-0">
						<?php endif; ?>
						<div class="text-white">
							<h3 class="text-2xl font-black uppercase"><?php echo esc_html( $leader['leader_name'] ); ?></h3>
							<p class="text-teal font-bold uppercase tracking-widest text-xs mb-2"><?php echo esc_html( $leader['leader_title'] ); ?></p>
							<?php if ( ! empty( $leader['leader_bio'] ) ) : ?>
							<p class="text-white/80 font-body text-sm leading-relaxed"><?php echo nl2br( esc_html( $leader['leader_bio'] ) ); ?></p>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<!-- Members Section -->
	<?php
	$members_query = new WP_Query( array(
		'post_type'      => 'members',
		'posts_per_page' => -1,
		'orderby'        => 'meta_value_num',
		'meta_key'       => 'member_order',
		'order'          => 'ASC',
		'post_status'    => 'publish',
	) );
	if ( $members_query->have_posts() ) :
	?>
	<section class="overflow-hidden" id="members">
		<div class="max-w-5xl mx-auto px-6 lg:px-8 pt-16 pb-20">

			<!-- Section label -->
			<p class="font-sans font-black uppercase text-white mb-10" style="letter-spacing:0.45em; font-size:0.8rem;">MEMBERS</p>

			<!-- Member cards -->
			<div class="space-y-6">
				<?php while ( $members_query->have_posts() ) : $members_query->the_post();
					$portrait     = function_exists( 'get_field' ) ? get_field( 'member_portrait' ) : null;
					$bg           = function_exists( 'get_field' ) ? get_field( 'member_bg_photo' ) : null;
					$portrait_url = $portrait['url'] ?? '';
					$bg_url       = $bg['url'] ?? '';
					$title_role   = function_exists( 'get_field' ) ? get_field( 'member_title' ) : '';
					$bio          = function_exists( 'get_field' ) ? get_field( 'member_bio' ) : '';
				?>
				<div class="relative overflow-hidden" style="min-height:480px;">

					<!-- Background: optional image or teal gradient -->
					<?php if ( $bg_url ) : ?>
					<img src="<?php echo esc_url( $bg_url ); ?>" alt="" class="absolute inset-0 w-full h-full object-cover">
					<div class="absolute inset-0" style="background:linear-gradient(135deg,rgba(42,157,143,0.8) 0%,rgba(26,34,81,0.55) 100%);"></div>
					<?php else : ?>
					<div class="absolute inset-0" style="background:linear-gradient(160deg,#2A9D8F 0%,#1a7a6a 30%,#16655a 52%,#1e3d6e 100%);"></div>
					<?php endif; ?>

					<!-- Portrait (left, bottom-aligned) -->
					<?php if ( $portrait_url ) : ?>
					<div class="absolute bottom-0 left-0" style="width:40%;height:88%;">
						<img src="<?php echo esc_url( $portrait_url ); ?>"
						     alt="<?php echo esc_attr( get_the_title() ); ?>"
						     class="w-full h-full object-cover object-top">
					</div>
					<?php endif; ?>

					<!-- Dark blue info panel (right side, bottom portion) -->
					<div class="absolute" style="left:42%;right:0;bottom:0;top:28%;background:#1A2251;padding:2.5rem 3rem;">
						<h3 class="font-serif italic font-bold mb-1" style="font-size:1.8rem;color:#2A9D8F;">
							<?php the_title(); ?>
						</h3>
						<?php if ( $title_role ) : ?>
						<p class="font-sans font-black uppercase text-white" style="font-size:0.65rem;letter-spacing:0.18em;">
							<?php echo esc_html( $title_role ); ?>
						</p>
						<?php endif; ?>
						<div style="border-top:1px solid rgba(255,255,255,0.35);margin:1rem 0;"></div>
						<?php if ( $bio ) : ?>
						<p class="font-body text-sm leading-relaxed" style="color:rgba(255,255,255,0.82);">
							<?php echo nl2br( esc_html( $bio ) ); ?>
						</p>
						<?php endif; ?>
					</div>

				</div>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<!-- Trusted By Section -->
	<?php
	$trusted_by = function_exists( 'get_field' ) ? get_field( 'trusted_by', 'option' ) : array();
	if ( ! empty( $trusted_by ) ) :
	?>
	<section class="py-20 bg-white">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="mb-12 text-center">
				<h2 class="text-4xl font-black text-darkblue uppercase mb-3">Đối Tác Tin Tưởng</h2>
				<div class="w-20 h-1 bg-teal mx-auto"></div>
			</div>
			<div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-5 gap-8 items-center">
				<?php foreach ( $trusted_by as $partner ) :
					$logo_url = $partner['partner_logo']['url'] ?? '';
					if ( ! $logo_url ) continue;
				?>
				<div class="flex items-center justify-center p-4 grayscale hover:grayscale-0 opacity-70 hover:opacity-100 transition-all duration-300">
					<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $partner['partner_name'] ); ?>"
					     class="max-h-16 w-auto object-contain">
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

</div>

<?php get_footer();
