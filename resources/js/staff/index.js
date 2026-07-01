function updateTable(results) {
    const tbody = document.querySelector(".t-body");
    if (results.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center py-4">No results found</td>
            </tr>
        `;
        return;
    }
    tbody.innerHTML = results
        .map((staff) => {
            // full_name is an accessor so concatenate from the real columns
            const fullName = `${staff.first_name} ${staff.last_name}`;
            const safeName = escapeHtml(fullName);
            const safePhone = escapeHtml(staff.phone);
            const safeEmail = escapeHtml(staff.email);
            const safeNameAttr = escapeAttributes(fullName);
            const safeFirstAttr = escapeAttributes(staff.first_name);
            const safeLastAttr = escapeAttributes(staff.last_name);
            const safePhoneAttr = escapeAttributes(staff.phone);
            const safeEmailAttr = escapeAttributes(staff.email);
            const isActive = !staff.deleted_at;

            return `
            <tr>
                <td class="font-semibold">${safeName}</td>
                <td class="font-semibold">${safePhone}</td>
                <td class="font-semibold">${safeEmail}</td>
                <td class="font-semibold">
                    <span class="badge ${isActive ? "badge-success" : "badge-error"}">
                        ${isActive ? "Active" : "Inactive"}
                    </span>
                </td>
                <td class="flex gap-2 justify-center">
                    <button
                        class="btn btn-neutral btn-xs edit-btn"
                        data-action="/admin/staff/${staff.id}"
                        data-type-name="${safeNameAttr}"
                        data-type-first-name="${safeFirstAttr}"
                        data-type-last-name="${safeLastAttr}"
                        data-type-email="${safeEmailAttr}"
                        data-type-phone="${safePhoneAttr}">
                        Edit
                    </button>
                    <button
                        class="btn btn-error btn-xs delete-btn"
                        data-action="/admin/staff/${staff.id}"
                        data-type-name="${safeNameAttr}">
                        Deactivate
                    </button>
                </td>
            </tr>
        `;
        })
        .join("");
}

function openEditModal(button) {
    const form = document.getElementById("edit-form");
    form.action = button.dataset.action;

    document.getElementById("staff-name").textContent =
        button.dataset.typeName ?? "";
    document.getElementById("edit-first-name").value =
        button.dataset.typeFirstName ?? "";
    document.getElementById("edit-last-name").value =
        button.dataset.typeLastName ?? "";
    document.getElementById("edit-email").value =
        button.dataset.typeEmail ?? "";
    document.getElementById("edit-phone").value =
        button.dataset.typePhone ?? "";

    document.getElementById("edit_modal").showModal();
}

function openDeleteModal(button) {
    document.getElementById("delete-form").action = button.dataset.action;
    document.getElementById("deact-type-name").textContent =
        button.dataset.typeName;
    document.getElementById("deact_modal").showModal();
}

function openActiveModal(button) {
    document.getElementById("restore-form").action = button.dataset.action;
    document.getElementById("restore-type-name").textContent =
        button.dataset.typeName;
    document.getElementById("restore_modal").showModal();
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

    const restoreButton = event.target.closest(".restore-btn");
    if (restoreButton) {
        openActiveModal(restoreButton);
    }
});

const debouncedSearch = debounce(async (params) => {
    try {
        const url = document.getElementById("search").dataset.url;
        const results = await search(url, params);
        updateTable(results);
    } catch (error) {
        console.error("Search failed:", error);
        document.querySelector(".t-body").innerHTML =
            `<tr><td colspan="5" class="text-center py-4 text-error">Search failed</td></tr>`;
    }
}, 500);

document.getElementById("search").addEventListener("input", async (event) => {
    const trimmed = event.target.value.trim().toLowerCase();
    let params = new URLSearchParams();
    params.append("search",trimmed);
    debouncedSearch(params);
});

document.getElementById("staffFilter").addEventListener("change", async (event) => {
    event.preventDefault();
    const formData = new FormData(document.getElementById("staffFilter"));
    const searchText = document.getElementById("search").value.trim();
    let params = new URLSearchParams();
    params.append("search", searchText);
    const status = formData.get('status');
    params.append("status", status);
    debouncedSearch(params);
});
