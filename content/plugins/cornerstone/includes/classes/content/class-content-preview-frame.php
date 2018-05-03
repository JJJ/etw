<?php

class Cornerstone_Content_Preview_Frame extends Cornerstone_Plugin_Component {

  protected $content_cache;

  public function setup() {

    $state = $this->plugin->component( 'Preview_Frame_Loader' )->get_state();

    if ( isset( $state['custom_js'] ) ) {

      $inline_scripts = $this->plugin->component('Inline_Scripts');

      foreach ($state['custom_js'] as $id => $content) {
        if ( $content ) {
          $inline_scripts->add_script_safely($id, $content);
        }
      }

    }

    do_action( 'cs_content_preview_setup', $state );
    add_action( 'template_redirect', array( $this, 'after_template_redirect' ), 9999999 );
    add_filter( '_cornerstone_custom_css', '__return_false' );

  }

  public function after_template_redirect() {

    $state = $this->plugin->component( 'Preview_Frame_Loader' )->get_state();

    if ( isset( $state['settings'] ) && isset( $state['settings']['general'] ) ) {
      $this->preview_general_settings( $state['settings']['general'] );
    }

    if ( isset( $state['settings'] ) && isset( $state['settings']['x-settings'] ) ) {
      $this->preview_x_settings( $state['settings']['x-settings'] );
    }

    add_filter( 'the_content', array( $this, 'output_content_zone' ), -9999999 );
		add_action( 'wp_footer', array( $this, 'process_content' ), -999999 );
  }

  /**
	 * Replace the page content with a wrapping div that will be re-populated
	 * with our javascript application.
	 */
	public function output_content_zone( $content ) {
		$this->content_cache = $content;
    ob_start();
    echo '<div id="cs-content" class="cs-content">';
    do_action('cs_content');
    echo '</div>';
    return ob_get_clean();
	}

	/**
	 * Process all the page shortcodes, but don't output anything.
	 * This allows shortcodes to enqueue scripts to the footer even if they
	 * were previously removed by the content wrapper.
	 */
	public function process_content() {
		apply_filters( 'the_content', $this->content_cache );
	}

  public function config( $state ) {
    return array(
      'mode' => $state['mode'],
      'post_id' => $state['post_id'],
      'responsive_text' => $state['responsive_text'],
      'dynamic_css_selector' => apply_filters('cs_dynamic_css_hook', null )
    );
  }

  public function preview_general_settings( $settings ) {

    global $post;

    if ( isset( $settings['post_title'] ) ) {
      $post->post_title = $settings['post_title'];
    }

    if ( isset( $settings['allow_comments'] ) ) {
      $post->comment_status = ( $settings['allow_comments'] ) ? 'open' : 'closed';
    }

    $updates = array();

    if ( isset( $settings['page_template'] ) ) {
      $updates['_wp_page_template'] = $settings['page_template'];
    }

    if ( ! empty( $updates ) ) {
      $this->plugin->component( 'Preview_Frame_Loader' )->prefilter_meta( get_the_ID(), $updates );
    }

  }

  public function preview_x_settings( $settings ) {

    $lookup = array(
      'alternate_index_title' => '_x_entry_alternate_index_title',
      'bg_image_full' => '_x_entry_bg_image_full',
      'bg_image_full_fade' => '_x_entry_bg_image_full_fade',
      'body_css_class' => '_x_entry_body_css_class',
      'disable_page_title' => '_x_entry_disable_page_title',
      'image_full_duration' => '_x_entry_image_full_duration',
      'one_page_navigation' => '_x_page_one_page_navigation'
    );

    $updates = array();
    foreach ($settings as $key => $value) {
      if ( isset( $lookup[$key] ) ) {
        $updates[$lookup[$key]] = $value;
      }
    }

    if ( ! empty( $updates ) ) {
      $this->plugin->component( 'Preview_Frame_Loader' )->prefilter_meta( get_the_ID(), $updates );
    }

  }

}
