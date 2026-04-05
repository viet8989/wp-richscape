<?php
/**
 * The front page template file
 */

get_header(); ?>

<?php echo do_shortcode( '[richscape_banner_slider]' ); ?>

<?php get_template_part( 'template-parts/section-vision-mission' ); ?>

<!-- Services Section -->
<section id="services" class="py-24 bg-white relative">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="mb-16">
			<h2 class="text-4xl md:text-5xl font-black text-darkblue uppercase mb-3">DỊCH VỤ</h2>
			<div class="w-20 h-1 bg-teal"></div>
		</div>

		<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
			<?php
			$services_query = new WP_Query( array(
				'post_type'      => 'services',
				'posts_per_page' => 4,
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
			) );

			$mock_services = array(
				array(
					'title' => 'THIẾT KẾ THI CÔNG CẢNH QUAN',
					'desc'  => 'Kiến tạo không gian xanh thẩm mỹ, mang đậm dấu ấn riêng với quy trình chuyên nghiệp từ khâu ý tưởng đến khi hoàn thiện thực tế.',
					'img'   => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=600&auto=format&fit=crop',
				),
				array(
					'title' => 'HỆ THỐNG CHIẾU SÁNG & TƯỚI TỰ ĐỘNG',
					'desc'  => 'Giải pháp chiếu sáng nghệ thuật và hệ thống tưới thông minh tiết kiệm nước, duy trì cảnh quan xanh tươi bền vững.',
					'img'   => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&auto=format&fit=crop',
				),
				array(
					'title' => 'ĐÀI PHUN NƯỚC, HỒ BƠI & HỒ ÂM',
					'desc'  => 'Thiết kế và thi công đài phun nước, hồ bơi, hồ cá Koi đạt tiêu chuẩn thẩm mỹ, mang lại không gian thư giãn lý tưởng.',
					'img'   => 'https://images.unsplash.com/photo-1576941089067-2de3c901e126?w=600&auto=format&fit=crop',
				),
				array(
					'title' => 'BẢO DƯỠNG CẢNH QUAN',
					'desc'  => 'Dịch vụ chăm sóc định kỳ, cắt tỉa và bảo dưỡng giúp cảnh quan luôn giữ được vẻ đẹp tươi xanh và phát triển bền vững.',
					'img'   => 'https://images.unsplash.com/photo-1585320806297-9794b3e4aaae?w=600&auto=format&fit=crop',
				),
			);

			$count = 1;

			if ( $services_query->have_posts() ) :
				while ( $services_query->have_posts() ) : $services_query->the_post();
					set_query_var( 'service_count', $count );
					get_template_part( 'template-parts/content-service-card' );
					$count++;
				endwhile;
				wp_reset_postdata();
			else :
				foreach ( $mock_services as $index => $ms ) :
					?>
					<div class="group relative overflow-hidden flex flex-col border border-white/20 transition-transform duration-300 hover:-translate-y-1"
					     style="background: linear-gradient(135deg, #1A2251 0%, #2A9D8F 100%); min-height: 500px; border-radius: 28px;">
						<div class="relative pt-6 px-5 pb-3">
							<div class="flex items-start">
								<h3 class="flex-1 text-white font-sans font-bold uppercase text-2xl leading-tight" style="min-height: 90px; padding-right: 56px;">
									<?php echo esc_html( $ms['title'] ); ?>
								</h3>
								<div class="absolute" style="top: 12px; right: 16px;">
									<span class="font-serif leading-none font-normal" style="font-size: 52px; color: #2A9D8F; line-height: 1;"><?php echo $index + 1; ?></span>
								</div>
							</div>
						</div>
						<div class="px-5 pb-4">
							<p class="text-white/80 font-body text-sm leading-relaxed"><?php echo esc_html( $ms['desc'] ); ?></p>
						</div>
						<div class="mx-2 mb-1 rounded-2xl overflow-hidden flex-grow" style="min-height: 240px;">
							<img src="<?php echo esc_url( $ms['img'] ); ?>" alt="<?php echo esc_attr( $ms['title'] ); ?>"
							     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
						</div>
						<div class="flex justify-center py-4">
							<a href="<?php echo esc_url( get_post_type_archive_link( 'projects' ) ); ?>"
							   class="font-sans font-bold text-xs uppercase tracking-widest px-6 py-2 rounded-full hover:opacity-80 transition-opacity duration-300"
							   style="background-color: #2A9D8F; color: #1A2251; text-decoration: underline;">
								DỰ ÁN LIÊN QUAN
							</a>
						</div>
					</div>
					<?php
				endforeach;
			endif;
			?>
		</div>
	</div>
</section>

<!-- Projects Section -->
<section id="projects" class="py-24 bg-gray-50">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

		<div class="mb-16">
			<h2 class="text-4xl md:text-5xl font-black text-darkblue uppercase mb-3">DỰ ÁN TIÊU BIỂU</h2>
			<div class="w-20 h-1 bg-teal"></div>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
			<?php
			$projects_query = new WP_Query( array(
				'post_type'      => 'projects',
				'posts_per_page' => 4,
			) );

			$mock_projects = array( 'POLARIS - RESORT', 'MVILLAGE - TÚ XƯƠNG', 'SUMMER SEA - RESORT', 'MVILLAGE - THI SÁCH' );

			if ( $projects_query->have_posts() ) :
				while ( $projects_query->have_posts() ) : $projects_query->the_post();
					get_template_part( 'template-parts/project-item' );
				endwhile;
				wp_reset_postdata();
			else :
				foreach ( $mock_projects as $mp ) :
					?>
					<div class="group relative rounded-2xl overflow-hidden shadow-xl aspect-[4/3] md:aspect-[16/9] bg-darkblue cursor-pointer">
						<img src="https://images.unsplash.com/photo-1598257006458-087169a1f08d?q=80&w=800&auto=format&fit=crop"
						     alt="<?php echo esc_attr( $mp ); ?>"
						     class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110 opacity-90 group-hover:opacity-100">
						<div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black/90 to-transparent"></div>
						<div class="absolute bottom-6 left-6 right-6">
							<h3 class="text-2xl md:text-3xl font-black uppercase text-white tracking-wide"><?php echo esc_html( $mp ); ?></h3>
						</div>
					</div>
					<?php
				endforeach;
			endif;
			?>
		</div>

		<div class="text-center">
			<a href="<?php echo esc_url( get_post_type_archive_link( 'projects' ) ); ?>"
			   class="inline-flex items-center justify-center px-12 py-4 text-sm font-bold tracking-widest text-darkblue bg-gray-200 rounded-full hover:bg-teal hover:text-white transition-all duration-300 uppercase shadow-md">
				Xem Tất Cả
			</a>
		</div>
	</div>
</section>

<?php get_footer();
