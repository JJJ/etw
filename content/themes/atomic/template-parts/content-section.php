<?php
/**
 * The template part for displaying standard page sections on the homepage.
 *
 * @package Atomic
 */
?>

<div class="section-home clear">
	<?php
		atomic_remove_sharing();
		the_content();
	?>
</div><!-- .section-home -->
