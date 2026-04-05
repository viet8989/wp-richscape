<?php
/**
 * Template Part: Vision, Mission & Core Values
 * Used in: front-page.php, page-about.php
 * Reads from ACF Options with hardcoded fallbacks.
 */

$vision_text  = function_exists( 'get_field' ) ? get_field( 'vision_text',  'option' ) : '';
$mission_text = function_exists( 'get_field' ) ? get_field( 'mission_text', 'option' ) : '';
$core_values  = function_exists( 'get_field' ) ? get_field( 'core_values',  'option' ) : array();

$vision_text  = $vision_text  ?: 'Trở thành công ty thiết kế và thi công cảnh quan hàng đầu tại Việt Nam, mang lại những giá trị bền vững và không gian sống hoàn hảo, gần gũi với thiên nhiên cho mọi khách hàng.';
$mission_text = $mission_text ?: 'Cam kết cung cấp dịch vụ chuyên nghiệp, sáng tạo và chất lượng vượt trội. Chúng tôi luôn lắng nghe và thấu hiểu để biến mỗi dự án thành một tác phẩm nghệ thuật, đóng góp tích cực vào môi trường sống và cộng đồng.';

if ( empty( $core_values ) ) {
	$core_values = array(
		array( 'cv_title' => 'ĐỔI MỚI SÁNG TẠO',       'cv_description' => 'Luôn tiên phong trong các giải pháp thiết kế mới.' ),
		array( 'cv_title' => 'CHẤT LƯỢNG',               'cv_description' => 'Đảm bảo tiêu chuẩn cao nhất cho mọi công trình.' ),
		array( 'cv_title' => 'TÔN TRỌNG THIÊN NHIÊN',    'cv_description' => 'Phát triển hài hòa và bảo vệ hệ sinh thái.' ),
		array( 'cv_title' => 'KHÁCH HÀNG LÀ TRUNG TÂM', 'cv_description' => 'Lắng nghe và đáp ứng mọi nhu cầu của khách hàng.' ),
		array( 'cv_title' => 'ĐÓNG GÓP CỘNG ĐỒNG',       'cv_description' => 'Xây dựng môi trường sống xanh, sạch, đẹp cho xã hội.' ),
	);
}
?>
<section class="py-20 bg-darkblue text-white relative">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-16">

			<!-- Left Column: Vision & Mission -->
			<div class="space-y-12">
				<div>
					<h2 class="font-serif italic text-3xl md:text-4xl text-teal mb-4 capitalize">Tầm nhìn</h2>
					<p class="text-gray-300 font-body leading-relaxed"><?php echo nl2br( esc_html( $vision_text ) ); ?></p>
				</div>
				<div>
					<h2 class="font-serif italic text-3xl md:text-4xl text-teal mb-4 capitalize">Sứ mệnh</h2>
					<p class="text-gray-300 font-body leading-relaxed"><?php echo nl2br( esc_html( $mission_text ) ); ?></p>
				</div>
			</div>

			<!-- Right Column: Core Values -->
			<div>
				<h2 class="font-serif italic text-3xl md:text-4xl text-teal mb-8 capitalize">Core Values</h2>
				<div class="space-y-6">
					<?php foreach ( $core_values as $i => $cv ) : ?>
					<div class="flex items-start">
						<div class="flex-shrink-0 w-10 h-10 rounded-full border-2 border-teal text-teal flex items-center justify-center font-bold text-lg mr-4 mt-1">
							<?php echo $i + 1; ?>
						</div>
						<div>
							<h3 class="text-xl font-bold uppercase tracking-wide mb-1"><?php echo esc_html( $cv['cv_title'] ); ?></h3>
							<p class="text-gray-400 font-body text-sm"><?php echo esc_html( $cv['cv_description'] ); ?></p>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
