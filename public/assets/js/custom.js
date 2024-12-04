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

// Toggle action
let currentlyOpenAction = null;
function toggleAction(ticketId) {
    let actionDiv = document.getElementById("action-" + ticketId);

    if (currentlyOpenAction === actionDiv) {
        actionDiv.style.display = "none";
        currentlyOpenAction = null;
        return;
    }

    if (currentlyOpenAction) {
        currentlyOpenAction.style.display = "none";
    }
    actionDiv.style.display = "block";
    currentlyOpenAction = actionDiv;
}

document.addEventListener("click", function (event) {
    if (
        currentlyOpenAction &&
        !event.target.closest(".action-container") &&
        !event.target.closest("button")
    ) {
        currentlyOpenAction.style.display = "none";
        currentlyOpenAction = null;
    }
});

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

