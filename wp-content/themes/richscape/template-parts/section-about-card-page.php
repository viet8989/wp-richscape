<?php
/**
 * Template Part: About Card (Page)
 * Used in: page-about.php
 * Gradient card with logo, tagline and intro text from ACF Options.
 * Matches Canva design: https://testky.my.canva.site/richscape-web/v-chng-ti
 */

$tagline = function_exists( 'get_field' ) ? get_field( 'about_tagline_en', 'option' ) : '';
$intro   = function_exists( 'get_field' ) ? get_field( 'about_intro_vi',   'option' ) : '';

$tagline = $tagline ?: 'As Landscape Creators,<br />We Bring Your Green Visions To Life.';
$intro   = $intro   ?: 'Được thành lập vào năm 2020, RichScape Landscape Design & Build Ltd. là đơn vị chuyên cung cấp các giải pháp thiết kế và thi công cảnh quan toàn diện. Với đội ngũ kiến trúc sư và chuyên gia tầm huyết, chúng tôi biến những ý tưởng sáng tạo thành các không gian sống xanh, bền vững và mang đậm dấu ấn thẩm mỹ riêng biệt. Sự am hiểu sâu sắc về kiến trúc cảnh quan và hệ sinh thái tự nhiên giúp RichScape luôn mang đến những công trình vượt ra ngoài sự mong đợi.';

$logo_header = function_exists( 'get_field' ) ? get_field( 'logo_header', 'option' ) : null;
$logo_url    = $logo_header['url'] ?? '/wp-content/uploads/logo.png';
$logo_alt    = $logo_header['alt'] ?? 'Richscape';
?>
<!-- Box matches Canva design element size: 500.96 x ~376px -->
<div class="about-card-wrapper relative overflow-hidden text-white" style="max-width: 500.96px; height: 376.21px; padding: 28px 46px; background: linear-gradient(90deg, #264191 0%, #02ad83 100%);">
	<!-- Logo: full render at correct size, transparent background -->
	<div class="flex justify-center" style="height: 60px; margin-bottom: 18px;">
		<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $logo_alt ); ?>"
		     class="w-auto object-contain"
		     style="height: 60px;">
	</div>
	<p class="font-utm font-bold text-white" style="font-size: 18px; line-height: 21px; margin-bottom: 12px;"><?php echo wp_kses_post( $tagline ); ?></p>
	<p class="font-display text-justify" style="font-size: 15px; line-height: 18px; margin-bottom: 10px; color: rgba(255,255,255,0.85);"><?php echo nl2br( esc_html( $intro ) ); ?></p>
	<p class="font-pws font-bold uppercase text-white" style="font-size: 11px; letter-spacing: 0.25em; text-align: center;">LANDSCAPE CREATOR</p>
</div>
