(function ($) {
    $("#ig_contactform_btn_add_fied").click(function () {
        var form_id = jQuery("select.ig-contactform-list-form").val();
        if (form_id == "" || form_id == "undefined") {
            alert("Please select a form");
            return;
        }
        window.send_to_editor("[ig_contactform id=" + form_id + "]");
    })
})(jQuery);
