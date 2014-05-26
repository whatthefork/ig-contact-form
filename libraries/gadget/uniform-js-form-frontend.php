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

class IG_Gadget_Uniform_Js_Form_Frontend extends IG_Gadget_Base {

	/**
	 * Gadget file name without extension.
	 *
	 * @var  string
	 */
	protected $gadget = 'uniform-js-form-frontend';

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

		header( 'Content-Type: application/javascript' );
		$filterFunctionInit = array();
		$filterFunctionInit[ 'button-submit-click' ] = '$(formname).find(".form-actions .jsn-form-submit").click(function () {
					                $(formname).find("form").submit();
					                return false;
					            });';
		$filterFunctionInit[ 'document-click' ] = '$(document).click(function () {
					                $(".ui-state-highlight").removeClass("ui-state-highlight");
					            });';
		$filterFunctionInit[ 'action-form-submit' ] = '$(formname).find("form").submit(function () {
					                var selfsubmit = this;
					                if (self.checkValidateForm($(this))) {
					                    $("body").append($("<div/>", {
					                        "class":"jsn-modal-overlay",
					                        "style":"z-index: 1000; display: inline;"
					                    })).append($("<div/>", {
					                        "class":"jsn-modal-indicator",
					                        "style":"display:block"
					                    })).addClass("jsn-loading-page");
					                    $(this).find(".help-block").remove();

					                    $("#jsn-form-target").remove();
					                    $(selfsubmit).find(\'.message-uniform\').html("");
					                    var iframe = $(\'<iframe/>\', {
					                        name:\'jsn-form-target\',
					                        id:\'jsn-form-target\'
					                    });
					                    iframe.appendTo($(\'body\'));
					                    iframe.css({
					                        display:\'none\'
					                    });
					                    var publickey = $(this).find(".form-captcha").attr("publickey");
					                    iframe.load(function () {
					                        var message = iframe.contents().find("input[name$=message]").val();
					                        var error = iframe.contents().find("input[name$=error]").val();

					                        var redirect = iframe.contents().find("input[name$=redirect]").val();
					                        if (redirect) {
					                            window.location = redirect;
					                        } else if (error) {
					                            error = $.evalJSON(error);
					                            self.callMessageError(formname, error);
					                            $(".jsn-modal-overlay,.jsn-modal-indicator").remove();
					                        } else if (message) {
					                            $.ajax({
					                                type:"GET",
					                                async:true,
					                                encoding:"UTF-8",
					                                scriptCharset:"utf-8",
					                                cache:false,
					                                contentType:"text/plain; charset=UTF-8",
					                                url:baseUrl + "/?ig-gadget=uniform-frontend&action=default&task=form.getHtmlForm&form_id=" + $(selfsubmit).find("input[name=form_id]").val(),
					                                success:function (htmlForm) {
					                                    $(selfsubmit).find(".jsn-row-container").empty();
					                                    $(selfsubmit).find(".jsn-row-container").html(htmlForm);
					                                    if (message) {
					                                        $(selfsubmit).find(\'.message-uniform\').html(
					                                            $("<div/>", {
					                                                "class":"success-uniform alert alert-success clearfix"
					                                            }).append(
					                                                $("<button/>", {
					                                                    "class":"close",
					                                                    "onclick":"return false;",
					                                                    "data-dismiss":"alert",
					                                                    text:"×"
					                                                })).append(message));
					                                    }
					                                    self.initJSNForm(formname);
					                                    var messagesFocus = $(formname).find(".message-uniform")[0];
					                                    $(window).scrollTop($(messagesFocus).offset().top - 50);
					                                    $(".jsn-modal-overlay,.jsn-modal-indicator").remove();
					                                }
					                            });
					                        } else {
					                            $.ajax({
					                                type:"GET",
					                                async:true,
					                                cache:false,
					                                encoding:"UTF-8",
					                                scriptCharset:"utf-8",
					                                contentType:"text/plain; charset=UTF-8",
					                                url:baseUrl + "/?ig-gadget=uniform-frontend&action=default&task=form.getHtmlForm&form_id=" + $(selfsubmit).find("input[name=form_id]").val(),
					                                success:function (htmlForm) {
					                                    $(selfsubmit).find(".jsn-row-container").empty();
					                                    $(selfsubmit).find(".jsn-row-container").html(htmlForm);
					                                    self.initJSNForm(formname);
					                                    var messagesFocus = $(formname).find(".message-uniform")[0];
					                                    $(window).scrollTop($(messagesFocus).offset().top - 50);
					                                    $(".jsn-modal-overlay,.jsn-modal-indicator").remove();
					                                }
					                            });
					                        }
					                        var idcaptcha;
					                        idcaptcha = $(selfsubmit).find(".form-captcha").attr("id");
					                        if (idcaptcha) {
					                            Recaptcha.destroy();
					                            Recaptcha.create(publickey, idcaptcha, {
					                                theme:\'white\',
					                                tabindex:0,
					                                callback:function () {
					                                    $(selfsubmit).find(".form-captcha").removeClass("error");
					                                    $(selfsubmit).find(".form-captcha #recaptcha_area").addClass("controls");
					                                    $(selfsubmit).find("#recaptcha_response_field").keypress(function (e) {
					                                        if (e.which == 13) {
					                                            if ($(formname).find("button.next").hasClass("hide")) {
					                                                $(formname).find("button.jsn-form-submit").click();
					                                            } else {
					                                                $(formname).find("button.next").click();
					                                            }
					                                            return false;
					                                        }
					                                    });
					                                    if (error) {
					                                        if (error.captcha) {
					                                            $(selfsubmit).find(".form-captcha").addClass("error");
					                                            $(selfsubmit).find(".form-captcha #recaptcha_area").append(
					                                                $("<span/>", {
					                                                    "class":"help-block"
					                                                }).append(
					                                                    $("<span/>", {
					                                                        "class":"validation-result label label-important",
					                                                        text:error.captcha
					                                                    })));
					                                            $(selfsubmit).find("#recaptcha_response_field").focus();
					                                        }
					                                    }
					                                }
					                            });
					                        }
					                    });

					                    self.checkPage(formname);
					                    $(this).attr(\'target\', \'jsn-form-target\');
					                } else {

					                    return false;
					                }
					            });';
		$filterFunctionInit = apply_filters( 'ig_uniform_frontend_javascript_function_init', $filterFunctionInit );
		$functionForm = array();
		$functionForm[ 'initJSNForm' ] = '$.initJSNForm = function (formname) {
					            var self = this;
					            $(".form-captcha").hide();
					            if ($(\'.ig-uniform .icon-question-sign\').length) {
					                $(\'.ig-uniform .icon-question-sign\').tipsy({
					                    gravity:\'w\',
					                    fade:true
					                });
					            }
					            $(formname).find("input,button.btn,textarea,select").focus(function () {
					                var form = $(this).parents(\'form:first\');
					                $(form).find(".ui-state-highlight").removeClass("ui-state-highlight");
					                $(this).parents(".control-group").addClass("ui-state-highlight");
					                self.captcha(form);
					            }).click(function (e) {
					                    var form = $(this).parents(\'form:first\');
					                    $(form).find(".ui-state-highlight").removeClass("ui-state-highlight");
					                    $(this).parents(".control-group").addClass("ui-state-highlight");
					                    e.stopPropagation();
					                });
					           $(formname).find("input").keypress(function (e) {
					                if (e.which == 13) {
					                    if ($(formname).find("button.next").hasClass("hide")) {
					                        $(formname).find("button.jsn-form-submit").click();
					                    } else {
					                        $(formname).find("button.next").click();
					                    }
					                    return false;
					                }
					            });
					            ' . implode( '', $filterFunctionInit ) . '


					            var formDefaultCaptcha = $(".form-captcha")[0];
					            if ($(formDefaultCaptcha).size()) {
					                $($(formDefaultCaptcha).parents("form:first").find("input,textarea,select")[0]).focus();
					            }
					            var randomizeListGroups = $(formname).find("select.list");
					            randomizeListGroups.each(function () {
					                if ($(this).hasClass("list-randomize")) {
					                    self.randomValueItems(this);
					                }
					            });
					            var randomizeDropdownGroups = $(formname).find("select.dropdown");
					            randomizeDropdownGroups.each(function () {
					                var selfDropdown = this;
					                if ($(this).hasClass("dropdown-randomize")) {
					                    self.randomValueItems(this);
					                    $(this).find("option").each(function () {
					                        if ($(this).attr("selectdefault") == "true") {
					                            $(this).prop("selected", true);
					                        }
					                    });
					                }
					                $(this).change(function () {
					                    if ($(this).val() == "Others" || $(this).val() == "others") {
					                        $(selfDropdown).parent().find("textarea.ig-dropdown-Others").removeClass("hide");
					                    } else {
					                        $(selfDropdown).parent().find("textarea.ig-dropdown-Others").addClass("hide");
					                    }
					                });
					            });
					            var randomizeChoiceGroups = $(formname).find("div.choices");
					            randomizeChoiceGroups.each(function () {
					                var selfChoices = this;
					                if ($(this).hasClass("choices-randomize")) {
					                    self.randomValueItems(this);
					                }
					                $(this).find("input[type=radio]").click(function () {
					                    if ($(this).val() == "Others" || $(this).val() == "others") {
					                        $(selfChoices).find("textarea.ig-value-Others").removeAttr("disabled");
					                    } else {
					                        $(selfChoices).find("textarea.ig-value-Others").attr("disabled", "true");
					                    }
					                });
					            });
					            var randomizeCheckboxGroups = $(formname).find("div.checkboxes");
					            randomizeCheckboxGroups.each(function () {
					                var selfChexbox = this;
					                if ($(this).hasClass("checkbox-randomize")) {
					                    self.randomValueItems(this);
					                }
					                $(this).find(".lbl-allowOther input[type=checkbox]").click(function () {
					                    if ($(this).is(\':checked\')) {
					                        $(selfChexbox).find("textarea.ig-value-Others").removeAttr("disabled");
					                    } else {
					                        $(selfChexbox).find("textarea.ig-value-Others").attr("disabled", "true");
					                    }
					                });
					            });

					            $(formname).find("div.choices .jsn-column-item input").change(function () {
					                if ($(this).is(\':checked\')) {
					                    var idField = $(this).parents(".jsn-columns-container").attr("id");
					                    $(formname).find("div.control-group." + idField).removeAttr("style");
					                    self.getActionField(formname, $(this), idField);
					                }
					            }).trigger("change");
					            $(formname).find("div.checkboxes .jsn-column-item input").change(function () {
					                var idField = $(this).parents(".jsn-columns-container").attr("id");
					                $(formname).find("div.control-group." + idField).removeAttr("style");
					                $(this).parents(".jsn-columns-container").find("input").each(function () {
					                    if ($(this).is(\':checked\')) {
					                        self.getActionField(formname, $(this), idField);
					                    }
					                });
					            }).trigger("change");
					            $(formname).find("select.dropdown").change(function () {
					                var idField = $(this).attr("id");
					                $(formname).find("div.control-group." + idField).removeAttr("style");
					                self.getActionField(formname, $(this), idField);
					            }).trigger("change");
					            $(formname).find("input.limit-required,textarea.limit-required").each(function () {
					                var settings = $(this).attr("data-limit");
					                var limitSettings = $.evalJSON(settings);
					                if (limitSettings) {
					                    $(this).keypress(function (e) {
					                            if (e.which != 27 && e.which != 13 && e.which != 8) {
					                                if (limitSettings.limitType == "Characters" && $(this).val().length == limitSettings.limitMax) {
					                                    alert(lang[\'IG_UNIFORM_CONFIRM_FIELD_MAX_LENGTH\'] + " " + limitSettings.limitMax + " Characters");
					                                    return false;
					                                }
					                                if (limitSettings.limitType == "Words") {
					                                    var lengthValue = $.trim($(this).val()).split(/[\s]+/);
					                                    if (lengthValue.length == limitSettings.limitMax && e.which != 0) {
					                                        alert(lang[\'IG_UNIFORM_CONFIRM_FIELD_MAX_LENGTH\'] + " " + limitSettings.limitMax + " Words");
					                                        return false;
					                                    }
					                                }
					                            }
					                        }
					                    );
					                }
					            });
					            $(formname).find("input,textarea").bind(\'change\', function () {
					                self.checkValidateForm($(this).parents(".control-group"), "detailInput", $(this), "onchange");
					            });

					            $(formname).find(".form-actions .prev").click(function () {
					                $(formname).find("div.jsn-form-content").each(function (i) {
					                    if (!$(this).is(\':hidden\')) {
					                        self.prevpaginationPage(formname);
					                        return false;
					                    }
					                });
					            });

					            $(formname).find(".form-actions .next").click(function () {
					                $(formname).find("div.jsn-form-content").each(function (i) {
					                    if (!$(this).is(\':hidden\')) {
					                        if (self.checkValidateForm($(this))) {
					                            self.nextpaginationPage(formname);
					                        }
					                        return false;
					                    }
					                });
					            });
					            $(formname).find(".form-actions .reset").click(function () {
					                $(formname).trigger("reset");
					                $(formname).find(".error").removeClass("error").find(".help-block").remove();
					                $(formname).find(".jsn-form-content").addClass("hide");
					                $(formname).find(".jsn-form-content").each(function (i, _formContent) {
					                    if (i == 0) {
					                        $(_formContent).removeClass("hide");
					                    }
					                });
					                self.checkPage(formname);
					            });
					            this.defaultPage(formname);
					            $("input, textarea").placeholder();
					        };';
		$functionForm[ 'getActionField' ] = '$.getActionField = function (formname, selfInput, idField) {
					            var dataSettings = $(selfInput).parents(".control-group").attr("data-settings");
					            if (dataSettings) {
					                dataSettings = $.evalJSON(dataSettings);
					            }
					            if (dataSettings) {
					                $.each(dataSettings, function (i, item) {
					                    if ($(selfInput).val() == i) {
					                        if (item.showField) {
					                            var classShow = [];
					                            $.each(item.showField, function (j, actionField) {
					                                if (actionField) {
					                                    classShow.push(".control-group." + actionField);
					                                }
					                            });
					                            $(formname).find(classShow.join(",")).addClass(idField).show();
					                        }
					                        if (item.hideField) {
					                            var classHide = [];
					                            $.each(item.hideField, function (j, actionField) {
					                                if (actionField) {
					                                    classHide.push("div.control-group." + actionField);
					                                }
					                            });
					                            $(formname).find(classHide.join(",")).addClass(idField).hide();
					                        }
					                    }
					                });
					            }
					        };';
		$functionForm[ 'randomValueItems' ] = '$.randomValueItems = function (_this) {
					            var group = $(_this),
					                choices = group.find(\'.jsn-column-item\'),
					                otherItem = choices.filter(function () {
					                    return $(\'label.lbl-allowOther\', this).size() > 0;
					                }),
					                randomItems = choices.not(otherItem);
					            randomItems.detach();
					            otherItem.detach();
					            while (randomItems.length > 0) {
					                var index = Math.floor(Math.random() * choices.length),
					                    choice = randomItems[index];
					                if (group.find(".lbl-allowOther").size()) {
					                    group.find(".lbl-allowOther").before(choice);
					                } else {
					                    group.append(choice);
					                }
					                delete(randomItems[index]);
					                var newList = [];
					                $(randomItems).each(function (index, element) {
					                    if (element !== undefined) {
					                        newList.push(element);
					                    }
					                });
					                randomItems = newList;
					            }
					            delete(randomItems[0]);
					            if (group.find(".lbl-allowOther").size()) {
					                group.find(".lbl-allowOther").before(otherItem);
					            } else {
					                group.append(otherItem);
					            }
					            return true;
					        };';
		$functionForm[ 'captcha' ] = '$.captcha = function (form) {
					            var self = this;
					            var idcaptcha = "";
					            var idcaptcha = form.find(".form-captcha").attr("id");
					            var publickey = form.find(".form-captcha").attr("publickey");
					            if (form.find(".form-captcha").length > 0 && form.find(".form-captcha").is(\':hidden\') && idcaptcha) {
					                $(".form-captcha").hide();
					                form.find(".form-captcha").show();
					                Recaptcha.create(publickey, idcaptcha, {
					                    theme:\'white\',
					                    tabindex:0,
					                    callback:function () {
					                        $(form).find(".form-captcha").removeClass("error");
					                        $(form).find(".form-captcha #recaptcha_area").addClass("controls");
					                        $(form).find("#recaptcha_response_field").keypress(function (e) {
					                            if (e.which == 13) {
					                                if ($(formname).find("button.next").hasClass("hide")) {
					                                    $(formname).find("button.jsn-form-submit").click();
					                                } else {
					                                   $(formname).find("button.next").click();
					                                }
					                                return false;
					                            }
					                        });
					                    }
					                });
					            }
					        };';
		$filterCheckFieldError = array();
		$filterCheckFieldError[ 'default' ] = 'if (key != "captcha") {
					                    if (key == "name" || key == "address" || key == "date" || key == "phone" || key == "currency" || key == "password") {
					                        $.each(value, function (i, item) {
					                            $(formname).find("input[name=password\\\\[" + i + "\\\\]\\\\[\\\\]], input[name=currency\\\\[" + i + "\\\\]\\\\[value\\\\]], input[name=phone\\\\[" + i + "\\\\]\\\\[default\\\\]], input[name=phone\\\\[" + i + "\\\\]\\\\[one\\\\]], input[name=date\\\\[" + i + "\\\\]\\\\[date\\\\]],input[name=name\\\\[" + i + "\\\\]\\\\[first\\\\]],input[name=address\\\\[" + i + "\\\\]\\\\[street\\\\]]").parents(".control-group").addClass("error").find(".controls").append($("<span/>", {
					                                "class":"help-block"
					                            }).append(
					                                $("<span/>", {
					                                    "class":"validation-result label label-important",
					                                    text:item
					                                })));
					                        });
					                    } else if (key != "max-upload") {
											if (key == "captcha_2") {
					                            $(formname).find("#ig-captcha").parents(".control-group").addClass("error").find(".controls").append($("<span/>", {
					                                "class":"help-block"
					                            }).append(
					                                $("<span/>", {
					                                    "class":"validation-result label label-important",
					                                    text:value
					                                })));
					                        } else {

					                            if ($(formname).find("#" + key).size()) {

					                                $(formname).find("#" + key).parents(".control-group").addClass("error").find(".controls").append($("<span/>", {
					                                    "class":"help-block"
					                                }).append(
					                                    $("<span/>", {
					                                        "class":"validation-result label label-important",
					                                        text:value
					                                    })));
					                            }
					                        }
					                    } else if (key == "max-upload") {
					                        $(formname).find(".message-uniform").html($("<div/>", {
					                            "class":"alert alert-error"
					                        }).append(value));
					                    }

					                }';
		$filterCheckFieldError = apply_filters( 'ig_uniform_frontend_javascript_check_field_error', $filterCheckFieldError );
		$functionForm[ 'callMessageError' ] = '$.callMessageError = function (formname, messageError) {
					            var self = this;
					            $.each(messageError, function (key, value) {
					                ' . implode( '', $filterCheckFieldError ) . '
					            });
					            var formError = $(formname).find(".error")[0];
					            if ($(formError).parents(".jsn-form-content").attr("data-value")) {
					                $(formname).find(".jsn-form-content").addClass("hide");
					                $(formError).parents(\'.jsn-form-content\').removeClass("hide");
					                self.checkPage(formname);
					            } else {
					                var countPage = $(formname).find("div.jsn-form-content").length;
					                if (countPage > 1) {
					                    $(formname).find("div.jsn-form-content")[countPage - 1].removeClass("hide");
					                } else {
					                    $(formname).find("div.jsn-form-content").removeClass("hide");
					                }
					                $(formname).find("input,button,textarea").focus();
					            }
					            if ($(formname).find(".error input,.error textarea,.error select").length) {
					                var fieldFocus = $(formname).find(".error")[0];
					                if ($(fieldFocus).find(".blank-required").size()) {
					                    $(fieldFocus).find("input,select,textarea").each(function () {
					                        var val = $(this).val();
					                        var val2 = val.replace(\' \', \'\');
					                        if (val2 == \'\' || val2 == 0) {
					                            $(window).scrollTop($(this).offset().top - 50);
					                            $(this).click();
					                            return false;
					                        }
					                    });
					                } else {
					                    var fieldFocus = $(formname).find(".error input,.error textarea,.error select")[0];
					                    $(window).scrollTop($(fieldFocus).offset().top - 50);
					                    fieldFocus.click();
					                }
					            }

					        };';
		$functionForm[ 'defaultPage' ] = '$.defaultPage = function (formname) {
					            if (forms.length < 1) {
					                this.captcha(formname);
					            }
					            $($(formname).find("div.jsn-form-content")[0]).removeClass("hide");
					            this.checkPage(formname);
					            $(formname).find("#page-loading").addClass("hide");
					            forms.push(formname);
					        };';
		$filterFunctionCheckPage = array();
		/* Create Filter frontend javascript check page */
		$filterFunctionCheckPage = apply_filters( 'ig_uniform_frontend_javascript_function_check_page', $filterFunctionCheckPage );
		$functionForm[ 'checkPage' ] = '$.checkPage = function (formname) {
					            $(formname).find("div.jsn-form-content").each(function (i) {

					                if (!$(this).hasClass("hide")) {
					                    if ($(this).next().attr("data-value")) {
					                        $(formname).find(".form-actions .next").removeClass("hide");
					                    } else {
					                        $(formname).find(".form-actions .next").addClass("hide");
					                    }
					                    if ($(this).prev().attr("data-value")) {
					                        $(formname).find(".form-actions .prev").removeClass("hide");
					                    } else {
					                        $(formname).find(".form-actions .prev").addClass("hide");
					                    }
					                    if (i + 1 == $(formname).find("div.jsn-form-content").length) {
					                        $(formname).find(".form-actions .next").addClass("hide");
					                        $(formname).find(".form-actions .jsn-form-submit").removeClass("hide");
					                        $(formname).find(".form-actions .reset").removeClass("hide");

					                    } else {
					                        $(formname).find(".form-actions .next").removeClass("hide");
					                        $(formname).find(".form-actions .jsn-form-submit").addClass("hide");
					                        $(formname).find(".form-actions .reset").addClass("hide");
					                    }
					                    ' . implode( '', $filterFunctionCheckPage ) . '
					                }
					            });
					        };';
		$functionForm[ 'nextpaginationPage' ] = '$.nextpaginationPage = function (formname) {
					            var self = this;
					            $(formname).find("div.jsn-form-content").each(function () {
					                if (!$(this).hasClass("hide")) {
					                    $(this).addClass("hide");
					                    $(this).next().removeClass("hide");
					                    self.checkPage(formname);
					                    return false;
					                }
					            });
					        };';
		$functionForm[ 'prevpaginationPage' ] = '$.prevpaginationPage = function (formname) {
					            var self = this;
					           $(formname).find("div.jsn-form-content").each(function () {
					                if (!$(this).hasClass("hide")) {
					                    $(this).addClass("hide");
					                    $(this).prev().removeClass("hide");
					                    self.checkPage(formname);
					                    return false;
					                }
					            });
					        };';
		$functionForm[ 'checkValidateForm' ] = '$.checkValidateForm = function (_this, type, element, onchange) {
					            var check = 0;
					            var $inputBlank = $(_this).find(".blank-required");
					            var self = this;
					            $inputBlank.each(function () {
					                if ($(this).parents(".control-group").css("display") != "none") {
					                    var checkBlank = true;
					                    $(this).find(".help-blank").remove();
					                    $(this).parent().removeClass("error");
					                    $(this).find("input,select,textarea").each(function () {
					                        var val = $(this).val();
					                        if (val) {
					                            var val2 = val.replace(\' \', \'\');
					                            if ($(this).attr("type") == "text") {
					                                if (val2 == \'\') {
					                                    checkBlank = false;
					                                }
					                            } else {
					                                if (val2 == \'\') {
					                                    checkBlank = false;
					                                }
					                            }
					                        } else {
					                            checkBlank = false;
					                        }
					                    });
					                    if (!checkBlank) {
					                        $(this).parent().addClass("error");
					                        $(this).append(
					                            $("<span/>", {
					                                "class":"help-block help-blank"
					                            }).append(
					                                $("<span/>", {
					                                    "class":"validation-result label label-important",
					                                    text:lang[\'IG_UNIFORM_CONFIRM_FIELD_CANNOT_EMPTY\']
					                                })));
					                        check++;
					                    }
					                }
					            });
					            var groupBlank = $(_this).find(".group-blank-required");
					            groupBlank.each(function () {
					                if ($(this).parents(".control-group").css("display") != "none") {
					                    var checkGroupBlank = false;
					                    $(this).find(".help-blank").remove();
					                    $(this).parent().removeClass("error");
					                    $(this).find("input").each(function () {
					                        var val = $(this).val();
					                        if (val) {
					                            var val2 = val.replace(\' \', \'\');
					                            if (val2 != \'\') {
					                                checkGroupBlank = true;
					                            }
					                        }

					                    });
					                    if (!checkGroupBlank) {
					                        $(this).parents(".control-group").addClass("error");
					                        $(this).append(
					                            $("<span/>", {
					                                "class":"help-block help-blank"
					                            }).append(
					                                $("<span/>", {
					                                    "class":"validation-result label label-important",
					                                    text:lang[\'IG_UNIFORM_CONFIRM_FIELD_CANNOT_EMPTY\']
					                                })));
					                        check++;
					                    }
					                }
					            });
					            var $dropdown = $(_this).find(".dropdown-required");
					            $dropdown.each(function () {
					                if ($(this).parents(".control-group").css("display") != "none") {
					                    $(this).find(".help-dropdown").remove();
					                    $(this).parent().removeClass("error");
					                    if ($(this).find("select").val() == "") {
					                        $(this).parent().addClass("error");
					                        $(this).append(
					                            $("<span/>", {
					                                "class":"help-block help-dropdown"
					                            }).append(
					                                $("<span/>", {
					                                    "class":"validation-result label label-important",
					                                    text:lang[\'IG_UNIFORM_CONFIRM_FIELD_CANNOT_EMPTY\']
					                                })))
					                        check++;
					                    } else if ($(this).find("select option:selected").hasClass(\'lbl-allowOther\')) {
					                        var selfRadio = this;

					                        $(this).find(".ig-dropdown-Others").focusout(function () {
					                            var checkRadio = false;
					                            var valchoices = $(selfRadio).find(".ig-dropdown-Others").val();
					                            var valchoices2 = valchoices.replace(\' \', \'\');
					                            if (valchoices2 == \'\') {
					                                checkRadio = true;
					                            }
					                            if (checkRadio) {
					                                $(selfRadio).find(".help-dropdown").remove();
					                                $(selfRadio).parent().addClass("error");
					                                $(selfRadio).append(
					                                    $("<span/>", {
					                                        "class":"help-block help-dropdown"
					                                    }).append(
					                                        $("<span/>", {
					                                            "class":"validation-result label label-important",
					                                            text:lang[\'IG_UNIFORM_CONFIRM_FIELD_CANNOT_EMPTY\']
					                                        })))
					                                check++;
					                            }
					                        });
					                        if (type != "detailInput") {
					                            $(this).find(".ig-dropdown-Others").trigger("focusout");
					                        }
					                    }
					                }
					            });
					            var $inputEmailNull = $(_this).find("input.email");
					            $inputEmailNull.each(function () {
					                if ($(this).parents(".control-group").css("display") != "none") {
					                    var parentEmail = $(this).parents(".control-group");
					                    $(parentEmail).find(".help-email").remove();
					                    $(parentEmail).removeClass("error");
					                    var val = $(this).val();
					                    var filter = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,6})$/;
					                    if (!filter.test(val) && $(this).hasClass("email-required")) {
					                        $(parentEmail).addClass("error");
					                        $(this).parents(".controls").append(
					                            $("<span/>", {
					                                "class":"help-block help-email"
					                            }).append(
					                                $("<span/>", {
					                                    "class":"validation-result label label-important",
					                                    text:lang[\'IG_UNIFORM_CONFIRM_FIELD_INVALID\']
					                                })));
					                        check++;
					                    } else if (!$(this).hasClass("email-required") && val && !filter.test(val)) {
					                        $(parentEmail).addClass("error");
					                        $(this).parents(".controls").append(
					                            $("<span/>", {
					                                "class":"help-block help-email"
					                            }).append(
					                                $("<span/>", {
					                                    "class":"validation-result label label-important",
					                                    text:lang[\'IG_UNIFORM_CONFIRM_FIELD_INVALID\']
					                                })));
					                        check++;
					                    }
					                    if (val && filter.test(val) && $(parentEmail).find(".ig-email-confirm").hasClass("ig-email-confirm") && ($(element).hasClass("ig-email-confirm") || !$(parentEmail).hasClass("ui-state-highlight"))) {
					                        if ($(parentEmail).find(".ig-email-confirm").val() != $(this).val()) {
					                            $(parentEmail).addClass("error");
					                            $(this).parents(".controls").append(
					                                $("<span/>", {
					                                    "class":"help-block help-email"
					                                }).append(
					                                    $("<span/>", {
					                                        "class":"validation-result label label-important",
					                                        text:lang[\'IG_UNIFORM_CONFIRM_FIELD_EMAIL_CONFIRM\']
					                                    })));
					                            check++;
					                        }
					                    }
					                }
					            });
					            var $inputWebsite = $(_this).find("input.website");
					            $inputWebsite.each(function () {
					                if ($(this).parents(".control-group").css("display") != "none") {
					                    $(this).parent().find(".help-website").remove();
					                    $(this).parent().parent().removeClass("error");
					                    var val = $(this).val();
					                    var regexp = /^(https?:\/\/|ftp:\/\/|www([0-9]{0,9})?\.)?(((([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&\'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&\'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&\'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&\'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&\'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i;
					                    if ((!regexp.test(val) && $(this).hasClass("website-required")) || (val != "" && val != "http://" && val != "https://" && !$(this).hasClass("website-required") && !regexp.test(val))) {
					                        $(this).parent().parent().addClass("error");
					                        $(this).after(
					                            $("<span/>", {
					                                "class":"help-block help-website"
					                            }).append(
					                                $("<span/>", {
					                                    "class":"validation-result label label-important",
					                                    text:lang[\'IG_UNIFORM_CONFIRM_FIELD_INVALID\']
					                                })));
					                        check++;
					                    }
					                }
					            });
					            var $inputInteger = $(_this).find("input.integer-required");
					            $inputInteger.each(function () {
					                if ($(this).parents(".control-group").css("display") != "none") {
					                    $(this).parent().find(".help-integer").remove();
					                    $(this).parent().parent().removeClass("error");
					                    var val = $(this).val();
					                    var regexp = /^[0-9]+$/;
					                    if (!regexp.test(val)) {
					                        $(this).parent().parent().addClass("error");
					                        $(this).parent().append(
					                            $("<span/>", {
					                                "class":"help-block help-integer"
					                            }).append(
					                                $("<span/>", {
					                                    "class":"validation-result label label-important",
					                                    text:lang[\'IG_UNIFORM_CONFIRM_FIELD_INVALID\']
					                                })));
					                        check++;
					                    }
					                }
					            });
					            if (onchange != "onchange") {
					                var $valueLimitPassword = $(_this).find(".limit-password-required");
					                $valueLimitPassword.each(function () {
					                    if ($(this).parents(".control-group").css("display") != "none") {
					                        var checkval = false;
					                        if ($(this).hasClass("group-blank-required")) {
					                            $(this).find("input").each(function () {
					                                var val = $(this).val();
					                                if (val) {
					                                    var val2 = val.replace(\' \', \'\');
					                                    if (val2 == \'\') {
					                                        checkval = true;
					                                    }
					                                } else {
					                                    checkval = true;
					                                }
					                            });
					                        }
					                        if (!checkval) {
					                            var inputPassword = $(this).find("input");
					                            var limitSettings = $.evalJSON($(inputPassword).attr("data-limit"));
					                            var checkPassword = false;
					                            if ($(this).find("input").length > 1) {
					                                $(this).parent().removeClass("error");
					                                $(this).find(".help-limit").remove();
					                                $(this).find("input").each(function () {
					                                    if ($(this).val().length < limitSettings.limitMin) {
					                                        checkPassword = true;
					                                    } else if ($(this).val().length > limitSettings.limitMax) {
					                                        checkPassword = true;
					                                    }
					                                });
					                            } else {
					                                if ($(inputPassword).val() != \'\' || $(inputPassword).val() != 0) {
					                                    $(inputPassword).parent().find(".help-limit").remove();
					                                    $(inputPassword).parent().parent().removeClass("error");
					                                    if ($(inputPassword).val().length < limitSettings.limitMin) {
					                                        checkPassword = true;
					                                    } else if ($(inputPassword).val().length > limitSettings.limitMax) {
					                                        checkPassword = true;
					                                    }
					                                }
					                            }

					                            if (checkPassword) {
					                                check++;
					                                var textLang = lang[\'IG_UNIFORM_CONFIRM_FIELD_PASSWORD_MIN_MAX_CHARACTER\'];
					                                textLang = textLang.replace("%mi%", limitSettings.limitMin);
					                                textLang = textLang.replace("%mx%", limitSettings.limitMax);
					                                $(this).parent().addClass("error");
					                                $(this).append(
					                                    $("<span/>", {
					                                        "class":"help-block help-limit"
					                                    }).append(
					                                        $("<span/>", {
					                                            "class":"validation-result label label-important",
					                                            text:textLang
					                                        })));
					                            }
					                        }
					                    }
					                });

					                var $valueLimit = $(_this).find(".limit-required");
					                $valueLimit.each(function () {
					                    if ($(this).parents(".control-group").css("display") != "none") {
					                        var limitSettings = $.evalJSON($(this).attr("data-limit"));
					                        var checkval = false;
					                        if ($(this).parent().hasClass("group-blank-required")) {
					                            $(this).find("input").each(function () {
					                                var val = $(this).val();
					                                if (val) {
					                                    var val2 = val.replace(\' \', \'\');
					                                    if (val2 == \'\') {
					                                        checkval = true;
					                                    }
					                                } else {
					                                    checkval = true;
					                                }
					                            });
					                        }
					                        if ($(this).parent().hasClass("blank-required")) {
					                            var val = $(this).val();
					                            if (val) {
					                                var val2 = val.replace(\' \', \'\');
					                                if ($(this).attr("type") == "text") {
					                                    if (val2 == \'\') {
					                                        checkval = true;
					                                    }
					                                } else {
					                                    if (val2 == \'\' || val2 == 0) {
					                                        checkval = true;
					                                    }
					                                }
					                            } else {
					                                checkval = true;
					                            }

					                        }
					                        ;
					                        if (!checkval) {
					                            $(this).parent().find(".help-limit").remove();
					                            $(this).parent().parent().removeClass("error");
					                            if (limitSettings.limitType == "Words") {
					                                //console.log($(this).parent().parent());
					                                return false;
					                                var lengthValue = $.trim($(this).val()).split(/[\s]+/);
					                                if (lengthValue.length < limitSettings.limitMin) {
					                                    check++;
					                                    $(this).parent().parent().addClass("error");
					                                    $(this).after(
					                                        $("<span/>", {
					                                            "class":"help-block help-limit"
					                                        }).append(
					                                            $("<span/>", {
					                                                "class":"validation-result label label-important",
					                                                text:lang[\'IG_UNIFORM_CONFIRM_FIELD_MIN_LENGTH\'] + " " + limitSettings.limitMin + " Words"
					                                            })));
					                                } else if (lengthValue.length > limitSettings.limitMax) {
					                                    check++;
					                                    $(this).parent().parent().addClass("error");
					                                    $(this).after(
					                                        $("<span/>", {
					                                            "class":"help-block help-limit"
					                                        }).append(
					                                            $("<span/>", {
					                                                "class":"validation-result label label-important",
					                                                text:lang[\'IG_UNIFORM_CONFIRM_FIELD_MAX_LENGTH\'] + " " + limitSettings.limitMax + " Words"
					                                            })));
					                                }
					                            } else {
					                                if ($(this).val().length < limitSettings.limitMin) {
					                                    check++;
					                                    $(this).parent().parent().addClass("error");
					                                    $(this).after(
					                                        $("<span/>", {
					                                            "class":"help-block help-limit"
					                                        }).append(
					                                            $("<span/>", {
					                                                "class":"validation-result label label-important",
					                                                text:lang[\'IG_UNIFORM_CONFIRM_FIELD_MIN_LENGTH\'] + " " + limitSettings.limitMin + " Character"
					                                            })));
					                                } else if ($(this).val().length > limitSettings.limitMax) {
					                                    check++;
					                                    $(this).parent().parent().addClass("error");
					                                    $(this).after(
					                                        $("<span/>", {
					                                            "class":"help-block help-limit"
					                                        }).append(
					                                            $("<span/>", {
					                                                "class":"validation-result label label-important",
					                                                text:lang[\'IG_UNIFORM_CONFIRM_FIELD_MAX_LENGTH\'] + " " + limitSettings.limitMax + " Character"
					                                            })));
					                                }
					                            }

					                        }
					                    }
					                });

					                var $valueNumberLimit = $(_this).find(".number-limit-required");
					                $valueNumberLimit.each(function () {
					                    if ($(this).parents(".control-group").css("display") != "none") {
					                        var checkval = false;
					                        if ($(this).hasClass("integer-required")) {
					                            var val = $(this).val();
					                            var regexp = /^[0-9]+$/;
					                            if (!regexp.test(val)) {
					                                checkval = true;
					                            }
					                        }
					                        if (!checkval) {
					                            var limitNumberSettings = $.evalJSON($(this).attr("data-limit"));
					                            $(this).parent().find(".help-limit").remove();
					                            $(this).parent().parent().removeClass("error");
					                            if ($(this).val() != \'\' || $(this).val() != 0) {
					                                if (parseInt($(this).val(), 10) < limitNumberSettings.limitMin) {
					                                    check++;
					                                    $(this).parent().parent().addClass("error");
					                                    $(this).parent().append(
					                                        $("<span/>", {
					                                            "class":"help-block help-limit"
					                                        }).append(
					                                            $("<span/>", {
					                                                "class":"validation-result label label-important",
					                                                text:lang[\'IG_UNIFORM_CONFIRM_FIELD_MIN_NUMBER\'] + " " + limitNumberSettings.limitMin
					                                            })));
					                                } else if (parseInt($(this).val(), 10) > limitNumberSettings.limitMax) {
					                                    check++;
					                                    $(this).parent().parent().addClass("error");
					                                    $(this).parent().append(
					                                        $("<span/>", {
					                                            "class":"help-block help-limit"
					                                        }).append(
					                                            $("<span/>", {
					                                                "class":"validation-result label label-important",
					                                                text:lang[\'IG_UNIFORM_CONFIRM_FIELD_MAX_NUMBER\'] + " " + limitNumberSettings.limitMax
					                                            })));
					                                }
					                            }

					                        }
					                    }
					                });
					            }
					            var $list = $(_this).find(".list-required");
					            $list.each(function () {
					                if ($(this).parents(".control-group").css("display") != "none") {
					                    $(this).parent().find(".help-list").remove();
					                    $(this).parent().removeClass("error");
					                    if (!$(this).find("select").val()) {
					                        $(this).parent().addClass("error");
					                        $(this).find("select").after(
					                            $("<span/>", {
					                                "class":"help-block help-list"
					                            }).append(
					                                $("<span/>", {
					                                    "class":"validation-result label label-important",
					                                    text:lang[\'IG_UNIFORM_CONFIRM_FIELD_INVALID\']
					                                })));
					                        check++;
					                    }
					                }
					            });
					            var $inputchoices = $(_this).find(".choices-required");
					            $inputchoices.each(function () {
					                if ($(this).parents(".control-group").css("display") != "none") {
					                    $(this).find(".help-choices").remove();
					                    $(this).parent().removeClass("error");
					                    if ($(this).find("input[type=radio]:checked").length < 1) {
					                        $(this).parent().addClass("error");
					                        $(this).append(
					                            $("<span/>", {
					                                "class":"help-block help-choices"
					                            }).append(
					                                $("<span/>", {
					                                    "class":"validation-result label label-important",
					                                    text:lang[\'IG_UNIFORM_CONFIRM_FIELD_CANNOT_EMPTY\']
					                                })))
					                        check++;
					                    } else if ($(this).find("input[type=radio]:checked").hasClass(\'allowOther\') && $(this).find("input[type=radio]:checked").length == 1) {
					                        var selfRadio = this;
					                        $(this).find(".ig-value-Others").focusout(function () {
					                            var checkRadio = false;
					                            var valchoices = $(selfRadio).find(".ig-value-Others").val();
					                            var valchoices2 = valchoices.replace(\' \', \'\');
					                            if (valchoices2 == \'\') {
					                                checkRadio = true;
					                            }
					                            if (checkRadio) {
					                                $(selfRadio).find(".help-choices").remove();
					                                $(selfRadio).parent().addClass("error");
					                                $(selfRadio).append(
					                                    $("<span/>", {
					                                        "class":"help-block help-choices"
					                                    }).append(
					                                        $("<span/>", {
					                                            "class":"validation-result label label-important",
					                                            text:lang[\'IG_UNIFORM_CONFIRM_FIELD_CANNOT_EMPTY\']
					                                        })))
					                                check++;
					                            }
					                        });
					                        if (type != "detailInput") {
					                            $(this).find(".ig-value-Others").trigger("focusout");
					                        }
					                    }
					                }
					            });
					            if (onchange != "onchange") {
					                var $inputlikert = $(_this).find(".likert-required");
					                $inputlikert.each(function () {
					                    if ($(this).parents(".control-group").css("display") != "none") {
					                        $(this).find(".help-likert").remove();
					                        $(this).parents(".control-group").removeClass("error");
					                        $(this).find("tbody tr").each(function () {
					                            if ($(this).find("input[type=radio]:checked").length < 1) {
					                                $(this).parents(".control-group").addClass("error");
					                                if (!$(this).parents(".controls").find(".help-likert").size()) {
					                                    $(this).parents(".controls").append(
					                                        $("<span/>", {
					                                            "class":"help-block help-likert"
					                                        }).append(
					                                            $("<span/>", {
					                                                "class":"validation-result label label-important",
					                                                text:lang[\'IG_UNIFORM_CONFIRM_FIELD_CANNOT_EMPTY\']
					                                            })))
					                                }
					                                check++;
					                            }
					                        })

					                    }
					                });
					            }
					            var $inputCheckbox = $(_this).find(".checkbox-required");
					            $inputCheckbox.each(function () {
					                if ($(this).parents(".control-group").css("display") != "none") {
					                    $(this).find(".help-checkbox").remove();
					                    $(this).parent().parent().removeClass("error");
					                    if ($(this).find("input[type=checkbox]:checked").length < 1) {
					                        $(this).parent().parent().addClass("error");
					                        $(this).append(
					                            $("<span/>", {
					                                "class":"help-block help-checkbox"
					                            }).append(
					                                $("<span/>", {
					                                    "class":"validation-result label label-important",
					                                    text:lang[\'IG_UNIFORM_CONFIRM_FIELD_CANNOT_EMPTY\']
					                                })))
					                        check++;
					                    } else if ($(this).find("input[type=checkbox]:checked").length == 1 && $(this).find("input[type=checkbox]:checked").hasClass(\'allowOther\')) {
					                        var selfCheckbox = this;
					                        $(this).find(".ig-value-Others").focusout(function () {
					                            var checkCheckbox = false;
					                            var valchoices = $(selfCheckbox).find(".ig-value-Others").val();
					                            var valchoices2 = valchoices.replace(\' \', \'\');
					                            if (valchoices2 == \'\') {
					                                checkCheckbox = true;
					                            }
					                            if (checkCheckbox) {
					                                $(selfCheckbox).find(".help-checkbox").remove();
					                                $(selfCheckbox).parent().parent().addClass("error");
					                                $(selfCheckbox).append(
					                                    $("<span/>", {
					                                        "class":"help-block help-checkbox"
					                                    }).append(
					                                        $("<span/>", {
					                                            "class":"validation-result label label-important",
					                                            text:lang[\'IG_UNIFORM_CONFIRM_FIELD_CANNOT_EMPTY\']
					                                        })))
					                                check++;
					                            }
					                        });
					                        if (type != "detailInput") {
					                            $(this).find(".ig-value-Others").trigger("focusout");
					                        }
					                    }
					                }
					            });

					            if (check > 0 && type != "detailInput") {
					                var fieldFocus = $(_this).find(".error")[0];
					                if ($(fieldFocus).find(".blank-required").size()) {
					                    $(fieldFocus).find("input,select,textarea").each(function () {
					                        var val = $(this).val();
					                        if (val) {
					                            var val2 = val.replace(\' \', \'\');
					                            if (val2 == \'\' || val2 == 0) {
					                                $(window).scrollTop($(this).offset().top - 50);
					                                $(this).focus();
					                                $(this).click();
					                                return false;
					                            }
					                        } else {
					                            $(window).scrollTop($(this).offset().top - 50);
					                            $(this).focus();
					                            $(this).click();
					                            return false;
					                        }

					                    })
					                } else {
					                    var fieldFocus = $(_this).find(".error input,.error textarea,.error select")[0];
					                    $(window).scrollTop($(fieldFocus).offset().top - 50);
					                    $(fieldFocus).focus();
					                }
					                return false;
					            }

					            if (check > 0 && type == "detailInput") {
					                return false;
					            }
					            return true;
					        };';
		$functionForm[ 'getBoxStyle' ] = '$.getBoxStyle = function (element) {
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
					        };';
		$functionForm[ 'jsnLoadForm' ] = 'function jsnLoadForm($) {
					            $(".ig-uniform").each(function () {
					                if ($(this).attr("data-form-name")) {
					                    var getLang = $(this).find("span.ig-language").attr("data-value");
					                    baseUrl = $(this).find("span.ig-base-url").attr("data-value");
					                    if (getLang) {
					                        lang = $.evalJSON(getLang);
					                    }

					                    $.initJSNForm($(this));
					                }
					            });
					        }';
		$functionForm = apply_filters( 'ig_uniform_frontend_function_js_form', $functionForm );
		$javascript = '(function ($) {
					    $(function () {
					        var lang = null, forms = [], baseUrl = "";
							' . implode( '', $functionForm ) . '
							jQuery(document).ready(jsnLoadForm($));
					    });
					})(jQuery);';
		echo '' . $javascript;
		exit();
	}


}
