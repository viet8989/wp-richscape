</main><!-- #primary -->

<?php
// ACF Options data with fallbacks
$company_name_full  = function_exists( 'get_field' ) ? get_field( 'company_name_full', 'option' ) : '';
$company_name_abbr  = function_exists( 'get_field' ) ? get_field( 'company_name_abbr', 'option' ) : '';
$company_name_intl  = function_exists( 'get_field' ) ? get_field( 'company_name_intl', 'option' ) : '';
$company_tax_id     = function_exists( 'get_field' ) ? get_field( 'company_tax_id', 'option' ) : '';
$contact_phone      = function_exists( 'get_field' ) ? get_field( 'contact_phone', 'option' ) : '';
$contact_email      = function_exists( 'get_field' ) ? get_field( 'contact_email', 'option' ) : '';
$contact_address    = function_exists( 'get_field' ) ? get_field( 'contact_address', 'option' ) : '';
$social_zalo        = function_exists( 'get_field' ) ? get_field( 'social_zalo_url', 'option' ) : '';
$social_messenger   = function_exists( 'get_field' ) ? get_field( 'social_messenger_url', 'option' ) : '';
$footer_copyright   = function_exists( 'get_field' ) ? get_field( 'footer_copyright', 'option' ) : '';
$logo_footer_data   = function_exists( 'get_field' ) ? get_field( 'logo_footer', 'option' ) : null;

$company_name_full  = $company_name_full  ?: 'CÔNG TY TNHH THIẾT KẾ & THI CÔNG CẢNH QUAN RICHSCAPE';
$company_name_abbr  = $company_name_abbr  ?: 'RS LDB CO.,LTD';
$company_name_intl  = $company_name_intl  ?: 'RICHSCAPE LANDSCAPE DESIGN & BUILD COMPANY LIMITED';
$company_tax_id     = $company_tax_id     ?: '0316356108';
$contact_phone      = $contact_phone      ?: '0937 430 701';
$contact_email      = $contact_email      ?: 'Khanhbui@Richscape.vn';
$contact_address    = $contact_address    ?: '13/3A, Đường 15, Bình Trưng Tây, TP. HCM';
$footer_copyright   = $footer_copyright   ?: '© ' . date( 'Y' ) . ' Richscape. All rights reserved.';
$logo_footer_url    = $logo_footer_data['url'] ?? '/wp-content/uploads/logo_footer.png';
$logo_footer_alt    = $logo_footer_data['alt'] ?? 'Richscape';
?>

<!-- Footer Section -->
<footer id="contact" class="bg-gradient-to-r from-darkblue to-teal pt-20 pb-10 px-6 text-white relative overflow-hidden">
	<div class="max-w-7xl mx-auto relative z-10">
		<div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-16">

			<!-- Column 1: Company Info -->
			<div class="space-y-4">
				<h3 class="text-2xl font-black tracking-tighter text-white mb-6 uppercase">RICHSCAPE</h3>
				<div class="text-gray-200 text-sm font-body leading-relaxed space-y-2">
					<p><strong><?php echo esc_html( $company_name_full ); ?></strong></p>
					<p><strong>Tên viết tắt:</strong> <?php echo esc_html( $company_name_abbr ); ?></p>
					<p><strong>Tên quốc tế:</strong> <?php echo esc_html( $company_name_intl ); ?></p>
					<p><strong>Mã số thuế:</strong> <?php echo esc_html( $company_tax_id ); ?></p>
				</div>
			</div>

			<!-- Column 2: Logo Prominent -->
			<div class="flex items-center justify-center">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-block transition-transform hover:scale-105">
					<img class="h-28 w-auto rounded-xl p-4" crossorigin="anonymous" draggable="false"
					     src="<?php echo esc_url( $logo_footer_url ); ?>"
					     alt="<?php echo esc_attr( $logo_footer_alt ); ?>">
				</a>
			</div>

			<!-- Column 3: Contact Info -->
			<div>
				<h4 class="text-white font-bold uppercase tracking-widest mb-6 text-xl">Thông Tin Liên Hệ</h4>
				<ul class="space-y-6 text-gray-200 text-sm font-body">
					<li class="flex items-start">
						<svg class="w-6 h-6 text-teal-300 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
						<span class="mt-1"><?php echo esc_html( $contact_phone ); ?></span>
					</li>
					<li class="flex items-start">
						<svg class="w-6 h-6 text-teal-300 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
						<span class="mt-1"><?php echo esc_html( $contact_email ); ?></span>
					</li>
					<li class="flex items-start">
						<svg class="w-6 h-6 text-teal-300 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
						<span class="mt-1"><?php echo nl2br( esc_html( $contact_address ) ); ?></span>
					</li>
				</ul>
			</div>
		</div>

		<!-- Floating Buttons: Zalo (green) + Phone (teal) + Messenger (blue) + Back-to-top -->
		<div class="fixed right-4 bottom-20 flex flex-col space-y-2 sm:right-6 sm:bottom-24 sm:space-y-3 z-50">
			<!-- Zalo -->
			<a href="<?php echo esc_url( $social_zalo ?: '#' ); ?>"
			   class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center text-white shadow-lg hover:scale-110 transition-transform duration-300"
			   style="background-color: #0068ff;" title="Zalo" aria-label="Liên hệ Zalo">
				<svg class="w-6 h-6 sm:w-7 sm:h-7" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M24 4C12.95 4 4 12.95 4 24C4 29.25 6.1 34.05 9.5 37.6L7 44L13.75 41.6C16.95 43.1 20.4 44 24 44C35.05 44 44 35.05 44 24C44 12.95 35.05 4 24 4Z" fill="white"/>
					<text x="10" y="30" font-family="Arial" font-weight="bold" font-size="14" fill="#0068ff">Zalo</text>
				</svg>
			</a>
			<!-- Phone -->
			<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $contact_phone ) ); ?>"
			   class="w-10 h-10 sm:w-12 sm:h-12 bg-teal rounded-full flex items-center justify-center text-white shadow-lg hover:scale-110 transition-transform duration-300"
			   title="Gọi điện" aria-label="Gọi điện">
				<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
				</svg>
			</a>
			<!-- Messenger -->
			<a href="<?php echo esc_url( $social_messenger ?: '#' ); ?>"
			   class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center text-white shadow-lg hover:scale-110 transition-transform duration-300"
			   style="background-color: #0084ff;" title="Messenger" aria-label="Liên hệ Messenger">
				<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
					<path d="M12 2C6.477 2 2 6.145 2 11.25c0 2.895 1.48 5.485 3.795 7.155.235.17.375.445.365.74l-.175 2.145c-.06.745.71 1.255 1.345.89l2.42-1.395c.23-.13.505-.175.76-.135 1.05.175 2.16.27 3.32.27 5.523 0 10-4.145 10-9.25S17.523 2 12 2z"/>
				</svg>
			</a>
		</div>

		<a href="#top" class="fixed right-4 bottom-4 sm:right-6 sm:bottom-6 w-10 h-10 sm:w-12 sm:h-12 bg-white text-darkblue rounded-full flex items-center justify-center shadow-lg hover:bg-teal hover:text-white transition-colors z-50" aria-label="Lên đầu trang">
			<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
		</a>

		<div class="pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center text-white/50 text-xs tracking-widest uppercase mt-8">
			<p><?php echo esc_html( $footer_copyright ); ?></p>
			<p class="mt-4 md:mt-0">Designed & Developed by Richscape</p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
