<?php
/**
 * Template Part: Vision, Mission & Core Values
 * Used in: front-page.php, page-about.php
 * Reads from ACF Options with hardcoded fallbacks.
 */

$vision_text  = function_exists( 'get_field' ) ? get_field( 'vision_text',  'option' ) : '';
$mission_text = function_exists( 'get_field' ) ? get_field( 'mission_text', 'option' ) : '';
$core_values  = function_exists( 'get_field' ) ? get_field( 'core_values',  'option' ) : array();

$vision_text  = $vision_text  ?: 'Richscape mong muốn trở thành đơn vị hàng đầu trong ngành thiết kế và chăm sóc cảnh quan, mang đến không gian sống xanh, bền vững và sáng tạo, nâng cao giá trị thẩm mỹ và chất lượng cuộc sống cho cộng đồng.';
$mission_text = $mission_text ?: 'Richscape cam kết cung cấp các giải pháp cảnh quan chất lượng cao, tận tâm phục vụ khách hàng thông qua việc kết hợp sự sáng tạo, công nghệ hiện đại và phong cách thiết kế tinh tế. Chúng tôi hướng tới việc bảo vệ môi trường và phát triển bền vững, đồng thời mang lại sự hài lòng và niềm vui cho từng không gian chúng tôi tạo ra.';

if ( empty( $core_values ) ) {
	$core_values = array(
		array( 'cv_title' => 'ĐỔI MỚI SÁNG TẠO',       'cv_description' => 'Chúng tôi luôn tìm kiếm những giải pháp thiết kế sáng tạo và bền vững, mang đến không gian sống và làm việc xanh hơn.' ),
		array( 'cv_title' => 'CHẤT LƯỢNG',               'cv_description' => 'Richscape cam kết cung cấp dịch vụ và sản phẩm tiêu chuẩn cao nhất, đảm bảo sự hài lòng của khách hàng.' ),
		array( 'cv_title' => 'TÔN TRỌNG THIÊN NHIÊN',    'cv_description' => 'Chúng tôi bảo vệ và gìn giữ sinh thái, sử dụng những vật liệu và phương pháp xây dựng thân thiện với môi trường.' ),
		array( 'cv_title' => 'KHÁCH HÀNG LÀ TRUNG TÂM', 'cv_description' => 'Chúng tôi lắng nghe và hiểu nhu cầu của khách hàng, cung cấp dịch vụ hoàn hảo và tạo dựng mối quan hệ bền chặt.' ),
		array( 'cv_title' => 'ĐÓNG GÓP CỘNG ĐỒNG',       'cv_description' => 'Chúng tôi tích cực tham gia các hoạt động bảo vệ môi trường và phát triển cộng đồng, tạo giá trị bền vững cho xã hội.' ),
	);
}
?>
<section class="py-20 bg-darkblue text-white relative">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="vm-grid">

			<!-- Left Column: Vision & Mission -->
			<div class="space-y-12">
				<div>
					<h2 class="font-serif italic text-3xl md:text-4xl text-teal mb-4">Vision</h2>
					<p class="text-gray-300 font-body leading-relaxed"><?php echo nl2br( esc_html( $vision_text ) ); ?></p>
				</div>
				<div>
					<h2 class="font-serif italic text-3xl md:text-4xl text-teal mb-4">Mission</h2>
					<p class="text-gray-300 font-body leading-relaxed"><?php echo nl2br( esc_html( $mission_text ) ); ?></p>
				</div>
			</div>

			<!-- Right Column: Core Values -->
			<div>
				<h2 class="font-serif italic text-3xl md:text-4xl text-teal mb-8">Core Values</h2>
				<div class="grid grid-cols-1 md:grid-cols-3 gap-x-6" style="row-gap: 10px;">
					<?php foreach ( $core_values as $i => $cv ) : ?>
					<div class="cv-item">
						<div class="cv-badge"><?php echo $i + 1; ?></div>
						<div class="cv-body">
							<div class="cv-line"></div>
							<div class="cv-text-block">
								<h3 class="text-sm font-bold uppercase tracking-wide text-white mb-2"><?php echo esc_html( $cv['cv_title'] ); ?></h3>
								<p class="font-body text-xs leading-relaxed" style="color: rgba(255,255,255,0.6);"><?php echo esc_html( $cv['cv_description'] ); ?></p>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>

		</div>
	</div>
</section>
