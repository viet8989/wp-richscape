<?php
/**
 * Custom Admin Page for Richscape Options
 *
 * This file provides an alternative admin page to view and edit Richscape Options
 * if the default ACF options page is not accessible.
 *
 * To activate, add this line to functions.php:
 * require_once( get_template_directory() . '/admin-richscape-options-page.php' );
 */

// Add admin page
add_action( 'admin_menu', function() {
	add_menu_page(
		'Richscape Options',
		'Richscape Options',
		'manage_options',
		'richscape-options-admin',
		'richscape_render_admin_page',
		'dashicons-admin-generic',
		2
	);
} );

// Render the admin page
function richscape_render_admin_page() {
	// Check permission
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'You do not have permission to access this page.' );
	}

	// Handle form submission
	if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['richscape_admin_nonce'] ) ) {
		if ( ! wp_verify_nonce( $_POST['richscape_admin_nonce'], 'richscape_admin_nonce' ) ) {
			echo '<div class="notice notice-error"><p>Security check failed.</p></div>';
		} else {
			// Update fields
			update_field( 'social_zalo_url', sanitize_url( $_POST['social_zalo_url'] ?? '' ), 'option' );
			update_field( 'social_messenger_url', sanitize_url( $_POST['social_messenger_url'] ?? '' ), 'option' );
			update_field( 'company_name_full', sanitize_text_field( $_POST['company_name_full'] ?? '' ), 'option' );
			update_field( 'company_name_abbr', sanitize_text_field( $_POST['company_name_abbr'] ?? '' ), 'option' );
			update_field( 'company_name_intl', sanitize_text_field( $_POST['company_name_intl'] ?? '' ), 'option' );
			update_field( 'company_tax_id', sanitize_text_field( $_POST['company_tax_id'] ?? '' ), 'option' );
			update_field( 'contact_phone', sanitize_text_field( $_POST['contact_phone'] ?? '' ), 'option' );
			update_field( 'contact_email', sanitize_email( $_POST['contact_email'] ?? '' ), 'option' );
			update_field( 'contact_address', sanitize_textarea_field( $_POST['contact_address'] ?? '' ), 'option' );
			update_field( 'map_lat', sanitize_text_field( $_POST['map_lat'] ?? '' ), 'option' );
			update_field( 'map_lng', sanitize_text_field( $_POST['map_lng'] ?? '' ), 'option' );
			update_field( 'about_tagline_en', wp_kses_post( $_POST['about_tagline_en'] ?? '' ), 'option' );
			update_field( 'about_intro_vi', sanitize_textarea_field( $_POST['about_intro_vi'] ?? '' ), 'option' );
			update_field( 'vision_text', sanitize_textarea_field( $_POST['vision_text'] ?? '' ), 'option' );
			update_field( 'mission_text', sanitize_textarea_field( $_POST['mission_text'] ?? '' ), 'option' );
			update_field( 'footer_copyright', sanitize_text_field( $_POST['footer_copyright'] ?? '' ), 'option' );

			echo '<div class="notice notice-success"><p><strong>✅ All options updated successfully!</strong></p></div>';
		}
	}

	// Get all current values
	$values = array(
		'social_zalo_url'     => get_field( 'social_zalo_url', 'option' ) ?: '',
		'social_messenger_url'=> get_field( 'social_messenger_url', 'option' ) ?: '',
		'company_name_full'   => get_field( 'company_name_full', 'option' ) ?: '',
		'company_name_abbr'   => get_field( 'company_name_abbr', 'option' ) ?: '',
		'company_name_intl'   => get_field( 'company_name_intl', 'option' ) ?: '',
		'company_tax_id'      => get_field( 'company_tax_id', 'option' ) ?: '',
		'contact_phone'       => get_field( 'contact_phone', 'option' ) ?: '',
		'contact_email'       => get_field( 'contact_email', 'option' ) ?: '',
		'contact_address'     => get_field( 'contact_address', 'option' ) ?: '',
		'map_lat'             => get_field( 'map_lat', 'option' ) ?: '',
		'map_lng'             => get_field( 'map_lng', 'option' ) ?: '',
		'about_tagline_en'    => get_field( 'about_tagline_en', 'option' ) ?: '',
		'about_intro_vi'      => get_field( 'about_intro_vi', 'option' ) ?: '',
		'vision_text'         => get_field( 'vision_text', 'option' ) ?: '',
		'mission_text'        => get_field( 'mission_text', 'option' ) ?: '',
		'footer_copyright'    => get_field( 'footer_copyright', 'option' ) ?: '',
	);
	?>

	<div class="wrap">
		<h1>🎨 Richscape Options</h1>
		<p style="font-size: 16px; color: #666; margin: 20px 0;">Manage all site-wide options including company info, contact details, and social media URLs.</p>

		<form method="POST" style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
			<?php wp_nonce_field( 'richscape_admin_nonce', 'richscape_admin_nonce' ); ?>

			<!-- Social Media Section -->
			<div style="margin-bottom: 30px; border-bottom: 2px solid #e5e5e5; padding-bottom: 20px;">
				<h2 style="color: #1a2251; margin-top: 0;">📱 Social Media URLs</h2>

				<div style="margin-bottom: 15px;">
					<label style="display: block; font-weight: bold; color: #333; margin-bottom: 5px;">
						⭐ Zalo URL <span style="color: #dc3545;">*</span>
						<span style="color: #999; font-weight: normal; font-size: 12px;"> (Used in footer.php line 12)</span>
					</label>
					<input type="url" name="social_zalo_url"
						value="<?php echo esc_attr( $values['social_zalo_url'] ); ?>"
						placeholder="https://zalo.me/yourprofile"
						style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; box-sizing: border-box;">
				</div>

				<div style="margin-bottom: 15px;">
					<label style="display: block; font-weight: bold; color: #333; margin-bottom: 5px;">Messenger URL</label>
					<input type="url" name="social_messenger_url"
						value="<?php echo esc_attr( $values['social_messenger_url'] ); ?>"
						placeholder="https://m.me/yourpage"
						style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; box-sizing: border-box;">
				</div>
			</div>

			<!-- Company Information Section -->
			<div style="margin-bottom: 30px; border-bottom: 2px solid #e5e5e5; padding-bottom: 20px;">
				<h2 style="color: #1a2251; margin-top: 0;">🏢 Company Information</h2>

				<div style="margin-bottom: 15px;">
					<label style="display: block; font-weight: bold; color: #333; margin-bottom: 5px;">Tên đầy đủ (Full Company Name)</label>
					<input type="text" name="company_name_full"
						value="<?php echo esc_attr( $values['company_name_full'] ); ?>"
						placeholder="CÔNG TY TNHH THIẾT KẾ & THI CÔNG CẢNH QUAN RICHSCAPE"
						style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; box-sizing: border-box;">
				</div>

				<div style="margin-bottom: 15px;">
					<label style="display: block; font-weight: bold; color: #333; margin-bottom: 5px;">Tên viết tắt (Abbreviation)</label>
					<input type="text" name="company_name_abbr"
						value="<?php echo esc_attr( $values['company_name_abbr'] ); ?>"
						placeholder="RS LDB CO.,LTD"
						style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; box-sizing: border-box;">
				</div>

				<div style="margin-bottom: 15px;">
					<label style="display: block; font-weight: bold; color: #333; margin-bottom: 5px;">Tên quốc tế (International Name)</label>
					<input type="text" name="company_name_intl"
						value="<?php echo esc_attr( $values['company_name_intl'] ); ?>"
						placeholder="RICHSCAPE LANDSCAPE DESIGN & BUILD COMPANY LIMITED"
						style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; box-sizing: border-box;">
				</div>

				<div style="margin-bottom: 15px;">
					<label style="display: block; font-weight: bold; color: #333; margin-bottom: 5px;">Mã số thuế (Tax ID)</label>
					<input type="text" name="company_tax_id"
						value="<?php echo esc_attr( $values['company_tax_id'] ); ?>"
						placeholder="0316356108"
						style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; box-sizing: border-box;">
				</div>
			</div>

			<!-- Contact Information Section -->
			<div style="margin-bottom: 30px; border-bottom: 2px solid #e5e5e5; padding-bottom: 20px;">
				<h2 style="color: #1a2251; margin-top: 0;">📞 Contact Information</h2>

				<div style="margin-bottom: 15px;">
					<label style="display: block; font-weight: bold; color: #333; margin-bottom: 5px;">Điện thoại (Phone)</label>
					<input type="text" name="contact_phone"
						value="<?php echo esc_attr( $values['contact_phone'] ); ?>"
						placeholder="0937 430 701"
						style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; box-sizing: border-box;">
				</div>

				<div style="margin-bottom: 15px;">
					<label style="display: block; font-weight: bold; color: #333; margin-bottom: 5px;">Email</label>
					<input type="email" name="contact_email"
						value="<?php echo esc_attr( $values['contact_email'] ); ?>"
						placeholder="Khanhbui@Richscape.vn"
						style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; box-sizing: border-box;">
				</div>

				<div style="margin-bottom: 15px;">
					<label style="display: block; font-weight: bold; color: #333; margin-bottom: 5px;">Địa chỉ (Address)</label>
					<textarea name="contact_address" rows="3"
						placeholder="13/3A, Đường 15, Bình Trưng Tây, TP. HCM"
						style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; font-family: inherit; box-sizing: border-box;"><?php echo esc_textarea( $values['contact_address'] ); ?></textarea>
				</div>
			</div>

			<!-- Map Coordinates Section -->
			<div style="margin-bottom: 30px; border-bottom: 2px solid #e5e5e5; padding-bottom: 20px;">
				<h2 style="color: #1a2251; margin-top: 0;">🗺️ Map Coordinates</h2>

				<div style="margin-bottom: 15px;">
					<label style="display: block; font-weight: bold; color: #333; margin-bottom: 5px;">Tọa độ - Vĩ độ (Latitude)</label>
					<input type="text" name="map_lat"
						value="<?php echo esc_attr( $values['map_lat'] ); ?>"
						placeholder="10.7756"
						style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; box-sizing: border-box;">
				</div>

				<div style="margin-bottom: 15px;">
					<label style="display: block; font-weight: bold; color: #333; margin-bottom: 5px;">Tọa độ - Kinh độ (Longitude)</label>
					<input type="text" name="map_lng"
						value="<?php echo esc_attr( $values['map_lng'] ); ?>"
						placeholder="106.7476"
						style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; box-sizing: border-box;">
				</div>
			</div>

			<!-- About Page Content Section -->
			<div style="margin-bottom: 30px; border-bottom: 2px solid #e5e5e5; padding-bottom: 20px;">
				<h2 style="color: #1a2251; margin-top: 0;">✍️ About Page Content</h2>

				<div style="margin-bottom: 15px;">
					<label style="display: block; font-weight: bold; color: #333; margin-bottom: 5px;">English Tagline <span style="color: #999; font-weight: normal; font-size: 12px;">(Use &lt;br /&gt; for line breaks)</span></label>
					<textarea name="about_tagline_en" rows="4"
						placeholder="As Landscape Creators,&#10;&lt;br /&gt;&#10;We Bring Your Green Visions To Life."
						style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; font-family: inherit; box-sizing: border-box;"><?php echo esc_textarea( $values['about_tagline_en'] ); ?></textarea>
					<p style="font-size: 12px; color: #666; margin-top: 5px;">💡 Tip: Use <code>&lt;br /&gt;</code> to create line breaks in the displayed tagline.</p>
				</div>

				<div style="margin-bottom: 15px;">
					<label style="display: block; font-weight: bold; color: #333; margin-bottom: 5px;">Vietnamese Intro</label>
					<textarea name="about_intro_vi" rows="4"
						placeholder="Enter Vietnamese introduction text here..."
						style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; font-family: inherit; box-sizing: border-box;"><?php echo esc_textarea( $values['about_intro_vi'] ); ?></textarea>
				</div>
			</div>

			<!-- Vision & Mission Section -->
			<div style="margin-bottom: 30px; border-bottom: 2px solid #e5e5e5; padding-bottom: 20px;">
				<h2 style="color: #1a2251; margin-top: 0;">💡 Vision & Mission</h2>

				<div style="margin-bottom: 15px;">
					<label style="display: block; font-weight: bold; color: #333; margin-bottom: 5px;">Nội dung Tầm Nhìn (Vision)</label>
					<textarea name="vision_text" rows="4"
						placeholder="Enter vision statement..."
						style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; font-family: inherit; box-sizing: border-box;"><?php echo esc_textarea( $values['vision_text'] ); ?></textarea>
				</div>

				<div style="margin-bottom: 15px;">
					<label style="display: block; font-weight: bold; color: #333; margin-bottom: 5px;">Nội dung Sứ Mệnh (Mission)</label>
					<textarea name="mission_text" rows="4"
						placeholder="Enter mission statement..."
						style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; font-family: inherit; box-sizing: border-box;"><?php echo esc_textarea( $values['mission_text'] ); ?></textarea>
				</div>
			</div>

			<!-- Footer Section -->
			<div style="margin-bottom: 30px; border-bottom: 2px solid #e5e5e5; padding-bottom: 20px;">
				<h2 style="color: #1a2251; margin-top: 0;">📄 Footer</h2>

				<div style="margin-bottom: 15px;">
					<label style="display: block; font-weight: bold; color: #333; margin-bottom: 5px;">Copyright Text</label>
					<input type="text" name="footer_copyright"
						value="<?php echo esc_attr( $values['footer_copyright'] ); ?>"
						placeholder="© 2026 Richscape. All rights reserved."
						style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; box-sizing: border-box;">
				</div>
			</div>

			<!-- Submit Button -->
			<div style="margin-top: 30px;">
				<button type="submit" class="button button-primary button-large" style="font-size: 16px; padding: 10px 30px;">
					💾 Save All Changes
				</button>
			</div>
		</form>
	</div>

	<?php
}
