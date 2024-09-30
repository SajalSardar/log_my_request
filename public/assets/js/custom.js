function submitSwitchAccount(event) {
    event.target.closest("form").submit();
}

function initSelect2(eliment_id_and_name = "") {
    $(`#${eliment_id_and_name}`)
        .select2()
        .on("change", function (e) {
            let data = $(this).val();
            let componentId = $(`#${eliment_id_and_name}`)
                .closest("[wire\\:id]")
                .attr("wire:id");
            Livewire.find(componentId).set(eliment_id_and_name, data);
        });
}

$(function ($) {
    $(".select2").select2({
        placeholder: "Select an option",
        allowClear: true,
    });
});
