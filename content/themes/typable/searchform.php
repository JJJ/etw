<?php
/**
 * Search form template
 *
 * @package Typable
 * @since 1.0
 */
?>
<form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-form clearfix">
	<fieldset>
		<input type="text" class="search-form-input text" name="s" onfocus="if (this.value == '<?php esc_attr_e( 'Type your search here and press enter...', 'typable' ); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php esc_attr_e( 'Type your search here and press enter...', 'typable' ); ?>';}" value="<?php esc_attr_e( 'Type your search here and press enter...', 'typable' ); ?>"/>
		<input type="submit" value="<?php esc_attr_e( 'Search', 'typable' ); ?>" class="submit search-button" />
	</fieldset>
</form>