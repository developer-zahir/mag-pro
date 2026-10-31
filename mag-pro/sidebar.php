<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package MagPro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<aside id="sidebar-wrapper" class="widget-area">
	<?php if ( is_active_sidebar( 'magpro-main-sidebar' ) ) : ?>
		<?php dynamic_sidebar( 'magpro-main-sidebar' ); ?>
	<?php else : ?>
		<!-- Default Demo Widgets if sidebar is empty -->
		<section class="widget magpro-widget">
			<h4 class="widget-title magpro-widget-title"><span class="title-text"><?php esc_html_e( 'Search', 'mag-pro' ); ?></span></h4>
			<?php get_search_form(); ?>
		</section>

		<section class="widget magpro-widget">
			<h4 class="widget-title magpro-widget-title"><span class="title-text"><?php esc_html_e( 'Recent Posts', 'mag-pro' ); ?></span></h4>
			<ul>
				<?php
				$recent_posts = wp_get_recent_posts( array( 'numberposts' => 5, 'post_status' => 'publish' ) );
				foreach ( $recent_posts as $post ) :
					?>
					<li><a href="<?php echo esc_url( get_permalink( $post['ID'] ) ); ?>"><?php echo esc_html( $post['post_title'] ); ?></a></li>
				<?php endforeach; wp_reset_query(); ?>
			</ul>
		</section>

		<section class="widget magpro-widget">
			<h4 class="widget-title magpro-widget-title"><span class="title-text"><?php esc_html_e( 'Categories', 'mag-pro' ); ?></span></h4>
			<ul>
				<?php wp_list_categories( array( 'title_li' => '', 'number' => 8 ) ); ?>
			</ul>
		</section>
	<?php endif; ?>
</aside>
