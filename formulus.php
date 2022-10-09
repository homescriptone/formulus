<?php
if ( ! function_exists( 'formulus_input_fields' ) ) {
	/**
	 * Generate appropriate fields for meta and page in WordPress.
	 *
	 * @param string $key Key.
	 * @param mixed  $args Arguments.
	 * @param string $value (default: null).
	 *
	 * @return string
	 */
	function formulus_input_fields( $key, $args, $value = null ) {

		if ( ! defined( 'ABSPATH' ) ) {
			die( 'This function requires WordPress to be runned.' );
		}

		$defaults = array(
			'type'              => 'text',
			'label'             => '',
			'description'       => '',
			'placeholder'       => '',
			'maxlength'         => false,
			'required'          => false,
			'autocomplete'      => false,
			'id'                => $key,
			'class'             => array(),
			'label_class'       => array(),
			'input_class'       => array(),
			'return'            => false,
			'options'           => array(),
			'custom_attributes' => array(),
			'validate'          => array(),
			'default'           => '',
			'autofocus'         => '',
			'priority'          => '',
		);

		$args = wp_parse_args( $args, $defaults );
		$args = apply_filters( 'formulus_form_field_args', $args, $key, $value );

		if ( $args['required'] ) {
			$args['class'][] = 'validate-required';
			$required        = '&nbsp;<abbr class="required" title="' . esc_attr__( 'required', 'formulus' ) . '">*</abbr>';
		} else {
			$required = '&nbsp;<span class="optional">(' . esc_html__( 'optional', 'formulus' ) . ')</span>';
		}

		if ( is_string( $args['label_class'] ) ) {
			$args['label_class'] = array( $args['label_class'] );
		}

		if ( is_null( $value ) || empty( $value ) ) {
			$value = $args['default'];
		}

		$counter = 0;
		$limit   = 0;

		if ( ! isset( $args['textarea_class'] ) ) {
			$args['textarea_class'] = array();
		}

		// Custom attribute handling.
		$custom_attributes         = array();
		$args['custom_attributes'] = array_filter( (array) $args['custom_attributes'], 'strlen' );

		if ( $args['maxlength'] ) {
			$args['custom_attributes']['maxlength'] = absint( $args['maxlength'] );
		}

		if ( ! empty( $args['autocomplete'] ) ) {
			$args['custom_attributes']['autocomplete'] = $args['autocomplete'];
		}

		if ( true === $args['autofocus'] ) {
			$args['custom_attributes']['autofocus'] = 'autofocus';
		}

		if ( $args['description'] ) {
			$args['custom_attributes']['aria-describedby'] = $args['id'] . '-description';
		}

		if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
			foreach ( $args['custom_attributes'] as $attribute => $attribute_value ) {
				$custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
			}
		}

		if ( ! empty( $args['validate'] ) ) {
			foreach ( $args['validate'] as $validate ) {
				$args['class'][] = 'validate-' . $validate;
			}
		}

		$field    = '';
		$label_id = $args['id'];
		$sort     = $args['priority'] ? $args['priority'] : '';
		if ( isset( $custom_attributes['wrapper'] ) ) {
			$field_container = '<p class="form-row %1$s" id="%2$s" data-priority="' . esc_attr( $sort ) . '">%3$s</p><br/>';
		} else {
			$field_container = '%3$s';
		}

		switch ( $args['type'] ) {
			case 'textarea':
				$field_container = '<div class="form-row %1$s ' . esc_attr( implode( ' ', $args['textarea_class'] ) ) . '" id="%2$s" data-priority="' . esc_attr( $sort ) . '">%3$s</div><br/>';
				$n_time          = 1;
				if ( isset( $args['n_display'] ) ) {
					$n_time  = $args['n_display'];
					$limit   = $n_time;
					$counter = 1;
				}
				while ( $counter <= $limit ) {
					if ( isset( $args['multiple_values'] ) ) {
						$value = $args['multiple_values'][ $counter - 1 ];
					}
					$field .= '<textarea name="' . esc_attr( $key ) . '" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . ( empty( $args['custom_attributes']['rows'] ) ? ' rows="2"' : '' ) . ( empty( $args['custom_attributes']['cols'] ) ? ' cols="5"' : '' ) . implode( ' ', $custom_attributes ) . ' data-id="' . $counter . '">' . esc_textarea( $value ) . '</textarea><br/>';
					++ $counter;
				}
				break;
			case 'checkbox':
				$field = '<label class="checkbox ' . implode( ' ', $args['label_class'] ) . '" ' . implode( ' ', $custom_attributes ) . '>
						<input type="' . esc_attr( $args['type'] ) . '" class="input-checkbox ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="1" ' . checked( $value, 1, false ) . ' /> ' . $args['label'] . $required . '</label>';

				break;
			case 'text':
			case 'password':
			case 'datetime':
			case 'datetime-local':
			case 'date':
			case 'month':
			case 'time':
			case 'week':
			case 'number':
			case 'email':
			case 'url':
			case 'tel':
				$field .= '<input type="' . esc_attr( $args['type'] ) . '" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '"  value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />';

				break;
			case 'select':
				$field   = '';
				$options = '';

				if ( isset( $args['options'] ) ) {
					foreach ( $args['options'] as $option_key => $option_text ) {
						$selected = '';
						if ( '' === $option_key ) {
							// If we have a blank option, select2 needs a placeholder.
							if ( empty( $args['placeholder'] ) ) {
								$args['placeholder'] = $option_text ? $option_text : __( 'Choose an option', 'formulus' );
							}
							$custom_attributes[] = 'data-allow_clear="true"';
						}

						if ( isset( $args['selected'] ) && in_array( $option_key, $args['selected'], true ) ) {
							$selected = 'selected=selected';
						}

						$options .= '<option value="' . esc_attr( $option_key ) . '" ' . selected( $value, $option_key, false ) . ' ' . $selected . ' >' . esc_attr( $option_text ) . '</option>';
					}

					$field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . ' data-placeholder="' . esc_attr( $args['placeholder'] ) . '">
							' . $options . '
						</select>';
				}

				break;
			case 'radio':
				$label_id .= '_' . current( array_keys( $args['options'] ) );

				if ( ! empty( $args['options'] ) ) {

					foreach ( $args['options'] as $option_key => $option_text ) {
						$field .= '<div> <input type="radio" class="input-radio ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" value="' . esc_attr( $option_key ) . '" name="' . esc_attr( $key ) . '" ' . implode( ' ', $custom_attributes ) . ' id="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '"' . checked( $value, $option_key, false ) . ' />';
						$field .= '<label for="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '" class="radio ' . implode( ' ', $args['label_class'] ) . '">' . $option_text . '</label> </div>';
					}
				}

				break;
		}

		if ( ! empty( $field ) ) {
			$field_html = '';

			if ( $args['label'] && 'checkbox' !== $args['type'] ) {
				$field_html .= '<label for="' . esc_attr( $label_id ) . '" class="' . esc_attr( implode( ' ', $args['label_class'] ) ) . '"><strong>' . $args['label'] . $required . '</strong></label>';
			}

			$field_html .= '<span class="formulus-input-wrapper">' . $field;

			if ( $args['description'] ) {
				$field_html .= '<span class="description" id="' . esc_attr( $args['id'] ) . '-description" aria-hidden="true">' . wp_kses_post( $args['description'] ) . '</span>';
			}

			$field_html .= '</span> ';

			$container_class = esc_attr( implode( ' ', $args['class'] ) );
			$container_id    = esc_attr( $args['id'] ) . '_field';
			$field           = sprintf( $field_container, $container_class, $container_id, $field_html );
		}

		/**
		 * Filter by type.
		 */
		$field = apply_filters( 'formulus_form_field_' . $args['type'], $field, $key, $args, $value );

		/**
		 * General filter on form fields.
		 *
		 * @since 3.4.0
		 */
		$field = apply_filters( 'formulus_form_field', $field, $key, $args, $value );

		if ( $args['return'] ) {
			return $field;
		} else {
			formulus_format_fields( $field );
		}
	}
}

if ( ! function_exists( 'formulus_input_table' ) ) {
	/**
	 * Build table containing multiple input.
	 *
	 * @param  mixed $key Key of table.
	 * @param  mixed $args List of fields that must been added to the table.
	 * @return void
	 */
	function formulus_input_table( $key, $args ) {
		$html = "<table style='border-style:double;' name='formulus-input-" . $key . "'> <tbody>";
		foreach ( $args as $arg ) {
			$label_class = '';
			if ( isset( $arg['label_class'] ) ) {
				$label_class = $arg['label_class'];
			}
			$tr_class = '';
			if ( isset( $arg['tr_class'] ) ) {
				$tr_class = $arg['tr_class'];
			}
			$html .= "<tr class='" . $tr_class . "'><td class='" . $label_class . "'>";
			if ( isset( $arg['label'] ) ) {
				$html .= '<strong>' . $arg['label'] . '</strong>';
			}
			if ( isset( $arg['description'] ) ) {
				$html .= '<br/>' . $arg['description'];
			}
			$html .= '</td><td>';
			if ( isset( $arg['content'] ) ) {
				$html .= $arg['content'];
			}
			$html .= '</td></tr>';
		}
		$html .= '</tbody></table>';
		formulus_format_fields( $html );
	}
}

if ( ! function_exists( 'formulus_format_fields' ) ) {

	/**
	 * Escape html fields based on some tags.
	 *
	 * @param  mixed $html_field Html code to escape.
	 *
	 * @return void
	 */
	function formulus_format_fields( $html_field ) {
		$allowedposttags = array();
		$allowed_atts    = array(
			'align'            => array(),
			'class'            => array(),
			'type'             => array(),
			'id'               => array(),
			'dir'              => array(),
			'lang'             => array(),
			'style'            => array(),
			'xml:lang'         => array(),
			'src'              => array(),
			'alt'              => array(),
			'href'             => array(),
			'rev'              => array(),
			'target'           => array(),
			'novalidate'       => array(),
			'value'            => array(),
			'name'             => array(),
			'tabindex'         => array(),
			'action'           => array(),
			'method'           => array(),
			'for'              => array(),
			'width'            => array(),
			'height'           => array(),
			'data'             => array(),
			'title'            => array(),
			'checked'          => array(),
			'placeholder'      => array(),
			'rel'              => array(),
			'data-analytic-id' => array(),
			'data-id'          => array(),
			'rows'             => array(),
			'selected'         => array(),

		);
		$allowedposttags['form']     = $allowed_atts;
		$allowedposttags['label']    = $allowed_atts;
		$allowedposttags['select']   = $allowed_atts;
		$allowedposttags['input']    = $allowed_atts;
		$allowedposttags['textarea'] = $allowed_atts;
		$allowedposttags['iframe']   = $allowed_atts;
		$allowedposttags['script']   = $allowed_atts;
		$allowedposttags['style']    = $allowed_atts;
		$allowedposttags['strong']   = $allowed_atts;
		$allowedposttags['small']    = $allowed_atts;
		$allowedposttags['table']    = $allowed_atts;
		$allowedposttags['span']     = $allowed_atts;
		$allowedposttags['abbr']     = $allowed_atts;
		$allowedposttags['code']     = $allowed_atts;
		$allowedposttags['pre']      = $allowed_atts;
		$allowedposttags['div']      = $allowed_atts;
		$allowedposttags['img']      = $allowed_atts;
		$allowedposttags['h1']       = $allowed_atts;
		$allowedposttags['h2']       = $allowed_atts;
		$allowedposttags['h3']       = $allowed_atts;
		$allowedposttags['h4']       = $allowed_atts;
		$allowedposttags['h5']       = $allowed_atts;
		$allowedposttags['h6']       = $allowed_atts;
		$allowedposttags['ol']       = $allowed_atts;
		$allowedposttags['ul']       = $allowed_atts;
		$allowedposttags['li']       = $allowed_atts;
		$allowedposttags['em']       = $allowed_atts;
		$allowedposttags['hr']       = $allowed_atts;
		$allowedposttags['br']       = $allowed_atts;
		$allowedposttags['tr']       = $allowed_atts;
		$allowedposttags['th']       = $allowed_atts;
		$allowedposttags['td']       = $allowed_atts;
		$allowedposttags['p']        = $allowed_atts;
		$allowedposttags['a']        = $allowed_atts;
		$allowedposttags['b']        = $allowed_atts;
		$allowedposttags['i']        = $allowed_atts;
		$allowedposttags['option']   = $allowed_atts;
		$allowedposttags['button']   = $allowed_atts;
		echo wp_kses( $html_field, $allowedposttags );
	}
}
