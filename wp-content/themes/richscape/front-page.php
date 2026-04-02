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
                'THIẾT KẾ THI CÔNG CẢNH QUAN',
                'HỆ THỐNG CHIẾU SÁNG & TƯỚI TỰ ĐỘNG',
                'ĐÀI PHUN NƯỚC, HỒ BƠI & HỒ ÂM',
                'BẢO DƯỠNG CẢNH QUAN'
            ];

            $count = 1;

			if ( $services_query->have_posts() ) :
				while ( $services_query->have_posts() ) : $services_query->the_post();
					$img_url = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'medium_large' ) : 'https://images.unsplash.com/photo-1558904541-efa843a96f1d?q=80&w=800&auto=format&fit=crop';
					?>
					<!-- Service Card -->
					<div class="group bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 flex flex-col h-full border border-gray-100">
						
						<div class="h-48 overflow-hidden relative">
							<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute top-4 right-4 text-white font-black text-3xl drop-shadow-lg opacity-80">
                                <?php echo str_pad($count, 2, '0', STR_PAD_LEFT); ?>
                            </div>
						</div>
						
						<div class="p-6 flex-grow flex flex-col items-center text-center">
							<h3 class="text-lg font-bold uppercase text-darkblue tracking-wide mb-3 min-h-[56px]"><?php the_title(); ?></h3>
							
							<div class="text-gray-500 font-body text-sm leading-relaxed mb-6 flex-grow">
								<?php 
								if ( has_excerpt() ) {
									the_excerpt();
								} else {
									echo wp_trim_words( get_the_content(), 15 );
								}
								?>
							</div>
							<a href="<?php the_permalink(); ?>" class="inline-flex items-center text-darkblue bg-gray-50 hover:bg-teal hover:text-white px-5 py-2 rounded-full text-xs font-bold uppercase tracking-widest transition-colors duration-300 mt-auto shadow-sm">
								Dự Án Liên Quan
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
                    <div class="group bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 flex flex-col h-full border border-gray-100">
						<div class="h-48 overflow-hidden relative">
							<img src="https://images.unsplash.com/photo-1584622781867-1c60ccfc428e?q=80&w=800&auto=format&fit=crop" alt="<?php echo $ms; ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute top-4 right-4 text-white font-black text-3xl drop-shadow-lg opacity-80">
                                <?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?>
                            </div>
						</div>
						<div class="p-6 flex-grow flex flex-col items-center text-center">
							<h3 class="text-lg font-bold uppercase text-darkblue tracking-wide mb-3 min-h-[56px]"><?php echo $ms; ?></h3>
							<p class="text-gray-500 font-body text-sm leading-relaxed mb-6 flex-grow">
								Giải pháp toàn diện và chuyên nghiệp giúp nâng tầm vẻ đẹp tự nhiên cho không gian sống của bạn.
							</p>
							<a href="#" class="inline-flex items-center text-darkblue bg-gray-50 hover:bg-teal hover:text-white px-5 py-2 rounded-full text-xs font-bold uppercase tracking-widest transition-colors duration-300 mt-auto shadow-sm">
								Dự Án Liên Quan
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
