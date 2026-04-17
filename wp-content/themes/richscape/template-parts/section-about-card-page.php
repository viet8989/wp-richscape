<?php
/**
 * Template Part: About Card (Page)
 * Used in: page-about.php
 * Gradient card with logo, tagline and intro text from ACF Options.
 * Matches Canva design: https://testky.my.canva.site/richscape-web/v-chng-ti
 */

$tagline = function_exists( 'get_field' ) ? get_field( 'about_tagline_en', 'option' ) : '';
$intro   = function_exists( 'get_field' ) ? get_field( 'about_intro_vi',   'option' ) : '';

$tagline = $tagline ?: 'As Landscape Creators, We Bring Your Green Visions To Life.';
$intro   = $intro   ?: 'Được thành lập vào năm 2020, RichScape Landscape Design & Build Ltd. là đơn vị chuyên cung cấp các giải pháp thiết kế và thi công cảnh quan toàn diện. Với đội ngũ kiến trúc sư và chuyên gia tầm huyết, chúng tôi biến những ý tưởng sáng tạo thành các không gian sống xanh, bền vững và mang đậm dấu ấn thẩm mỹ riêng biệt. Sự am hiểu sâu sắc về kiến trúc cảnh quan và hệ sinh thái tự nhiên giúp RichScape luôn mang đến những công trình vượt ra ngoài sự mong đợi.';

$logo_header = function_exists( 'get_field' ) ? get_field( 'logo_header', 'option' ) : null;
$logo_url    = $logo_header['url'] ?? '/wp-content/uploads/logo.png';
$logo_alt    = $logo_header['alt'] ?? 'Richscape';
?>
<div class="about-card-wrapper relative overflow-hidden text-white p-8 md:p-10" style="max-width: 420px; background: linear-gradient(90deg, #1A2251 0%, #2A9D8F 100%);">
	<!-- Logo clipped (show only top portion like Canva design) -->
	<div class="mb-6 overflow-hidden flex justify-center" style="height: 63px;">
		<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $logo_alt ); ?>"
		     class="w-auto"
		     style="height: 112px; margin-top: -17px;">
	</div>
	<p class="font-sans font-bold text-lg leading-snug mb-5"><?php echo nl2br( esc_html( $tagline ) ); ?></p>
	<p class="font-body text-sm leading-relaxed mb-8" style="color: rgba(255,255,255,0.85);"><?php echo nl2br( esc_html( $intro ) ); ?></p>
	<p class="font-sans font-bold uppercase text-xs" style="color: rgba(255,255,255,0.5); letter-spacing: 0.25em; text-align: center;">LANDSCAPE CREATOR</p>
</div>
