<?php
/**
 *  IGUniform generate form helper
 *
 * @package     Joomla.Administrator
 * @subpackage  com_uniform
 * @since       1.6
 */
class IGUniformGenerateHtmlForm {

	/**
	 * Generate html code for a form which includes all the required fields
	 *
	 * @param   object  $dataGenrate     Data genrate
	 *
	 * @param   string  $layout          The layout genrate
	 *
	 * @param   object  $dataSumbission  Data submission
	 *
	 * @return void
	 */
	public static function generate( $dataGenrate = null, $dataSumbission = null, $pageContainer = null ) {
		$formElement = array();
		load_plugin_textdomain( IG_UNIFORM_TEXTDOMAIN, false, IG_UNIFORM_TEXTDOMAIN . '/frontend/languages/' );
		foreach ( $dataGenrate as $data ) {
			$fileType = preg_replace( '/[^a-z]/i', '', $data->type );
			$method = "field{$fileType}";
			$filterClassGenerateForm = array( 'default' => 'IGUniformGenerateHtmlForm' );
			$filterClassGenerateForm = apply_filters( 'ig_uniform_frontend_class_generate_form', $filterClassGenerateForm );
			if ( ! empty( $filterClassGenerateForm ) ) {
				foreach ( $filterClassGenerateForm as $class ) {
					if ( method_exists( $class, $method ) ) {
						$formElement[ $data->position ][ ] = $class::$method( $data, $dataSumbission );
					}
				}
			}
		}
		$getContainer = json_decode( $pageContainer );
		$columnOutput = '';
		foreach ( $getContainer as $items ) {
			if ( $items ) {
				$columnOutput .= "<div class='jsn-row-container row-fluid'>";

				foreach ( $items as $item ) {
					$columName = ! empty( $item->columnName ) ? $item->columnName : 'left';
					$columClass = ! empty( $item->columnClass ) ? $item->columnClass : 'span12';
					$dataColumn = isset( $formElement[ $columName ] ) ? $formElement[ $columName ] : array();
					$columnOutput .= "<div class=\"ig-container-{$columName} {$columClass}\">";
					if ( ! empty( $dataColumn ) ) {
						$columnOutput .= implode( "\n", $dataColumn );
					}
					$columnOutput .= '</div>';
				}
				$columnOutput .= '</div>';
			}
		}
		return $columnOutput;
	}

	/**
	 * Return span number based on bootstrap grid layout
	 *
	 * @param   string  $styles       Style Column
	 *
	 * @param   int     $columnCount  Count column
	 *
	 * @return array
	 */
	public static function getcolumnsizes( $styles, $columnCount ) {
		$spans = explode( '-', $styles );
		$spanCount = count( $spans );

		if ( $spanCount < $columnCount ) {
			$spans = array_merge( $spans, array_fill( 0, $columnCount - $spanCount, 1 ) );
		}
		elseif ( $spanCount > $columnCount ) {
			$spans = array_slice( $spans, 0, $columnCount );
		}

		$spanSum = array_sum( $spans );
		$ratio = 12 / $spanSum;

		foreach ( $spans as $index => $span ) {
			$spans[ $index ] = ceil( $span * $ratio );
		}

		$spans[ ] = 12 - array_sum( $spans );
		return $spans;
	}

	/**
	 * Generate html code for "SingleLineText" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fieldsinglelinetext( $data, $dataSumbission ) {

		$limitValue = '';
		$styleClassLimit = '';
		$identify = ! empty( $data->identify ) ? $data->identify : '';
		if ( isset( $data->options->limitation ) && $data->options->limitation == 1 ) {
			$josnLimit = json_encode(
				array(
					'limitMin' => $data->options->limitMin,
					'limitMax' => $data->options->limitMax,
					'limitType' => $data->options->limitType,
				)
			);
			if ( isset( $data->options->limitMax ) && isset( $data->options->limitMin ) && $data->options->limitMax >= $data->options->limitMin && $data->options->limitMax > 0 && $data->options->limitMin >= 0 ) {
				if ( $data->options->limitMax != 0 && $data->options->limitType == 'Characters' ) {
					$limitValue = "data-limit='{$josnLimit}' maxlength=\"{$data->options->limitMax}\"";
				}
				else {
					$limitValue = "data-limit='{$josnLimit}'";
				}
				$styleClassLimit = 'limit-required';
			}
		}
		$defaultValue = ! empty( $dataSumbission[ $data->id ] ) ? $dataSumbission[ $data->id ] : '';
		$required = ! empty( $data->options->required ) ? ' <span class="required" >*</span > ' : '';
		$requiredBlank = ! empty( $data->options->required ) ? 'blank-required' : '';
		$hideField = ! empty( $data->options->hideField ) ? 'hide' : '';
		$customClass = ! empty( $data->options->customClass ) ? $data->options->customClass : '';
		$instruction = ! empty( $data->options->instruction ) ? ' <i original-title="' . htmlentities( __( $data->options->instruction, IG_UNIFORM_TEXTDOMAIN ), ENT_QUOTES, 'UTF-8' ) . '" class="icon-question-sign"></i>' : '';
		$sizeInput = ! empty( $data->options->size ) ? $data->options->size : '';
		$placeholder = ! empty( $data->options->value ) ? __( $data->options->value, IG_UNIFORM_TEXTDOMAIN ) : '';
		$html = '<div class="control-group ' . $customClass . ' ' . $identify . ' ' . $hideField . '"><label for="' . htmlentities( __( $data->options->label, IG_UNIFORM_TEXTDOMAIN ), ENT_QUOTES, 'UTF-8' ) . '" class="control-label">' . htmlentities( __( $data->options->label, IG_UNIFORM_TEXTDOMAIN ), ENT_QUOTES, 'UTF-8' ) . $required . $instruction . '</label><div class="controls ' . $requiredBlank . '"><input ' . $limitValue . ' class=" ' . $styleClassLimit . ' ' . $sizeInput . '" id="' . $data->id . '" name="' . $data->id . '" type="text" value="' . htmlentities( $defaultValue, ENT_QUOTES, 'UTF-8' ) . '" placeholder="' . htmlentities( $placeholder, ENT_QUOTES, 'UTF-8' ) . '" /></div></div>';
		return $html;
	}

	/**
	 * Generate html code for "ParagraphText" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fieldparagraphtext( $data, $dataSumbission ) {

		$identify = ! empty( $data->identify ) ? $data->identify : '';
		$hideField = ! empty( $data->options->hideField ) ? 'hide' : '';
		$customClass = ! empty( $data->options->customClass ) ? $data->options->customClass : '';
		$limitValue = '';
		$styleClassLimit = '';
		if ( isset( $data->options->limitation ) && $data->options->limitation == 1 ) {
			$josnLimit = json_encode(
				array(
					'limitMin' => $data->options->limitMin,
					'limitMax' => $data->options->limitMax,
					'limitType' => $data->options->limitType,
				)
			);
			if ( isset( $data->options->limitMax ) && isset( $data->options->limitMin ) && $data->options->limitMax >= $data->options->limitMin && $data->options->limitMax > 0 && $data->options->limitMin >= 0 ) {
				if ( $data->options->limitMax != 0 && $data->options->limitType == 'Characters' ) {
					$limitValue = "data-limit='{$josnLimit}' maxlength=\"{$data->options->limitMax}\"";
				}
				else {
					$limitValue = "data-limit='{$josnLimit}'";
				}
				$styleClassLimit = 'limit-required';
			}
		}
		$sizeInput = ! empty( $data->options->size ) ? $data->options->size : '';
		$defaultValue = ! empty( $dataSumbission[ $data->id ] ) ? $dataSumbission[ $data->id ] : '';
		$required = ! empty( $data->options->required ) ? ' <span class="required" >*</span > ' : '';
		$requiredBlank = ! empty( $data->options->required ) ? 'blank-required' : '';
		$rows = ! empty( $data->options->rows ) && (int)$data->options->rows ? $data->options->rows : '10';
		$instruction = $instruction = ! empty( $data->options->instruction ) ? ' <i original-title = "' . htmlentities( __( $data->options->instruction, IG_UNIFORM_TEXTDOMAIN ), ENT_QUOTES, 'UTF-8' ) . '" class="icon-question-sign" ></i > ' : '';
		$placeholder = ! empty( $data->options->value ) ? __( $data->options->value, IG_UNIFORM_TEXTDOMAIN ) : '';
		$html = '<div class="control-group ' . $customClass . ' ' . $identify . ' ' . $hideField . '"><label for="' . htmlentities( __( $data->options->label, IG_UNIFORM_TEXTDOMAIN ), ENT_QUOTES, 'UTF-8' ) . '" class="control-label">' . htmlentities( __( $data->options->label, IG_UNIFORM_TEXTDOMAIN ), ENT_QUOTES, 'UTF-8' ) . $required . $instruction . '</label><div class="controls ' . $requiredBlank . '"><textarea ' . $limitValue . ' rows="' . $rows . '" class="' . $styleClassLimit . ' ' . $sizeInput . '" id="' . $data->id . '" name="' . $data->id . '" placeholder="' . htmlentities( $placeholder, ENT_QUOTES, 'UTF-8' ) . '">' . $defaultValue . '</textarea></div></div>';
		return $html;
	}

	/**
	 * Generate html code for "DropDown" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fielddropdown( $data, $dataSumbission ) {

		$identify = ! empty( $data->identify ) ? $data->identify : '';
		$hideField = ! empty( $data->options->hideField ) ? 'hide' : '';
		$customClass = ! empty( $data->options->customClass ) ? $data->options->customClass : '';
		$required = ! empty( $data->options->required ) ? ' <span class="required" >*</span > ' : '';
		$randomDropdown = ! empty( $data->options->randomize ) ? 'dropdown-randomize' : '';
		$instruction = $instruction = ! empty( $data->options->instruction ) ? ' <i original-title = "' . htmlentities( __( $data->options->instruction, IG_UNIFORM_TEXTDOMAIN ), ENT_QUOTES, 'UTF-8' ) . '" class="icon-question-sign" ></i > ' : '';
		$defaultValue = ! empty( $dataSumbission[ $data->id ] ) ? $dataSumbission[ $data->id ] : '';
		$sizeInput = ! empty( $data->options->size ) ? $data->options->size : '';
		$dataSettings = ! empty( $data->options->itemAction ) ? $data->options->itemAction : '';
		$requiredBlank = ! empty( $data->options->firstItemAsPlaceholder ) && ! empty( $data->options->required ) ? 'dropdown-required' : '';
		$html = '<div class="control-group ' . $customClass . ' ' . $identify . ' ' . $hideField . '" data-settings="' . htmlentities( $dataSettings, ENT_QUOTES, 'UTF-8' ) . '"><label for="' . htmlentities( __( $data->options->label, IG_UNIFORM_TEXTDOMAIN ), ENT_QUOTES, 'UTF-8' ) . '" class="control-label">' . htmlentities( __( $data->options->label, IG_UNIFORM_TEXTDOMAIN ), ENT_QUOTES, 'UTF-8' ) . $required . $instruction . '</label><div class="controls ' . $requiredBlank . '"><select id="' . $data->id . '" class="dropdown ' . $sizeInput . ' ' . $randomDropdown . '" name="' . $data->id . '">';

		if ( isset( $data->options->items ) && is_array( $data->options->items ) ) {
			foreach ( $data->options->items as $index => $option ) {
				if ( ! empty( $defaultValue ) ) {
					if ( isset( $option->text ) && $option->text == $defaultValue ) {
						$selected = "selected='true'";
					}
					else {
						$selected = '';
					}
				}
				else {
					if ( $option->checked == 1 || $option->checked == 'true' ) {
						$selected = "selected='true'";
					}
					else {
						$selected = '';
					}
				}
				$selectDefault = '';
				if ( $selected ) {
					$selectDefault = 'selectdefault="true"';
				}
				if ( ! empty( $data->options->firstItemAsPlaceholder ) && $index == 0 ) {
					$html .= '<option ' . $selected . ' ' . $selectDefault . ' value="">' . htmlentities( __( $option->text, IG_UNIFORM_TEXTDOMAIN ), ENT_QUOTES, 'UTF-8' ) . '</option>';
				}
				else {
					$html .= '<option class="jsn-column-item" ' . $selected . ' ' . $selectDefault . ' value="' . htmlentities( $option->text, ENT_QUOTES, 'UTF-8' ) . '">' . htmlentities( __( $option->text, IG_UNIFORM_TEXTDOMAIN ), ENT_QUOTES, 'UTF-8' ) . '</option>';
				}
			}
		}
		$textOthers = ! empty( $data->options->labelOthers ) ? $data->options->labelOthers : 'Others';
		if ( ! empty( $data->options->allowOther ) ) {
			$html .= '<option class="lbl-allowOther" value="Others">' . __( $textOthers, IG_UNIFORM_TEXTDOMAIN ) . '</option>';
			$html .= '</select>';
			$html .= '<div class="jsn-column-item ig-uniform-others"><textarea class="ig-dropdown-Others hide" name="fieldOthers[' . $data->id . ']"  rows="3"></textarea></div></div>';
		}
		else {
			$html .= '</select></div>';
		}
		$html .= '</div>';
		return $html;
	}

	/**
	 * Generate html code for "DropDown" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fieldlist( $data, $dataSumbission ) {

		$identify = ! empty( $data->identify ) ? $data->identify : '';
		$hideField = ! empty( $data->options->hideField ) ? 'hide' : '';
		$customClass = ! empty( $data->options->customClass ) ? $data->options->customClass : '';
		$required = ! empty( $data->options->required ) ? ' <span class="required" >*</span > ' : '';
		$requiredBlank = ! empty( $data->options->required ) ? 'list-required' : '';
		$randomList = ! empty( $data->options->randomize ) ? 'list-randomize' : '';
		$instruction = $instruction = ! empty( $data->options->instruction ) ? ' <i original-title = "' . htmlentities( __( $data->options->instruction, IG_UNIFORM_TEXTDOMAIN ), ENT_QUOTES, 'UTF-8' ) . '" class="icon-question-sign" ></i > ' : '';
		$defaultValue = ! empty( $dataSumbission[ $data->id ] ) ? $dataSumbission[ $data->id ] : '';
		$sizeInput = ! empty( $data->options->size ) ? $data->options->size : '';
		$multiple = ! empty( $data->options->multiple ) ? 'multiple' : 'size="4"';
		$html = '<div class="control-group ' . $customClass . ' ' . $identify . ' ' . $hideField . ' "><label for="' . htmlentities( __( $data->options->label, IG_UNIFORM_TEXTDOMAIN ), ENT_QUOTES, 'UTF-8' ) . '" class="control-label">' . htmlentities( __( $data->options->label, IG_UNIFORM_TEXTDOMAIN ), ENT_QUOTES, 'UTF-8' ) . $required . $instruction . '</label><div class="controls ' . $requiredBlank . '"><select ' . $multiple . ' id="' . $data->id . '" class="list ' . $sizeInput . ' ' . $randomList . '" name="' . $data->id . '[]">';

		if ( isset( $data->options->items ) && is_array( $data->options->items ) ) {
			foreach ( $data->options->items as $option ) {
				if ( ! empty( $defaultValue ) ) {
					if ( isset( $option->text ) && $option->text == $defaultValue ) {
						$selected = "selected='true'";
					}
					else {
						$selected = '';
					}
				}
				else {
					if ( $option->checked == 1 || $option->checked == 'true' ) {
						$selected = "selected='true'";
					}
					else {
						$selected = '';
					}
				}
				$html .= '<option class="jsn-column-item" ' . $selected . ' value="' . $option->text . '">' . htmlentities( __( $option->text, IG_UNIFORM_TEXTDOMAIN ), ENT_QUOTES, 'UTF-8' ) . '</option>';
			}
		}
		$html .= '</select></div></div>';
		return $html;
	}

	/**
	 * Generate html code for "Choices" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fieldchoices( $data, $dataSumbission ) {
		$identify = ! empty( $data->identify ) ? $data->identify : '';
		$hideField = ! empty( $data->options->hideField ) ? 'hide' : '';
		$customClass = ! empty( $data->options->customClass ) ? $data->options->customClass : '';
		$required = ! empty( $data->options->required ) ? ' <span class="required" >*</span > ' : '';
		$instruction = $instruction = ! empty( $data->options->instruction ) ? ' <i original-title = "' . htmlentities( __( $data->options->instruction, IG_UNIFORM_TEXTDOMAIN ), ENT_QUOTES, 'UTF-8' ) . '" class="icon-question-sign" ></i > ' : '';
		$requiredChoices = ! empty( $data->options->required ) ? 'choices-required' : '';
		$randomChoices = ! empty( $data->options->randomize ) ? 'choices-randomize' : '';
		$dataSettings = ! empty( $data->options->itemAction ) ? $data->options->itemAction : '';
		$html = '<div class="control-group ' . $customClass . ' ' . $identify . ' ' . $hideField . ' " data-settings="' . htmlentities( $dataSettings, ENT_QUOTES, 'UTF-8' ) . '" ><label for="' . htmlentities( __( $data->options->label, IG_UNIFORM_TEXTDOMAIN ), ENT_QUOTES, 'UTF-8' ) . '" class="control-label">' . htmlentities( __( $data->options->label, IG_UNIFORM_TEXTDOMAIN ), ENT_QUOTES, 'UTF-8' ) . $required . $instruction . '</label><div class="controls ' . $requiredChoices . '"><div id="' . $data->id . '" class="choices jsn-columns-container ' . $data->options->layout . ' ' . $randomChoices . '">';

		$defaultValue = isset( $dataSumbission[ $data->id ] ) ? $dataSumbission[ $data->id ] : '';
		if ( isset( $data->options->items ) && is_array( $data->options->items ) ) {
			foreach ( $data->options->items as $i => $option ) {
				if ( ! empty( $defaultValue ) ) {
					if ( isset( $option->text ) && $option->text == $defaultValue ) {
						$checked = "checked='true'";
					}
					else {
						$checked = '';
					}
				}
				else {
					if ( isset( $option->checked ) && $option->checked == 'true' ) {
						$checked = "checked='true'";
					}
					else {
						$checked = '';
					}
				}
				$html .= '<div class="jsn-column-item"><label class="radio"><input ' . $checked . ' name="' . $data->id . '" value="' . htmlentities( $option->text, ENT_QUOTES, 'UTF-8' ) . '" type="radio" />' . htmlentities( __( $option->text, IG_UNIFORM_TEXTDOMAIN ), ENT_QUOTES, 'UTF-8' ) . '</label></div>';
			}
		}
		$textOthers = ! empty( $data->options->labelOthers ) ? $data->options->labelOthers : 'Others';
		if ( ! empty( $data->options->allowOther ) ) {
			$html .= '<div class="jsn-column-item ig-uniform-others"><label class="radio lbl-allowOther"><input class="allowOther" name="' . $data->id . '" value="Others" type="radio" />' . htmlentities( __( $textOthers, IG_UNIFORM_TEXTDOMAIN ), ENT_QUOTES, 'UTF-8' ) . '</label>';
			$html .= '<textarea disabled="true" class="ig-value-Others" name="fieldOthers[' . $data->id . ']" rows="3"></textarea></div>';
		}
		$html .= '<div class="clearbreak"></div></div></div></div>';

		return $html;
	}

	/**
	 * Generate html code for "Checkboxes" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fieldcheckboxes( $data, $dataSumbission ) {

		$identify = ! empty( $data->identify ) ? $data->identify : '';
		$hideField = ! empty( $data->options->hideField ) ? 'hide' : '';
		$customClass = ! empty( $data->options->customClass ) ? $data->options->customClass : '';
		$required = ! empty( $data->options->required ) ? ' <span class="required" >*</span > ' : '';
		$instruction = $instruction = ! empty( $data->options->instruction ) ? ' <i original-title = "' . htmlentities( __( $data->options->instruction, IG_UNIFORM_TEXTDOMAIN ), ENT_QUOTES, 'UTF-8' ) . '" class="icon-question-sign" ></i > ' : '';
		$requiredCheckbox = ! empty( $data->options->required ) ? 'checkbox-required' : '';
		$randomCheckbox = ! empty( $data->options->randomize ) ? 'checkbox-randomize' : '';
		$dataSettings = ! empty( $data->options->itemAction ) ? $data->options->itemAction : '';
		$html = '<div class="control-group ' . $customClass . ' ' . $identify . ' ' . $hideField . ' " data-settings="' . htmlentities( $dataSettings, ENT_QUOTES, 'UTF-8' ) . '"><label for="' . htmlentities( __( $data->options->label, IG_UNIFORM_TEXTDOMAIN ), ENT_QUOTES, 'UTF-8' ) . '" class="control-label">' . htmlentities( __( $data->options->label, IG_UNIFORM_TEXTDOMAIN ), ENT_QUOTES, 'UTF-8' ) . $required . $instruction . '</label><div class="controls"><div id="' . $data->id . '" class="checkboxes jsn-columns-container ' . $data->options->layout . ' ' . $randomCheckbox . ' ' . $requiredCheckbox . '">';
		$defaultValue = isset( $dataSumbission[ $data->id ] ) ? $dataSumbission[ $data->id ] : '';
		if ( isset( $data->options->items ) && is_array( $data->options->items ) ) {
			foreach ( $data->options->items as $i => $option ) {
				$checked = '';
				if ( ! empty( $defaultValue ) ) {
					if ( isset( $option->text ) && in_array( $option->text, $defaultValue ) ) {
						$checked = "checked='true'";
					}
				}
				else {
					if ( isset( $option->checked ) && $option->checked == 'true' ) {
						$checked = "checked='true'";
					}
				}

				$html .= '<div class="jsn-column-item"><label class="checkbox"><input ' . $checked . ' name="' . $data->id . '[]" value="' . htmlentities( $option->text, ENT_QUOTES, 'UTF-8' ) . '" type="checkbox" />' . htmlentities( __( $option->text, IG_UNIFORM_TEXTDOMAIN ), ENT_QUOTES, 'UTF-8' ) . '</label></div>';
			}
		}
		$textOthers = ! empty( $data->options->labelOthers ) ? $data->options->labelOthers : 'Others';
		if ( ! empty( $data->options->allowOther ) ) {
			$html .= '<div class="jsn-column-item ig-uniform-others"><label class="checkbox lbl-allowOther"><input class="allowOther" value="Others" type="checkbox" />' . htmlentities( __( $textOthers, IG_UNIFORM_TEXTDOMAIN ), ENT_QUOTES, 'UTF-8' ) . '</label>';
			$html .= '<textarea disabled="true" class="ig-value-Others" name="' . $data->id . '[]"  rows="3"></textarea></div>';
		}
		$html .= '<div class="clearbreak"></div></div></div></div>';

		return $html;
	}


	/**
	 * Generate html code for "Static Content" data field
	 *
	 * @param   object  $data            Data field
	 *
	 * @param   array   $dataSumbission  Data submission
	 *
	 * @return string
	 */
	public static function fieldstaticcontent( $data, $dataSumbission ) {

		$identify = ! empty( $data->identify ) ? $data->identify : '';
		$hideField = ! empty( $data->options->hideField ) ? 'hide' : '';
		$customClass = ! empty( $data->options->customClass ) ? $data->options->customClass : '';
		$value = isset( $data->options->value ) ? __( $data->options->value, IG_UNIFORM_TEXTDOMAIN ) : '';
		$html = "<div class=\"control-group {$customClass} {$identify} {$hideField} \"><div class=\"controls clearfix\">{$value}</div></div>";
		return $html;
	}
}