<?php
/**
 * Template Part: Breadcrumb
 * Used in: single-projects.php, single-post.php, page templates
 * Receives: $breadcrumbs array via set_query_var('breadcrumbs', [...])
 * Each item: [ 'label' => string, 'url' => string ] — omit 'url' for the last (current) item
 */

$breadcrumbs = get_query_var( 'breadcrumbs', array() );
if ( empty( $breadcrumbs ) ) return;
?>
<nav class="py-4 bg-gray-50 border-b border-gray-200" aria-label="Breadcrumb">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<ol class="flex items-center flex-wrap gap-2 text-sm text-gray-500 font-body">
			<?php foreach ( $breadcrumbs as $i => $crumb ) :
				$is_last = ( $i === count( $breadcrumbs ) - 1 );
			?>
			<?php if ( $i > 0 ) : ?>
			<li aria-hidden="true">
				<svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
				</svg>
			</li>
			<?php endif; ?>
			<li <?php echo $is_last ? 'aria-current="page"' : ''; ?>>
				<?php if ( ! $is_last && ! empty( $crumb['url'] ) ) : ?>
					<a href="<?php echo esc_url( $crumb['url'] ); ?>" class="hover:text-teal transition-colors"><?php echo esc_html( $crumb['label'] ); ?></a>
				<?php else : ?>
					<span class="text-darkblue font-semibold"><?php echo esc_html( $crumb['label'] ); ?></span>
				<?php endif; ?>
			</li>
			<?php endforeach; ?>
		</ol>
	</div>
</nav>
