<?php

// =============================================================================
// TCO.PHP
// -----------------------------------------------------------------------------
// Code commonly used across Themeco products.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Class Definition
//       a. Version
//       b. Boilerplate
// =============================================================================

// Class Definition
// =============================================================================

if ( ! class_exists( 'TCO_1_0' ) ) :

  class TCO_1_0 {

    // Version
    // -------

    const VERSION = '1.0';


    // Boilerplate
    // -----------

    private static $instance;
    protected $path = '';
    protected $url = '';

    public function __construct( $file ) {
      $this->path = trailingslashit( dirname( $file ) );
      add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), -999 );
      require_once( $this->path( 'class-tco-updates.php' ) );
      require_once( $this->path( 'class-tco-validator.php' ) );
      TCO_Updates::$tco = $this;
      TCO_Validator::$tco = $this;
    }

    public function init( $options ) {
      if ( isset( $options['url'] ) ) {
        $this->url = trailingslashit( $options['url'] );
      }
    }

    public static function instance() {
      if ( ! isset( self::$instance ) ) {
        self::$instance = new self( __FILE__ );
      }
      return self::$instance;
    }


    // Script & Style Registration
    // ---------------------------
    // 01. Admin styles.
    // 02. Admin scripts.

    public function admin_enqueue_scripts() {

      wp_register_style( $this->handle( 'admin-css' ), $this->url( 'dist/css/tco.css' ), array(), self::VERSION ); // 01

      $handle = $this->handle( 'admin-js' );

      wp_register_script( $handle, $this->url( 'dist/js/tco.js' ), array( 'jquery', 'wp-util' ), self::VERSION, true ); // 02

      // Localization will be handled by products, but this will setup fallbacks.
      wp_localize_script( $handle, 'tcoCommon', array(
        'debug' => ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ),
        'logo'  => $this->get_themeco_logo(),
        '_tco_nonce' => wp_create_nonce( 'tco-common' ),
        'strings' => apply_filters( 'tco_localize_' . $handle, array(
            'details' => 'Details',
            'back'    => 'Back',
            'yep'     => 'Yep',
            'nope'    => 'Nope'
          ) )
      ) );

    }


    // Helpers
    // -------
    // 01. Get a versioned handle that can be used to specify dependencies.
    // 02. Get the path to the /tco-common/ folder (optionally add to the path).
    // 03. Get the URL to the /tco-common/ folder (optionally add to the URL).
    // 04. Get the update module.
    // 05. Get current admin color scheme.
    // 06. Return admin image.
    // 07. Echo admin image.
    // 08. Return admin icon.
    // 09. Echo admin icon.
    // 10. Return Themeco logo.
    // 11. Echo Themeco logo.
    // 12. Return X logo.
    // 13. Echo X logo.
    // 14. Return Pro logo.
    // 15. Echo Pro logo.
    // 16. Return Header Builder logo.
    // 17. Echo Header Builder logo.
    // 18. Return Content Builder logo.
    // 19. Echo Content Builder logo.
    // 20. Return Footer Builder logo.
    // 21. Echo Footer Builder logo.
    // 22. Return Cornerstone logo.
    // 23. Echo Cornerstone logo.
    // 24. Return product logo.
    // 25. Echo product logo.
    // 26. Output styled admin notice.
    // 27. Get site URL.
    // 28. Check AJAX referrer.

    public function handle( $handle = 'admin-js' ) { // 01
      return 'tco-common-' . $handle . '-' . str_replace( '.', '-', self::VERSION );
    }

    public function path( $more = '' ) { // 02
      return $this->path . $more;
    }

    public function url( $more = '' ) { // 03
      return $this->url . $more;
    }

    public function updates() { // 04
    	return TCO_Updates::instance();
    }

    function get_current_admin_color_scheme( $type = 'colors' ) { // 05
      GLOBAL $_wp_admin_css_colors;
      $current_color_scheme = get_user_option( 'admin_color' );
      $admin_colors         = $_wp_admin_css_colors;
      $user_colors          = (array) $admin_colors[$current_color_scheme];
      return ( $type == 'icons' ) ? $user_colors['icon_colors'] : $user_colors['colors'];
    }

    public function get_admin_image( $image ) { // 06
      $image = $this->url( 'img/admin/' . $image );
      return $image;
    }

    public function admin_image( $image ) { // 07
      echo $this->get_admin_image( $image );
    }

    public function get_admin_icon( $icon, $class = '', $style = '' ) { // 08
      $href   = $this->url( 'img/admin/icons.svg#' . $icon );
      $class  = ( $class == '' ) ? '' : ' class="' . $class . '"';
      $style  = ( $style == '' ) ? '' : ' style="' . $style . '"';
      $output = '<svg' . $class . $style . '><use xlink:href="' . $href . '"></use></svg>';
      return $output;
    }

    public function admin_icon( $icon, $class = '', $style = '' ) { // 09
      echo $this->get_admin_icon( $icon, $class, $style );
    }

    public function get_themeco_logo( $class = '', $style = '' ) { // 10

      $class  = ( $class == '' ) ? '' : ' class="' . $class . '"';
      $style  = ( $style == '' ) ? '' : ' style="' . $style . '"';

      $logo = '<svg' . $class . $style . ' version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 4320 504" style="enable-background:new 0 0 4320 504;" xml:space="preserve">
                 <polygon points="198,0 0,0 0,108 198,108 198,504 306,504 306,108 504,108 504,0 306,0     "/>
                 <polygon points="1008,198 720,198 720,0 612,0 612,198 612,306 612,504 720,504 720,306 1008,306 1008,504 1116,504 1116,306 1116,198 1116,0 1008,0    "/>
                 <rect x="1224" width="504" height="108"/>
                 <rect x="1224" y="198" width="504" height="108"/>
                 <rect x="1224" y="396" width="504" height="108"/>
                 <polygon points="2214,0 2106,0 1944,0 1836,0 1836,108 1836,504 1944,504 1944,108 2106,108 2106,504 2214,504 2214,108 2376,108 2376,504 2484,504 2484,108 2484,0 2376,0    "/>
                 <rect x="2592" width="504" height="108"/>
                 <rect x="2592" y="198" width="504" height="108"/>
                 <rect x="2592" y="396" width="288" height="108"/>
                 <rect x="2988" y="396" width="108" height="108"/>
                 <polygon points="3204,0 3204,108 3204,396 3204,504 3312,504 3708,504 3708,396 3312,396 3312,108 3708,108 3708,0 3312,0     "/>
                 <path d="M4212,0h-288h-108v108v288v108h108h288h108V396V108V0H4212z M4212,396h-288V108h288V396z"/>
               </svg>';

      return $logo;

    }

    public function themeco_logo( $class = '', $style = '' ) { // 11
      echo $this->get_themeco_logo( $class, $style );
    }

    public function get_x_logo( $class = '', $style = '' ) { // 12

      $class  = ( $class == '' ) ? '' : ' class="' . $class . '"';
      $style  = ( $style == '' ) ? '' : ' style="' . $style . '"';

      $logo = '<svg' . $class . $style . ' viewBox="0 0 314 314" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                 <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                   <g transform="translate(-465.000000, -660.000000)" fill="#000000">
                     <g transform="translate(465.000000, 660.000000)">
                       <polygon points="92.2385914 87 123.226879 87 157.525701 139.018555 192.196599 87.0859375 221.951847 87.0859375 174.820623 156.598633 223.402654 227.489258 191.967905 227.489258 157.755193 175.689453 122.392888 227.351562 91 227.351562 140.283513 156.523438"></polygon>
                       <path d="M157,314 C70.2912943,314 0,243.708706 0,157 C0,70.2912943 70.2912943,0 157,0 C243.708706,0 314,70.2912943 314,157 C314,243.708706 243.708706,314 157,314 Z M157,291 C231.006156,291 291,231.006156 291,157 C291,82.9938435 231.006156,23 157,23 C82.9938435,23 23,82.9938435 23,157 C23,231.006156 82.9938435,291 157,291 Z"></path>
                     </g>
                   </g>
                 </g>
               </svg>';

      return $logo;

    }

    public function x_logo( $class = '', $style = '' ) { // 13
      echo $this->get_x_logo( $class, $style );
    }

    public function get_pro_logo( $class = '', $style = '' ) { // 14

      $class  = ( $class == '' ) ? '' : ' class="' . $class . '"';
      $style  = ( $style == '' ) ? 'fill: #265998;' : $style;

      $logo = '<svg' . $class . ' style="' . $style . '" viewBox="0 0 281 317" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <g id="pro-solid">
          <g id="Pro-Logo">
            <path d="M127.406476,2.7395047 C133.616099,-0.858480949 143.727203,-0.915998835 149.978168,2.60422723 L269.977989,70.1820261 C276.234367,73.7053001 281.306163,82.3896987 281.306163,89.5607286 L281.306163,225.974417 C281.306163,233.153704 276.249926,241.851898 270.007866,245.405149 L149.948291,313.74828 C143.708414,317.300289 133.633456,317.241619 127.435773,313.61169 L11.2142214,245.541739 C5.02077793,241.914293 1.07802775e-13,233.145446 1.03838259e-13,225.974417 L2.84217094e-14,89.5607286 C2.44526274e-14,82.3814407 5.03711142,73.6428704 11.2435182,70.0467487 L127.406476,2.7395047 Z M78.801,128.209 C68.791,128.209 58.781,128.3 48.771,128.3 L48.771,192 L60.783,192 L60.783,173.254 L78.801,173.254 C110.014,173.254 109.923,128.209 78.801,128.209 Z M166.798,191.181 L147.506,169.432 C159.609,166.975 163.613,158.148 163.613,149.412 C163.613,138.401 155.696,128.391 140.681,128.3 C130.58,128.3 120.479,128.209 110.378,128.209 L110.378,192 L122.39,192 L122.39,170.706 L133.947,170.706 L152.511,192 L166.798,192 L166.798,191.181 Z M140.681,139.493 C148.234,139.493 151.601,144.589 151.601,149.685 C151.601,154.781 148.325,159.877 140.681,159.877 L122.39,159.877 L122.39,139.493 L140.681,139.493 Z M80.6799927,138.490005 C88.2327319,138.490005 90.6000061,145.583993 90.6000061,150.679993 C90.6000061,155.775993 88.3237288,162.880005 80.6799927,162.880005 L60.3899994,162.880005 L60.3899994,138.493 L80.6799927,138.490005 Z M201.651,127.026 C179.629,127.026 168.891,143.861 168.891,160.605 C168.891,177.349 179.265,193.456 201.651,193.456 C224.037,193.456 234.138,176.985 234.32,160.514 C234.502,143.861 223.582,127.026 201.651,127.026 Z M201.651,137.946 C216.666,137.946 222.672,149.958 222.49,160.696 C222.308,171.161 216.666,182.445 201.651,182.445 C186.636,182.445 180.994,171.252 180.721,160.787 C180.448,150.049 186.636,137.946 201.651,137.946 Z" id="Combined-Shape"></path>
          </g>
        </g>
      </svg>';

      return $logo;

    }

    public function pro_logo( $class = '', $style = '' ) { // 15
      echo $this->get_pro_logo( $class, $style );
    }

    public function get_header_builder_logo( $class = '', $style = '' ) { // 16

      $class  = ( $class == '' ) ? '' : ' class="' . $class . '"';
      $style  = ( $style == '' ) ? '' : ' style="' . $style . '"';

      $logo = '<svg' . $class . $style . ' viewBox="0 0 340 232" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;">
                 <g transform="matrix(1,0,0,1,-2456.75,-5251.97)">
                   <g transform="matrix(1.40625,-8.09101e-17,-5.21329e-17,1,843.357,4613.58)">
                     <g transform="matrix(0.711111,8.55019e-18,-6.47074e-18,1,320.729,57.1198)">
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1069.64,411.741)">
                         <path d="M166.277,480L471.118,304L581.969,368L277.128,544L166.277,480Z" style="fill:rgb(198,135,223);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1069.64,411.741)">
                         <path d="M581.969,432L277.128,608L277.128,544L581.969,368L581.969,432Z" style="fill:rgb(157,118,189);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1069.64,411.741)">
                         <path d="M166.277,480L166.277,544L277.128,608L277.128,544L166.277,480Z" style="fill:rgb(141,96,179);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1054.18,420.664)">
                         <path d="M692.82,592L803.672,528L803.672,464L692.82,528L692.82,592Z" style="fill:rgb(0,188,225);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1054.18,420.664)">
                         <path d="M637.395,368L526.543,432L692.82,528L803.672,464L637.395,368Z" style="fill:rgb(23,207,243);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1054.18,420.664)">
                         <path d="M692.82,592L526.543,496L526.543,432L692.82,528L692.82,592Z" style="fill:rgb(0,172,207);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1069.64,411.741)">
                         <path d="M304.841,624L304.841,560L471.118,656L471.118,720L304.841,624Z" style="fill:rgb(0,172,207);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1069.64,411.741)">
                         <path d="M637.395,624L637.395,560L471.118,656L471.118,720L637.395,624Z" style="fill:rgb(0,188,225);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1069.64,411.741)">
                         <path d="M471.118,464L304.841,560L471.118,656L637.395,560L471.118,464Z" style="fill:rgb(23,207,243);"/>
                       </g>
                     </g>
                   </g>
                 </g>
               </svg>';

      return $logo;

    }

    public function header_builder_logo( $class = '', $style = '' ) { // 17
      echo $this->get_header_builder_logo( $class, $style );
    }

    public function get_content_builder_logo( $class = '', $style = '' ) { // 18

      $class  = ( $class == '' ) ? '' : ' class="' . $class . '"';
      $style  = ( $style == '' ) ? '' : ' style="' . $style . '"';

      $logo = '<svg' . $class . $style . ' viewBox="0 0 345 232" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;">
                 <g transform="matrix(1,0,0,1,-3343.72,-5251.96)">
                   <g transform="matrix(1.40625,-8.09101e-17,-5.21329e-17,1,843.357,4613.58)">
                     <g transform="matrix(1,0,1.2326e-32,1,-153.994,13.4452)">
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M237.029,152.955L237.029,185.144L223.104,177.092L223.104,161.005L223.086,161.005L181.258,136.851L181.258,120.746L237.029,152.955Z" style="fill:rgb(0,172,207);"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M181.258,120.746L237.029,152.955L334.629,96.607L278.858,64.399L181.258,120.746Z" style="fill:rgb(23,207,243);fill-rule:nonzero;"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M237.029,152.955L237.029,185.144L334.629,128.798L334.629,96.607L237.029,152.955Z" style="fill:rgb(0,188,225);fill-rule:nonzero;"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M223.086,161.004L167.315,193.197L167.315,225.404L223.086,193.197L223.105,177.093L223.105,161.004L223.086,161.004Z" style="fill:rgb(157,118,189);fill-rule:nonzero;"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M111.56,193.214L167.315,225.404L167.315,193.197L111.56,161.004L111.56,193.214Z" style="fill:rgb(141,96,179);fill-rule:nonzero;"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M223.086,161.005L167.314,193.197L111.561,161.005L153.371,136.851L167.314,128.798L181.258,136.851L223.086,161.005Z" style="fill:rgb(198,135,223);"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M223.086,177.093L223.105,177.093L223.086,177.093Z" style="fill:rgb(254,120,100);fill-rule:nonzero;"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M98.804,153.65L98.804,152.955L98.804,153.65Z" style="fill:rgb(254,120,100);fill-rule:nonzero;"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M167.315,0L0,96.607L97.619,152.955L153.371,120.746L139.447,112.711L111.543,96.607L223.105,32.209L167.315,0Z" style="fill:rgb(23,207,243);"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M0,128.798L97.898,185.318L98.804,184.812L98.804,153.65L97.619,152.955L0,96.607L0,128.798Z" style="fill:rgb(0,172,207);fill-rule:nonzero;"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M223.104,32.209L223.104,64.399L139.447,112.693L139.447,112.711L111.543,96.607L223.104,32.209Z" style="fill:rgb(0,188,225);"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M98.804,185.841L97.899,185.318L98.804,185.841Z" style="fill:rgb(254,120,100);fill-rule:nonzero;"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M97.619,185.493L97.898,185.318L97.619,185.493Z" style="fill:rgb(254,120,100);fill-rule:nonzero;"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M98.804,185.841L98.804,184.812L98.804,185.841Z" style="fill:rgb(254,120,100);fill-rule:nonzero;"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M153.371,120.746L153.371,136.851L111.561,161.005L111.561,177.441L111.543,177.441L98.804,184.812L98.804,153.65L97.619,152.955L153.371,120.746Z" style="fill:rgb(0,188,225);fill-rule:nonzero;"/>
                       </g>
                     </g>
                   </g>
                 </g>
               </svg>';

      return $logo;

    }

    public function content_builder_logo( $class = '', $style = '' ) { // 19
      echo $this->get_content_builder_logo( $class, $style );
    }

    public function get_footer_builder_logo( $class = '', $style = '' ) { // 20

      $class  = ( $class == '' ) ? '' : ' class="' . $class . '"';
      $style  = ( $style == '' ) ? '' : ' style="' . $style . '"';

      $logo = '<svg' . $class . $style . ' viewBox="0 0 340 232" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;">
                 <g transform="matrix(1,0,0,1,-2900.24,-5251.97)">
                   <g transform="matrix(1.40625,-8.09101e-17,-5.21329e-17,1,843.357,4613.58)">
                     <g transform="matrix(0.711111,8.55019e-18,-6.47074e-18,1,299.899,57.1198)">
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1449.69,376.05)">
                         <path d="M692.82,592L803.672,528L803.672,464L692.82,528L692.82,592Z" style="fill:rgb(0,188,225);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1449.69,376.05)">
                         <path d="M637.395,368L526.543,432L692.82,528L803.672,464L637.395,368Z" style="fill:rgb(23,207,243);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1449.69,376.05)">
                         <path d="M692.82,592L526.543,496L526.543,432L692.82,528L692.82,592Z" style="fill:rgb(0,172,207);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1465.15,367.128)">
                         <path d="M304.841,624L304.841,560L471.118,656L471.118,720L304.841,624Z" style="fill:rgb(0,172,207);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1465.15,367.128)">
                         <path d="M637.395,624L637.395,560L471.118,656L471.118,720L637.395,624Z" style="fill:rgb(0,188,225);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1465.15,367.128)">
                         <path d="M471.118,464L304.841,560L471.118,656L637.395,560L471.118,464Z" style="fill:rgb(23,207,243);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1650.6,474.2)">
                         <path d="M166.277,480L471.118,304L581.969,368L277.128,544L166.277,480Z" style="fill:rgb(198,135,223);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1650.6,474.2)">
                         <path d="M581.969,432L277.128,608L277.128,544L581.969,368L581.969,432Z" style="fill:rgb(157,118,189);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1650.6,474.2)">
                         <path d="M166.277,480L166.277,544L277.128,608L277.128,544L166.277,480Z" style="fill:rgb(141,96,179);"/>
                       </g>
                     </g>
                   </g>
                 </g>
               </svg>';

      return $logo;

    }

    public function footer_builder_logo( $class = '', $style = '' ) { // 21
      echo $this->get_footer_builder_logo( $class, $style );
    }

    public function get_cornerstone_logo( $class = '', $style = '' ) { // 22

      $class  = ( $class == '' ) ? '' : ' class="' . $class . '"';
      $style  = ( $style == '' ) ? '' : ' style="' . $style . '"';

      $logo = '<svg' . $class . $style . ' version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="-137 283 336 227" enable-background="new -137 283 336 227" xml:space="preserve">
                 <path fill="#26CABC" d="M86.8,444.8C52.6,464.5,65.3,457.2,31,477c-5.9-3.4-49.9-28.8-55.8-32.2c61.8-35.7,25.9-15,55.8-32.2C49.9,423.5,33.8,414.2,86.8,444.8z"/>
                 <path fill="#22B3A6" d="M86.8,444.8V477c-34.2,19.7-21.5,12.4-55.8,32.2V477C65.2,457.3,52.5,464.6,86.8,444.8z"/>
                 <path fill="#1D968D" d="M31,477v32.2c-5.9-3.4-49.9-28.8-55.8-32.2v-32.2C-18.9,448.2,25.1,473.6,31,477z"/>
                 <path fill="#DF5540" d="M-38.7,436.7L-38.7,436.7v32.2c-54.9-31.7-13.2-7.6-97.6-56.4v-32.1C-135.9,380.7-67.1,420.3-38.7,436.7z"/>
                 <path fill="#FA5745" d="M86.8,316v32.2c-74.9,43.3-33.5,19.4-83.7,48.3l-27.9-16.1C73,324,24.8,351.8,86.8,316z"/>
                 <path fill="#FE7864" d="M31,283.8l-167.3,96.6c0.5,0.3,69.2,40,97.6,56.3l55.8-32.2c-17.7-10.2-8.7-5-41.8-24.1C73,324,24.8,351.8,86.8,316L31,283.8z"/>
                 <path fill="#FE7864" d="M142.5,348.2c-13.4,7.7-83.9,48.4-97.6,56.3l55.8,32.2c29-16.7,94.9-54.8,97.6-56.4C164.1,360.7,176.8,368,142.5,348.2z"/>
                 <path fill="#FA5745" d="M198.3,380.4v32.2c0,0-97.6,56.3-97.6,56.4v-32.2C129.7,420,195.6,382,198.3,380.4z"/>
                 <path fill="#FA5745" d="M17,404.5v16.1c-17.8,10.3-8.8,5.1-41.8,24.1v16.4l-13.6,7.9l-0.3-0.2v-32.2l0,0L17,404.5z"/>
                 <path fill="#DF5540" d="M100.7,436.8V469l-13.9-8.1l0,0v-16.1C59,428.7,59.4,429,45,420.6v-16.1l0,0L100.7,436.8z"/>
               </svg>';

      return $logo;

    }

    public function cornerstone_logo( $class = '', $style = '' ) { // 23
      echo $this->get_cornerstone_logo( $class, $style );
    }

    public function get_product_logo( $product, $class = '', $style = '' ) { // 24
      $function = array( $this, "get_{$product}_logo" );
      if ( is_callable( $function ) ) {
        return call_user_func( $function, $class, $style );
      }
      return '';
    }

    public function product_logo( $product, $class = '', $style = '' ) { // 25
      echo $this->get_product_logo( $product, $class, $style );
    }

    public function admin_notice( $msg = '', $args = array() ) { // 26

      if ( is_array( $msg ) ) {
        $args = $msg;
      }

      $args = wp_parse_args( $args, array(
        'message'     => is_string( $msg ) ? $msg : '',
        'handle'      => false,
        'echo'        => true,
        'class'       => '',
        'dismissible'  => false,
        'ajax_dismiss' => false
      ) );

      extract( $args );

      $script = '';

      if ( is_string( $ajax_dismiss ) ) {

        if ( ! $handle ) {
          $handle = 'tco_' . uniqid();
        }

        ob_start(); ?>

        <script type="text/javascript">
        jQuery( function( $ ) {
          $('[data-tco-notice="<?php echo $handle; ?>"]').on( 'click', '.notice-dismiss', function(){
            $.post('<?php echo admin_url('admin-ajax.php?action=' . esc_attr( $ajax_dismiss ) ); ?>');
          });
        } );
        </script>
        <?php

        $script = ob_get_clean();

      }

      $class = ( $dismissible ) ? ' ' . $class . ' is-dismissible' : ' ' . $class;

      $logo_svg = $this->get_themeco_logo();
      $logo = "<a class=\"tco-notice-logo\" href=\"https://theme.co/\" target=\"_blank\">{$logo_svg}</a>";

      if ( $handle ) {
      $handle = "data-tco-notice=\"$handle\"";
      }

      $notice = "<div class=\"tco-notice notice {$class}\" {$handle}>{$logo}<p>{$message}</p></div>{$script}";

      if ( $echo ) {
        echo $notice;
      }

      return $notice;

    }

    public function get_site_url() { // 27
      return esc_attr( trailingslashit( network_home_url() ) );
    }

    public function check_ajax_referer( $die = true ) { // 28

      if ( ! isset( $_REQUEST['_tco_nonce'] ) ) {
        return false;
      }

      $check = ( false !== wp_verify_nonce( $_REQUEST['_tco_nonce'], 'tco-common' ) );

      if ( ! $check && $die ) {
        wp_send_json_error();
      }

      return $check;

    }


    // Compatibilty Functions
    // ----------------------

    public function xpro_logo( $class = '', $style = '' ) {
      echo $this->get_pro_logo( $class, $style );
    }

    public function get_xpro_logo( $class = '', $style = '' ) {
      return $this->get_pro_logo( $class, $style );
    }

  }

endif;
