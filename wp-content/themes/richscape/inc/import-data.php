<?php
/**
 * Import Demo Data for Richscape Theme
 */

function richscape_import_demo_data() {
	if ( get_option( 'richscape_demo_imported' ) ) {
		return;
	}

	$services_data = array(
		array(
			'title'   => 'THIẾT KẾ - THI CÔNG - CẢNH QUAN',
			'content' => 'Giải pháp toàn diện và chuyên nghiệp giúp nâng tầm vẻ đẹp tự nhiên cho không gian sống của bạn.',
			'excerpt' => 'Kiến tạo không gian xanh thẩm mỹ, mang đậm dấu ấn riêng với quy trình chuyên nghiệp từ khâu ý tưởng đến khi hoàn thiện thực tế.',
			'sub_items' => array(
				array( 'caption' => 'MASTER PLAN' ),
				array( 'caption' => '3D CONCEPT' ),
				array( 'caption' => 'KHÁI TOÁN' ),
				array( 'caption' => 'HARDSCAPE & CÂY XANH' ),
			),
		),
		array(
			'title'   => 'CHIẾU SÁNG - TƯỚI TỰ ĐỘNG',
			'content' => 'Chúng tôi cung cấp hệ thống chiếu sáng nghệ thuật và giải pháp tưới tự động thông minh giúp duy trì cảnh quan xanh tươi.',
			'excerpt' => 'Ứng dụng công nghệ tự động, đảm bảo tiêu chuẩn để tối ưu hóa việc chăm sóc cây trồng, kết hợp nghệ thuật thị giác làm bừng sáng vẻ đẹp cảnh quan mọi thời điểm trong ngày.',
			'sub_items' => array(
				array( 'caption' => 'KỊCH BẢN CHIẾU SÁNG - HỆ TƯỚI' ),
				array( 'caption' => 'LẮP ĐẶT CHIẾU SÁNG' ),
				array( 'caption' => 'HỆ TƯỚI TỰ ĐỘNG' ),
				array( 'caption' => 'THIẾT BỊ CHÍNH HÃNG, AN TOÀN' ),
			),
		),
		array(
			'title'   => 'ĐÀI PHUN NƯỚC - HỒ BƠI - HỒ CẢNH',
			'content' => 'Thiết kế và thi công hệ thống đài phun nước, hồ bơi và hồ cảnh đạt tiêu chuẩn thẩm mỹ và kỹ thuật cao.',
			'excerpt' => 'Đội ngũ kỹ sư tư vấn - lắp đặt vào dự án các hạng mục kỹ thuật cảnh quan nước tinh tế, tạo điểm nhấn sinh thái và phong thủy hài hòa.',
			'sub_items' => array(
				array( 'caption' => 'THÁC NƯỚC - ĐÀI PHUN NGHỆ THUẬT' ),
				array( 'caption' => 'HỒ BƠI' ),
				array( 'caption' => 'HỒ SINH THÁI' ),
				array( 'caption' => 'HỒ JACUZZI' ),
			),
		),
		array(
			'title'   => 'CHĂM SÓC - BẢO TRÌ - CẢNH QUAN',
			'content' => 'Dịch vụ chăm sóc, bảo dưỡng định kỳ giúp cảnh quan luôn giữ được vẻ đẹp nguyên bản và phát triển bền vững.',
			'excerpt' => 'Duy trì vẻ đẹp bền vững và sức sống tươi tốt cho cảnh quan bằng dịch vụ chăm sóc, cắt tỉa và bảo dưỡng định kỳ tận tâm.',
			'sub_items' => array(
				array( 'caption' => 'CẮT TỈA & TẠO DÁNG ĐỊNH KỲ' ),
				array( 'caption' => 'VỆ SINH CẢNH QUAN' ),
				array( 'caption' => 'BẢO TRÌ HỆ THỐNG BƠM - LỌC' ),
				array( 'caption' => 'DINH DƯỠNG, PHÒNG BỆNH' ),
			),
		),
	);

	$projects_data = array(
		array(
			'title'   => 'POLARIS - RESORT',
			'content' => 'Dự án thiết kế cảnh quan nghỉ dưỡng cao cấp tại Polaris Resort, mang lại không gian thư giãn tuyệt đối hài hòa với thiên nhiên.',
			'excerpt' => 'Dự án cảnh quan nghỉ dưỡng cao cấp tại Polaris Resort.',
		),
		array(
			'title'   => 'MVILLAGE - TÚ XƯƠNG',
			'content' => 'Không gian sống xanh mát, hiện đại dành cho cộng đồng cư dân tinh hoa tại Mvillage Tú Xương.',
			'excerpt' => 'Không gian sống xanh mát, hiện đại tại Mvillage Tú Xương.',
		),
		array(
			'title'   => 'SUMMER SEA - RESORT',
			'content' => 'Khu nghỉ dưỡng ven biển đẳng cấp với thiết kế cảnh quan mở, tận dụng tối đa ánh sáng và gió biển tự nhiên.',
			'excerpt' => 'Khu nghỉ dưỡng ven biển đẳng cấp với thiết kế cảnh quan mở.',
		),
		array(
			'title'   => 'MVILLAGE - THI SÁCH',
			'content' => 'Dự án cảnh quan đô thị tại Mvillage Thi Sách, kiến tạo môi trường sống trong lành giữa lòng thành phố nhộn nhịp.',
			'excerpt' => 'Dự án cảnh quan đô thị kiến tạo môi trường sống trong lành.',
		),
		array(
			'title'   => 'HAPPY HOME PARK',
			'content' => 'Không gian cảnh quan khu đô thị sinh thái Happy Home Park với mảng xanh phủ rộng, hồ cảnh và lối đi bộ thiên nhiên.',
			'excerpt' => 'Khu đô thị sinh thái với mảng xanh phủ rộng và hồ cảnh.',
		),
		array(
			'title'   => 'MVILLAGE - HỘI AN',
			'content' => 'Dự án cảnh quan khu đô thị Mvillage tại Hội An, kết hợp kiến trúc truyền thống với không gian xanh hiện đại.',
			'excerpt' => 'Cảnh quan khu đô thị kết hợp kiến trúc truyền thống và không gian xanh.',
		),
		array(
			'title'   => 'JAPAN GARDEN',
			'content' => 'Thiết kế vườn Nhật Bản thuần túy với tiểu cảnh đá, hồ cá Koi và cây cảnh được tỉa tạo nghệ thuật theo phong cách Zen.',
			'excerpt' => 'Vườn Nhật Bản phong cách Zen với tiểu cảnh đá và hồ cá Koi.',
		),
		array(
			'title'   => 'EMPIRE BALCONY',
			'content' => 'Giải pháp cảnh quan ban công và sân thượng cao cấp cho tòa nhà Empire, biến không gian đô thị thành ốc đảo xanh.',
			'excerpt' => 'Cảnh quan ban công và sân thượng xanh cho tòa nhà cao tầng.',
		),
		array(
			'title'   => 'VANLANG UNIVERSITY',
			'content' => 'Dự án cảnh quan khuôn viên Trường Đại học Văn Lang, tạo môi trường học tập xanh, sáng tạo và truyền cảm hứng.',
			'excerpt' => 'Cảnh quan khuôn viên đại học tạo môi trường học tập xanh, sáng tạo.',
		),
	);

	$news_data = array(
		array(
			'title'   => 'Xu hướng thiết kế cảnh quan 2024: Không gian xanh trong lòng đô thị',
			'content' => 'Thiết kế cảnh quan đô thị ngày càng hướng đến việc tích hợp thiên nhiên vào không gian sống, làm việc và giải trí. Các chuyên gia dự báo năm 2024 sẽ chứng kiến sự bùng nổ của các mảng xanh đứng, vườn thẳng đứng và mái nhà sinh thái.',
			'excerpt' => 'Xu hướng thiết kế cảnh quan 2024 hướng đến tích hợp thiên nhiên vào không gian đô thị với các giải pháp xanh đứng và mái nhà sinh thái.',
		),
		array(
			'title'   => 'Hệ thống tưới thông minh: Tiết kiệm 40% lượng nước cho cảnh quan',
			'content' => 'Công nghệ tưới tự động thông minh tích hợp cảm biến độ ẩm và dự báo thời tiết giúp tối ưu lượng nước sử dụng, giảm chi phí vận hành và duy trì cảnh quan luôn xanh tươi.',
			'excerpt' => 'Hệ thống tưới tự động thông minh giúp tiết kiệm đến 40% lượng nước trong khi vẫn duy trì cảnh quan tươi tốt.',
		),
		array(
			'title'   => 'Richscape hoàn thành dự án cảnh quan Polaris Resort',
			'content' => 'Sau 8 tháng thi công, Richscape đã hoàn thành và bàn giao thành công dự án thiết kế cảnh quan cho Polaris Resort. Công trình bao gồm hệ thống hồ bơi tràn bờ, vườn nhiệt đới và hệ thống chiếu sáng nghệ thuật.',
			'excerpt' => 'Richscape hoàn thành dự án cảnh quan Polaris Resort với hồ bơi tràn bờ, vườn nhiệt đới và chiếu sáng nghệ thuật.',
		),
		array(
			'title'   => 'Tầm quan trọng của cây xanh trong thiết kế đô thị hiện đại',
			'content' => 'Nghiên cứu cho thấy các khu đô thị có mật độ cây xanh cao giúp giảm nhiệt độ môi trường 3-5°C, cải thiện chất lượng không khí và tăng giá trị bất động sản lên đến 15%.',
			'excerpt' => 'Cây xanh trong đô thị không chỉ làm đẹp mà còn giảm nhiệt độ, cải thiện không khí và tăng giá trị bất động sản.',
		),
		array(
			'title'   => 'Hướng dẫn chăm sóc cảnh quan mùa khô: Bí quyết giữ xanh cho khu vườn',
			'content' => 'Mùa khô là thách thức lớn với mọi khu vườn. Richscape chia sẻ những bí quyết chăm sóc và bảo dưỡng cảnh quan trong điều kiện khô hạn, từ lịch tưới tối ưu đến lựa chọn loại cây phù hợp.',
			'excerpt' => 'Những bí quyết từ chuyên gia Richscape để duy trì cảnh quan xanh tươi và khỏe mạnh trong mùa khô.',
		),
	);

	// Insert Services
	foreach ( $services_data as $index => $service ) {
		$existing = get_page_by_title( $service['title'], OBJECT, 'services' );
		if ( $existing ) {
			// Update sub_items if service exists but has no sub_items
			$existing_items = get_post_meta( $existing->ID, '_service_sub_items', true );
			if ( empty( $existing_items ) && ! empty( $service['sub_items'] ) ) {
				$sub_items = array();
				foreach ( $service['sub_items'] as $item ) {
					$sub_items[] = array(
						'image_id' => 0,
						'caption'  => $item['caption'] ?? '',
					);
				}
				update_post_meta( $existing->ID, '_service_sub_items', $sub_items );
			}
			continue;
		}
		$post_id = wp_insert_post( array(
			'post_title'   => $service['title'],
			'post_content' => $service['content'],
			'post_excerpt' => $service['excerpt'],
			'post_status'  => 'publish',
			'post_type'    => 'services',
			'post_author'  => 1,
			'menu_order'   => $index,
		) );

		// Save sub_items meta
		if ( $post_id && ! is_wp_error( $post_id ) && ! empty( $service['sub_items'] ) ) {
			$sub_items = array();
			foreach ( $service['sub_items'] as $item ) {
				$sub_items[] = array(
					'image_id' => 0,
					'caption'  => $item['caption'] ?? '',
				);
			}
			update_post_meta( $post_id, '_service_sub_items', $sub_items );
		}
	}

	// Insert Projects
	foreach ( $projects_data as $index => $project ) {
		$existing = get_page_by_title( $project['title'], OBJECT, 'projects' );
		if ( $existing ) continue;
		wp_insert_post( array(
			'post_title'   => $project['title'],
			'post_content' => $project['content'],
			'post_excerpt' => $project['excerpt'],
			'post_status'  => 'publish',
			'post_type'    => 'projects',
			'post_author'  => 1,
			'menu_order'   => $index,
		) );
	}

	// Insert Demo News Posts
	foreach ( $news_data as $index => $news ) {
		$existing = get_page_by_title( $news['title'], OBJECT, 'post' );
		if ( $existing ) continue;
		wp_insert_post( array(
			'post_title'   => $news['title'],
			'post_content' => $news['content'],
			'post_excerpt' => $news['excerpt'],
			'post_status'  => 'publish',
			'post_type'    => 'post',
			'post_author'  => 1,
		) );
	}

	// Create Static Pages for navigation
	$pages_to_create = array(
		array( 'title' => 'Về Chúng Tôi', 'slug' => 'about',   'template' => 'page-about.php' ),
		array( 'title' => 'Thông Tin - Bản Tin', 'slug' => 'news',    'template' => 'page-news.php' ),
		array( 'title' => 'Liên Hệ',       'slug' => 'contact', 'template' => 'page-contact.php' ),
		array( 'title' => 'Dịch Vụ',       'slug' => 'services-page', 'template' => 'page-services.php' ),
		array( 'title' => 'Dự Án',         'slug' => 'projects-page', 'template' => 'page-projects.php' ),
	);

	foreach ( $pages_to_create as $page_data ) {
		$existing = get_page_by_path( $page_data['slug'] );
		if ( $existing ) continue;
		$page_id = wp_insert_post( array(
			'post_title'  => $page_data['title'],
			'post_name'   => $page_data['slug'],
			'post_status' => 'publish',
			'post_type'   => 'page',
			'post_author' => 1,
		) );
		if ( $page_id && ! is_wp_error( $page_id ) ) {
			update_post_meta( $page_id, '_wp_page_template', $page_data['template'] );
		}
	}

	// Create Main Navigation Menu
	$menu_name = 'Main Navigation';
	$menu_exists = wp_get_nav_menu_object( $menu_name );

	if ( ! $menu_exists ) {
		$menu_id = wp_create_nav_menu( $menu_name );

		$about_page   = get_page_by_path( 'about' );
		$news_page    = get_page_by_path( 'news' );
		$contact_page = get_page_by_path( 'contact' );

		$menu_items = array(
			'TRANG CHỦ'           => home_url( '/' ),
			'VỀ CHÚNG TÔI'        => $about_page   ? get_permalink( $about_page->ID )   : home_url( '/about/' ),
			'DỊCH VỤ'             => get_post_type_archive_link( 'services' ) ?: home_url( '/services/' ),
			'DỰ ÁN TIÊU BIỂU'    => get_post_type_archive_link( 'projects' ) ?: home_url( '/projects/' ),
			'THÔNG TIN - BẢN TIN' => $news_page    ? get_permalink( $news_page->ID )    : home_url( '/news/' ),
			'LIÊN HỆ'             => $contact_page ? get_permalink( $contact_page->ID ) : home_url( '/contact/' ),
		);

		foreach ( $menu_items as $title => $url ) {
			wp_update_nav_menu_item( $menu_id, 0, array(
				'menu-item-title'  => $title,
				'menu-item-url'    => $url,
				'menu-item-status' => 'publish',
			) );
		}

		$locations = get_theme_mod( 'nav_menu_locations' );
		if ( empty( $locations['primary'] ) ) {
			$locations['primary'] = $menu_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}
	}

	update_option( 'richscape_demo_imported', true );
}

add_action( 'admin_init', 'richscape_import_demo_data' );

/**
 * Sync existing service posts to canonical titles/excerpts when the demo-data
 * version bumps. Guards against re-running with the richscape_data_version
 * option. Bump RICHSCAPE_DATA_VERSION when the canonical map below changes.
 */
function richscape_sync_service_titles() {
	$version         = '2';
	$current_version = get_option( 'richscape_data_version' );
	if ( $current_version === $version ) {
		return;
	}

	$canonical = array(
		'THIẾT KẾ - THI CÔNG - CẢNH QUAN' => array(
			'aliases' => array( 'THIẾT KẾ THI CÔNG CẢNH QUAN' ),
			'excerpt' => 'Kiến tạo không gian xanh thẩm mỹ, mang đậm dấu ấn riêng với quy trình chuyên nghiệp từ khâu ý tưởng đến khi hoàn thiện thực tế.',
		),
		'CHIẾU SÁNG - TƯỚI TỰ ĐỘNG' => array(
			'aliases' => array( 'CHIẾU SÁNG TƯỚI TỰ ĐỘNG' ),
			'excerpt' => 'Ứng dụng công nghệ tự động, đảm bảo tiêu chuẩn để tối ưu hóa việc chăm sóc cây trồng, kết hợp nghệ thuật thị giác làm bừng sáng vẻ đẹp cảnh quan mọi thời điểm trong ngày.',
		),
		'ĐÀI PHUN NƯỚC - HỒ BƠI - HỒ CẢNH' => array(
			'aliases' => array( 'ĐÀI PHUN NƯỚC, HỒ BƠI & HỒ ÂM', 'ĐÀI PHUN NƯỚC, HỒ BƠI & HỒ CẢNH' ),
			'excerpt' => 'Đội ngũ kỹ sư tư vấn - lắp đặt vào dự án các hạng mục kỹ thuật cảnh quan nước tinh tế, tạo điểm nhấn sinh thái và phong thủy hài hòa.',
		),
		'CHĂM SÓC - BẢO TRÌ - CẢNH QUAN' => array(
			'aliases' => array( 'CHĂM SÓC - BẢO TRÌ CẢNH QUAN', 'BẢO DƯỠNG CẢNH QUAN' ),
			'excerpt' => 'Duy trì vẻ đẹp bền vững và sức sống tươi tốt cho cảnh quan bằng dịch vụ chăm sóc, cắt tỉa và bảo dưỡng định kỳ tận tâm.',
		),
	);

	$services = get_posts( array(
		'post_type'      => 'services',
		'posts_per_page' => -1,
		'post_status'    => 'any',
	) );

	foreach ( $services as $post ) {
		foreach ( $canonical as $canonical_title => $meta ) {
			$matches_canonical = $post->post_title === $canonical_title;
			$matches_alias     = in_array( $post->post_title, $meta['aliases'], true );
			if ( ! $matches_canonical && ! $matches_alias ) {
				continue;
			}
			wp_update_post( array(
				'ID'           => $post->ID,
				'post_title'   => $canonical_title,
				'post_excerpt' => $meta['excerpt'],
			) );
			break;
		}
	}

	update_option( 'richscape_data_version', $version );
}
add_action( 'init', 'richscape_sync_service_titles' );
