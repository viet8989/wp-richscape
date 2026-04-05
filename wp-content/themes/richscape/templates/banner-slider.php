<?php
/**
 * Richscape Banner Slider – HTML template
 *
 * Rendered by the [richscape_banner_slider] shortcode defined in functions.php.
 * Slide data comes from:
 *   1. ACF repeater field 'banner_slides' on any page (preferred).
 *   2. A theme option stored under the option key 'richscape_banner_slides'.
 *   3. Built-in placeholder slides as the final fallback.
 *
 * Expected $slides variable: array of arrays, each with:
 *   'url'  – full image URL
 *   'alt'  – alt text string
 *
 * @var array $slides  Injected by the shortcode callback.
 */

if ( empty( $slides ) || ! is_array( $slides ) ) {
    return;
}
?>

<section
    class="richscape-banner-slider"
    aria-label="<?php esc_attr_e( 'Banner Slider', 'richscape' ); ?>"
>

    <?php /* ── Slide track ─────────────────────────────────── */ ?>
    <div class="rbs-track">
        <?php foreach ( $slides as $index => $slide ) :
            $is_first = ( 0 === $index );
        ?>
        <div
            class="rbs-slide<?php echo $is_first ? ' active' : ''; ?>"
            role="group"
            aria-roledescription="slide"
            aria-label="<?php echo esc_attr( sprintf( __( 'Slide %d of %d', 'richscape' ), $index + 1, count( $slides ) ) ); ?>"
        >
            <img
                src="<?php echo esc_url( $slide['url'] ); ?>"
                alt="<?php echo esc_attr( $slide['alt'] ); ?>"
                <?php echo $is_first ? 'loading="eager"' : 'loading="lazy"'; ?>
                width="1920"
                height="800"
            />
        </div>
        <?php endforeach; ?>
    </div>

    <?php
    // Read overlay text from ACF Options with hardcoded fallbacks
    $rbs_tagline = function_exists( 'get_field' ) ? get_field( 'about_tagline_en', 'option' ) : '';
    $rbs_intro   = function_exists( 'get_field' ) ? get_field( 'about_intro_vi',   'option' ) : '';
    $rbs_tagline = $rbs_tagline ?: 'As Landscape Creators, We Bring Your Green Visions To Life.';
    $rbs_intro   = $rbs_intro   ?: 'RICHSCAPE mang đến giải pháp thiết kế và thi công cảnh quan chuyên nghiệp – từ ý tưởng đến hiện thực.';
    ?>
    <?php /* ── Overlay gradient card (bottom-left) ──────────── */ ?>
    <div class="rbs-overlay-card" aria-hidden="true">
        <span class="rbs-label">VỀ CHÚNG TÔI</span>
        <p class="rbs-tagline"><?php echo nl2br( esc_html( $rbs_tagline ) ); ?></p>
        <p class="rbs-body"><?php echo nl2br( esc_html( $rbs_intro ) ); ?></p>
        <span class="rbs-footer-text">LANDSCAPE CREATOR</span>
    </div>

    <?php /* ── Prev / Next arrow buttons ───────────────────── */ ?>
    <button class="rbs-arrow rbs-prev" aria-label="<?php esc_attr_e( 'Previous slide', 'richscape' ); ?>">&#10094;</button>
    <button class="rbs-arrow rbs-next" aria-label="<?php esc_attr_e( 'Next slide', 'richscape' ); ?>">&#10095;</button>

    <?php /* ── Dot container – buttons injected by JS ─────── */ ?>
    <div class="rbs-dots" role="tablist" aria-label="<?php esc_attr_e( 'Slider navigation', 'richscape' ); ?>"></div>

</section>
