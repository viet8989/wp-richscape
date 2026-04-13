<?php
/**
 * The front page template file
 */

get_header(); ?>

<?php echo do_shortcode( '[richscape_banner_slider]' ); ?>

<?php get_template_part( 'template-parts/section-about-card' ); ?>

<?php get_template_part( 'template-parts/section-vision-mission' ); ?>

<!-- Services Section -->
<section id="services" class="py-20 bg-white relative">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="mb-12">
			<h2 class="inline-block text-2xl md:text-3xl font-sans font-bold text-teal uppercase tracking-wide pb-1 border-b-2 border-teal">DỊCH VỤ</h2>
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
					'title' => "THIẾT KẾ\nTHI CÔNG\nCẢNH QUAN",
					'desc'  => 'Kiến tạo không gian xanh thẩm mỹ, mang đậm dấu ấn riêng với quy trình chuyên nghiệp từ khâu ý tưởng đến khi hoàn thiện thực tế.',
					'img'   => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=600&auto=format&fit=crop',
				),
				array(
					'title' => "CHIẾU SÁNG\nTƯỚI TỰ ĐỘNG",
					'desc'  => 'Ứng dụng công nghệ tự động, đảm bảo tiêu chuẩn để tối ưu hóa việc chăm sóc cây trồng, kết hợp nghệ thuật thị giác làm bừng sáng vẻ đẹp cảnh quan mọi thời điểm trong ngày.',
					'img'   => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&auto=format&fit=crop',
				),
				array(
					'title' => "ĐÀI PHUN NƯỚC\nHỒ BƠI\nHỒ CẢNH",
					'desc'  => 'Đội ngũ kỹ sư tư vấn - lắp đặt vào dự án các hạng mục kỹ thuật cảnh quan nước tinh tế, tạo điểm nhấn sinh thái và phong thủy hài hòa.',
					'img'   => 'https://images.unsplash.com/photo-1576941089067-2de3c901e126?w=600&auto=format&fit=crop',
				),
				array(
					'title' => "CHĂM SÓC\nBẢO TRÌ\nCẢNH QUAN",
					'desc'  => 'Duy trì vẻ đẹp bền vững và sức sống tươi tốt cho cảnh quan bằng dịch vụ chăm sóc, cắt tỉa và bảo dưỡng định kỳ tận tâm.',
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
					<div class="group relative overflow-hidden flex flex-col transition-transform duration-300 hover:-translate-y-1"
					     style="background: linear-gradient(180deg, #1A2251 0%, #2A9D8F 100%); border-radius: 32px; height: 100%; border: 1px solid rgba(95,217,195,0.25);">
						<div class="relative pt-7 px-6 pb-2">
							<h3 class="text-white font-sans font-bold uppercase leading-tight"
							    style="min-height: 90px; padding-right: 80px; white-space: pre-line; font-size: 1.35rem;"><?php echo esc_html( $ms['title'] ); ?></h3>
							<!-- Number badge -->
							<div class="absolute" style="top: 14px; right: 10px; line-height: 1;">
								<span class="font-sans font-bold" style="font-size: 72px; color: #5FD9C3; line-height: 1;"><?php echo $index + 1; ?></span>
							</div>
						</div>
						<div class="px-6 pt-1 pb-5">
							<p class="text-white/85 font-body text-xs leading-relaxed"><?php echo esc_html( $ms['desc'] ); ?></p>
						</div>
						<div class="mx-4 mb-6 rounded-2xl overflow-hidden" style="height: 325px; margin-top: auto;">
							<img src="<?php echo esc_url( $ms['img'] ); ?>" alt="<?php echo esc_attr( $ms['title'] ); ?>"
							     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
						</div>
						<div class="flex justify-center pb-6">
							<a href="<?php echo esc_url( get_post_type_archive_link( 'projects' ) ); ?>"
							   class="font-sans font-bold text-[11px] uppercase tracking-widest px-5 py-1.5 rounded-full border transition-colors duration-300"
							   style="border-color: #5FD9C3; color: #5FD9C3; background-color: transparent;">
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
<section id="projects" class="py-20 bg-white">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

		<div class="mb-12">
			<h2 class="inline-block text-2xl md:text-3xl font-sans font-bold text-teal uppercase tracking-wide pb-1 border-b-2 border-teal">DỰ ÁN TIÊU BIỂU</h2>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-12 mb-14">
			<?php
			$projects_query = new WP_Query( array(
				'post_type'      => 'projects',
				'posts_per_page' => 4,
				'orderby'        => 'menu_order date',
				'order'          => 'ASC',
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
					<a href="<?php echo esc_url( get_post_type_archive_link( 'projects' ) ); ?>" class="group block">
						<div class="overflow-hidden rounded-sm aspect-[3/4]">
							<img src="https://images.unsplash.com/photo-1598257006458-087169a1f08d?q=80&w=800&auto=format&fit=crop"
							     alt="<?php echo esc_attr( $mp ); ?>"
							     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
						</div>
						<h3 class="mt-4 text-center font-sans font-bold uppercase text-sm tracking-wide text-teal underline underline-offset-4"><?php echo esc_html( $mp ); ?></h3>
					</a>
					<?php
				endforeach;
			endif;
			?>
		</div>

		<div class="text-center">
			<a href="<?php echo esc_url( get_post_type_archive_link( 'projects' ) ); ?>"
			   class="inline-flex items-center justify-center px-6 py-2 text-[11px] font-sans font-bold tracking-widest text-darkblue bg-white border border-darkblue/30 hover:bg-teal hover:text-white hover:border-teal transition-all duration-300 uppercase">
				XEM TẤT CẢ
			</a>
		</div>
	</div>
</section>

<?php get_footer();
