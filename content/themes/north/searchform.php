<?php
/**
 * Search form template
 *
 * @package North
 * @since 1.0
 */
?>
<form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-form clearfix">
	<fieldset>
		<input type="text" class="search-form-input text" name="s" onfocus="if (this.value == '<?php _e('Search the site &hellip;','north'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Search the site &hellip;','north'); ?>';}" value="<?php esc_attr_e('Search the site &hellip;','north'); ?>"/>
		<input type="submit" value="<?php _e('Search','north'); ?>" class="submit search-button" />
	</fieldset>
</form>