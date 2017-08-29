<?php
/**
 * This template displays the search form.
 *
 * @package Baseline
 */
?>

<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div>
		<label class="screen-reader-text" for="s"><?php esc_html_e( 'Search for:', 'baseline' ); ?></label>

		<input type="text" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" id="s" placeholder="<?php esc_attr_e( 'Search here...', 'baseline' ); ?>" />

		<button type="submit" id="searchsubmit">
			<i class="fa fa-search"></i> <span><?php echo esc_html_e( 'Search', 'baseline' ); ?></span>
		</button>
	</div>
</form>