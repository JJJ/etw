<div class="apsc-boards-tabs" id="apsc-board-cache-settings" style="display:none">
	<div class="apsc-tab-wrapper">
		<div class="apsc-option-inner-wrapper">
			<label><?php _e('Cache Period','accesspress-social-counter');?></label>
			<div class="apsc-option-field">
				<input type="number" name="cache_period" value="<?php echo $apsc_settings['cache_period'];?>" min="0"/>
				<div class="apsc-option-note"><?php _e('Please enter the time in hours in which the count should be updated.Default is 24 hours','accesspress-social-counter');?></div>
			</div>
		</div>
	</div>
</div>