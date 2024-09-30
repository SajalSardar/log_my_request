function submitSwitchAccount(event) {
    event.target.closest("form").submit();
}

function reinitializeSelect2() {
    if ($.fn.select2 && $(".select2").hasClass("select2-hidden-accessible")) {
        $(".select2").select2("destroy");
    }

    $(".select2").select2({
        placeholder: "Select an option",
        allowClear: true,
    });
}
