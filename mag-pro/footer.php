<?php
/**
 * The template for displaying the footer.
 *
 * @package MagPro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
	</div><!-- #content -->

	<?php
	/**
	 * Renders Before Footer template if configured.
	 */
	magpro_render_before_footer();

	/**
	 * Renders Elementor Footer if active, or Fallback Footer.
	 */
	magpro_render_footer();
	?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

