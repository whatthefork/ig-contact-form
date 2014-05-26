<?php
/**
 * Created by JetBrains PhpStorm.
 * User: thailv
 * Date: 4/4/14
 * Time: 10:41 AM
 * To change this template use File | Settings | File Templates.
 */
class IGUniformEditForm {

	public function __construct() {
		add_action( 'ig_uniform_form_container_tabs', array( &$this, 'add_container_form_design' ), 10, 8 );
		add_action( 'ig_uniform_form_container_tabs', array( &$this, 'add_container_form_action' ), 10, 8 );
		add_action( 'ig_uniform_form_edit_form_bar', array( &$this, 'add_form_bar' ), 10, 8 );
	}

	public function add_form_bar( $form, $formStyle, $formSettings, $listPage, $listFontType, $items, $formItems, $formPage ) {

		?>
		<div class="jsn-form-bar">
		<div class="control-group ">
			<label class="control-label ig-label-des-tipsy" original-title="Select to show form fields in in single page or multiple pages.">Form Type</label>

			<div class="controls">
				<?php
				$fieldFormType = $form[ 'ig-form-field-form_type' ];
				$fieldFormType->get( 'input' );
				?>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label ig-captcha inline" original-title="Select to show form field title and element in vertical column or horizontal row.">Form Layout</label>
		<?php
		$vertical = '';
		$horizontal = '';
		if ( empty( $formStyle->layout ) && $formStyle->layout == 'Vertical' ) {
			$vertical = 'selected';
		}
		else if ( ! empty( $formStyle->layout ) && $formStyle->layout == 'form-horizontal' ) {
			$horizontal = 'selected';
		}
		?>
			<div class="controls">
				<select id="jform_form_style" style="width:100px" name="form_style[layout]" class="jsn-input-fluid">
					<option <?php echo '' . $vertical;?> value="Vertical">
						<?php echo '' . __( 'Vertical', IG_UNIFORM_TEXTDOMAIN );?>
					</option>
					<option <?php echo '' . $horizontal;?> value="form-horizontal">
						<?php echo '' . __( 'Horizontal', IG_UNIFORM_TEXTDOMAIN );?>
					</option>
				</select>
			</div>
		</div>
		<div class="pull-right">
			<button id="select_form_style" class="btn" onclick="return false;">
				<i class="icon-pencil"></i>Form Style
			</button>
			<div id="container-select-style" class="jsn-bootstrap">
				<div class="popover bottom">
					<div class="arrow"></div>
					<h3 class="popover-title">Form Style</h3>

					<div class="popover-content">
						<div class="jsn-form-bar">
							<div class="jsn-padding-medium jsn-rounded-medium jsn-box-shadow-small jsn-bgpattern pattern-sidebar">
								<div class="control-group">
									<label class="control-label label-color-scheme" original-title="Color Scheme">Color Scheme</label>

									<div class="controls">
										<div id="theme_select">
											<div id="form-select">
												<?php
												$optionTheme = '';
												?>
												<select id="jform_form_theme" style="width: 200px" name="form_style[theme]">
		<?php
		$themes = ! empty( $formStyle->themes ) ? $formStyle->themes : array(
			'light',
			'dark',
		);
		if ( ! empty( $themes ) ) {
			foreach ( $themes as $theme ) {
				$dataValue = '';
				if ( ! empty( $formStyle->themes_style ) ) {
					$themeStyle = $formStyle->themes_style;

					$dataValue = ! empty( $themeStyle->$theme ) ? $themeStyle->$theme : '';
				}
				$checked = ! empty( $formStyle->theme ) && $formStyle->theme == 'ig-style-' . $theme ? 'selected' : '';
				echo '' . '<option ' . $checked . ' value="ig-style-' . $theme . '">' . $theme . '</option>';
				$optionTheme .= "<input type='hidden' class='ig-style-{$theme}' value='{$dataValue}' name='form_style[themes_style][{$theme}]'/><input type='hidden' value='{$theme}' name='form_style[themes][]'/>";
			}
		}
		?>
												</select>
											</div>
											<div id="add-theme-select" class="hide">
												<div class="control-group">
													<input type="text" id="input_new_theme" class="input-medium" name="new_theme">

													<div class="control-group">
														<button title="Save" id="btn_add_theme" onclick="return false;" class="btn btn-icon">
															<i class="icon-ok"></i></button>
														<button title="Cancel" id="btn_cancel_theme" onclick="return false;" class="btn btn-icon">
															<i class="icon-remove"></i></button>
													</div>
												</div>
											</div>
											<div id="option_themes" class="hide">
												<?php echo '' . $optionTheme;?>
											</div>
											<div id="theme_action" class="pull-right">
												<button class="btn btn-icon" id="theme_action_refresh" onclick="return false;">
													<i class="icon-refresh"></i></button>
												<button class="btn btn-icon" id="theme_action_delete" onclick="return false;">
													<i class="icon-trash"></i></button>
												<button class="btn btn-icon btn-success pull-right" id="theme_action_add" onclick="return false;">
													<i class="icon-plus"></i></button>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>
						<div id="style_accordion_content" class="jsn-tabs form-horizontal">
							<ul>
								<li class="active"><a href="#formStyleContainer">Container</a></li>
								<li><a href="#formStyleTitle">Title</a></li>
								<li><a href="#formStyleField">Field</a></li>
								<li><a href="#formStyleMessageError">Error</a></li>
								<li><a href="#formStyleButtons">Buttons</a></li>
								<li><a href="#formCustomCss">CSS</a></li>
							</ul>
							<div id="formStyleContainer">
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'IG_UNIFORM_BACKGROUND_COLOR', IG_UNIFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<input type="text" data-value="background-color" data-type="jsn-element" value="<?php echo '' . $formStyle->background_color;?>" class="jsn-input-fluid" name="form_style[background_color]" id="style_background_color" />

										<div class="jsn-select-color">
											<div></div>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'IG_UNIFORM_BACKGROUND_ACTIVE_COLOR', IG_UNIFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<input type="text" data-value="background-color" data-type="ui-state-edit" value="<?php echo '' . $formStyle->background_active_color;?>" class="jsn-input-fluid" name="form_style[background_active_color]" id="style_background_active_color" />

										<div class="jsn-select-color">
											<div></div>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'IG_UNIFORM_BORDER_THICKNESS', IG_UNIFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<div class="input-append">
											<input type="number" data-value="border" data-type="jsn-element" value="<?php echo '' . ! empty( $formStyle->border_thickness ) ? $formStyle->border_thickness : 0;?>" class="jsn-input-number input-mini" name="form_style[border_thickness]" id="style_border_thickness" /><span class="add-on">px</span>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'IG_UNIFORM_BORDER_COLOR', IG_UNIFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<input type="text" data-value="border-color" data-type="jsn-element" value="<?php echo '' . $formStyle->border_color;?>" class="jsn-input-fluid" name="form_style[border_color]" id="style_border_color" />

										<div class="jsn-select-color">
											<div></div>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'IG_UNIFORM_BORDER_ACTIVE_COLOR', IG_UNIFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<input type="text" data-value="border-color" data-type="ui-state-edit" value="<?php echo '' . $formStyle->border_active_color;?>" class="jsn-input-fluid" name="form_style[border_active_color]" id="style_border_active_color" />

										<div class="jsn-select-color">
											<div></div>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'IG_UNIFORM_ROUNDED_CORNER_RADIUS', IG_UNIFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<div class="input-append">
											<input type="number" data-value="border-radius,-moz-border-radius,-webkit-border-radius" data-type="jsn-element" value="<?php echo '' . ! empty( $formStyle->rounded_corner_radius ) ? $formStyle->rounded_corner_radius : 0;?>" class="input-mini jsn-input-number" name="form_style[rounded_corner_radius]" id="style_rounded_corner_radius" /><span class="add-on">px</span>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'IG_UNIFORM_PADDING_SPACE', IG_UNIFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<div class="input-append">
											<input type="number" data-value="padding" data-type="jsn-element" value="<?php echo '' . ! empty( $formStyle->padding_space ) ? $formStyle->padding_space : 0;?>" class="input-mini jsn-input-number" name="form_style[padding_space]" id="style_padding_space" /><span class="add-on">px</span>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'IG_UNIFORM_MARGIN_SPACE', IG_UNIFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<div class="input-append">
											<input type="number" data-value="margin" data-type="jsn-element" value="<?php echo '' . ! empty( $formStyle->margin_space ) ? $formStyle->margin_space : 0;?>" class="input-mini jsn-input-number" name="form_style[margin_space]" id="style_margin_space" /><span class="add-on">px</span>
										</div>
									</div>
								</div>
							</div>
							<div id="formStyleTitle">
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'IG_UNIFORM_TEXT_COLOR', IG_UNIFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<input type="text" data-value="color" data-type="control-label" value="<?php echo '' . $formStyle->text_color;?>" class="jsn-input-fluid" name="form_style[text_color]" id="style_text_color" />

										<div class="jsn-select-color">
											<div></div>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'IG_UNIFORM_FONT_TYPE', IG_UNIFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<select data-value="font-family" data-type="control-label" name="form_style[font_type]" id="style_font_type">
		<?php
		foreach ( $listFontType as $fontType ) {
			$selected = '';
			if ( $fontType == $formStyle->font_type ) {
				$selected = 'selected';
			}
			echo '' . "<option {$selected} value='{$fontType}'>{$fontType}</option>";
		}
		?>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'IG_UNIFORM_FONT_SIZE', IG_UNIFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<div class="input-append">
											<input type="number" data-value="font-size" data-type="control-label" default-value="14px" value="<?php echo '' . ! empty( $formStyle->font_size ) ? $formStyle->font_size : 0;?>" class="input-mini jsn-input-number" name="form_style[font_size]" id="style_font_size" /><span class="add-on">px</span>
										</div>
									</div>
								</div>
							</div>
							<div id="formStyleField">
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'IG_UNIFORM_BACKGROUND_COLOR', IG_UNIFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<input type="text" data-value="background-color" data-type="field" value="<?php echo '' . $formStyle->field_background_color;?>" class="jsn-input-fluid" name="form_style[field_background_color]" id="style_field_background_color" />

										<div class="jsn-select-color">
											<div></div>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'IG_UNIFORM_BORDER_COLOR', IG_UNIFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<input type="text" data-value="border-color" data-type="field" value="<?php echo '' . $formStyle->field_border_color;?>" class="jsn-input-fluid" name="form_style[field_border_color]" id="style_field_border_color" />

										<div class="jsn-select-color">
											<div></div>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'IG_UNIFORM_SHADOW_COLOR', IG_UNIFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<input type="text" data-value="box-shadow" data-type="field" value="<?php echo '' . $formStyle->field_shadow_color;?>" class="jsn-input-fluid" name="form_style[field_shadow_color]" id="style_field_shadow_color" />

										<div class="jsn-select-color">
											<div></div>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'IG_UNIFORM_TEXT_COLOR', IG_UNIFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<input type="text" data-value="color" data-type="field" value="<?php echo '' . $formStyle->field_text_color;?>" class="jsn-input-fluid" name="form_style[field_text_color]" id="style_field_text_color" />

										<div class="jsn-select-color">
											<div></div>
										</div>
									</div>
								</div>

							</div>
							<div id="formStyleMessageError">
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'IG_UNIFORM_BACKGROUND_COLOR', IG_UNIFORM_TEXTDOMAIN );?></label>

									<div class="controls">
										<input type="text" value="<?php echo '' . $formStyle->message_error_background_color;?>" class="jsn-input-fluid" name="form_style[message_error_background_color]" id="style_message_error_background_color" />

										<div class="jsn-select-color">
											<div></div>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'IG_UNIFORM_TEXT_COLOR', IG_UNIFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<input type="text" value="<?php echo '' . $formStyle->message_error_text_color;?>" class="jsn-input-fluid" name="form_style[message_error_text_color]" id="style_message_error_text_color" />

										<div class="jsn-select-color">
											<div></div>
										</div>
									</div>
								</div>
							</div>
							<div id="formStyleButtons">
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'IG_UNIFORM_BUTTON_POSITION', IG_UNIFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<select class="input-large" name="form_style[button_position]" id="button_position">
											<?php
											$buttonPosition = ! empty( $formStyle->button_position ) ? $formStyle->button_position : 'btn-toolbar';
											echo '' . IGUniformHelper::render_options_button_position( $buttonPosition );
											?>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . $formItems->form_btn_submit_text ? $formItems->form_btn_submit_text : 'Submit'; ?></label>

									<div class="controls">
										<select class="input-large ig-select2" name="form_style[button_submit_color]" id="button_submit_color">
											<?php
											$buttonSubmitColor = ! empty( $formStyle->button_submit_color ) ? $formStyle->button_submit_color : 'btn btn-primary';
											echo '' . IGUniformHelper::render_options_button_style( $buttonSubmitColor );
											?>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . $formItems->form_btn_reset_text ? $formItems->form_btn_reset_text : 'Reset'; ?></label>

									<div class="controls">
										<select class="input-large ig-select2" name="form_style[button_reset_color]" id="button_reset_color">
											<?php
											$buttonResetColor = ! empty( $formStyle->button_reset_color ) ? $formStyle->button_reset_color : 'btn';
											echo '' . IGUniformHelper::render_options_button_style( $buttonResetColor );
											?>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . $formItems->form_btn_prev_text ? $formItems->form_btn_prev_text : 'Prev'; ?></label>

									<div class="controls">
										<select class="input-large ig-select2" name="form_style[button_prev_color]" id="button_prev_color">
											<?php
											$buttonPrevColor = ! empty( $formStyle->button_prev_color ) ? $formStyle->button_prev_color : 'btn';
											echo '' . IGUniformHelper::render_options_button_style( $buttonPrevColor );
											?>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . $formItems->form_btn_next_text ? $formItems->form_btn_next_text : 'Next'; ?></label>

									<div class="controls">

										<select class="input-large ig-select2" name="form_style[button_next_color]" id="button_next_color">
											<?php
											$buttonNextColor = ! empty( $formStyle->button_next_color ) ? $formStyle->button_next_color : 'btn btn-primary';
											echo '' . IGUniformHelper::render_options_button_style( $buttonNextColor );
											?>
										</select>
									</div>
								</div>
							</div>
							<div id="formCustomCss">
								<textarea id="style_custom_css" name="form_style[custom_css]"><?php echo '' . $formStyle->custom_css;?></textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
	<?php
	}

	/**
	 * Add container form design content
	 *
	 * @param $form
	 */
	public function add_container_form_design( $form, $formStyle, $formSettings, $listPage, $listFontType, $items, $formItems, $formPage ) {
		$buttonPosition = ! empty( $formStyle->button_position ) ? $formStyle->button_position : 'btn-toolbar';
		$buttonSubmitColor = ! empty( $formStyle->button_submit_color ) ? $formStyle->button_submit_color : 'btn btn-primary';
		$buttonResetColor = ! empty( $formStyle->button_reset_color ) ? $formStyle->button_reset_color : 'btn';
		$buttonPrevColor = ! empty( $formStyle->button_prev_color ) ? $formStyle->button_prev_color : 'btn';
		$buttonNextColor = ! empty( $formStyle->button_next_color ) ? $formStyle->button_next_color : 'btn btn-primary';
		?>
		<div id="form-design">
		<?php do_action( 'ig_uniform_form_edit_form_bar', $form, $formStyle, $formSettings, $listPage, $listFontType, $items, $formItems, $formPage );?>
		<hr />
		<div class="ig-page">
			<?php echo '' . $listPage; ?>
			<div id="form-design-content" class="clearfix <?php echo '' . ! empty( $formItems->form_theme ) ? $formItems->form_theme : 'ig-style-light'; ?>">
				<div id="form-container" class="jsn-layout">
					<div id="page-loading" class="jsn-bgloading">
						<i class="jsn-icon32 jsn-icon-loading"></i></div>
					<a class="jsn-add-more" id="ig-add-container" href="javascript:void(0);"><i class="icon-plus"></i>Add Container
					</a>

					<div class="ui-sortable ig-sortable-disable">
						
						<div class="ui-sortable ig-sortable-disable">
							<div class="form-actions ui-state-default jsn-iconbar-trigger">
								<div class="<?php echo '' . $buttonPosition;?>">
		<?php
		$stateBtnReset = 'hide';
		if ( ! empty( $formSettings->form_state_btn_reset_text ) && $formSettings->form_state_btn_reset_text == 'Yes' ) {
			$stateBtnReset = '';
		}

									?>
									<button onclick="return false;" class="<?php echo '' . $buttonPrevColor;?> jsn-form-prev hide"><?php echo '' . $formSettings->form_btn_prev_text ? $formSettings->form_btn_prev_text : 'Prev'; ?></button>
									<button onclick="return false;" class="<?php echo '' . $buttonNextColor;?> jsn-form-next hide"><?php echo '' . $formSettings->form_btn_next_text ? $formSettings->form_btn_next_text : 'Next'; ?></button>

									<button class="<?php echo '' . $buttonSubmitColor;?> jsn-form-submit hide" onclick="return false;"><?php echo '' . $formSettings->form_btn_submit_text ? $formSettings->form_btn_submit_text : 'Submit'; ?></button>
									<button class="<?php echo '' . $buttonResetColor;?> jsn-form-reset hide" onclick="return false;"><?php echo '' . $formSettings->form_btn_reset_text ? $formSettings->form_btn_reset_text : 'Reset'; ?></button>
									<input type="hidden" id="jform_form_btn_next_text" name="ig_uniform[form_settings][form_btn_next_text]" value="<?php echo '' . ( ! empty( $formSettings->form_btn_next_text ) ? $formSettings->form_btn_next_text : 'Next' );?>">
									<input type="hidden" id="jform_form_btn_prev_text" name="ig_uniform[form_settings][form_btn_prev_text]" value="<?php echo '' . ( ! empty( $formSettings->form_btn_prev_text ) ? $formSettings->form_btn_prev_text : 'Prev' );?>">
									<input type="hidden" id="jform_form_btn_submit_text" name="ig_uniform[form_settings][form_btn_submit_text]" value="<?php echo '' . ( ! empty( $formSettings->form_btn_submit_text ) ? $formSettings->form_btn_submit_text : 'Submit' );?>">
									<input type="hidden" id="jform_form_btn_reset_text" name="ig_uniform[form_settings][form_btn_reset_text]" value="<?php echo '' . ( ! empty( $formSettings->form_btn_reset_text ) ? $formSettings->form_btn_reset_text : 'Reset' );?>">
									<input type="hidden" id="jform_form_state_btn_reset_text" name="ig_uniform[form_settings][form_state_btn_reset_text]" value="<?php echo '' . ( ! empty( $formSettings->form_state_btn_reset_text ) ? $formSettings->form_state_btn_reset_text : 'No' );?>">
								</div>
								<div class="jsn-iconbar">
									<a class="element-edit" title="Edit Button Action" onclick="return false;" href="#"><i class="icon-pencil"></i></a>
								</div>
							</div>
						</div>
					</div>
					<?php
					$titleForm = isset( $_GET[ 'form' ] ) ? $_GET[ 'form' ] : '';
					$arrayTranslated = array(
						'IG_UNIFORM_FORM_NEW_PAGE',
						'IG_UNIFORM_EMAIL_SUBMITTER_TITLE',
						'IG_UNIFORM_MOVE_UP_CONTAINER',
						'IG_UNIFORM_EMAIL_ADDRESS_TITLE',
						'IG_UNIFORM_MOVE_DOWN_CONTAINER',
						'IG_UNIFORM_ADD_CONTAINER_COLUMN',
						'IG_UNIFORM_DELETE_CONTAINER',
						'IG_UNIFORM_DELETE_CONTAINER_COLUMN',
						'IG_UNIFORM_CONFIRM_DELETE_CONTAINER',
						'IG_UNIFORM_CONFIRM_DELETE_CONTAINER_COLUMN',
						'IG_UNIFORM_COLOR_CONFIRM_RESET',
						'IG_UNIFORM_COLOR_CONFIRM_DELETE',
						'IG_UNIFORM_COLOR_CONFIRM_EXISTS',
						'IG_UNIFORM_ALL_FORM_FIELD_ARE_HIDDEN',
						'IG_UNIFORM_ALL_FORM_FIELD_ARE_DISPLAYED',
						'IG_UNIFORM_ENABLE_RANGE_SELECTION',
						'TITLES',
						'IG_UNIFORM_DATE_HOUR_TEXT',
						'IG_UNIFORM_DATE_MINUTE_TEXT',
						'IG_UNIFORM_DATE_CLOSE_TEXT',
						'IG_UNIFORM_DATE_PREV_TEXT',
						'IG_UNIFORM_DATE_NEXT_TEXT',
						'IG_UNIFORM_DATE_CURRENT_TEXT',
						'IG_UNIFORM_DATE_MONTH_JANUARY',
						'IG_UNIFORM_DATE_MONTH_FEBRUARY',
						'IG_UNIFORM_DATE_MONTH_MARCH',
						'IG_UNIFORM_DATE_MONTH_APRIL',
						'IG_UNIFORM_DATE_MONTH_MAY',
						'IG_UNIFORM_DATE_MONTH_JUNE',
						'IG_UNIFORM_DATE_MONTH_JULY',
						'IG_UNIFORM_DATE_MONTH_AUGUST',
						'IG_UNIFORM_DATE_MONTH_SEPTEMBER',
						'IG_UNIFORM_DATE_MONTH_OCTOBER',
						'IG_UNIFORM_DATE_MONTH_NOVEMBER',
						'IG_UNIFORM_DATE_MONTH_DECEMBER',
						'IG_UNIFORM_DATE_MONTH_JANUARY_SHORT',
						'IG_UNIFORM_DATE_MONTH_FEBRUARY_SHORT',
						'IG_UNIFORM_DATE_MONTH_MARCH_SHORT',
						'IG_UNIFORM_DATE_MONTH_APRIL_SHORT',
						'IG_UNIFORM_DATE_MONTH_MAY_SHORT',
						'IG_UNIFORM_DATE_MONTH_JUNE_SHORT',
						'IG_UNIFORM_DATE_MONTH_JULY_SHORT',
						'IG_UNIFORM_DATE_MONTH_AUGUST_SHORT',
						'IG_UNIFORM_DATE_MONTH_SEPTEMBER_SHORT',
						'IG_UNIFORM_DATE_MONTH_OCTOBER_SHORT',
						'IG_UNIFORM_DATE_MONTH_NOVEMBER_SHORT',
						'IG_UNIFORM_DATE_MONTH_DECEMBER_SHORT',
						'IG_UNIFORM_DATE_DAY_SUNDAY',
						'IG_UNIFORM_DATE_DAY_MONDAY',
						'IG_UNIFORM_DATE_DAY_TUESDAY',
						'IG_UNIFORM_DATE_DAY_WEDNESDAY',
						'IG_UNIFORM_DATE_DAY_THURSDAY',
						'IG_UNIFORM_DATE_DAY_FRIDAY',
						'IG_UNIFORM_DATE_DAY_SATURDAY',
						'IG_UNIFORM_DATE_DAY_SUNDAY_SHORT',
						'IG_UNIFORM_DATE_DAY_MONDAY_SHORT',
						'IG_UNIFORM_DATE_DAY_TUESDAY_SHORT',
						'IG_UNIFORM_DATE_DAY_WEDNESDAY_SHORT',
						'IG_UNIFORM_DATE_DAY_THURSDAY_SHORT',
						'IG_UNIFORM_DATE_DAY_FRIDAY_SHORT',
						'IG_UNIFORM_DATE_DAY_SATURDAY_SHORT',
						'IG_UNIFORM_DATE_DAY_SUNDAY_MIN',
						'IG_UNIFORM_DATE_DAY_MONDAY_MIN',
						'IG_UNIFORM_DATE_DAY_TUESDAY_MIN',
						'IG_UNIFORM_DATE_DAY_WEDNESDAY_MIN',
						'IG_UNIFORM_DATE_DAY_THURSDAY_MIN',
						'IG_UNIFORM_DATE_DAY_FRIDAY_MIN',
						'IG_UNIFORM_DATE_DAY_SATURDAY_MIN',
						'IG_UNIFORM_DATE_DAY_WEEK_HEADER',
						'IG_UNIFORM__MAIL_SETTINGS',
						'IG_UNIFORM_SELECT_MENU_ITEM',
						'IG_UNIFORM_SELECT_ARTICLE',
						'IG_UNIFORM_FORM_APPEARANCE',
						'IG_UNIFORM_SELECT',
						'IG_UNIFORM_SAVE',
						'IG_UNIFORM_CANCEL',
						'IG_UNIFORM_ADD_FIELD',
						'IG_UNIFORM_BUTTON_SAVE',
						'IG_UNIFORM_BUTTON_CANCEL',
						'IG_UNIFORM_CONFIRM_CONVERTING_FORM',
						'IG_UNIFORM_UPGRADE__DITION_TITLE',
						'IG_UNIFORM_UPGRADE__DITION',
						'IG_UNIFORM_CONFIRM_SAVE_FORM',
						'IG_UNIFORM_NO__MAIL',
						'IG_UNIFORM_NO__MAIL_DES',
						'IG_UNIFORM_CONFIRM_DELETING_A_FIELD',
						'IG_UNIFORM_CONFIRM_DELETING_A_FIELD_DES',
						'IG_UNIFORM_BTN_BACKUP',
						'IG_UNIFORM_IF_CHECKED_VALUE_DUPLICATION',
						'IG_UNIFORM__MAIL_SUBMITTER_TITLE',
						'IG_UNIFORM__MAIL_ADDRESS_TITLE',
						'IG_UNIFORM_LAUNCHPAD_PLUGIN_SYNTAX',
						'IG_UNIFORM_LAUNCHPAD_PLUGIN_SYNTAX_DES',
						'IG_UNIFORM_FORM_LIMIG_FILE_EXTENSIONS',
						'IG_UNIFORM_FOR_SECURITY_REASONS_FOLLOWING_FILE_EXTENSIONS',
						'IG_UNIFORM_FORM_LIMIG_FILE_SIZE',
						'STREET_ADDRESS',
						'ADDRESS_LINE_2',
						'CITY',
						'POSTAL_ZIP_CODE',
						'STATE_PROVINCE_REGION',
						'FIRST',
						'MIDDLE',
						'LAST',
						'COUNTRY',
						'IG_UNIFORM_ALLOW_USER_CHOICE',
						'IG_UNIFORM_SET_ITEM_PLACEHOLDER',
						'IG_UNIFORM_SET_ITEM_PLACEHOLDER_DES',
						'IG_UNIFORM_SHOW_DATE_FORMAT',
						'IG_UNIFORM_SHOW_TIME_FORMAT',
						'IG_UNIFORM__NABLE_RANGE_SELECTION',
						'IG_UNIFORM_YOU_CAN_NOT_HIDE_THE_COPYLINK',
						'IG_UNIFORM_CUSTOM_DATE_FORMAT',
						'IG_UNIFORM_UPGRADE_EDITION',
						'IG_UNIFORM_UPGRADE_EDITION_TITLE',
						'IG_UNIFORM_YOU_HAVE_REACHED_THE_LIMITATION_OF_1_PAGE_IN_FREE_EDITION',
						'IG_UNIFORM_YOU_HAVE_REACHED_THE_LIMITATION_OF_10_FIELD_IN_FREE_EDITION',
					);
					$formSubmitter = isset( $items->form_submitter ) ? json_decode( $items->form_submitter ) : '';
					$languages = IGUniformHelper::get_translated( $arrayTranslated );
					$fieldFormStyle = $form[ 'ig-form-field-form_style' ];;
					$fieldFormStyle->get( 'input' );
					?>
					<input type="hidden" value="<?php echo '' . htmlentities( $formPage )  ?>" id="jform_form_content" name="jform[form_content]">
					<input type="hidden" name="jform_form_id" id="jform_form_id" value="<?php echo '' . ( ! empty( $items->form_id ) ? $items->form_id : '' );?>" />
					<input type="hidden" name="jform_form_title" id="jform_form_title" value="<?php echo '' . ( ! empty( $_GET[ 'form' ] ) ? $_GET[ 'form' ] : '' );?>" />
					<input type="hidden" name="urlAdmin" id="urlAdmin" value="<?php echo '' . get_admin_url();?>" />
					<input type="hidden" name="urlBase" id="ig_uniform_urlBase" value="<?php echo '' . get_site_url();?>" />
					<input type="hidden" name="languages" id="ig_uniform_languages" value='<?php echo '' . json_encode( $languages ) . '';?>' />
					<input type="hidden" id="ig_uniform_formStyle" name="ig_uniform_formStyle" value='<?php echo '' . htmlentities( json_encode( $formStyle ) ); ?>'>
					<input type="hidden" id="ig_uniform_dataEmailSubmitter" name="ig_uniform_dataEmailSubmitter" value="<?php echo '' . htmlentities( json_encode( $formSubmitter ) ); ?>">
				</div>
			</div>
		</div>
		<?php IGUniformHelper::get_footer();?>
		</div>
	<?php
	}

	/**
	 * add Container form action
	 *
	 * @param $form
	 */
	public function add_container_form_action( $form, $formStyle, $formSettings, $listPage, $listFontType, $items, $formItems, $formPage ) {
		?>
		<div id="form-action" class="form-horizontal">
		<?php do_action( 'ig_uniform_form_edit_form_action_position_1',$form, $formStyle, $formSettings, $listPage, $listFontType, $items, $formItems, $formPage );?>
		<div class="row-fluid">
			<fieldset id="postaction">
				<legend>
					<?php echo '' . __( 'IG_UNIFORM_POST_SUBMISSION_ACTION', IG_UNIFORM_TEXTDOMAIN ); ?>
				</legend>
				<div class="control-group">
					<label class="control-label ig-label-des-tipsy" original-title="<?php echo '' . __( 'IG_UNIFORM_SAVE_SUBMISSIONS_DES', IG_UNIFORM_TEXTDOMAIN ); ?>"><?php echo '' . __( 'IG_UNIFORM_SAVE_SUBMISSIONS', IG_UNIFORM_TEXTDOMAIN ); ?></label>

					<div class="controls">
						<?php
						$fieldActionSaveSubmissions = $form[ 'ig-form-field-action_save_submissions' ];
						$fieldActionSaveSubmissions->get( 'input' );
						?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label ig-label-des-tipsy" original-title="<?php echo '' . __(
						'IG_UNIFORM_SELECT_THE_ACTION_TO_TAKE_AFTER', IG_UNIFORM_TEXTDOMAIN
					); ?>"><?php echo '' . __( 'IG_UNIFORM_ALERT_FORM_SUBMITSSION', IG_UNIFORM_TEXTDOMAIN ); ?></label>

					<div class="controls">
						<?php
						$fieldActionPostForm = $form[ 'ig-form-field-form_post_action' ];;
						$fieldActionPostForm->get( 'input' );
						?>
					</div>
				</div>
				<div class="form-action-data">
					<?php
					$fieldActionPostDataForm = $form[ 'form_post_action_data' ];;
					$fieldActionPostDataForm->get( 'input' );
					?>
				</div>
			</fieldset>
		</div>
		<?php do_action( 'ig_uniform_form_edit_form_action_position_2',$form, $formStyle, $formSettings, $listPage, $listFontType, $items, $formItems, $formPage );?>
		<div class="row-fluid">
			<fieldset id="email">
				<legend>
					<?php echo '' . __( 'IG_UNIFORM_FORM_EMAIL_NOTIFICATION', IG_UNIFORM_TEXTDOMAIN ); ?>
				</legend>
				<?php
				$fieldContentEmailSendTo = $form[ 'ig-form-field-content_email_send_to' ];
				$fieldContentEmailSendTo->get( 'input' );
				$fieldContentEmailSendToSubmitter = $form[ 'ig-form-field-content_email_send_to_submitter' ];
				$fieldContentEmailSendToSubmitter->get( 'input' );
				$fieldListEmailSendTo = $form[ 'ig-form-field-list_email_send_to' ];;
				$fieldListEmailSendTo->get( 'input' );
				$fieldListEmailSendToSubmitter = $form[ 'ig-form-field-list_email_send_to_submitter' ];
				$fieldListEmailSendToSubmitter->get( 'input' );
				?>
				<div class="control-group jsn-items-list-container">
					<label class="control-label ig-label-des-tipsy" original-title="<?php echo '' . __( 'IG_UNIFORM_SPECIFY_EMAIL_ADDRESS', IG_UNIFORM_TEXTDOMAIN )?>">
						<?php echo '' . __( 'IG_UNIFORM_SEND_EMAIL_TO', IG_UNIFORM_TEXTDOMAIN );?>
					</label>

					<div class="controls">
						<button class="btn btn-icon pull-right" data-placement="top" id="btn_email_list" original-title="<?php echo '' . __(
							'IG_UNIFORM_EMAIL_CONTENT', IG_UNIFORM_TEXTDOMAIN
						);?>" title="<?php echo '' . __( 'IG_UNIFORM_EMAIL_CONTENT', IG_UNIFORM_TEXTDOMAIN );?>" onclick="return false;">
							<i class="icon-envelope"></i></button>
						<div class="email-addresses">
							<ul id="emailAddresses" class="jsn-items-list ui-sortable"></ul>
							<a href="#" onclick="return false;" id="show-div-add-email" class="jsn-add-more"><?php echo '' . __(
								'IG_UNIFORM_ADD_MORE_EMAIL', IG_UNIFORM_TEXTDOMAIN
							);?></a>

							<div id="addMoreEmail" class="jsn-form-bar">
								<div class="control-group input-append">
									<input name="nemail" class="input-xlarge" id="input_new_email" type="text">
								</div>
								<div class="control-group">
									<button class="btn btn-icon" onclick="return false;" id="add-email" title="<?php echo '' . __(
										'IG_UNIFORM_BUTTON_SAVE', IG_UNIFORM_TEXTDOMAIN
									);?>"><i class="icon-ok"></i></button>
									<button class="btn btn-icon" onclick="return false;" id="close-email" title="<?php echo '' . __(
										'IG_UNIFORM_BUTTON_CANCEL', IG_UNIFORM_TEXTDOMAIN
									) ?>"><i class="icon-remove"></i></button>
								</div>
								<div class="control-group"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="control-group jsn-items-list-container">
					<label class="control-label ig-label-des-tipsy" original-title="<?php echo '' . __(
						'IG_UNIFORM_SELECT_EMAIL_FORM_FIELD', IG_UNIFORM_TEXTDOMAIN
					); ?>">
						<?php echo '' . __( 'IG_UNIFORM_SEND_TO_SUBMITTER', IG_UNIFORM_TEXTDOMAIN ); ?>
					</label>

					<div class="controls">
						<button class="btn btn-icon pull-right " id="btn_email_submit" original-title="<?php echo '' . __(
							'IG_UNIFORM_EMAIL_CONTENT', IG_UNIFORM_TEXTDOMAIN
						); ?>" onclick="return false;" title="<?php echo '' . __(
							'IG_UNIFORM_EMAIL_CONTENT', IG_UNIFORM_TEXTDOMAIN
						); ?>">
							<i class="icon-envelope"></i></button>
						<div class="email-submitters">
							<ul id="emailSubmitters" class="jsn-items-list ui-sortable"></ul>
						</div>
					</div>
				</div>
			</fieldset>
		</div>
		<?php do_action( 'ig_uniform_form_edit_form_action_position_3',$form, $formStyle, $formSettings, $listPage, $listFontType, $items, $formItems, $formPage );?>
			<?php IGUniformHelper::get_footer();?>
		</div>
	<?php
	}
}
