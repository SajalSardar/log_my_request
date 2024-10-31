function submitSwitchAccount(event) {
    event.target.closest("form").submit();
}

function initSelect2(eliment_id_and_name = "") {
    $(`#${eliment_id_and_name}`)
        .select2({
            allowClear: true,
        })
        .on("change", function (e) {
            let data = $(this).val();
            let componentId = $(`#${eliment_id_and_name}`)
                .closest("[wire\\:id]")
                .attr("wire:id");
            Livewire.find(componentId).set(eliment_id_and_name, data);
        });
}

function initSelect2form(eliment_id_and_name = "") {
    $(`#${eliment_id_and_name}`)
        .select2({
            allowClear: true,
        })
        .on("change", function (e) {
            let data = $(this).val();
            let componentId = $(`#${eliment_id_and_name}`)
                .closest("[wire\\:id]")
                .attr("wire:id");
            Livewire.find(componentId).set("form." + eliment_id_and_name, data);
        });
}
function toggleAction(ticketId) {
    var actionDiv = document.getElementById("action-" + ticketId);
    if (actionDiv.style.display === "none" || actionDiv.style.display === "") {
        actionDiv.style.display = "block";
    } else {
        actionDiv.style.display = "none";
    }
}

function activeCkEditor(eliment) {
    const editor = ClassicEditor.create(document.querySelector(`#${eliment}`), {
        toolbar: [
            "heading",
            "bold",
            "italic",
            "link",
            "bulletedList",
            "numberedList",
            "blockQuote",
        ],
    }).catch((error) => {
        console.error(error);
    });
}
