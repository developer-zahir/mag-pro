<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package MagPro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_active_sidebar( 'magpro-main-sidebar' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area magpro-sidebar-area">
	<?php dynamic_sidebar( 'magpro-main-sidebar' ); ?>
</aside>
