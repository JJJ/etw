<?php
/**
 * Search form template
 *
 * @package Medium
 * @since 1.0
 */
?>
<form action="<?php echo home_url( '/' ); ?>" class="search-form">
	<fieldset>
		<input type="text" class="search-form-input text" name="s" onfocus="if (this.value == '<?php _e('Search...','medium'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Search...','medium'); ?>';}" value="<?php _e('Search...','medium'); ?>"/>
		<input type="submit" value="Search" class="submit search-button" />
	</fieldset>
</form>