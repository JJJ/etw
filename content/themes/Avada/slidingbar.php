<?php 
global $smof_data; 

$is_open_class = '';
if ( $smof_data['slidingbar_open_on_load'] ) {
	$is_open_class = 'class="open_onload"';
}

?>
<div id="slidingbar-area" <?php echo $is_open_class; ?>>
	<div id="slidingbar">
		<div class="fusion-row">
			<div class="fusion-columns row fusion-columns-<?php echo $smof_data['slidingbar_widgets_columns']; ?> columns columns-<?php echo $smof_data['slidingbar_widgets_columns']; ?>">
				<?php 
				$column_width = 12 / $smof_data['slidingbar_widgets_columns']; 
				if( $smof_data['slidingbar_widgets_columns'] == '5' ) {
					$column_width = 2;
				}
				
				// Render as many widget columns as have been chosen in Theme Options
				for ( $i = 1; $i < 7; $i++ ) {
					if ( $smof_data['slidingbar_widgets_columns'] >= $i ) {
						echo sprintf( '<div class="fusion-column col-lg-%s col-md-%s col-sm-%s">', $column_width, $column_width, $column_width );

							if (  function_exists( 'dynamic_sidebar' ) && 
								 dynamic_sidebar( sprintf( 'SlidingBar Widget %s', $i ) )
							) {
								// All is good, dynamic_sidebar() already called the rendering
							}
						echo '</div>';
					}
				}
				?>
				<div class="fusion-clearfix"></div>
			</div>			
		</div>
	</div>
	<div class="sb-toggle-wrapper">
		<a class="sb-toggle" href="#"></a>
	</div>
</div>
<?php wp_reset_postdata(); ?>