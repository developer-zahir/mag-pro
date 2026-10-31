<?php
/**
 * The template for displaying comments.
 *
 * @package MagPro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area magpro-comments-area">

	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
			$magpro_comment_count = get_comments_number();
			if ( '1' === $magpro_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One Comment on &ldquo;%1$s&rdquo;', 'mag-pro' ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			} else {
				printf(
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s Comment on &ldquo;%2$s&rdquo;', '%1$s Comments on &ldquo;%2$s&rdquo;', $magpro_comment_count, 'comments title', 'mag-pro' ) ),
					number_format_i18n( $magpro_comment_count ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			}
			?>
		</h3>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size' => 48,
				)
			);
			?>
		</ol>

		<?php
		the_comments_navigation();

		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'mag-pro' ); ?></p>
			<?php
		endif;

	endif;

	comment_form();
	?>

</div><!-- #comments -->
