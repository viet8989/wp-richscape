<?php
/**
 * Import Demo Data for Richscape Theme
 */

function richscape_import_demo_data() {
    // Check if demo data has already been imported
    if ( get_option( 'richscape_demo_imported' ) ) {
        return;
    }

    $services_data = array(
        array(
            'title' => 'THIẾT KẾ THI CÔNG CẢNH QUAN',
            'content' => 'Giải pháp toàn diện và chuyên nghiệp giúp nâng tầm vẻ đẹp tự nhiên cho không gian sống của bạn.',
            'excerpt' => 'Giải pháp toàn diện và chuyên nghiệp giúp nâng tầm vẻ đẹp tự nhiên cho không gian.'
        ),
        array(
            'title' => 'HỆ THỐNG CHIẾU SÁNG & TƯỚI TỰ ĐỘNG',
            'content' => 'Chúng tôi cung cấp hệ thống chiếu sáng nghệ thuật và giải pháp tưới tự động thông minh giúp duy trì cảnh quan xanh tươi.',
            'excerpt' => 'Hệ thống chiếu sáng nghệ thuật và giải pháp tưới tự động thông minh.'
        ),
        array(
            'title' => 'ĐÀI PHUN NƯỚC, HỒ BƠI & HỒ ÂM',
            'content' => 'Thiết kế và thi công hệ thống đài phun nước, hồ bơi và hồ cá Koi (hồ âm) đạt tiêu chuẩn thẩm mỹ và kỹ thuật cao.',
            'excerpt' => 'Thiết kế và thi công đài phun nước, hồ bơi và hồ cá Koi đạt chuẩn.'
        ),
        array(
            'title' => 'BẢO DƯỠNG CẢNH QUAN',
            'content' => 'Dịch vụ chăm sóc, bảo dưỡng định kỳ giúp cảnh quan luôn giữ được vẻ đẹp nguyên bản và phát triển bền vững.',
            'excerpt' => 'Dịch vụ chăm sóc định kỳ giúp cảnh quan luôn giữ được vẻ đẹp nguyên bản.'
        )
    );

    $projects_data = array(
        array(
            'title' => 'POLARIS - RESORT',
            'content' => 'Dự án thiết kế cảnh quan nghỉ dưỡng cao cấp tại Polaris Resort, mang lại không gian thư giãn tuyệt đối hài hòa với thiên nhiên.',
            'excerpt' => 'Dự án cảnh quan nghỉ dưỡng cao cấp tại Polaris Resort.'
        ),
        array(
            'title' => 'MVILLAGE - TÚ XƯƠNG',
            'content' => 'Không gian sống xanh mát, hiện đại dành cho cộng đồng cư dân tinh hoa tại Mvillage Tú Xương.',
            'excerpt' => 'Không gian sống xanh mát, hiện đại tại Mvillage Tú Xương.'
        ),
        array(
            'title' => 'SUMMER SEA - RESORT',
            'content' => 'Khu nghỉ dưỡng ven biển đẳng cấp với thiết kế cảnh quan mở, tận dụng tối đa ánh sáng và gió biển tự nhiên.',
            'excerpt' => 'Khu nghỉ dưỡng ven biển đẳng cấp với thiết kế cảnh quan mở.'
        ),
        array(
            'title' => 'MVILLAGE - THI SÁCH',
            'content' => 'Dự án cảnh quan đô thị tại Mvillage Thi Sách, kiến tạo môi trường sống trong lành giữa lòng thành phố nhộn nhịp.',
            'excerpt' => 'Dự án cảnh quan đô thị kiến tạo môi trường sống trong lành.'
        )
    );

    // Insert Services
    foreach ( $services_data as $index => $service ) {
        $post_data = array(
            'post_title'    => $service['title'],
            'post_content'  => $service['content'],
            'post_excerpt'  => $service['excerpt'],
            'post_status'   => 'publish',
            'post_type'     => 'services',
            'post_author'   => 1,
            'menu_order'    => $index
        );
        $post_id = wp_insert_post( $post_data );
        
        // You would typically simulate attaching a placeholder image here if needed
        // For now, post is created without thumbnail, relying on the theme's fallback image
    }

    // Insert Projects
    foreach ( $projects_data as $index => $project ) {
        $post_data = array(
            'post_title'    => $project['title'],
            'post_content'  => $project['content'],
            'post_excerpt'  => $project['excerpt'],
            'post_status'   => 'publish',
            'post_type'     => 'projects',
            'post_author'   => 1,
            'menu_order'    => $index
        );
        $post_id = wp_insert_post( $post_data );
        
        // Thumbnail handling could go here
    }

    // Create Main Navigation Menu
    $menu_name = 'Main Navigation Demo';
    $menu_location = 'primary';
    $menu_exists = wp_get_nav_menu_object( $menu_name );

    if ( ! $menu_exists ) {
        $menu_id = wp_create_nav_menu( $menu_name );

        $menu_items = array(
            'TRANG CHỦ'           => home_url( '/' ),
            'VỀ CHÚNG TÔI'        => '#about',
            'DỊCH VỤ'             => '#services',
            'DỰ ÁN TIÊU BIỂU'     => '#projects',
            'THÔNG TIN - BẢN TIN' => '#news',
            'LIÊN HỆ'             => '#contact',
        );

        foreach ( $menu_items as $title => $url ) {
            wp_update_nav_menu_item( $menu_id, 0, array(
                'menu-item-title'  => $title,
                'menu-item-url'    => $url,
                'menu-item-status' => 'publish',
            ) );
        }

        // Assign to the primary theme location
        $locations = get_theme_mod( 'nav_menu_locations' );
        if ( empty( $locations[ $menu_location ] ) ) {
            $locations[ $menu_location ] = $menu_id;
            set_theme_mod( 'nav_menu_locations', $locations );
        }
    }

    // Mark as imported to prevent duplicate imports
    update_option( 'richscape_demo_imported', true );
}

// Hook it to init (or admin_init) so it runs automatically when the site loads
add_action( 'admin_init', 'richscape_import_demo_data' );
