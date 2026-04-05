<?php
/**
 * Template Name: Liên Hệ
 * The Contact page template.
 */

get_header();

$phone    = function_exists( 'get_field' ) ? get_field( 'contact_phone',   'option' ) : '';
$email    = function_exists( 'get_field' ) ? get_field( 'contact_email',   'option' ) : '';
$address  = function_exists( 'get_field' ) ? get_field( 'contact_address', 'option' ) : '';
$maps_url = function_exists( 'get_field' ) ? get_field( 'maps_embed_url' )             : '';

$phone   = $phone   ?: '0937 430 701';
$email   = $email   ?: 'Khanhbui@Richscape.vn';
$address = $address ?: '13/3A, Đường 15, Bình Trưng Tây, TP. HCM';

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
			<div class="mb-12">
				<h1 class="text-4xl md:text-5xl font-black text-darkblue uppercase mb-3">Liên Hệ</h1>
				<div class="w-20 h-1 bg-teal"></div>
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-2 gap-16">

				<!-- Contact Info + Form -->
				<div>
					<h2 class="text-2xl font-black text-darkblue uppercase mb-8">Thông Tin Liên Hệ</h2>
					<ul class="space-y-6 font-body mb-12">
						<li class="flex items-start gap-4">
							<div class="w-12 h-12 rounded-full bg-teal flex items-center justify-center flex-shrink-0">
								<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
							</div>
							<div>
								<p class="font-bold text-darkblue uppercase tracking-widest text-xs mb-1">Điện Thoại</p>
								<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>" class="text-gray-700 hover:text-teal transition-colors text-lg"><?php echo esc_html( $phone ); ?></a>
							</div>
						</li>
						<li class="flex items-start gap-4">
							<div class="w-12 h-12 rounded-full bg-teal flex items-center justify-center flex-shrink-0">
								<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
							</div>
							<div>
								<p class="font-bold text-darkblue uppercase tracking-widest text-xs mb-1">Email</p>
								<a href="mailto:<?php echo esc_attr( $email ); ?>" class="text-gray-700 hover:text-teal transition-colors text-lg"><?php echo esc_html( $email ); ?></a>
							</div>
						</li>
						<li class="flex items-start gap-4">
							<div class="w-12 h-12 rounded-full bg-teal flex items-center justify-center flex-shrink-0">
								<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
							</div>
							<div>
								<p class="font-bold text-darkblue uppercase tracking-widest text-xs mb-1">Địa Chỉ</p>
								<p class="text-gray-700 text-lg"><?php echo nl2br( esc_html( $address ) ); ?></p>
							</div>
						</li>
					</ul>

					<h2 class="text-2xl font-black text-darkblue uppercase mb-6">Gửi Tin Nhắn</h2>

					<?php if ( $form_sent ) : ?>
					<div class="bg-teal/10 border border-teal text-teal rounded-xl p-4 mb-6 font-body text-sm">
						Tin nhắn của bạn đã được gửi thành công. Chúng tôi sẽ liên hệ lại sớm nhất!
					</div>
					<?php elseif ( $form_error ) : ?>
					<div class="bg-red-50 border border-red-300 text-red-700 rounded-xl p-4 mb-6 font-body text-sm">
						Vui lòng điền đầy đủ các trường bắt buộc.
					</div>
					<?php endif; ?>

					<form method="post" class="space-y-4">
						<?php wp_nonce_field( 'richscape_send_contact', 'richscape_contact_nonce' ); ?>
						<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
							<div>
								<label for="contact_name" class="block text-sm font-bold text-darkblue mb-1">Họ và tên <span class="text-red-500">*</span></label>
								<input type="text" id="contact_name" name="contact_name" required
								       class="w-full px-4 py-3 border border-gray-300 rounded-xl font-body text-sm focus:outline-none focus:border-teal transition-colors"
								       placeholder="Nguyễn Văn A">
							</div>
							<div>
								<label for="contact_phone_field" class="block text-sm font-bold text-darkblue mb-1">Số điện thoại</label>
								<input type="tel" id="contact_phone_field" name="contact_phone_field"
								       class="w-full px-4 py-3 border border-gray-300 rounded-xl font-body text-sm focus:outline-none focus:border-teal transition-colors"
								       placeholder="0900 000 000">
							</div>
						</div>
						<div>
							<label for="contact_email_field" class="block text-sm font-bold text-darkblue mb-1">Email <span class="text-red-500">*</span></label>
							<input type="email" id="contact_email_field" name="contact_email_field" required
							       class="w-full px-4 py-3 border border-gray-300 rounded-xl font-body text-sm focus:outline-none focus:border-teal transition-colors"
							       placeholder="email@example.com">
						</div>
						<div>
							<label for="contact_message" class="block text-sm font-bold text-darkblue mb-1">Nội dung <span class="text-red-500">*</span></label>
							<textarea id="contact_message" name="contact_message" rows="5" required
							          class="w-full px-4 py-3 border border-gray-300 rounded-xl font-body text-sm focus:outline-none focus:border-teal transition-colors resize-none"
							          placeholder="Nhập nội dung liên hệ..."></textarea>
						</div>
						<button type="submit"
						        class="w-full py-4 bg-teal text-white font-bold uppercase tracking-widest text-sm rounded-full hover:bg-darkblue transition-colors duration-300">
							Gửi Tin Nhắn
						</button>
					</form>
				</div>

				<!-- Google Maps -->
				<div>
					<h2 class="text-2xl font-black text-darkblue uppercase mb-8">Bản Đồ</h2>
					<?php if ( $maps_url ) : ?>
					<div class="rounded-2xl overflow-hidden shadow-xl" style="height: 520px;">
						<iframe src="<?php echo esc_url( $maps_url ); ?>"
						        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
						        referrerpolicy="no-referrer-when-downgrade"></iframe>
					</div>
					<?php else : ?>
					<div class="rounded-2xl overflow-hidden shadow-xl bg-gray-100 flex items-center justify-center" style="height: 520px;">
						<div class="text-center text-gray-400 p-8">
							<svg class="w-16 h-16 mx-auto mb-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
							</svg>
							<p class="font-body text-sm">Thêm Google Maps Embed URL trong<br>WP Admin → Liên Hệ (edit page)</p>
						</div>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
</div>

<?php get_footer();
