(function ($) {
    $("#ig_uniform_btn_add_fied").click(function () {
        var form_id = jQuery("select.ig-uniform-list-form").val();
        if (form_id == "" || form_id == "undefined") {
            alert("Please select a form");
            return;
        }
        window.send_to_editor("[ig_uniform id=" + form_id + "]");
    })
})(jQuery);
