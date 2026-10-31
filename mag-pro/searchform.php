<?php
/**
 * Clean search form template matching MagPro style.
 *
 * @package MagPro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form role="search" method="get" class="search-form magpro-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="display:flex; border:1px solid var(--border-color); border-radius:var(--radius); overflow:hidden;">
	<label style="flex:1; margin:0;">
		<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'mag-pro' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'mag-pro' ); ?>" value="<?php echo get_search_query(); ?>" name="s" style="width:100%; border:none; padding:10px 14px; background:var(--body-bg); color:var(--text-color); font-family:inherit; outline:none;" />
	</label>
	<button type="submit" class="search-submit" aria-label="<?php echo esc_attr_x( 'Search', 'submit button', 'mag-pro' ); ?>" style="background:var(--main-color); color:#fff; border:none; padding:0 16px; cursor:pointer;">
		<i class="fas fa-search"></i>
	</button>
</form>
