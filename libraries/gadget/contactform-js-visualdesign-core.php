<?php
/**
 * @version    $Id$
 * @package    IG_Plugin_Framework
 * @author     InnoThemes Team <support@innothemes.com>
 * @copyright  Copyright (C) 2012 InnoThemes.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.innothemes.com
 * Technical Support:  Feedback - http://www.innothemes.com/contact-us/get-support.html
 */

class IG_Gadget_Contactform_Js_Visualdesign_Core extends IG_Gadget_Base {

	/**
	 * Gadget file name without extension.
	 *
	 * @var  string
	 */
	protected $gadget = 'contactform-js-visualdesign-core';

	/**
	 * Constructor.
	 *
	 * @return  void
	 */
	public function __construct() {

	}

	/**
	 *  set default action
	 */
	public function default_action() {
		require_once( ABSPATH . 'wp-admin/includes/admin.php' );
		auth_redirect();
		header( 'Content-Type: application/javascript' );
		$addParamsVisualDesign = array( 'newElement' => 'this.newElement = $(\'<a href="javascript:void(0);" class="jsn-add-more"><i class="icon-plus"></i>\' + lang[\'IG_CONTACTFORM_ADD_FIELD\'] + \'</a>\');' );
		/* Create Filter add params visual design */
		$addParamsVisualDesign = apply_filters( 'ig_contactform_visualdesign_add_params', $addParamsVisualDesign );
		$addBoxContent = array();
		$addBoxContent[ 'toolboxContent' ] = 'JSNVisualDesign.wrapper = $(\'<div class="jsn-element ui-state-default jsn-iconbar-trigger"><div class="jsn-element-content"></div><div class="jsn-element-overlay"></div><div class="jsn-iconbar"><a href="#" onclick="return false;" title="Edit element" class="element-edit"><i class="icon-pencil"></i></a><a href="#" onclick="return false;" title="Duplicate element" class="element-duplicate"><i class="icon-copy"></i></a><a href="#" title="Delete element" onclick="return false;" class="element-delete"><i class="icon-trash"></i></a></div></div>\');
				        JSNVisualDesign.toolbox = $(\'<div class="box jsn-bootstrap"></div>\');
				        JSNVisualDesign.toolboxContent = $(\'<div class="popover top" />\');
				        JSNVisualDesign.toolboxContent.css(\'display\', \'block\');
				        JSNVisualDesign.toolboxContent.append($(\'<div class="arrow" />\'));
				        JSNVisualDesign.toolboxContent.append($(\'<h3 class="popover-title">Select Field</h3>\'));
				        JSNVisualDesign.toolboxContent.append($(\'<div/>\', { "class":"popover-content"  }).append( $("<form/>") ));
				        JSNVisualDesign.toolbox.append(JSNVisualDesign.toolboxContent);
				        JSNVisualDesign.toolbox.attr(\'id\', \'visualdesign-toolbox\');
				        JSNVisualDesign.optionsBox = $(\'<div class="box jsn-bootstrap" id="visualdesign-options"></div>\');
				        JSNVisualDesign.optionsBoxContent = $(\'<div class="popover bottom"></div>\');
				        JSNVisualDesign.optionsBoxContent.css(\'display\', \'block\');
				        JSNVisualDesign.optionsBoxContent.append($(\'<div class="arrow" />\'));
				        JSNVisualDesign.optionsBoxContent.append($(\'<h3 class="popover-title">Properties</h3>\'));
				        JSNVisualDesign.optionsBoxContent.append($(\'<div class="popover-content"><form><div class="tabs"><ul><li class="active"><a data-toggle="tab" href="#visualdesign-options-general">General</a></li><li><a data-toggle="tab" href="#visualdesign-options-values">Values</a></li></ul><div id="visualdesign-options-general" class="tab-pane active"></div><div id="visualdesign-options-values" class="tab-pane"></div></div></form></div>\'));
				        JSNVisualDesign.optionsBox.append(JSNVisualDesign.optionsBoxContent);';
		/* Create filter render html add box content*/
		$addBoxContent = apply_filters( 'ig_contactform_visualdesign_add_box_content', $addBoxContent );

		/* Create Filter get action change option content */
		$actionChangeOptionsBoxContent = array();
		$actionChangeOptionsBoxContent = apply_filters( 'ig_contactform_visualdesign_action_change_option_box_content', $actionChangeOptionsBoxContent );

		/* Create Filter get action change option box content */
		$beforeActionChangeOptionBoxContent = array();
		$beforeActionChangeOptionBoxContent = apply_filters( 'ig_contactform_visualdesign_before_action_change_option_box_content', $beforeActionChangeOptionBoxContent );
		/* Create Filter get after action change option box content */
		$afterActionChangeOptionBoxContent = array();
		$afterActionChangeOptionBoxContent = apply_filters( 'ig_contactform_visualdesign_before_action_change_option_box_content', $afterActionChangeOptionBoxContent );
		/* Crate Filter get event box content submit*/
		$eventBoxContentSubmit = array();
		/* Set event default */
		$eventBoxContentSubmit[ 'default' ] = '$(this).trigger(\'change\'); e.preventDefault();';
		$eventBoxContentSubmit = apply_filters( 'ig_contactform_visualdesign_event_box_content_submit', $eventBoxContentSubmit );
		/* Create Filter get algorithm check mousedown box content */
		$ifCheckTargetMouseDownBoxContent = array();
		$ifCheckTargetMouseDownBoxContent[ 'default' ] = 'event.target != JSNVisualDesign.optionsBox.get(0) && !$.contains(JSNVisualDesign.optionsBox.get(0), event.target) && $(event.target).parent().attr("class") != "jsn-element ui-state-edit" && $(event.target).parent().attr("class") != "ui-state-edit" && !$(event.target).parents("#ui-datepicker-div").size() && $(event.target).attr("id") != "ui-datepicker-div" && $(event.target).attr("class") != "ui-widget-overlay" && !$(event.target).parents(".ui-dialog").size() && !$(event.target).parents(".wysiwyg-dialog-modal-div").size() && !$(event.target).parents(".control-list-action").size() && !$(event.target).parents(".ui-autocomplete").size() && !$(event.target).parents(".pac-container").size() && !$(event.target).parents(".dialog-google-maps").size() && $(event.target).attr("class") != "ig-lock-screen"';
		$ifCheckTargetMouseDownBoxContent = apply_filters( 'ig_contactform_visualdesign_if_check_target_mousedown_box_content', $ifCheckTargetMouseDownBoxContent );
		/* Create Filter get logic check mousedown box content */
		$logicIfCheckTargetMouseDownBoxContent = array( 'default' => '$("#form-design .ui-state-edit").removeClass("ui-state-edit"); JSNVisualDesign.closeOptionsBox();' );
		$logicIfCheckTargetMouseDownBoxContent = apply_filters( 'ig_contactform_visualdesign_logic_if_check_target_mousedown_box_content', $logicIfCheckTargetMouseDownBoxContent );

		/* Create Filter get event mousedown box content*/
		$eventMouseDownBoxContent = array();
		$eventMouseDownBoxContent[ 'default' ] = '  if (event.target != JSNVisualDesign.toolbox.get(0) && !$.contains(JSNVisualDesign.toolbox.get(0), event.target)) {
				                    JSNVisualDesign.closeToolbox();
				                }
				                if (' . implode( '', $ifCheckTargetMouseDownBoxContent ) . ') {
				                    ' . implode( '', $logicIfCheckTargetMouseDownBoxContent ) . '
				                }';
		$eventMouseDownBoxContent = apply_filters( 'ig_contactform_visualdesign_event_mousedown_box_content', $eventMouseDownBoxContent );
		/* Create Filter get algorithm check button add field */
		$ifCheckRenderButtonAddField = array( 'default' => 'identify != "form-actions" && identify != "form-captcha"' );
		$ifCheckRenderButtonAddField = apply_filters( 'ig_contactform_visualdesign_if_check_render_button_add_field', $ifCheckRenderButtonAddField );
		/* Create Filter get event click button add field */
		$eventClickButtonAddField = array();
		$eventClickButtonAddField[ 'dropdown' ] = 'if (this.name == "dropdown") {  $("#option-firstItemAsPlaceholder-checkbox").prop("checked", true); }';

		/* Get filter event click button add field*/
		$eventClickButtonAddField = apply_filters( 'ig_contactform_visualdesign_event_click_button_add_field', $eventClickButtonAddField );

		$createFunctionVisualDesign = array();
		$createFunctionVisualDesign[ 'filterResults' ] = 'JSNVisualDesign.filterResults = function (value, resultsFilter) {
				        $(resultsFilter).find("li").hide();
				        if (value != "") {
				            $(resultsFilter).find("li").each(function () {
				                var textField = $(this).attr("data-value").toLowerCase();
				                if (textField.search(value.toLowerCase()) == -1) {
				                    $(this).hide();
				                } else {
				                    $(this).fadeIn(800);
				                }
				            });
				        } else {
				            $(resultsFilter).find("li").each(function () {
				                $(this).fadeIn(800);
				            });
				        }
				    };';
		$filterAddButtonField = array();
		$filterAddButtonField[ 'all' ] = ' if(buttons.standard.length>0 || buttons.extra.length>0){
					            $(listFilter).append(
				                $("<option/>", {
				                    "value":"all",
				                    "text":"All Fields"
				                })
				            );
				            }';
		$filterAddButtonField[ 'standard' ] = ' if(buttons.standard.length>0){
					            $(listFilter).append(
					                $("<option/>", {
					                    "value":"standard",
					                    "text":"Standard Fields"
					                })
					            )
				            }';
		$filterAddButtonField[ 'extra' ] = 'if(buttons.extra.length>0){
					              $(listFilter).append($("<option/>", {
					                "value":"extra",
					                "text":"PRO Fields"
					                 })
					              )
				            }';
		$getFilterAddButtonField = apply_filters( 'ig_contactform_add_select_button_field', $filterAddButtonField );
		if ( ! empty( $getFilterAddButtonField ) ) {
			$filterAddButtonField = $getFilterAddButtonField;
		}
		$filterButtonField = array();
		$filterButtonField[ 'standard' ] = 'case \'standard\':
				                      $(resultsFilter).empty();
                                      var buttons = JSNVisualDesign.drawToolboxButtons();
				                      if(buttons.standard.length>0){
											 $.each(buttons.standard, function (i, val) {
				                                 $(resultsFilter).append(val)
				                            });
										}
				                        break;';
		$filterButtonField[ 'all' ] = 'case \'all\':
				                        $(resultsFilter).empty();
									   var buttons = JSNVisualDesign.drawToolboxButtons();
				                       if(buttons.standard.length>0){
											 $.each(buttons.standard, function (i, val) {
				                                 $(resultsFilter).append(val)
				                            });
										}

				                        if(buttons.extra.length>0){
											 $.each(buttons.extra, function (i, val) {
				                                 $(resultsFilter).append(val)
				                            });
										}

				                        break;';
		$filterButtonField[ 'extra' ] = ' case \'extra\':
				                        $(resultsFilter).empty();
				                        var buttons = JSNVisualDesign.drawToolboxButtons();
										if(buttons.extra.length>0){
											 $.each(buttons.extra, function (i, val) {
				                                 $(resultsFilter).append(val)
				                            });
										}
				                        break;';
		$getFilterButtonField = apply_filters( 'ig_contactform_button_field', $filterButtonField );
		if ( ! empty( $getFilterButtonField ) ) {
			$filterButtonField = $getFilterButtonField;
		}
		$createFunctionVisualDesign[ 'openToolbox' ] = 'JSNVisualDesign.openToolbox = function (sender, target) {
				        if (JSNVisualDesign.toolbox.find(\'button.btn\').size() == 0) {
				        var buttons = JSNVisualDesign.drawToolboxButtons();
				            var resultsFilter = $("<ul/>", {
				                "class":"jsn-items-list"
				            });
				            var oldIconFilter = "";
				            var listFilter = $("<select/>", {
				                "class":"ig-filter-button input-large"
				            })
				           ' . implode( ' ', $filterAddButtonField ) . '

				            $(listFilter).change(function () {
				                JSNVisualDesign.toolbox.find("input#jsn-quicksearch-field").val("");
				                JSNVisualDesign.toolbox.find(".jsn-reset-search").hide();
				                switch ($(this).val()) { ' . implode( ' ', $filterButtonField ) . '}
				            });
				            $.fn.delayKeyup = function (callback, ms) {
				                var timer = 0;
				                var el = $(this);
				                $(this).keyup(function () {
				                    clearTimeout(timer);
				                    timer = setTimeout(function () {
				                        callback(el)
				                    }, ms);
				                });
				                return $(this);
				            };
				            JSNVisualDesign.toolbox.find("form").find(".jsn-elementselector").remove();
				            JSNVisualDesign.toolbox.find("form").append(
				                $("<div/>", {
				                    "class":"jsn-elementselector"
				                }).append(
				                    $("<div/>", {
				                        "class":"jsn-fieldset-filter"
				                    }).append(
				                        $("<fieldset/>").append(
				                            $("<div/>", {
				                                "class":"pull-left"
				                            }).append(listFilter)
				                        ).append(
				                            $("<div/>", {
				                                "class":"pull-right"
				                            }).append(
				                                $("<input/>", {
				                                    "class":"input search-query",
				                                    "type":"text",
				                                    "id":"jsn-quicksearch-field",
				                                    "placeholder":"Search…"
				                                }).delayKeyup(function (el) {
				                                        if ($(el).val() != oldIconFilter) {
				                                            oldIconFilter = $(el).val();
				                                            JSNVisualDesign.filterResults($(el).val(), resultsFilter);
				                                        }
				                                        if ($(el).val() == "") {
				                                            JSNVisualDesign.toolbox.find(".jsn-reset-search").hide();
				                                        } else {
				                                            JSNVisualDesign.toolbox.find(".jsn-reset-search").show();
				                                        }
				                                    }, 500)
				                            ).append(
				                                $("<a/>", {"href":"javascript:void(0);", "title":"Clear Search", "class":"jsn-reset-search"}).append($("<i/>", {"class":"icon-remove"})).click(function () {
				                                    JSNVisualDesign.toolbox.find("#jsn-quicksearch-field").val("");
				                                    oldIconFilter = "";
				                                    JSNVisualDesign.filterResults("", resultsFilter);
				                                    $(this).hide();
				                                })
				                            )
				                        )
				                    )
				                ).append(resultsFilter).append(resultsFilter).append(
				                $("<div/>",{"class":"row-fluid"}).append(
				                    $("<span/>",{"class":"jsn-contactform-more-addons"}).append("Want to add more fields? <a target=\"_blank\" title=\"Check add-ons\" href=\"edit.php?post_type=ig_cf_post_type&page=ig-contactform-addons\">Check add-ons</a>.")
				                )
				                )
				            )
				            JSNVisualDesign.toolbox.find("select.ig-filter-button").trigger("change");
				            JSNVisualDesign.toolbox.find("select.ig-filter-button").select2({
			                    minimumResultsForSearch:99
			                });
				            JSNVisualDesign.toolbox.find("input#jsn-quicksearch-field").attr("placeholder", "Search…");
				            $(\'input, textarea\').placeholder();

				        } else {
				            JSNVisualDesign.toolbox.find("input#jsn-quicksearch-field").val("");
				            JSNVisualDesign.toolbox.find("select.ig-filter-button").trigger("change");
				        }

				        JSNVisualDesign.closeOptionsBox();
				        JSNVisualDesign.toolbox.hide().appendTo($(\'body\')).show();
				        JSNVisualDesign.position(JSNVisualDesign.toolbox, sender, \'top\', {
				            top:-5
				        });
				        JSNVisualDesign.toolboxTarget = target;
				        if ($(sender).offset().top - $(window).scrollTop() < JSNVisualDesign.toolbox.find(".popover").height() + 30) {
				            $(window).scrollTop($(sender).offset().top - JSNVisualDesign.toolbox.find(".popover").height() - 60);
				        }
				    };';
		$createFunctionVisualDesign[ 'savePage' ] = '  JSNVisualDesign.savePage = function (action) {
				        var container = $("#ig_contactform_master #form-container");
				        var listOptionPage = [];
				        var listContainer = [];
				        var instance = container.data(\'visualdesign-instance\');
				        var content = "";
				        var serialize = instance.serialize(true);
				        if (serialize != "" && serialize != "[]") {
				            content = $.toJSON(serialize);
				        }
				        $(" ul.jsn-page-list li.page-items").each(function () {
				            listOptionPage.push([$(this).find("input").attr(\'data-id\'), $(this).find("input").attr(\'value\')]);
				        });
				        $("#form-container .jsn-row-container").each(function () {
				            var listColumn = [];
				            $(this).find(".jsn-column-content").each(function () {
				                var dataContainer = {};
				                var columnName = $(this).attr("data-column-name");
				                var columnClass = $(this).attr("data-column-class");
				                dataContainer.columnName = columnName;
				                dataContainer.columnClass = columnClass;
				                listColumn.push(dataContainer);
				            });
				            listContainer.push(listColumn);
				        });
				        $.ajax({
				            type:"POST",
				            dataType:\'json\',
				            url:"admin-ajax.php?action=ig_contactform_save_page",
				            data:{
				                form_id:$("#jform_form_id").val(),
				                form_content:content,
				                form_page_name:$("#form-design-header").attr(\'data-value\'),
				                form_list_page:listOptionPage,
				                form_list_container:$.toJSON(listContainer)
				            },
				            success:function () {
				                JSNVisualDesign.emailNotification();

				                if (action == \'delete\') {
				                    $("#form-design-header .jsn-iconbar").css("display", "");
				                    $(".jsn-page-actions").css("display", "");
				                }
				            }
				        });
				    };';
		$createFunctionVisualDesign[ 'emailNotification' ] = 'JSNVisualDesign.emailNotification = function () {
				        var container = $("#ig_contactform_master #form-container");
				        var instance = container.data(\'visualdesign-instance\');
				        var formContent = instance.serialize(true);
				        var content = "";
				        if (formContent != "" && formContent != "[]") {
				            content = $.toJSON(formContent);
				        }
				        var check = 0;
				        var listOptionPage = [];
				        $(" ul.jsn-page-list li.page-items").each(function () {
				            listOptionPage.push([$(this).find("input").attr(\'data-id\'), $(this).find("input").attr(\'value\')]);
				        });
				        $.ajax({
				            type:"POST",
				            dataType:\'json\',
				            url:"admin-ajax.php?action=ig_contactform_load_session_field",
				            data:{
				                form_id:$("#jform_form_id").val(),
				                form_page_name:$("#form-design-header").attr(\'data-value\'),
				                form_content:content,
				                form_list_page:listOptionPage
				            },
				            success:function (response) {
				                $("#email .email-submitters .jsn-items-list").html("");
				                if (response) {
				                    if ($("#ig-form-field-list_email_send_to_submitter").val()) {
				                        dataEmailSubmitter = $.evalJSON($("#ig-form-field-list_email_send_to_submitter").val());
				                    }
				                    $.each(response, function (i, item) {
				                        if (item.type == \'email\') {
				                            check++;
				                            if ($.inArray(item.identify, dataEmailSubmitter) != -1) {
				                                $("#email .email-submitters .jsn-items-list").append(
				                                    $("<li/>", {
				                                        "class":"jsn-item ui-state-default"
				                                    }).append(
				                                        $("<label/>", {
				                                            "class":"checkbox",
				                                            text:item.options.label
				                                        }).append(
				                                            $("<input/>", {
				                                                "type":"checkbox",
				                                                "name":"ig_contactform[list_email_send_to_submitter][]",
				                                                "checked":"checked",
				                                                "class":"ig-check-submitter",
				                                                "value":item.identify
				                                            }))))
				                            } else {
				                                $("#email .email-submitters .jsn-items-list").append(
				                                    $("<li/>", {
				                                        "class":"jsn-item ui-state-default"
				                                    }).append(
				                                        $("<label/>", {
				                                            "class":"checkbox",
				                                            text:item.options.label
				                                        }).append(
				                                            $("<input/>", {
				                                                "type":"checkbox",
				                                                "name":"ig_contactform[list_email_send_to_submitter][]",
				                                                "class":"ig-check-submitter",
				                                                "value":item.identify
				                                            }))))
				                            }
				                        }
				                    });
				                }
				                if (check == 0 || !check) {
				                    $("#email .email-submitters .jsn-items-list").append(
				                        $("<div/>", {
				                            "class":"ui-state-default ui-state-disabled",
				                            "text":lang["IG_CONTACTFORM_NO_EMAIL"],
				                            "title":lang["IG_CONTACTFORM_NO_EMAIL_DES"]
				                        }))
				                }
				                $("#email .email-submitters .jsn-items-list").parent().parent().show();
				            }
				        });
				    };';
		$createFunctionVisualDesign[ 'checkLimitation' ] = '  JSNVisualDesign.checkLimitation = function () {
				        if ($("#visualdesign-options-values #option-limitation-checkbox").is(\':checked\')) {
				            $("#visualdesign-options-values #option-limitMin-number").removeAttr("disabled");
				            $("#visualdesign-options-values #option-limitMax-number").removeAttr("disabled");
				            $("#visualdesign-options-values #option-limitType-select").removeAttr("disabled");
				        } else {
				            $("#visualdesign-options-values #option-limitMin-number").attr("disabled", "disabled");
				            $("#visualdesign-options-values #option-limitMax-number").attr("disabled", "disabled");
				            $("#visualdesign-options-values #option-limitType-select").attr("disabled", "disabled");
				        }
				    };';

		$createFunctionVisualDesign[ 'eventChangeallowOther' ] = ' JSNVisualDesign.eventChangeallowOther = function () {
				        if ($("#option-allowOther-checkbox").is(\':checked\')) {
				            $("#visualdesign-options-values .ig-allow-other #option-labelOthers-_text").show();
				        } else {
				            $("#visualdesign-options-values .ig-allow-other #option-labelOthers-_text").hide();
				        }
				    };';

		$createFunctionVisualDesign[ 'eventChangeConfirm' ] = 'JSNVisualDesign.eventChangeConfirm = function () {
				        if ($("#option-requiredConfirm-checkbox").is(\':checked\')) {
				            $("#visualdesign-options-values #option-valueConfirm-text").show();
				        } else {
				            $("#visualdesign-options-values #option-valueConfirm-text").hide();
				        }
				    };';
		$actionFunctionCreateElement = array();
		$actionFunctionCreateElement[ 'duplicate' ] = 'wrapper.find(".element-duplicate").click(function () {
				                var newOtions = {};
				                var d = new Date();
								var time = d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
								var getLabel = opts.label + "_" + Math.floor(Math.random() * 999999999) + time;
						        var label = getLabel.toLowerCase();
						        while (/[^a-zA-Z0-9_]+/.test(label)) {
						            label = label.replace(/[^a-zA-Z0-9_]+/, \'_\');
						        }
				                newOtions = opts;
				                newOtions.identify = label;
				                var element = JSNVisualDesign.createElement(type, newOtions);
				                $(wrapper).after(element);
				                JSNVisualDesign.savePage();
				                JSNVisualDesign.contentGoogleMaps();
				            });';
		$actionFunctionCreateElement[ 'delete' ] = 'wrapper.find(\'.element-delete\').click(function () {
								if (confirm(lang["IG_CONTACTFORM_CONFIRM_DELETING_A_FIELD"])) {
									$("#form-design-header .jsn-iconbar").css("display", "none");
					                $(".jsn-page-actions").css("display", "none");
					                if (id) {
					                    wrapper.remove();
					                    JSNVisualDesign.savePage(\'delete\');
					                } else {
					                    wrapper.remove();
					                    JSNVisualDesign.savePage(\'delete\');
					                }
								}
				            });';
		$actionFunctionCreateElement[ 'edit' ] = '  wrapper.find("a.element-edit").click(function (event) {
				                $("#form-design .ui-state-edit").removeClass("ui-state-edit");
				                wrapper.addClass("ui-state-edit");
				                JSNVisualDesign.openOptionsBox(wrapper, type, wrapper.data(\'visualdesign-element-data\').options, $(this));
				            });';
		/* Create filter get action on function create element */
		$actionFunctionCreateElement = apply_filters( 'ig_contactform_visualdesign_action_function_create_element', $actionFunctionCreateElement );
		$createFunctionVisualDesign[ 'createElement' ] = '
				    JSNVisualDesign.createElement = function (type, opts, id) {
				        var control = JSNVisualDesign.controls[type];
				        if (control) {
				            var data = (opts === undefined) ? control.defaults : $.extend({}, control.defaults, opts);
				            var wrapper = JSNVisualDesign.wrapper.clone();
				            wrapper.data(\'visualdesign-element-data\', {
				                id:id,
				                type:type,
				                options:data
				            });
				            ' . implode( '', $actionFunctionCreateElement ) . '
				            wrapper.find(\'.jsn-element-content\').append($.tmpl(control.tmpl, data));
				            return wrapper;
				        }
				    };';

		$actionOpenOptionsBox = array();
		$actionOpenOptionsBox[ 'eventChangeConfirm' ] = 'JSNVisualDesign.eventChangeConfirm(); $("#option-requiredConfirm-checkbox").change(function () { JSNVisualDesign.eventChangeConfirm();});';
		$actionOpenOptionsBox[ 'actions' ] = ' if (type == "form-actions") {
				            var pageItems = $("ul.jsn-page-list li.page-items");
				            if (pageItems.size() <= 1) {
				                $("#option-btnNext-text").parents(".control-group").remove();
				                $("#option-btnPrev-text").parents(".control-group").remove();
				            }
				        }';
		$actionOpenOptionsBox[ 'eventChangeallowOther' ] = '   JSNVisualDesign.eventChangeallowOther();
				        $("#option-allowOther-checkbox").change(function () {
				            JSNVisualDesign.eventChangeallowOther();
				        });';
		$actionOpenOptionsBox[ 'wysiwyg' ] = 'if ($("#visualdesign-options-general #option-value-textarea").size()) {
				            $("#visualdesign-options-general #option-value-textarea").wysiwyg({
				                controls:{
				                    bold:{ visible:true },
				                    italic:{ visible:true },
				                    underline:{ visible:true },
				                    strikeThrough:{ visible:true },
				                    justifyLeft:{ visible:true },
				                    justifyCenter:{ visible:true },
				                    justifyRight:{ visible:true },
				                    justifyFull:{ visible:true },
				                    indent:{ visible:true },
				                    outdent:{ visible:true },
				                    subscript:{ visible:true },
				                    superscript:{ visible:true },
				                    undo:{ visible:true },
				                    redo:{ visible:true },
				                    insertOrderedList:{ visible:true },
				                    insertUnorderedList:{ visible:true },
				                    insertHorizontalRule:{ visible:true },
				                    h4:{
				                        visible:true,
				                        className:\'h4\',
				                        command:($.browser.msie || $.browser.safari) ? \'formatBlock\' : \'heading\',
				                        arguments:($.browser.msie || $.browser.safari) ? \'<h4>\' : \'h4\',
				                        tags:[\'h4\'],
				                        tooltip:\'Header 4\'
				                    },
				                    h5:{
				                        visible:true,
				                        className:\'h5\',
				                        command:($.browser.msie || $.browser.safari) ? \'formatBlock\' : \'heading\',
				                        arguments:($.browser.msie || $.browser.safari) ? \'<h5>\' : \'h5\',
				                        tags:[\'h5\'],
				                        tooltip:\'Header 5\'
				                    },
				                    h6:{
				                        visible:true,
				                        className:\'h6\',
				                        command:($.browser.msie || $.browser.safari) ? \'formatBlock\' : \'heading\',
				                        arguments:($.browser.msie || $.browser.safari) ? \'<h6>\' : \'h6\',
				                        tags:[\'h6\'],
				                        tooltip:\'Header 6\'
				                    },
				                    html:{ visible:true },
				                    increaseFontSize:{ visible:true },
				                    decreaseFontSize:{ visible:true }
				                },
				                html:\'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head><body style="margin:0; padding:10px;">INITIAL_CONTENT</body></html>\'
				            });
				        }';
		$actionOpenOptionsBox[ 'checkLimitation' ] = 'JSNVisualDesign.checkLimitation();';
		$actionOpenOptionsBox[ 'itemAction' ] = 'if (JSNVisualDesign.controls[type].params.values) {
				            if (JSNVisualDesign.controls[type].params.values.itemAction) {
				                var itemAction = $("#visualdesign-options-values #option-itemAction-hidden").val();
				                if (itemAction) {
				                    itemAction = $.evalJSON(itemAction);
				                }
				                if (itemAction) {
				                    $("#visualdesign-options-values .jsn-items-list .jsn-item input[name=item-list]").each(function () {
				                        var inputItem = $(this);
				                        $.each(itemAction, function (i, item) {
				                            if (i == $(inputItem).val()) {
				                                $(inputItem).attr("action-show-field", $.toJSON(item.showField));
				                                $(inputItem).attr("action-hide-field", $.toJSON(item.hideField));
				                                if ($(item.showField).length > 0 || $(item.hideField).length > 0) {
				                                    var jsnItem = $(inputItem).parents(".jsn-item");
				                                    $(jsnItem).addClass("jsn-highlight");
				                                } else {
				                                    var jsnItem = $(inputItem).parents(".jsn-item");
				                                    $(jsnItem).removeClass("jsn-highlight");
				                                }
				                            }
				                        })
				                    });
				                }
				            }
				        }';

		$createFunctionVisualDesign[ 'renderOptionsBox' ] = 'JSNVisualDesign.renderOptionsBox = function (options, data) {
				        if (options.general === undefined) {
				            JSNVisualDesign.optionsBoxContent.find(\'a[href^="#visualdesign-options-general"]\').parent().hide();
				        } else {
				            JSNVisualDesign.optionsBoxContent.find(\'a[href^="#visualdesign-options-general"]\').parent().show();
				        }
				        if (options.values === undefined) {
				            JSNVisualDesign.optionsBoxContent.find(\'a[href^="#visualdesign-options-values"]\').parent().hide();
				        } else {
				            JSNVisualDesign.optionsBoxContent.find(\'a[href^="#visualdesign-options-values"]\').parent().show();
				        }
				        JSNVisualDesign.optionsBoxContent.find(\'div[id^="visualdesign-options-"]\').removeClass(\'active\').empty();
				        JSNVisualDesign.optionsBoxContent.find(\'div#visualdesign-options-general\').addClass(\'active\');
				        JSNVisualDesign.optionsBoxContent.find(\'a[href^="#visualdesign-options-"]\').parent().removeClass(\'active\');
				        JSNVisualDesign.optionsBoxContent.find(\'a[href^="#visualdesign-options-general"]\').parent().addClass(\'active\');
				        $.map(options, function (params, tabName) {
				            var tabPane = JSNVisualDesign.optionsBoxContent.find(\'#visualdesign-options-\' + tabName);
				            $.map(params, function (elementOptions, name) {
				                // Render for group option
				                if (elementOptions.type == \'group\') {
				                    var group = null;
				                    group = $(\'<div/>\').append($(elementOptions.decorator));
				                    group.addClass(\'group \' + name);
				                    $.map(elementOptions.elements, function (itemOptions, itemName) {
				                        itemOptions.name = itemName;
				                        group.find(itemName.toLowerCase()).replaceWith(JSNVisualDesign.createControl(itemOptions, data[itemName], data.identify));
				                    });
				                    tabPane.append(group);
				                    return false;
				                }
				                if (elementOptions.type == \'horizontal\') {
				                    var group = null;
				                    group = $(\'<div/>\', {
				                        "class":"control-group"
				                    }).append($("<label/>", {
				                        "class":"control-label"
				                    }).append(elementOptions.title)).append($("<div/>", {
				                        "class":"controls"
				                    }).append($(elementOptions.decorator)));
				                    $.map(elementOptions.elements, function (itemOptions, itemName) {
				                        itemOptions.name = itemName;
				                        group.find(itemName.toLowerCase()).replaceWith(JSNVisualDesign.createControl(itemOptions, data[itemName], data.identify));
				                    });
				                    tabPane.append(group);
				                    return false;
				                }
				                elementOptions.name = name;
				                if (elementOptions.name == \'group\') {
				                    var groupControl = $(\'<div/>\', {
				                        \'class\':\'controls\'
				                    });
				                    $.each(elementOptions, function (index, value) {
				                        if (index != "name") {
				                            value.name = index;
				                            value.classLabel = false;
				                            groupControl.append(JSNVisualDesign.createControl(value, data[index], data.identify));
				                        }
				                    });
				                    tabPane.append($(\'<div/>\', {
				                        \'class\':\'control-group visualdesign-options-group\'
				                    }).append(groupControl));
				                } else {
				                    tabPane.append(JSNVisualDesign.createControl(elementOptions, data[name], data.identify))
				                }
				                JSNVisualDesign.optionsBoxContent.find(\'a[href^="#visualdesign-options-\' + tabName + \'"]\').parent().show();
				            });
				        });
				        JSNVisualDesign.optionsBoxContent.find(\'input[type="text"], textarea\')
				            .bind(\'keyup\', function () {
				                $(this).closest(\'form\').trigger(\'change\');
				            });
				    };';

		$createFunctionVisualDesign[ 'closeOptionsBox' ] = ' JSNVisualDesign.closeOptionsBox = function () {
				        if (checkChangeEmail) {
				            JSNVisualDesign.savePage();
				        }
				        checkChangeEmail = false;
				        JSNVisualDesign.optionsBox.hide();
				    };';

		$actionTypeCheckBoxCreateControl = array();
		$actionTypeCheckBoxCreateControl[ 'default' ] = ' if (options.field == "allowOther") {
				                element.find(\'label\').append(control).addClass(\'checkbox\').removeClass("control-label");
				                var contentLabel = element.find(\'label\').remove();
				                element.find(".control-group").parent().append(contentLabel);
				                element.find(".control-group").remove();
				            } else {
				                element.find(\'label\').append(control).addClass(\'checkbox\').removeClass("control-label");
				                var contentLabel = element.find(\'label\').remove();
				                element.find(".control-group").append($("<div/>", {
				                    "class":"controls"
				                }).append(contentLabel));
				            }';
		/* Create Filter get action if type check on create control */
		$actionTypeCheckBoxCreateControl = apply_filters( 'ig_contactform_visualdesign_action_type_checkbox_create_control', $actionTypeCheckBoxCreateControl );
		$createFunctionVisualDesign[ 'createControl' ] = 'JSNVisualDesign.createControl = function (options, value, identify) {
				        var templates = {
				            \'hidden\':\'<input type="hidden" value="${value}" name="${options.name}" id="${id}" />\',
				            \'text\':\'<div class="controls"><input type="text" value="${value}" name="${options.name}" id="${id}" class="text jsn-input-xxlarge-fluid" /></div>\',
				            \'_text\':\'<input type="text" value="${value}" name="${options.name}" id="${id}" class="text jsn-input-xxlarge-fluid" />\',
				            \'number\':\'<div class="controls"><input type="number" value="${value}" name="${options.name}" id="${id}" class="number input-mini" /></div>\',
				            \'select\':\'<div class="controls"><select name="${options.name}" id="${id}" class="select">{{each(i, val) options.options}}<option value="${i}" {{if val==value || (typeof(i) == "string" && i==value)}}selected{{/if}}>${val}</option>{{/each}}</select></div>\',
				            \'checkbox\':\'<input type="checkbox" value="1" name="${options.name}" id="${id}" {{if value==1 || value == "1"}}checked{{/if}} />\',
				            \'checkboxes\':\'<div class="controls">{{each(i, val) options.options}}<label for="${id}-${i}" class="{{if options.class == ""}}checkbox{{else}}${options.class}{{/if}}"><input type="checkbox" name="${options.name}[]" value="${val}" id="${id}-${i}" {{if value.indexOf(val)!=-1}}checked{{/if}} />${val}</label>{{/each}}</div>\',
				            \'radio\':\'<div class="controls">{{each(i, val) options.options}}<label for="${id}-${i}" class="{{if options.class == ""}}radio{{else}}${options.class}{{/if}}"><input type="radio" name="${options.name}" value="${i}" id="${id}-${i}" {{if value==val}}checked{{/if}} />${val}</label>{{/each}}</div>\',
				            \'textarea\':\'<div class="controls"><textarea name="${options.name}" id="${id}" rows="3" class="textarea jsn-input-xxlarge-fluid">${value}</textarea></div>\'
				        };
				        var elementId = \'option-\' + options.name + \'-\' + options.type;
				        var control = null;
				        var element = $(\'<div/>\');
				        var setAttributes = function (element, attrs) {
				            var elm = $(element),
				                field = elm.is(\':input\') ? elm : elm.find(\':input\');
				            field.attr(attrs);
				        };
				        if (templates[options.type] !== undefined) {
				            control = $.tmpl(templates[options.type], {
				                options:options,
				                value:value,
				                id:elementId
				            });
				            if ($.isPlainObject(options.attrs))
				                setAttributes(control, options.attrs);
				        } else if (options.type == \'itemlist\') {
				            control = $.itemList($.extend({}, {
				                listItems:value,
				                id:elementId,
				                identify:identify,
				                language:lang
				            }, options));
				        } else
				            return;
				        if (options.label !== undefined && options.classLabel == undefined) {
				            element.append($("<div/>", {
				                "class":"control-group"
				            }).append($(\'<label/>\', {
				                \'for\':elementId,
				                text:options.label,
				                \'class\':\'control-label\',
				                title:lang[options.title]
				            })));
				        } else if (!options.classLabel && options.group != "horizontal") {
				            element.append($("<div/>", {
				                "class":"control-group "
				            }).append($(\'<label/>\', {
				                \'for\':elementId,
				                text:options.label,
				                title:lang[options.title]
				            })));
				        }
				        if (options.type == \'checkbox\') {
							' . implode( '', $actionTypeCheckBoxCreateControl ) . '
				        } else {
				            if (options.type == "itemlist") {
				                element.find(".control-group").append(control).addClass("jsn-items-list-container");
				            } else if (options.group == "horizontal") {
				                if (options.field && (options.field == "horizontal" || options.field == "currency" || options.field == "input-inline")) {
				                    $(control).attr("class", "ig-inline");
				                    element.append(control);
				                } else if (options.field && (options.field == "horizontal" || options.field == "number")) {
				                    $(control).attr("class", "ig-inline");
				                    element.append(control);
				                } else {
				                    $(control).attr("class", "input-append ig-inline");
				                    element.append(control);
				                }
				            } else if (options.field == "allowOther") {
				                element.append(control);
				                element.find(".control-group").remove();
				            } else {
				                element.find(".control-group").append(control);
				            }
				        }

				        return element.children();
				    };';
		$actionOpenOptionsBox = apply_filters( 'ig_contactform_visualdesign_action_open_options_box', $actionOpenOptionsBox );
		$prototypeSerialize = array();
		$prototypeSerialize[ 'default' ] = ' $(\'input, textarea\').placeholder();  $(".control-group.ig-hidden-field").parents(".jsn-element").addClass("jsn-disabled");';
		$prototypeSerialize = apply_filters( 'ig_contactform_visualdesign_prototype_serialize', $prototypeSerialize );
		$createFunctionVisualDesign = apply_filters( 'ig_contactform_visualdesign_create_function', $createFunctionVisualDesign );
		$containerFunction = array();
		$getContainerFunction = apply_filters( 'ig_contactform_visualdesign_container_function', $containerFunction );
		if ( ! empty( $getContainerFunction ) ) {
			$containerFunction = $getContainerFunction;
		}
		$javascript = '(function ($) {
				    var listLabel = [];
				    var checkChangeEmail = false;
				    var dataEmailSubmitter = [];

				    var lang = [];
				    var limitSize = \'\';
				    var limitEx = \'\';
				    ' . implode( '', $containerFunction ) . '
				    function JSNVisualDesign(container, params) {
				        this.params = params;
				        lang = params.language;

				        limitSize = params.limitSize;
				        limitEx = params.limitEx;
						' . implode( '', $addParamsVisualDesign ) . '
				        this.container;
				        this.init(container);
				    }
				    /**
				     * This variable will contains all registered control
				     * @var object
				     */
				    JSNVisualDesign.controls = {};
				    JSNVisualDesign.controlGroups = {};
				    JSNVisualDesign.toolboxTarget = null;
				    JSNVisualDesign.optionsBox = null;
				    JSNVisualDesign.optionsBoxContent = null;
				    JSNVisualDesign.toolbox = null;
				    JSNVisualDesign.wrapper = null;
				    JSNVisualDesign.initialize = function (language) {
				       ' . implode( '', $addBoxContent ) . '
				        JSNVisualDesign.optionsBoxContent.find(\'form\').change(function (event) {
				         ' . implode( '', $beforeActionChangeOptionBoxContent ) . '
				            var activeElement = JSNVisualDesign.optionsBox.data(\'visualdesign-active-element\');
				            if (activeElement) {
				                var options = activeElement.data(\'visualdesign-element-data\');
				                if (options) {
				                    var eventId = $(event.target).attr("id");
				                    var optionsNew = $(this).toJSON();
				                    optionsNew.identify = options.options.identify;
				                    var newElement = JSNVisualDesign.createElement(options.type, optionsNew, options.id);
				                    activeElement.replaceWith(newElement);
				                    JSNVisualDesign.optionsBox.data(\'visualdesign-active-element\', newElement);
				                    ' . implode( '', $actionChangeOptionsBoxContent ) . '
				                    newElement.addClass("ui-state-edit");
				                }
				            }
				            $(\'input, textarea\').placeholder();
				            $(".control-group.ig-hidden-field").parents(".jsn-element").addClass("jsn-disabled");
							 ' . implode( '', $afterActionChangeOptionBoxContent ) . '
				        }).submit(function (e) {
								' . implode( '', $eventBoxContentSubmit ) . '
				            });
				        $(function () {
				            $(document).mousedown(function (event) {
				                ' . implode( '', $eventMouseDownBoxContent ) . '
				            });
				        });
				        // Register class as global object
				        window.JSNVisualDesign = JSNVisualDesign;
				    };
				    /**
				     * Register control item that can use for page design
				     * @param string identify
				     * @param object options
				     */
				    JSNVisualDesign.register = function (identify, options) {
				        if (JSNVisualDesign.controls[identify] !== undefined || identify === undefined || identify == \'\' || options.caption === undefined || options.caption == \'\' || options.defaults === undefined || !$.isPlainObject(options.defaults) || options.params === undefined || !$.isPlainObject(options.params) || options.tmpl === undefined || options.tmpl == \'\') {
				            return false;
				        }
				        if (JSNVisualDesign.controlGroups[options.group] === undefined) {
				            JSNVisualDesign.controlGroups[options.group] = [];
				        }
				        // Save control to list
				        //options.identify;
				        JSNVisualDesign.controls[identify] = options;
				        JSNVisualDesign.controlGroups[options.group].push(identify);
				    };
				    /**
				     * Draw registered buttons to toolbox
				     * @return void
				     */
				    JSNVisualDesign.drawToolboxButtons = function () {
				        this.buttons = {};
				        var self = this;
				        $.map(JSNVisualDesign.controlGroups, function (buttons, group) {
				            var buttonList = [];
				            $(buttons).each(function (index, identify) {
				                if (' . implode( '', $ifCheckRenderButtonAddField ) . ') {
				                    var options = JSNVisualDesign.controls[identify];
				                    var button = $(\'<li/>\', {
				                        \'class\':\'jsn-item\',
				                        \'data-value\':options.caption
				                    }).append($(\'<button/>\', {
				                        \'name\':identify,
				                        \'class\':\'btn\'
				                    }).click(function (e) {
				                                if (JSNVisualDesign.toolboxTarget == null){
				                                    JSNVisualDesign.closeToolbox();
				                                }
				                                var control = JSNVisualDesign.controls[this.name];
				                                var d = new Date();
												var time = d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
												var getLabel = this.name + "_" + Math.floor(Math.random() * 999999999) + time;
										        var label = getLabel.toLowerCase();
										        while (/[^a-zA-Z0-9_]+/.test(label)) {
										            label = label.replace(/[^a-zA-Z0-9_]+/, \'_\');
										        }
				                                control.defaults.identify = label;
				                                var element = JSNVisualDesign.createElement(this.name, control.defaults);
				                                element.appendTo(JSNVisualDesign.toolboxTarget);
				                                element.find("a.element-edit").click();
												' . implode( '', $eventClickButtonAddField ) . '
				                                JSNVisualDesign.savePage();
				                                JSNVisualDesign.closeToolbox();
				                                JSNVisualDesign.optionsBox.find(\'form\').trigger("change");
				                            e.preventDefault();
				                        }).append($(\'<i/>\', {
				                        \'class\':\'jsn-icon16 icon-formfields jsn-icon-\' + identify
				                    })).append(options.caption))
				                    buttonList.push(button);
				                }
				            });
				            self.buttons[group] = buttonList;
				        });
				        return self.buttons;
				    };
					' . implode( '', $createFunctionVisualDesign ) . '
				    JSNVisualDesign.closeToolbox = function () {
				        JSNVisualDesign.toolbox.hide();
				    };
				    JSNVisualDesign.openOptionsBox = function (sender, type, params, action) {
				        if (JSNVisualDesign.controls[type] === undefined) {
				            return;
				        }
				        JSNVisualDesign.closeToolbox();
				        JSNVisualDesign.renderOptionsBox(JSNVisualDesign.controls[type].params, params);
				        JSNVisualDesign.optionsBox.data(\'visualdesign-active-element\', sender);
				        JSNVisualDesign.optionsBox.appendTo($(\'body\')).show();
				        $(".tabs").tabs({
				            active:0
				        });
				        $("#visualdesign-options-values #option-limitation-checkbox").change(function () {
				            JSNVisualDesign.checkLimitation();
				        });

				        $("#option-firstItemAsPlaceholder-checkbox").after(\'<i class="icon-question-sign" original-title="\' + lang["IG_CONTACTFORM_SET_ITEM_PLACEHOLDER_DES"] + \'"></i>\');
						' . implode( '', $actionOpenOptionsBox ) . '
				        JSNVisualDesign.position(JSNVisualDesign.optionsBox, sender, \'bottom\', {
				            bottom:-5
				        }, action);

				        if ($(sender).offset().top - $(window).scrollTop() > JSNVisualDesign.optionsBox.find(".popover").height()) {
				            $(window).scrollTop($(sender).offset().top - JSNVisualDesign.optionsBox.find(".popover").height());
				        }
				        $(\'#visualdesign-options .icon-question-sign\').tipsy({
				            gravity:\'se\',
				            fade:true
				        });
				    };
				    JSNVisualDesign.position = function (e, p, pos, extra, action) {
				        var position = {},
				            elm = $(e);
				        if (action) {
				            var parent = $(action);
				        } else {
				            var parent = $(p);
				        }
				        //JSNVisualDesign.equalsHeight(elm.find(\'.tab-pane\'));
				        var elmStyle = JSNVisualDesign.getBoxStyle(elm),
				            parentStyle = JSNVisualDesign.getBoxStyle(parent),
				            elmStyleParet = JSNVisualDesign.getBoxStyle($(e).find(".popover"));
				        var modalWindow = JSNVisualDesign.getBoxStyle($("#form-design"));
				        if (pos === undefined) {
				            pos = \'center\';
				        }
				        if (pos == "top" && parentStyle.offset.top < elmStyleParet.outerHeight) {
				            pos = "bottom";
				        }
				        switch (pos) {
				            case \'left\':
				                position.left = parentStyle.offset.left + (parentStyle.outerWidth - elmStyleParet.outerWidth) / 2;
				                position.top = parentStyle.offset.top;
				                elm.find(".popover").removeClass("top").removeClass("bottom");
				                break;
				            case \'center\':
				                position.left = parentStyle.offset.left + (parentStyle.outerWidth - elmStyleParet.outerWidth) / 2;
				                position.top = parentStyle.offset.top + parentStyle.outerHeight;
				                elm.find(".popover").removeClass("top").addClass("bottom");
				                break;
				            case \'top\':
				                position.left = parentStyle.offset.left + (parentStyle.outerWidth - elmStyleParet.outerWidth) / 2;
				                position.top = parentStyle.offset.top - elmStyleParet.outerHeight;
				                elm.find(".popover").removeClass("bottom").addClass("top");
				                break;
				            case \'bottom\':
				                position.left = parentStyle.offset.left + (parentStyle.outerWidth - elmStyleParet.outerWidth) / 2;
				                position.top = parentStyle.offset.top + parentStyle.outerHeight;
				                elm.find(".popover").removeClass("top").addClass("bottom");
				                break;
				        }
				        if (extra !== undefined) {
				            if (extra.left !== undefined) {
				                position.left = position.left + extra.left;
				            }
				            if (extra.right !== undefined) {
				                position.right = position.right + extra.right;
				            }
				            if (extra.top !== undefined) {
				                position.top = position.top + extra.top;
				            }
				            if (extra.bottom !== undefined) {
				                position.bottom = position.bottom + extra.bottom;
				            }
				        }
				        elm.css(position);
				    };
				    JSNVisualDesign.getBoxStyle = function (element) {
				        var style = {
				            width:element.width(),
				            height:element.height(),
				            outerHeight:element.outerHeight(),
				            outerWidth:element.outerWidth(),
				            offset:element.offset(),
				            margin:{
				                left:parseInt(element.css(\'margin-left\')),
				                right:parseInt(element.css(\'margin-right\')),
				                top:parseInt(element.css(\'margin-top\')),
				                bottom:parseInt(element.css(\'margin-bottom\'))
				            },
				            padding:{
				                left:parseInt(element.css(\'padding-left\')),
				                right:parseInt(element.css(\'padding-right\')),
				                top:parseInt(element.css(\'padding-top\')),
				                bottom:parseInt(element.css(\'padding-bottom\'))
				            }
				        };
				        return style;
				    };
				    /**
				     * Set all elements to same height
				     * @param elements
				     */
				    JSNVisualDesign.equalsHeight = function (elements) {
				        elements.css(\'height\', \'auto\');
				        var maxHeight = 0;
				        elements.each(function () {
				            var height = $(this).height();
				            if (maxHeight < height)
				                maxHeight = height;
				        });
				        elements.css(\'height\', maxHeight + \'px\');
				    };
				    /**
				     * Generate identify for field based on label
				     * @param label
				     * @return
				     */
				    JSNVisualDesign.generateIdentify = function (data, listLabel) {
				        if(!data.options.identify){
					        var d = new Date();
							var time = d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
							var getLabel = data.options.label + "_" + Math.floor(Math.random() * 999999999) + time;
					        var label = getLabel.toLowerCase();
					        while (/[^a-zA-Z0-9_]+/.test(label)) {
					            label = label.replace(/[^a-zA-Z0-9_]+/, \'_\');
					        }
				            return label;
				        }else{
				            return data.options.identify;
				        }
				    };
				    JSNVisualDesign.prototype = {
				        /**
				         * Initialize page for design
				         * @param object element
				         * @param object options
				         */
				        init:function (container) {
				            $("#visualdesign-options").remove();
				            $("#visualdesign-toolbox").remove();
				            JSNVisualDesign.initialize(lang);
				            // this.JSNContactformDialogEdition  = new JSNContactformDialogEdition(this.params);
				            this.container = $(container);
				            this.document = $(document);
				            this.options = {
				                regionSelector:\'.jsn-column-content\',
				                elementSelector:\'.jsn-element\',
				                elements:{}
				            };
				            this.newElement.click(function (e) {
				                e.preventDefault();
				                e.stopPropagation();
				                JSNVisualDesign.openToolbox($(e.currentTarget), $(e.currentTarget).prev());
				            });
				            // Enable sortable
				            this.container.data(\'visualdesign-instance\', this).find(this.options.regionSelector + \' .jsn-element-container\').sortable({
				                items:this.options.elementSelector,
				                connectWith:this.options.regionSelector + \' .jsn-element-container\',
				                placeholder:\'ui-state-highlight\',
				                forcePlaceholderSize:true
				            }).parent().append(this.newElement);
				        },
				        clearElements:function () {
				            this.container.find(\'div.jsn-element\').remove();
				        },
				        /**
				         * Add existing elements to designing page
				         * @param array elements
				         */
				        setElements:function (elements) {
				            var self = this;
				            $(elements).each(function () {
				                this.options.identify = this.identify;
				                var element = JSNVisualDesign.createElement(this.type, this.options, this.id);
				                var column = self.container.find(\'div[data-column-name="\' + this.position + \'"] .jsn-element-container\');
				                if (column.size() == 0) {
				                    column = self.container.find(\'div[data-column-name] .jsn-element-container\');
				                }
				                column.append(element);
				            });
				            return self;
				        },
				        /**
				         * Serialize designed page to JSON format for save it to database
				         * @return string
				         */
				        serialize:function (toObject) {
				            var serialized = [];
				            var serializeObject = toObject || false;
				            this.container.find(\'[data-column-name]\').each(function () {
				                var elements = $(this).find(\'.jsn-element\');
				                var column = $(this).attr(\'data-column-name\');
				                elements.each(function () {
				                    var data = $(this).data(\'visualdesign-element-data\');
				                    serialized.push({
				                        id:data.id,
				                        identify:JSNVisualDesign.generateIdentify(data, listLabel),
				                        options:data.options,
				                        type:data.type,
				                        position:column
				                    });
				                });
				            });
				            ' . implode( '', $prototypeSerialize ) . '
				            return serializeObject ? serialized : $.toJSON(serialized);
				        }
				    };
				    /**
				     * Plugin for jQuery to serialize a form to JSON format
				     * @param options
				     * @return
				     */
				    $.fn.toJSON = function (options) {
				        options = $.extend({}, options);
				        var self = this,
				            json = {},
				            push_counters = {},
				            patterns = {
				                "validate":/^[a-zA-Z][a-zA-Z0-9_]*(?:\[(?:\d*|[a-zA-Z0-9_]+)\])*$/,
				                "key":/[a-zA-Z0-9_]+|(?=\[\])/g,
				                "push":/^$/,
				                "fixed":/^\d+$/,
				                "named":/^[a-zA-Z0-9_]+$/,
				                "ignore":/^ignored:/
				            };
				        this.build = function (base, key, value) {
				            base[key] = (value.indexOf(\'json:\') == -1) ? value : $.evalJSON(value.substring(5));
				            return base;
				        };
				        this.push_counter = function (key, i) {
				            if (push_counters[key] === undefined) {
				                push_counters[key] = 0;
				            }
				            if (i === undefined) {
				                return push_counters[key]++;
				            } else if (i !== undefined && i > push_counters[key]) {
				                return push_counters[key] = ++i;
				            }
				        };
				        $.each($(this).serializeArray(), function () {
				            // skip invalid keys
				            if (!patterns.validate.test(this.name) || patterns.ignore.test(this.name)) {
				                return;
				            }
				            var k, keys = this.name.match(patterns.key),
				                merge = this.value,
				                reverse_key = this.name;
				            while ((k = keys.pop()) !== undefined) {
				                // adjust reverse_key
				                reverse_key = reverse_key.replace(new RegExp("\\[" + k + "\\]$"), \'\');
				                // push
				                if (k.match(patterns.push)) {
				                    merge = self.build([], self.push_counter(reverse_key), merge);
				                }
				                // fixed
				                else if (k.match(patterns.fixed)) {
				                    self.push_counter(reverse_key, k);
				                    merge = self.build([], k, merge);
				                }
				                // named
				                else if (k.match(patterns.named)) {
				                    merge = self.build({}, k, merge);
				                }
				            }
				            json = $.extend(true, json, merge);
				        });
				        return json;
				    };
				    JSNVisualDesign.initialize();
				})(jQuery);';
		echo '' . $javascript;
		exit();
	}


}
