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
		<div class="mx-auto">

			<!-- Section label -->
			<p class="font-sans font-black uppercase text-white mb-10" style="letter-spacing:0.45em; font-size:0.8rem;">MEMBERS</p>

			<!-- Member cards -->
			<div class="mx-auto" style="width:1115px; margin-bottom:50px;">
				<?php while ( $members_query->have_posts() ) : $members_query->the_post();
					$portrait     = function_exists( 'get_field' ) ? get_field( 'member_portrait' ) : null;
					$bg           = function_exists( 'get_field' ) ? get_field( 'member_bg_photo' ) : null;
					$portrait_url = $portrait['url'] ?? '';
					$bg_url       = $bg['url'] ?? '';
					$title_role   = function_exists( 'get_field' ) ? get_field( 'member_title' ) : '';
					$bio          = function_exists( 'get_field' ) ? get_field( 'member_bio' ) : '';
				?>
				<!-- Card outer: overflow:visible so portrait can overlap upward -->
				<div class="overflow-visible" style="position:relative;">
					<div class="relative overflow-hidden" style="height:510px;">
					<div class="relative overflow-hidden" style="height:200px;background:linear-gradient(360deg,transparent,#2aaf87);z-index:999;">
					</div>
						<?php if ( $bg_url ) : ?>
						<img src="<?php echo esc_url( $bg_url ); ?>" alt=""
						     class="absolute inset-0 w-full h-full object-cover">
						<div class="absolute inset-0"
						     style="background:linear-gradient(135deg,rgba(42,157,143,0.65) 0%,rgba(26,34,81,0.5) 100%);"></div>
						<?php else : ?>
						<div class="absolute inset-0"
						     style="background:linear-gradient(160deg,#2A9D8F 0%,#1a7a6a 30%,#16655a 52%,#1e3d6e 100%);"></div>
						<?php endif; ?>
					</div>

					<!-- Bottom: dark blue row with portrait + text info -->
					<div style="background:#24408e;padding:2rem 2.5rem 2.5rem 4rem;display:flex;align-items:flex-start;gap:2rem;">

						<!-- Portrait: negative margin-top overlaps into top image -->
						<?php if ( $portrait_url ) : ?>
						<div class="flex-shrink-0" style="margin-top:-200px;position:relative;z-index:10;box-shadow:0 8px 32px rgba(0,0,0,0.35); background-image:url('/wp-content/uploads/background-member.png'); background-size:cover; background-position:center;">
							<img src="<?php echo esc_url( $portrait_url ); ?>"
							     alt="<?php echo esc_attr( get_the_title() ); ?>"
							     style="width:100%;object-fit:contain;object-position:bottom;display:block;">
						</div>
						<?php endif; ?>

						<!-- Text info -->
						<div class="text-white" style="padding-top:0.5rem;flex:1;">
							<h3 class="font-serif italic font-bold mb-1" style="font-size:1.8rem;color:#2A9D8F;padding-left:100px">
								<?php the_title(); ?>
							</h3>
							<?php if ( $title_role ) : ?>
							<p class="font-sans font-black uppercase text-white"
							   style="font-size:0.65rem;letter-spacing:0.18em;padding-left:100px;">
								<?php echo esc_html( $title_role ); ?>
							</p>
							<?php endif; ?>
							<div style="border-top:1px solid #fff;margin:1rem 0;"></div>
							<?php if ( $bio ) : ?>
							<p class="font-body text-sm leading-relaxed"
							   style="color:rgba(255,255,255,0.82);padding-left:100px;padding-right:100px;">
								<?php echo nl2br( esc_html( $bio ) ); ?>
							</p>
							<?php endif; ?>
						</div>

					</div>

					<div class="relative overflow-hidden" style="height:200px;background:linear-gradient(180deg,#24408e,#2aaf87);">
					</div>
				</div>
				<?php endwhile; wp_reset_postdata(); ?>
				<div class="relative overflow-hidden" style="height:200px;background:linear-gradient(360deg,transparent,#2aaf87);z-index:999;">
				</div>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<!-- Trusted By Section -->
	<?php
	$logos_base = content_url( '/uploads/customer-logos/' );
	$partner_logos = array(
		array( 'file' => 'tt-group.png',      'name' => 'T&T Group' ),
		array( 'file' => 'tt-capital.png',    'name' => 'TT Capital' ),
		array( 'file' => 'apache.png',        'name' => 'Apache' ),
		array( 'file' => 'newtecons.png',     'name' => 'Newtecons' ),
		array( 'file' => 'hung-loc-phat.png', 'name' => 'Hưng Lộc Phát Group' ),
		array( 'file' => 'unicons.png',       'name' => 'Unicons' ),
		array( 'file' => 'm-village.png',     'name' => 'M Village' ),
		array( 'file' => 'uth.png',           'name' => 'University of Transport Ho Chi Minh City' ),
		array( 'file' => 'kymdan.png',        'name' => 'Kymdan' ),
	);
	?>
	<section class="py-20 bg-white">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="mb-12">
				<h2 class="text-4xl font-bold italic text-darkblue">Trusted by</h2>
			</div>
			<div class="grid grid-cols-2 md:grid-cols-3 gap-x-8 gap-y-16 items-center">
				<?php foreach ( $partner_logos as $logo ) : ?>
				<div class="flex items-center justify-center p-4">
					<img src="<?php echo esc_url( $logos_base . $logo['file'] ); ?>" alt="<?php echo esc_attr( $logo['name'] ); ?>"
					     class="max-h-20 w-auto object-contain">
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

</div>

<?php get_footer();
