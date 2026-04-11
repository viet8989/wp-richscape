<?php
/**
 * Template Name: Liên Hệ
 * The Contact page template.
 */

get_header();

$phone    = function_exists( 'get_field' ) ? get_field( 'contact_phone',   'option' ) : '';
$email    = function_exists( 'get_field' ) ? get_field( 'contact_email',   'option' ) : '';
$address  = function_exists( 'get_field' ) ? get_field( 'contact_address', 'option' ) : '';
$maps_url = function_exists( 'get_field' ) ? get_field( 'maps_embed_url' ) : '';

$phone   = $phone   ?: '0937 430 701';
$email   = $email   ?: 'Khanhbui@Richscape.vn';
$address = $address ?: '13/3A, Đường 15, Bình Trưng Tây, TP. HCM';

// Resolve map coordinates: ACF → Nominatim geocode (cached 7 days) → fallback
$acf_lat = function_exists( 'get_field' ) ? get_field( 'map_lat', 'option' ) : '';
$acf_lng = function_exists( 'get_field' ) ? get_field( 'map_lng', 'option' ) : '';

if ( $acf_lat && $acf_lng ) {
	$map_lat = (float) $acf_lat;
	$map_lng = (float) $acf_lng;
} else {
	$map_lat   = 10.789279402769392;
	$map_lng   = 106.75738773913484;
	$cache_key = 'richscape_geocode_' . md5( $address );
	$cached    = get_transient( $cache_key );
	if ( $cached ) {
		$map_lat = $cached['lat'];
		$map_lng = $cached['lng'];
	} else {
		$geo = wp_remote_get(
			'https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' . rawurlencode( $address ),
			array( 'headers' => array( 'User-Agent' => 'Richscape/1.0 (contact@richscape.vn)' ) )
		);
		if ( ! is_wp_error( $geo ) ) {
			$data = json_decode( wp_remote_retrieve_body( $geo ), true );
			if ( ! empty( $data[0] ) ) {
				$map_lat = (float) $data[0]['lat'];
				$map_lng = (float) $data[0]['lon'];
				set_transient( $cache_key, array( 'lat' => $map_lat, 'lng' => $map_lng ), DAY_IN_SECONDS * 7 );
			}
		}
	}
}

// Handle form submission
$form_sent  = false;
$form_error = false;
if ( isset( $_POST['richscape_contact_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['richscape_contact_nonce'] ) ), 'richscape_send_contact' ) ) {
	$sender_name  = sanitize_text_field( wp_unslash( $_POST['contact_name']    ?? '' ) );
	$sender_email = sanitize_email( wp_unslash( $_POST['contact_email_field'] ?? '' ) );
	$sender_phone = sanitize_text_field( wp_unslash( $_POST['contact_phone_field'] ?? '' ) );
	$message      = sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ?? '' ) );

	if ( $sender_name && $sender_email && $message ) {
		$to      = get_option( 'admin_email' );
		$subject = '[Richscape] Tin nhắn từ ' . $sender_name;
		$body    = "Họ tên: {$sender_name}\nEmail: {$sender_email}\nSĐT: {$sender_phone}\n\nNội dung:\n{$message}";
		$headers = array( 'Content-Type: text/plain; charset=UTF-8', "Reply-To: {$sender_email}" );
		wp_mail( $to, $subject, $body, $headers );
		$form_sent = true;
	} else {
		$form_error = true;
	}
}
?>

<div class="pt-32">

	<?php
	set_query_var( 'breadcrumbs', array(
		array( 'label' => 'Trang Chủ', 'url' => home_url( '/' ) ),
		array( 'label' => 'Liên Hệ' ),
	) );
	get_template_part( 'template-parts/section-breadcrumb' );
	?>

	<section class="py-16 bg-white">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<!-- <div class="mb-12">
				<h1 class="text-4xl md:text-5xl font-black text-darkblue uppercase mb-3">Liên Hệ</h1>
				<div class="w-20 h-1 bg-teal"></div>
			</div> -->

			<div class="grid grid-cols-1 lg:grid-cols-2 gap-16">

				<!-- Contact Info Card -->
				<!-- <div class="rounded-2xl p-10 flex flex-col gap-8" style="background-color: #1A3A6B;"> -->
				<div class="p-10 flex flex-col gap-8" style="background-color: #1A3A6B;">
					<div>
						<p class="text-teal uppercase tracking-widest text-sm font-semibold mb-2">Address</p>
						<p class="text-white text-xl font-semibold leading-snug"><?php echo esc_html( $address ); ?></p>
					</div>
					<div>
						<p class="text-teal uppercase tracking-widest text-sm font-semibold mb-2">Phone</p>
						<p class="text-white text-xl font-semibold"><?php echo esc_html( $phone ); ?></p>
					</div>
					<div>
						<p class="text-teal uppercase tracking-widest text-sm font-semibold mb-2">Email</p>
						<p class="text-white text-xl font-semibold"><?php echo esc_html( $email ); ?></p>
					</div>
				</div>


				<!-- Leaflet Map -->
				<div>
					<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
					<div id="richscape-map" class="overflow-hidden shadow-xl" style="height: 520px;"></div>
					<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
					<script>
					(function () {
						var lat     = <?php echo (float) $map_lat; ?>;
						var lng     = <?php echo (float) $map_lng; ?>;
						var address = <?php echo wp_json_encode( $address ); ?>;
						var phone   = <?php echo wp_json_encode( $phone ); ?>;
						var email   = <?php echo wp_json_encode( $email ); ?>;

						var map = L.map('richscape-map').setView([lat, lng], 17);

						L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
							attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
						}).addTo(map);

						var marker = L.marker([lat, lng]).addTo(map);
						marker.bindPopup(
							'<strong style="color:#1A2251;font-size:13px;">RICHSCAPE</strong>' +
							'<br><span style="color:#555;font-size:12px;">' + address + '</span>' +
							'<br><span style="color:#2A9D8F;font-size:12px;">' + phone + '</span>' +
							'<br><span style="color:#555;font-size:12px;">' + email + '</span>',
							{ maxWidth: 220 }
						).openPopup();
					})();
					</script>
				</div>
			</div>
		</div>
	</section>
</div>

<?php get_footer();
