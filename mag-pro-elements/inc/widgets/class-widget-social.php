<?php
/**
 * MagPro Social Follow Widget
 *
 * @package MagProElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

class MagPro_Widget_Social extends \Elementor\Widget_Base {

	public function get_name() {
		return 'magpro-social';
	}

	public function get_title() {
		return esc_html__( 'MagPro - Social Follow Us', 'mag-pro-elements' );
	}

	public function get_icon() {
		return 'eicon-share';
	}

	public function get_categories() {
		return array( 'magpro-elements' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Social Profiles', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'widget_title',
			array(
				'label'   => esc_html__( 'Widget Title', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Follow Us', 'mag-pro-elements' ),
			)
		);

		$this->add_control(
			'facebook_url',
			array(
				'label'   => esc_html__( 'Facebook URL', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'https://facebook.com/',
			)
		);

		$this->add_control(
			'twitter_url',
			array(
				'label'   => esc_html__( 'Twitter / X URL', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'https://twitter.com/',
			)
		);

		$this->add_control(
			'youtube_url',
			array(
				'label'   => esc_html__( 'YouTube URL', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'https://youtube.com/',
			)
		);

		$this->add_control(
			'instagram_url',
			array(
				'label'   => esc_html__( 'Instagram URL', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'https://instagram.com/',
			)
		);

		$this->add_control(
			'pinterest_url',
			array(
				'label'   => esc_html__( 'Pinterest URL', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			)
		);

		$this->add_control(
			'telegram_url',
			array(
				'label'   => esc_html__( 'Telegram URL', 'mag-pro-elements' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="magpro-social-wrap">
			<?php if ( ! empty( $settings['widget_title'] ) ) : ?>
				<h3 class="magpro-widget-title"><?php echo esc_html( $settings['widget_title'] ); ?></h3>
			<?php endif; ?>

			<div class="magpro-social-grid">
				<?php if ( ! empty( $settings['facebook_url'] ) ) : ?>
					<a href="<?php echo esc_url( $settings['facebook_url'] ); ?>" class="magpro-social-btn magpro-social-facebook" target="_blank" rel="noopener noreferrer">
						<span><i class="fab fa-facebook-f"></i> Facebook</span>
						<span><i class="fas fa-thumbs-up"></i></span>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $settings['twitter_url'] ) ) : ?>
					<a href="<?php echo esc_url( $settings['twitter_url'] ); ?>" class="magpro-social-btn magpro-social-twitter" target="_blank" rel="noopener noreferrer">
						<span><i class="fab fa-twitter"></i> Twitter</span>
						<span><i class="fas fa-plus"></i></span>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $settings['youtube_url'] ) ) : ?>
					<a href="<?php echo esc_url( $settings['youtube_url'] ); ?>" class="magpro-social-btn magpro-social-youtube" target="_blank" rel="noopener noreferrer">
						<span><i class="fab fa-youtube"></i> YouTube</span>
						<span><i class="fas fa-play"></i></span>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $settings['instagram_url'] ) ) : ?>
					<a href="<?php echo esc_url( $settings['instagram_url'] ); ?>" class="magpro-social-btn magpro-social-instagram" target="_blank" rel="noopener noreferrer">
						<span><i class="fab fa-instagram"></i> Instagram</span>
						<span><i class="fas fa-camera"></i></span>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $settings['pinterest_url'] ) ) : ?>
					<a href="<?php echo esc_url( $settings['pinterest_url'] ); ?>" class="magpro-social-btn magpro-social-pinterest" target="_blank" rel="noopener noreferrer">
						<span><i class="fab fa-pinterest-p"></i> Pinterest</span>
						<span><i class="fas fa-pin"></i></span>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $settings['telegram_url'] ) ) : ?>
					<a href="<?php echo esc_url( $settings['telegram_url'] ); ?>" class="magpro-social-btn magpro-social-telegram" target="_blank" rel="noopener noreferrer">
						<span><i class="fab fa-telegram-plane"></i> Telegram</span>
						<span><i class="fas fa-paper-plane"></i></span>
					</a>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}

