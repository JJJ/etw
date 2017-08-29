<?php
/**
 * Array Toolkit Gallery
 *
 * @package Array Toolkit
 * @since 1.0.0
 */


class Array_Toolkit_Gallery {

	/**
	 * Holds default gallery settings.
	 *
	 * @var array
	 */
	static $defaults = array(
		'before'      => '<div class="gallery-wrap"><div class="flexslider"><ul class="slides">',
		'after'       => '</ul></div></div>',
		'before_item' => '<li>',
		'after_item'  => '</li>',
		'image_size'  => 'large-image',
	);


	/**
	 * Adds action hooks
	 */
	function __construct() {

		// Scripts and styles
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_head' ) );

		// Meta box
		add_action( 'add_meta_boxes', array( $this, 'add_gallery_meta_box' ), 1 );

		// Save gallery
		add_action( 'wp_ajax_array_save_custom_gallery_meta', array( $this, 'save_gallery' ) );

	}



	/**
	 * Enqueues admin scripts and styles
	 *
	 * @since 1.0.0
	 */
	function admin_head( $hook ) {

		global $post;

		if( $hook != 'post.php' && $hook != 'post-new.php' )
			return;

		// add js vars
		echo '<script type="text/javascript">
		var array_ajax = {
			post_id : 0,
			nonce : ""
		};
		array_ajax.nonce = "' . wp_create_nonce( 'array-ajax' ) . '";
		array_ajax.post_id = "' . $post->ID . '";

		</script>';
		wp_enqueue_script( 'array-admin', plugin_dir_url(__FILE__) . '/gallery-admin.js', array( 'jquery' ), true );
		wp_enqueue_style( 'gallery-admin-styles', plugin_dir_url(__FILE__) . '/array-gallery.css', array(), '1.0.0', 'screen' );
	}




	/**
	 * Adds the Array Gallery meta box to supported post edit screens
	 *
	 * @since 1.0.0
	 */
	function add_gallery_meta_box() {

		$screens = array( 'post', 'array-portfolio' );
		foreach ( $screens as $screen ) {
			add_meta_box(
				'array_gallery_meta_box', // $id
				__( 'Featured Gallery', 'array-toolkit' ), // $title
				array( $this, 'show_gallery_meta_box' ), // $callback
				$screen, // $page
				'normal', // $context
				'high'); // $priority
		}

	}



	/**
	 * Outputs the markup for the Array Gallery meta box
	 *
	 * @since 1.0.0
	 */
	function show_gallery_meta_box() {

		global $post;

		$meta = get_post_meta( $post->ID, '_gallery_image_ids', true ); ?>

		<p>
			<a href="#" class="button button-primary button-large" id="array-gallery-button"><?php _e( 'Add Gallery', 'array-toolkit' ); ?></a>
			<input type="hidden" name="<?php echo $post->ID; ?>_gallery_image_ids" id="gallery_image_ids" value="<?php echo $meta; ?>" />
		</p>
		<div class="array-gallery-thumbs">
			<?php

			// update thumbs
			$thumbs = explode( ',', $meta );
			$thumbs_output = '';
			if ( $thumbs[0] != '' ) {
				foreach( $thumbs as $thumb ) {
					$thumbs_output .= '<li>' . wp_get_attachment_image( $thumb, array(125,125) ) . '</li>';
				}
			}
		   echo $thumbs_output; ?>
		</div>
		<script>
			jQuery(document).ready(function($) {

				function loadImages(images) {
					if( images ){

						var shortcode = new wp.shortcode({
							tag:    "gallery",
							attrs:   { ids: images },
							type:   "single"
						});
						var attachments = wp.media.gallery.attachments( shortcode );
						var selection = new wp.media.model.Selection( attachments.models, {
							props:    attachments.props.toJSON(),
							multiple: true
						});
						selection.gallery = attachments.gallery;
						// Fetch the query"s attachments, and then break ties from the
						// query to allow for sorting.
						selection.more().done( function() {
							// Break ties with the query.
							selection.props.set({ query: false });
							selection.unmirror();
							selection.props.unset("orderby");
						});

					return selection;
				}

				return false;
				}
				selection = loadImages(<?php echo json_encode($meta); ?>);
						$('#array-gallery-button').on('click', function() {
							var button = $(this);
							id = $('#gallery_image_ids');

							options =
							{
									frame:     'post',
									state:     'gallery-edit',
									title:     wp.media.view.l10n.editGalleryTitle,
									editing:   true,
									multiple:  true,
									selection: selection
							}
							frame = wp.media(options).open();

							// Tweak views
							frame.menu.get('view').unset('cancel');
							frame.menu.get('view').unset('separateCancel');
							frame.menu.get('view').get('gallery-edit').el.innerHTML = 'Edit Featured Gallery';
							frame.content.get('view').sidebar.unset('gallery'); // Hide Gallery Settings in sidebar

							// Override insert button
							function overrideGalleryInsert() {
								frame.toolbar.get('view').set({
									insert: {
										style: 'primary',
										text: 'Save Featured Gallery',
										click: function() {
										var models = frame.state().get('library'),
										ids = '';
										models.each( function( attachment ) {
											ids += attachment.id + ','
										});
										this.el.innerHTML = 'Saving...';

										$.ajax({
											type: 'POST',
											url: ajaxurl,
											data: {
												ids: ids,
												action: 'array_save_custom_gallery_meta',
												post_id: array_ajax.post_id,
												nonce: array_ajax.nonce
											},
											success: function(){
												selection = loadImages(ids);
												$(id).val( ids );
												frame.close();
											},
											dataType: 'html'
											}).done( function( data ) {
												$('.array-gallery-thumbs').html( data );
												if ($(".array-gallery-thumbs").html()) {
													$("#array-gallery-button").html("Edit Gallery").removeClass('button-primary');
												} else {
													$("#array-gallery-button").html("Add Gallery").addClass('button-primary');
												}
											});
										}
									}

								});
							}
							overrideGalleryInsert();

							frame.on( 'toolbar:render:gallery-edit', function() {
								overrideGalleryInsert();
							});
						});
					});

		</script>
		<?php
	}



	/**
	 * Saves the gallery data to the post meta
	 *
	 * @since 1.0.0
	 */
	function save_gallery() {

		// verify nonce
		if ( ! isset($_POST['ids'] ) || ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'array-ajax' ) ) {
			return;
		}

		// check autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		$post_id = absint( $_POST['post_id'] );
		$ids = strip_tags( rtrim( $_POST['ids'], ',' ) );
		update_post_meta( $post_id, '_gallery_image_ids', $ids );

		// update thumbs
		$thumbs = explode( ',', $ids );
		$thumbs_output = '';
		if ( $thumbs[0] != '' ) {
			foreach( $thumbs as $thumb ) {
				$thumbs_output .= '<li>' . wp_get_attachment_image( $thumb, array( 125, 125 ) ) . '</li>';
			}
		}
		echo $thumbs_output;
		die();
	}





	/**
	 * Template tag for displaying the gallery
	 *
	 * @since 1.0.0
	 */
	public static function array_gallery( $args = NULL ) {

		// Merge any passed markup with the defaults stored in self::$defaults
		$args = wp_parse_args( $args, self::$defaults );

		global $post;

		// Get our image IDs
		$image_ids = get_post_meta( $post->ID, '_gallery_image_ids', true );
		$images = explode( ',', $image_ids );

		if ( $images ) {
			echo $args['before'];

				foreach ( $images as $image ) {

					if ( is_single() ) {
						// Set the link to the image file on single views
						echo $args['before_item'] . '<a href="'. wp_get_attachment_url( $image ) .'">';

					} else {
						// Set the link to the post
						echo $args['before_item'] . '<a href="'. get_permalink( $post->ID ) .'">';

					}

					// Display the image
					echo wp_get_attachment_image( $image, $args['image_size'], false, false );
					echo '</a>' . $args['after_item'];

				}

			echo $args['after'];
		}
	}

}// class
$array_toolkit_gallery = new Array_Toolkit_Gallery;


/**
 * Displays a post's gallery
 */
function array_gallery( $args = NULL ) {

	return Array_Toolkit_Gallery::array_gallery( $args );
}