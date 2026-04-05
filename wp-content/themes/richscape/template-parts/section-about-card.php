<?php
/**
 * Template Part: About Card
 * Used in: page-about.php
 * Displays English tagline, Vietnamese intro, logo — all from ACF Options.
 */

$tagline   = function_exists( 'get_field' ) ? get_field( 'about_tagline_en', 'option' ) : '';
$intro     = function_exists( 'get_field' ) ? get_field( 'about_intro_vi',   'option' ) : '';
$logo_data = function_exists( 'get_field' ) ? get_field( 'logo_footer',      'option' ) : null;

$tagline  = $tagline ?: 'As Landscape Creators, We Bring Your Green Visions To Life.';
$intro    = $intro   ?: 'RICHSCAPE mang đến giải pháp thiết kế và thi công cảnh quan chuyên nghiệp – từ ý tưởng đến hiện thực.';
$logo_url = $logo_data['url'] ?? '/wp-content/uploads/logo_footer.png';
$logo_alt = $logo_data['alt'] ?? 'Richscape';
?>
<div class="rounded-2xl overflow-hidden p-8 md:p-12 text-white h-full flex flex-col justify-center" style="background: linear-gradient(135deg, #1A2251 0%, #2A9D8F 100%);">
	<span class="text-teal font-bold uppercase tracking-widest text-sm mb-4 block">VỀ CHÚNG TÔI</span>
	<p class="font-serif text-2xl md:text-3xl font-bold leading-snug mb-6"><?php echo esc_html( $tagline ); ?></p>
	<p class="font-body text-white/80 text-sm leading-relaxed mb-8"><?php echo nl2br( esc_html( $intro ) ); ?></p>
	<div class="flex items-center gap-6">
		<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $logo_alt ); ?>" class="h-12 w-auto opacity-80">
		<span class="text-white/50 font-sans font-bold uppercase tracking-widest text-xs">LANDSCAPE CREATOR</span>
	</div>
</div>
