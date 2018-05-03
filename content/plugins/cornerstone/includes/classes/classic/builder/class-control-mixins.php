<?php
/**
 * This class defines several control defaults. This way when
 * mapping elements we can do this: 'supports' => array( 'id', 'class', 'style' )
 */
class Cornerstone_Control_Mixins extends Cornerstone_Plugin_Component {

  private $cache;

  /**
   * Declare what mixins we're creating, and attach their callbacks.
   */
  public function setup() {

    $this->mixins = apply_filters( 'cornerstone_control_mixins', array(
      'id'         => array( $this, 'id' ),
      'class'      => array( $this, 'customClass' ),
      'style'      => array( $this, 'style' ),
      'padding'    => array( $this, 'padding' ),
      'border'     => array( $this, 'border' ),
      'link'       => array( $this, 'link' ),
      'visibility' => array( $this, 'visibility' ),
      'text_align' => array( $this, 'textAlign' ),
      'animation'  => array( $this, 'animation' ),
    ) );

    //
    // These hooks are used internally. They should never be used elsewhere.
    // Use the cornerstone_control_mixins hook above if needed.
    //

    foreach ($this->mixins as $name => $cb ) {
      add_filter( "_cornerstone_control_mixin_{$name}", array( $this, 'reset') );
      add_action( "_cornerstone_control_mixin_{$name}_action", array( $cb[0], $cb[1] ) );
    }

    //
		// Keys will be stripped from the output $atts
		// Callbacks will process
		//

		$this->mixin_expanders = apply_filters( 'cornerstone_control_mixin_expanders', array(
			'_text_color'  => array( $this, 'inject_text_color' ), // text_color is multipurpose, so we don't want to strip the key
			'margin'       => array( $this, 'inject_margin' ),
			'padding'      => array( $this, 'inject_padding' ),
			'border_style' => array( $this, 'inject_border_style' ),
			'border'       => null,
			'border_width' => null,
			'border_color' => null,
			'visibility'   => array( $this, 'inject_visibility' ),
			'text_align'   => array( $this, 'inject_text_align' ),
			'class'        => array( $this, 'inject_class' ),
			'style'        => array( $this, 'inject_style' ),
		) );

		add_filter( 'cornerstone_control_injections', array( $this, 'injector' ) );

  }

  /**
   * Reset the internal cache between retrieving each mixin.
   * This allows the API to remain consistent with element mappings.
   */
  public function reset() {
    $this->cache = array();
    do_action( current_filter() . '_action', $this );
    return $this->cache;
  }

  public function id() {

    $this->addControl(
      'id',
      'text',
      __( 'ID', 'cornerstone' ),
      __( 'Add an ID to this element so you can target it with your own customizations.', 'cornerstone' ),
      '',
      array( 'monospace' => true, 'advanced' => true )
    );

  }

  public function customClass() {

    $this->addControl(
      'class',
      'text',
      __( 'Class', 'cornerstone' ),
      __( 'Add custom classes to this element. Multiple classes should be seperated by spaces. They will be added at the root level element.', 'cornerstone' ),
      '',
      array( 'monospace' => true, 'advanced' => true )
    );

  }

  public function style() {

    $this->addControl(
      'style',
      'text',
      __( 'Style', 'cornerstone' ),
      __( 'Add an inline style to this element. This only contain valid CSS rules with no selectors or braces.', 'cornerstone' ),
      '',
      array( 'monospace' => true, 'advanced' => true )
    );

  }

  public function padding() {

    $this->addControl(
      'padding',
      'dimensions',
      __( 'Padding', 'cornerstone' ),
      __( 'Specify a custom padding for each side of this element. Can accept CSS units like px, ems, and % (default unit is px).', 'cornerstone' ),
      array( '0px', '0px', '0px', '0px', 'unlinked' )
    );

  }

  public function border() {

    $this->addControl(
      'border_style',
      'select',
      __( 'Border', 'cornerstone' ),
      __( 'Specify a custom border for this element by selecting a style, choosing a color, and inputting your dimensions.', 'cornerstone' ),
      'none',
      array(
        'choices' => array(
          array( 'value' => 'none',   'label' => __( 'None', 'cornerstone' ) ),
          array( 'value' => 'solid',  'label' => __( 'Solid', 'cornerstone' ) ),
          array( 'value' => 'dotted', 'label' => __( 'Dotted', 'cornerstone' ) ),
          array( 'value' => 'dashed', 'label' => __( 'Dashed', 'cornerstone' ) ),
          array( 'value' => 'double', 'label' => __( 'Double', 'cornerstone' ) ),
          array( 'value' => 'groove', 'label' => __( 'Groove', 'cornerstone' ) ),
          array( 'value' => 'ridge',  'label' => __( 'Ridge', 'cornerstone' ) ),
          array( 'value' => 'inset',  'label' => __( 'Inset', 'cornerstone' ) ),
          array( 'value' => 'outset', 'label' => __( 'Outset', 'cornerstone' ) )
        )
      )
    );

    $this->addControl(
      'border_color',
      'color',
      null,
      null,
      '',
      array(
        'condition' => array(
          'border_style:not' => 'none',
        )
      )
    );

    $this->addControl(
      'border',
      'dimensions',
      null,
      null,
      array( '1px', '1px', '1px', '1px', 'linked' ),
      array(
        'condition' => array(
          'border_style:not' => 'none',
        )
      )
    );

  }

  public function link() {

    $this->addControl(
      'href',
      'text',
      __( 'Href', 'cornerstone' ),
      __( 'Enter in the URL you want to link to.', 'cornerstone' ),
      '#'
    );

    $this->addControl(
      'href_title',
      'text',
      __( 'Link Title Attribute', 'cornerstone' ),
      __( 'Enter in the title attribute you want for your link.', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'href_target',
      'toggle',
      __( 'Open Link in New Window', 'cornerstone' ),
      __( 'Select to open your link in a new window.', 'cornerstone' ),
      false
    );

  }

  public function visibility() {

    $this->addControl(
      'visibility',
      'multi-choose',
      __( 'Hide based on screen width', 'cornerstone' ),
      __( 'Hide this element at different screen widths. Keep in mind that the &ldquo;Extra Large&rdquo; toggle is 1200px+, so you may not see your element disappear if your preview window is not large enough.', 'cornerstone' ),
      array(),
      array(
        'columns' => '5',
        'choices' => array(
          array( 'value' => 'xl', 'icon' => fa_entity( 'desktop' ), 'tooltip' => __( 'XL', 'cornerstone' ) ),
          array( 'value' => 'lg', 'icon' => fa_entity( 'laptop' ),  'tooltip' => __( 'LG', 'cornerstone' ) ),
          array( 'value' => 'md', 'icon' => fa_entity( 'tablet' ),  'tooltip' => __( 'MD', 'cornerstone' ) ),
          array( 'value' => 'sm', 'icon' => fa_entity( 'tablet' ),  'tooltip' => __( 'SM', 'cornerstone' ) ),
          array( 'value' => 'xs', 'icon' => fa_entity( 'mobile' ),  'tooltip' => __( 'XS', 'cornerstone' ) ),
        )
      )
    );

  }

  public function textAlign() {

    $this->addControl(
      'text_align',
      'choose',
      __( 'Text Align', 'cornerstone' ),
      __( 'Set a text alignment, or deselect to inherit from parent elements.', 'cornerstone' ),
      'none',
      array(
        'columns' => '4',
        'offValue' => '',
        'choices' => array(
          array( 'value' => 'l', 'icon' => fa_entity( 'align-left' ),    'tooltip' => __( 'Left', 'cornerstone' ) ),
          array( 'value' => 'c', 'icon' => fa_entity( 'align-center' ),  'tooltip' => __( 'Center', 'cornerstone' ) ),
          array( 'value' => 'r', 'icon' => fa_entity( 'align-right' ),   'tooltip' => __( 'Right', 'cornerstone' ) ),
          array( 'value' => 'j', 'icon' => fa_entity( 'align-justify' ), 'tooltip' => __( 'Justify', 'cornerstone' ) )
        )
      )
    );

  }

  public function animation() {

    $this->addControl(
      'animation',
      'select',
      __( 'Animation', 'cornerstone' ),
      __( 'Optionally add animation to your element as users scroll down the page.', 'cornerstone' ),
      'none',
      array(
        'choices' => self::animationChoices()
      )
    );

    $this->addControl(
      'animation_offset',
      'text',
      __( 'Animation Offset (%)', 'cornerstone' ),
      __( 'Specify a percentage value where the element should appear on screen for the animation to take place.', 'cornerstone' ),
      '50',
      array(
        'condition' => array(
          'animation:not' => 'none'
        )
      )
    );

    $this->addControl(
      'animation_delay',
      'text',
      __( 'Animation Delay (ms)', 'cornerstone' ),
      __( 'Specify an amount of time before the graphic animation starts in milliseconds.', 'cornerstone' ),
      '0',
      array(
        'condition' => array(
          'animation:not' => 'none'
        )
      )
    );

  }

  /**
   * Call from inside a mixin. Map controls in order you'd like them in the inspector pane.
   * @param string $name     Required. Control name - will become an attribute name for the element
   * @param string $type     Type of view used to create the UI for this control
   * @param string $title    Localized title. Set null to compact this control
   * @param string $tooltip  Localized tooltip. Only visible if title is set
   * @param array  $default  Values used to populate the control if the element doesn't have values of its own
   * @param array  $options  Information specific to this control. For example, the names and data of items in a dropdown
   */
  public function addControl( $name, $type, $title = null, $tooltip = null, $default = array(), $options = array() ) {
    $this->cache[] = array( 'name' => $name, 'controlType' => $type, 'controlTitle' => $title, 'controlTooltip' => $tooltip, 'defaultValue' => $default, 'options' => $options );
  }

  /**
   * Return animation choices.
   */
  public static function animationChoices() {
    return CS()->config_group( 'controls/animation-choices' );
  }





  /**
	 * Main Process. Filter attributes and run the expansion handlers
	 */

	public function injector( $atts ) {

		$expanders = apply_filters( 'cornerstone_control_mixin_expanders_dynamic', $this->mixin_expanders );

		$inject = array(
			'classes' => array(),
			'styles'  => array()
		);

		//
		// Run handlers
		//

		$expanded_callbacks = array_values( $expanders );
		foreach ( $expanded_callbacks as $callback ) {
			if ( is_callable( $callback ) ) {
				$inject = call_user_func( $callback, $inject, $atts );
			}
		}

		//
		// Remove processed keys
		//

		$expanded_keys = array_keys( $expanders );
		foreach ( $expanded_keys as $key ) {
			unset( $atts[$key] );
		}

		//
		// Inject attributes
		//

		$classes = array_values( $inject['classes'] );
		if ( count( $classes ) > 0 ) {
			$atts['class'] = trim( implode( $classes, ' ' ) );
		}

		$styles = array_values( $inject['styles'] );
		if ( count( $styles ) > 0 ) {
			$atts['style'] = Cornerstone_Style_Reducer::reduce( implode( ';', $styles ) );
		}

		return $atts;

	}

	/**
	 * Injection Handlers
	 */

	public function inject_text_color( $inject, $atts ) {

		if ( isset( $atts['text_color'] ) && $atts['text_color'] != '' ) {
			$inject['styles'][] = 'color: ' . $atts['text_color'] . ';';
		}

		return $inject;

	}

	public function inject_margin( $inject, $atts ) {

		if ( isset( $atts['margin'] ) && $atts['margin'] != '' ) {
			if ( is_array( $atts['margin'] ) ) {
				$atts['margin'] = Cornerstone_Control_Dimensions::simplify( $atts['margin'] );
			}
			$inject['styles'][] = 'margin: ' . $atts['margin'] . ';';
    }

		return $inject;

	}

	public function inject_padding( $inject, $atts ) {

		if ( isset( $atts['padding'] ) && $atts['padding'] != '' ) {
			if ( is_array( $atts['padding'] ) ) {
				$atts['padding'] = Cornerstone_Control_Dimensions::simplify( $atts['padding'] );
			}
			$inject['styles'][] = 'padding: ' . $atts['padding'] . ';';
    }

		return $inject;

	}

	public function inject_border_style( $inject, $atts ) {

		if ( isset( $atts['border_style'] ) && $atts['border_style'] != 'none' ) {

			$inject['styles'][] = 'border-style: ' . $atts['border_style'] . ';';

			if ( isset( $atts['border'] ) && $atts['border'] != '' ) {
				$atts['border_width'] = $atts['border'];
			}

			if ( isset( $atts['border_width'] ) && $atts['border_width'] != '' ) {
				if ( is_array( $atts['border_width'] ) ) {
					$atts['border_width'] = Cornerstone_Control_Dimensions::simplify( $atts['border_width'] );
				}
				$inject['styles'][] = 'border-width: ' . $atts['border_width'] . ';';
			}

			if ( isset( $atts['border_color'] ) && $atts['border_color'] != '' ) {
				$inject['styles'][] = 'border-color: ' . $atts['border_color'] . ';';
			}

		}

		return $inject;

	}

	public function inject_visibility( $inject, $atts ) {

		if ( isset( $atts['visibility'] ) ) {

			if ( is_array( $atts['visibility'] ) ) {
				$visibilty_classes = $atts['visibility'];
			} else {
				$visibilty_classes = explode(' ', $atts['visibility'] );
			}

			$visibilty_classes = CS()->common()->classMap( 'visibility', $visibilty_classes );

			if ( count( $visibilty_classes ) > 0 ) {
				$inject['classes'] = array_merge( $inject['classes'], $visibilty_classes );
			}

    }

		return $inject;

	}

	public function inject_text_align( $inject, $atts ) {

		if ( isset( $atts['text_align'] ) && $atts['text_align'] != 'none' ) {
			$inject['classes'][] = CS()->common()->classMap( 'text_align', $atts['text_align'] );
		}

		return $inject;

	}

	public function inject_class( $inject, $atts ) {

		if ( isset( $atts['class'] ) ) {
			$inject['classes'][] = $atts['class'];
		}

		return $inject;

	}

	public function inject_style( $inject, $atts ) {

		if ( isset( $atts['style'] ) ) {
			$inject['styles'][] = $atts['style'];
		}

		return $inject;

	}
}
