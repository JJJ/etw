<?php

class Cornerstone_CLI_Headers extends WP_CLI_Command {

  public function create( $args, $assoc_args ) {

    $fields = wp_parse_args( $assoc_args, array(
      'title' => 'New Header'
    ) );

    $header = new Cornerstone_Header( array('title' => $fields['title'] ) );
    $data = $header->save();
    $id = $data['id'];

    WP_CLI::success( "Header created! ID: $id" );
  }

  public function lookup( $args ) {
    $header = new Cornerstone_Header( (int) $args[0] );
    if ($args[1] ) {
      $method = array( $header, $args[1] );
      if ( is_callable( $method ) ) {
        var_dump( call_user_func_array( $method, array() ) );
      } else {
        WP_CLI::success( "Header does not have method: {$args[1]}" );
      }
    } else {
      var_dump( $header );
    }

  }

  public function delete_all( $args, $assoc_args ) {

    if ( ! isset($assoc_args['confirm']) || ! $assoc_args['confirm'] ) {
      return WP_CLI::error( 'This will delete all headers. Add --confirm to continue');
    }

    $posts = get_posts( array(
      'post_type' => 'cs_header',
      'post_status' => 'any',
      'orderby' => 'type',
      'posts_per_page' => 2500
    ) );

    $progress = \WP_CLI\Utils\make_progress_bar( 'Deleting headers', count( $posts ) );

    foreach ($posts as $post) {
      $header = new Cornerstone_Header( $post->ID );
      $header->delete();
      $progress->tick();
    }

    $progress->finish();

  }
}
