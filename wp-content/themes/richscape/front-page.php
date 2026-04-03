<?php
/**
 * The front page template file
 */

get_header(); ?>

<?php echo do_shortcode( '[richscape_banner_slider]' ); ?>

<!-- Vision, Mission & Core Values Section -->
<section class="py-20 bg-darkblue text-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            
            <!-- Left Column: Vision & Mission -->
            <div class="space-y-12">
                <div>
                    <h2 class="font-serif italic text-3xl md:text-4xl text-teal mb-4 capitalize">Tầm nhìn</h2>
                    <p class="text-gray-300 font-body leading-relaxed">
                        Trở thành công ty thiết kế và thi công cảnh quan hàng đầu tại Việt Nam, mang lại những giá trị bền vững và không gian sống hoàn hảo, gần gũi với thiên nhiên cho mọi khách hàng.
                    </p>
                </div>
                <div>
                    <h2 class="font-serif italic text-3xl md:text-4xl text-teal mb-4 capitalize">Sứ mệnh</h2>
                    <p class="text-gray-300 font-body leading-relaxed">
                        Cam kết cung cấp dịch vụ chuyên nghiệp, sáng tạo và chất lượng vượt trội. Chúng tôi luôn lắng nghe và thấu hiểu để biến mỗi dự án thành một tác phẩm nghệ thuật, đóng góp tích cực vào môi trường sống và cộng đồng.
                    </p>
                </div>
            </div>

            <!-- Right Column: Core Values -->
            <div>
                <h2 class="font-serif italic text-3xl md:text-4xl text-teal mb-8 capitalize">Core Values</h2>
                <div class="space-y-6">
                    <?php 
                    $core_values = [
                        'ĐỔI MỚI SÁNG TẠO' => 'Luôn tiên phong trong các giải pháp thiết kế mới.',
                        'CHẤT LƯỢNG' => 'Đảm bảo tiêu chuẩn cao nhất cho mọi công trình.',
                        'TÔN TRỌNG THIÊN NHIÊN' => 'Phát triển hài hòa và bảo vệ hệ sinh thái.',
                        'KHÁCH HÀNG LÀ TRUNG TÂM' => 'Lắng nghe và đáp ứng mọi nhu cầu của khách hàng.',
                        'ĐÓNG GÓP CỘNG ĐỒNG' => 'Xây dựng môi trường sống xanh, sạch, đẹp cho xã hội.'
                    ];
                    $i = 1;
                    foreach ($core_values as $title => $desc): ?>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full border-2 border-teal text-teal flex items-center justify-center font-bold text-lg mr-4 mt-1">
                            <?php echo $i; ?>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold uppercase tracking-wide mb-1"><?php echo $title; ?></h3>
                            <p class="text-gray-400 font-body text-sm"><?php echo $desc; ?></p>
                        </div>
                    </div>
                    <?php $i++; endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="py-24 bg-white relative">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="text-center mb-16">
			<h3 class="text-teal text-lg font-bold uppercase tracking-widest mb-2">Dịch Vụ</h3>
			<h2 class="text-3xl md:text-5xl font-black text-darkblue capitalize">
				Nâng Tầm Không Gian Sống Của Bạn
			</h2>
		</div>

		<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
			<?php
			$services_query = new WP_Query( array(
				'post_type'      => 'services',
				'posts_per_page' => 4,
				'orderby'        => 'date',
				'order'          => 'ASC'
			) );

            $mock_services = [
                [
                    'title' => 'THIẾT KẾ THI CÔNG CẢNH QUAN',
                    'desc'  => 'Kiến tạo không gian xanh thẩm mỹ, mang đậm dấu ấn riêng với quy trình chuyên nghiệp từ khâu ý tưởng đến khi hoàn thiện thực tế.',
                    'img'   => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=600&auto=format&fit=crop',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-auto" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 22v-7m0-3c0 0-4-2.5-4-6a4 4 0 018 0c0 3.5-4 6-4 6zm-2 10h4"/></svg>',
                ],
                [
                    'title' => 'HỆ THỐNG CHIẾU SÁNG & TƯỚI TỰ ĐỘNG',
                    'desc'  => 'Giải pháp chiếu sáng nghệ thuật và hệ thống tưới thông minh tiết kiệm nước, duy trì cảnh quan xanh tươi bền vững.',
                    'img'   => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&auto=format&fit=crop',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-auto" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.5"><circle cx="12" cy="12" r="4"/><path stroke-linecap="round" d="M12 2v2m0 16v2M4.22 4.22l1.42 1.42m12.72 12.72 1.42 1.42M2 12h2m16 0h2M4.22 19.78l1.42-1.42m12.72-12.72 1.42-1.42"/></svg>',
                ],
                [
                    'title' => 'ĐÀI PHUN NƯỚC, HỒ BƠI & HỒ ÂM',
                    'desc'  => 'Thiết kế và thi công đài phun nước, hồ bơi, hồ cá Koi đạt tiêu chuẩn thẩm mỹ, mang lại không gian thư giãn lý tưởng.',
                    'img'   => 'https://images.unsplash.com/photo-1576941089067-2de3c901e126?w=600&auto=format&fit=crop',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-auto" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3C12 3 6 10 6 15a6 6 0 0012 0c0-5-6-12-6-12z"/><path stroke-linecap="round" d="M9 20c0 0-3 1-3 0m12 0c0 1-3 0-3 0"/></svg>',
                ],
                [
                    'title' => 'BẢO DƯỠNG CẢNH QUAN',
                    'desc'  => 'Dịch vụ chăm sóc định kỳ, cắt tỉa và bảo dưỡng giúp cảnh quan luôn giữ được vẻ đẹp tươi xanh và phát triển bền vững.',
                    'img'   => 'https://images.unsplash.com/photo-1585320806297-9794b3e4aaae?w=600&auto=format&fit=crop',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-auto" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 22C7.5 22 4 18.5 4 14c0-6 8-12 8-12s8 6 8 12c0 4.5-3.5 8-8 8z"/><path stroke-linecap="round" d="M12 22v-9"/></svg>',
                ],
            ];

            $count = 1;

			if ( $services_query->have_posts() ) :
				while ( $services_query->have_posts() ) : $services_query->the_post();
					$fallback_imgs = [
						'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=600&auto=format&fit=crop',
						'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&auto=format&fit=crop',
						'https://images.unsplash.com/photo-1576941089067-2de3c901e126?w=600&auto=format&fit=crop',
						'https://images.unsplash.com/photo-1585320806297-9794b3e4aaae?w=600&auto=format&fit=crop',
					];
					$img_url  = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'medium_large' ) : $fallback_imgs[ ($count - 1) % 4 ];
					$icon_url = get_post_meta( get_the_ID(), '_service_icon_url', true );
					$desc     = has_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_content(), 25 );
					?>
					<!-- Service Card -->
					<div class="group relative overflow-hidden flex flex-col border border-white/20 transition-transform duration-300 hover:-translate-y-1"
					     style="background: linear-gradient(135deg, #1A2251 0%, #2A9D8F 100%); min-height: 500px; border-radius: 28px;">

						<!-- Top: title left, icon+number right -->
						<div class="relative pt-6 px-5 pb-3">
							<div class="flex items-start">
								<!-- Title -->
								<h3 class="flex-1 text-white font-sans font-bold uppercase text-2xl leading-tight" style="min-height: 90px; padding-right: 56px;">
									<?php the_title(); ?>
								</h3>
								<!-- Icon -->
								<?php if ( $icon_url ) : ?>
								<div class="absolute" style="top: 24px; right: 52px; width: 44px;">
									<img src="<?php echo esc_url( $icon_url ); ?>" alt="" style="width: 44px; height: auto; object-fit: contain; opacity: 0.9;">
								</div>
								<?php endif; ?>
								<!-- Number -->
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
					<?php
                    $count++;
				endwhile;
				wp_reset_postdata();
			else :
                foreach ($mock_services as $index => $ms) {
                    ?>
                    <!-- Service Card -->
					<div class="group relative overflow-hidden flex flex-col border border-white/20 transition-transform duration-300 hover:-translate-y-1"
					     style="background: linear-gradient(135deg, #1A2251 0%, #2A9D8F 100%); min-height: 500px; border-radius: 28px;">

						<!-- Top: title left, icon+number right -->
						<div class="relative pt-6 px-5 pb-3">
							<div class="flex items-start">
								<!-- Title -->
								<h3 class="flex-1 text-white font-sans font-bold uppercase text-2xl leading-tight" style="min-height: 90px; padding-right: 56px;">
									<?php echo esc_html( $ms['title'] ); ?>
								</h3>
								<!-- Icon -->
								<div class="absolute" style="top: 24px; right: 52px; width: 44px;">
									<?php echo $ms['icon']; ?>
								</div>
								<!-- Number -->
								<div class="absolute" style="top: 12px; right: 16px;">
									<span class="font-serif leading-none font-normal" style="font-size: 52px; color: #2A9D8F; line-height: 1;"><?php echo $index + 1; ?></span>
								</div>
							</div>
						</div>

						<!-- Description -->
						<div class="px-5 pb-4">
							<p class="text-white/80 font-body text-sm leading-relaxed"><?php echo esc_html( $ms['desc'] ); ?></p>
						</div>

						<!-- Photo -->
						<div class="mx-2 mb-1 rounded-2xl overflow-hidden flex-grow" style="min-height: 240px;">
							<img src="<?php echo esc_url( $ms['img'] ); ?>"
							     alt="<?php echo esc_attr( $ms['title'] ); ?>"
							     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
						</div>

						<!-- CTA -->
						<div class="flex justify-center py-4">
							<a href="#"
							   class="font-sans font-bold text-xs uppercase tracking-widest px-6 py-2 rounded-full hover:opacity-80 transition-opacity duration-300"
							   style="background-color: #2A9D8F; color: #1A2251; text-decoration: underline;">
								DỰ ÁN LIÊN QUAN
							</a>
						</div>
					</div>
                    <?php
                }
			endif;
			?>
		</div>
	</div>
</section>

<!-- Projects Section -->
<section id="projects" class="py-24 bg-gray-50">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		
		<div class="text-center mb-16">
			<h3 class="text-teal text-lg font-bold uppercase tracking-widest mb-2">Dự Án Tiêu Biểu</h3>
			<h2 class="text-3xl md:text-5xl font-black text-darkblue capitalize">
				Các Dự Án Tâm Huyết Của Chúng Tôi
			</h2>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
			<?php
			$projects_query = new WP_Query( array(
				'post_type'      => 'projects',
				'posts_per_page' => 4,
			) );

            $mock_projects = ['POLARIS - RESORT', 'MVILLAGE - TÚ XƯƠNG', 'SUMMER SEA - RESORT', 'MVILLAGE - THI SÁCH'];

			if ( $projects_query->have_posts() ) :
				while ( $projects_query->have_posts() ) : $projects_query->the_post();
					$img_url = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'large' ) : 'https://images.unsplash.com/photo-1598257006458-087169a1f08d?q=80&w=800&auto=format&fit=crop';
					?>
					<!-- Project Card -->
					<div class="group relative rounded-2xl overflow-hidden shadow-xl aspect-[4/3] md:aspect-[16/9] bg-darkblue cursor-pointer">
						<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110 opacity-90 group-hover:opacity-100">
						
						<!-- Gradient Overlay -->
						<div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black/90 to-transparent"></div>
						
						<div class="absolute bottom-6 left-6 right-6">
							<h3 class="text-2xl md:text-3xl font-black uppercase text-white tracking-wide"><?php the_title(); ?></h3>
                            <a href="<?php the_permalink(); ?>" class="inline-flex mt-3 text-teal items-center font-bold text-sm uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform translate-y-2 group-hover:translate-y-0">
                                Xem Dự Án <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
						</div>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
			else :
                foreach ($mock_projects as $mp) {
                    ?>
                    <div class="group relative rounded-2xl overflow-hidden shadow-xl aspect-[4/3] md:aspect-[16/9] bg-darkblue cursor-pointer">
						<img src="https://images.unsplash.com/photo-1598257006458-087169a1f08d?q=80&w=800&auto=format&fit=crop" alt="<?php echo $mp; ?>" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110 opacity-90 group-hover:opacity-100">
						<div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black/90 to-transparent"></div>
						<div class="absolute bottom-6 left-6 right-6">
							<h3 class="text-2xl md:text-3xl font-black uppercase text-white tracking-wide"><?php echo $mp; ?></h3>
                            <a href="#" class="inline-flex mt-3 text-teal items-center font-bold text-sm uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                                Xem Dự Án <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
						</div>
					</div>
                    <?php
                }
			endif;
			?>
		</div>

        <div class="text-center">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'projects' ) ); ?>" class="inline-flex items-center justify-center px-12 py-4 text-sm font-bold tracking-widest text-darkblue bg-gray-200 rounded-full hover:bg-teal hover:text-white transition-all duration-300 uppercase shadow-md">
                Xem Tất Cả
            </a>
        </div>
	</div>
</section>

<?php
get_footer();
