function updateTable(results) {
    const tbody = document.querySelector(".t-body");
    if (results.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="4" class="text-center py-4">
                    No results found
                </td>
            </tr>
        `;
        return;
    }
    tbody.innerHTML = results
        .map((type) => {
            // escapeHtml  → safe for tag text content
            // escapeAttributes → safe for quoted attribute values
            const safeName = escapeHtml(type.name);
            const safeDescription = escapeHtml(type.description);
            const safeNameAttr = escapeAttributes(type.name);
            const safeDescAttr = escapeAttributes(type.description);

            return `
            <tr>
                <td class="font-semibold">${safeName}</td>
                <td class="font-semibold">
                    <div class="max-w-xs truncate" title="${safeDescAttr}">
                        ${safeDescription}
                    </div>
                </td>
                <td>
                    <span class="badge badge-info">
                        ${type.rooms_count ?? 0}
                    </span>
                </td>
                <td class="flex gap-2 justify-center">
                    <a href="#"
                        class="btn btn-neutral btn-xs edit-btn"
                        data-action="/admin/room-types/${escapeAttributes(type.id)}"
                        data-type-name="${safeNameAttr}"
                        data-type-description="${safeDescAttr}">
                        Edit
                    </a>
                    <a href="#"
                        class="btn btn-error btn-xs delete-btn"
                        data-action="/admin/room-types/${escapeAttributes(type.id)}"
                        data-type-name="${safeNameAttr}">
                        Delete
                    </a>
                </td>
            </tr>
        `;
        })
        .join("");
}

function openEditModal(button) {
    const form = document.getElementById("edit-form");
    form.action = button.dataset.action;

    document.getElementById("edit-name").value = button.dataset.typeName ?? "";
    document.getElementById("edit-description").value =
        button.dataset.typeDescription ?? "";

    document.getElementById("edit_modal").showModal();
}

function openDeleteModal(button) {
    document.getElementById("delete-form").action = button.dataset.action;
    document.getElementById("type-name").textContent = button.dataset.typeName;
    document.getElementById("delete_modal").showModal();
}

const actions = document.querySelector(".t-body");
actions.addEventListener("click", (event) => {
    const removeButton = event.target.closest(".delete-btn");
    if (removeButton) {
        openDeleteModal(removeButton);
    }

    const editButton = event.target.closest(".edit-btn");
    if (editButton) {
        openEditModal(editButton);
    }
});

const debouncedSearch = debounce(async (text) => {
    try {
        const url = document.getElementById("search").dataset.url;
        const results = await search(url, text);
        updateTable(results);
    } catch (error) {
        console.error("Search failed:", error);
        document.querySelector(".t-body").innerHTML =
            `<tr><td colspan="4" class="text-center py-4 text-error">Search failed</td></tr>`;
    }
}, 500);
document.getElementById("search").addEventListener("input", async (event) => {
    const trimmed = event.target.value.trim();
    debouncedSearch(trimmed);
});
