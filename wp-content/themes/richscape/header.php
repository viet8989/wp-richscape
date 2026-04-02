<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> id="top">
<?php wp_body_open(); ?>

<div id="page" class="site min-h-screen flex flex-col">

	<header id="masthead" class="site-header fixed w-full top-0 z-50 bg-white/95 backdrop-blur-md shadow-sm transition-all duration-300">
        <!-- Top Gradient Bar -->
        <div class="w-full flex justify-center">
            <div class="bg-gradient-to-r from-darkblue to-teal w-full" style="max-width:1280px;height:41.11px;"></div>
        </div>
        
		<div class="mx-auto w-full px-4 sm:px-6 lg:px-12" style="max-width:1280px;">
			<div class="flex items-center justify-between h-24">
				
				<!-- Logo -->
				<div class="flex-shrink-0 flex flex-col justify-center">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center">
						<img class="_7_i_XA h-14 w-auto drop-shadow-sm" crossorigin="anonymous" draggable="false" src="/wp-content/uploads/logo.png" alt="Richscape">
					</a>
				</div>
				
				<!-- Primary Navigation -->
				<nav id="site-navigation" class="hidden md:flex flex-grow justify-end items-center main-navigation">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'container'      => false,
						'fallback_cb'    => false,
					) );
					?>
				</nav>

				<!-- Mobile menu button -->
				<div class="md:hidden flex items-center">
					<button type="button" class="text-darkblue hover:text-teal focus:outline-none" aria-expanded="false" id="mobile-menu-button">
						<span class="sr-only">Open main menu</span>
						<svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
						</svg>
					</button>
				</div>
			</div>
		</div>
		
		<!-- Mobile Menu (Hidden by default) -->
		<div class="md:hidden hidden bg-white shadow-lg absolute w-full border-t border-gray-100" id="mobile-menu">
			<div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'flex flex-col space-y-4 px-4 py-4 text-sm font-semibold uppercase text-darkblue',
					'fallback_cb'    => false,
				) );
				?>
			</div>
		</div>
	</header>

	<script>
		// Simple Mobile Menu Toggle
		document.getElementById('mobile-menu-button').addEventListener('click', function() {
			var menu = document.getElementById('mobile-menu');
			menu.classList.toggle('hidden');
		});
	</script>

	<main id="primary" class="site-main flex-grow pt-32">
