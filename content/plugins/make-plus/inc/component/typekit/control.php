<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_Typekit_Control
 *
 * Defines a Typekit control for the Customizer.
 *
 * @since 1.7.0.
 */
class MAKEPLUS_Component_Typekit_Control extends WP_Customize_Control {
	/**
	 * The control type.
	 *
	 * @since 1.7.0.
	 *
	 * @var string
	 */
	public $type = 'makeplus_typekit';

	/**
	 * Add extra properties to JSON array.
	 *
	 * @since 1.7.0.
	 *
	 * @return array
	 */
	public function json() {
		$json = parent::json();

		$json['id'] = $this->id;
		$json['link'] = $this->get_link();
		$json['value'] = $this->value();

		return $json;
	}

	/**
	 * Define the JS template for the control.
	 *
	 * @since 1.7.0.
	 *
	 * @return void
	 */
	protected function content_template() {
		?>
		<# if (data.label) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>
		<# if (data.description) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<div class="makeplus-typekit-container">
			<div class="makeplus-typekit-inputs">
				<label for="kit-id_{{ data.id }}">
					<span class="screen-reader-text"><?php esc_html_e( 'Enter kit ID', 'make-plus' ); ?></span>
					<input id="kit-id_{{ data.id }}" class="makeplus-typekit-id-field" type="text" placeholder="<?php esc_html_e( 'Enter Kit ID', 'make-plus' ); ?>" value="{{ data.value }}" {{{ data.link }}} autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
					<i id="kit-id-status_{{ data.id }}" class="makeplus-typekit-id-status"></i>
				</label>
			</div>
			<div class="makeplus-typekit-buttons">
				<button id="refresh_{{ data.id }}" class="button-secondary button-disabled">
					<?php esc_html_e( 'Refresh Kit', 'make-plus' ); ?>
				</button>
				<a class="makeplus-typekit-help" href="https://thethemefoundry.com/docs/make-docs/customizer/typography/" target="_blank">
					<?php esc_html_e( 'Need help?', 'make-plus' ); ?>
				</a>
			</div>
		</div>

		<div id="troubleshooting_{{ data.id }}" class="screen-reader-text">
			<h4 class="customize-control-title"><?php esc_html_e( 'Troubleshooting', 'make-plus' ); ?></h4>
			<ul class="makeplus-typekit-troubleshooting description">
				<li><?php esc_html_e( 'Is the kit ID correct?', 'make-plus' ); ?></li>
				<li><?php esc_html_e( 'Is the kit published?', 'make-plus' ); ?></li>
				<li><?php
					printf(
						'<a href="http://help.typekit.com/customer/portal/articles/6856-Domains" target="_blank">%s</a>',
						esc_html__( 'Has the site domain been added to the kit\'s allowed domains list?', 'make-plus' )
					);
				?></li>
			</ul>
		</div>
	<?php
	}
}