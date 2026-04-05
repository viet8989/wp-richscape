<?php
/**
 * Template Name: Về Chúng Tôi
 * The About Us page template.
 */

get_header(); ?>

<div class="pt-32">

	<?php
	set_query_var( 'breadcrumbs', array(
		array( 'label' => 'Trang Chủ', 'url' => home_url( '/' ) ),
		array( 'label' => 'Về Chúng Tôi' ),
	) );
	get_template_part( 'template-parts/section-breadcrumb' );
	?>

	<!-- About Card + Intro -->
	<section class="py-16 bg-white">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-stretch">
				<div class="rounded-2xl overflow-hidden" style="min-height: 400px;">
					<?php
					$hero_img = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'large' ) : 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=800&auto=format&fit=crop';
					?>
					<img src="<?php echo esc_url( $hero_img ); ?>" alt="Richscape cảnh quan"
					     class="w-full h-full object-cover">
				</div>
				<?php get_template_part( 'template-parts/section-about-card' ); ?>
			</div>
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
	$members = function_exists( 'get_field' ) ? get_field( 'members' ) : array();
	if ( ! empty( $members ) ) :
	?>
	<section class="py-20 bg-gray-50">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="mb-12">
				<h2 class="text-4xl font-black text-darkblue uppercase mb-3">Đội Ngũ Thành Viên</h2>
				<div class="w-20 h-1 bg-teal"></div>
			</div>
			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
				<?php foreach ( $members as $member ) :
					$portrait_url = $member['member_portrait']['url'] ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&auto=format&fit=crop';
				?>
				<div class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
					<div class="relative overflow-hidden" style="height: 280px;">
						<img src="<?php echo esc_url( $portrait_url ); ?>" alt="<?php echo esc_attr( $member['member_name'] ); ?>"
						     class="w-full h-full object-cover">
					</div>
					<div class="p-6">
						<h3 class="text-xl font-black uppercase text-darkblue"><?php echo esc_html( $member['member_name'] ); ?></h3>
						<p class="text-teal font-bold uppercase tracking-widest text-xs mb-3"><?php echo esc_html( $member['member_title'] ); ?></p>
						<?php if ( ! empty( $member['member_bio'] ) ) : ?>
						<p class="text-gray-600 font-body text-sm leading-relaxed"><?php echo esc_html( $member['member_bio'] ); ?></p>
						<?php endif; ?>
					</div>
				</div>
				<?php endforeach; ?>
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
