<?php
/**
 * Template Part: About Card
 * Used in: front-page.php, page-about.php
 * Displays gradient card (left half) with tagline and intro text from ACF Options.
 */

$tagline = function_exists( 'get_field' ) ? get_field( 'about_tagline_en', 'option' ) : '';
$intro   = function_exists( 'get_field' ) ? get_field( 'about_intro_vi',   'option' ) : '';

$tagline = $tagline ?: 'As Landscape Creators, We Bring Your Green Visions To Life.';
$intro   = $intro   ?: 'Được thành lập vào năm 2020, RichScape Landscape Design & Build Ltd. là đơn vị chuyên cung cấp các giải pháp thiết kế và thi công cảnh quan toàn diện. Với đội ngũ kiến trúc sư và chuyên gia tầm huyết, chúng tôi biến những ý tưởng sáng tạo thành các không gian sống xanh, bền vững và mang đậm dấu ấn thẩm mỹ riêng biệt. Sự am hiểu sâu sắc về kiến trúc cảnh quan và hệ sinh thái tự nhiên giúp RichScape luôn mang đến những công trình vượt ra ngoài sự mong đợi.';
?>
<section id="about" class="about-section-overlap">
	<div class="about-card-inner">
		<span class="font-sans font-bold uppercase tracking-widest text-xs mb-6 block" style="color: #2A9D8F; letter-spacing: 0.15em;">VỀ CHÚNG TÔI</span>
		<p class="font-sans font-bold text-xl leading-snug mb-6"><?php echo nl2br( esc_html( $tagline ) ); ?></p>
		<p class="font-body text-sm leading-relaxed mb-10" style="color: rgba(255,255,255,0.8);"><?php echo nl2br( esc_html( $intro ) ); ?></p>
		<p class="font-sans font-bold uppercase text-xs text-center" style="color: rgba(255,255,255,0.45); letter-spacing: 0.25em;">LANDSCAPE CREATOR</p>
	</div>
</section>
