<?php
wp_reset_query();
global $post;
if(is_shop()) {
	$pageID = get_option('woocommerce_shop_page_id');
} else {
	$pageID = $post->ID;
}
$content_css = '';
$sidebar_css = '';
$sidebar_exists = true;
$sidebar_left = '';

$double_sidebars = false;
$sidebar_1 = get_post_meta( $pageID, 'sbg_selected_sidebar_replacement', true );
$sidebar_2 = get_post_meta( $pageID, 'sbg_selected_sidebar_2_replacement', true );
if( ( is_array( $sidebar_1 ) && ( $sidebar_1[0] || $sidebar_1[0] === '0' ) ) && ( is_array( $sidebar_2 ) && ( $sidebar_2[0] || $sidebar_2[0] === '0' ) ) ) {
	$double_sidebars = true;
}

if( ( is_array( $sidebar_1 ) && ( $sidebar_1[0] || $sidebar_1[0] === '0' ) ) || ( is_array( $sidebar_2 ) && ( $sidebar_2[0] || $sidebar_2[0] === '0' ) ) ) {
	$sidebar_exists = true;
} else {
	$sidebar_exists = false;
}

if( ! $sidebar_exists ) {
	$content_css = 'width:100%';
	$sidebar_css = 'display:none';
	$sidebar_exists = false;
} elseif(get_post_meta($pageID, 'pyre_sidebar_position', true) == 'left') {
	$content_css = 'float:right;';
	$sidebar_css = 'float:left;';
	$sidebar_left = 1;
} elseif(get_post_meta($pageID, 'pyre_sidebar_position', true) == 'right') {
	$content_css = 'float:left;';
	$sidebar_css = 'float:right;';
} elseif(get_post_meta($pageID, 'pyre_sidebar_position', true) == 'default' || ! metadata_exists( 'post', $pageID, 'pyre_sidebar_position' )) {
	if($smof_data['default_sidebar_pos'] == 'Left') {
		$content_css = 'float:right;';
		$sidebar_css = 'float:left;';
		$sidebar_left = 1;
	} elseif($smof_data['default_sidebar_pos'] == 'Right') {
		$content_css = 'float:left;';
		$sidebar_css = 'float:right;';
		$sidebar_left = 2;
	}
}

if(get_post_meta($pageID, 'pyre_sidebar_position', true) == 'right') {
	$sidebar_left = 2;
}

if($double_sidebars == true) {
	$content_css = 'float:left;';
	$sidebar_css = 'float:left;';
	$sidebar_2_css = 'float:left;';
} else {
	$sidebar_left = 1;
}
?>
<?php if( $sidebar_exists == true ): ?>
<div id="sidebar" class="sidebar" style="<?php echo $sidebar_css; ?>">
	<?php
	if($sidebar_left == 1) {
		generated_dynamic_sidebar($sidebar_1);
	}
	if($sidebar_left == 2) {
		generated_dynamic_sidebar_2($sidebar_2);
	}
	?>
</div>
<?php if( $double_sidebars == true ): ?>
<div id="sidebar-2" class="sidebar" style="<?php echo $sidebar_2_css; ?>">
	<?php
	if($sidebar_left == 1) {
		generated_dynamic_sidebar_2($sidebar_2);
	}
	if($sidebar_left == 2) {
		generated_dynamic_sidebar($sidebar_1);
	}
	?>
</div>
<?php endif; ?>
<?php endif; ?>