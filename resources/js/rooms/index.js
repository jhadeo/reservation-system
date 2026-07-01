function updateTable(results) {
    const container = document.querySelector("#rooms-container");

    if (!results || results.length === 0) {
        container.innerHTML = `
            <div class="text-center py-6">
                No results found
            </div>
        `;
        return;
    }

    container.innerHTML = results
        .map(group => `
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4">
                    ${escapeHtml(group.type_name)}
                    (${group.rooms.length})
                </h3>

                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>Room ID</th>
                                <th>Room Name</th>
                                <th>Rate</th>
                                <th>Max Capacity</th>
                                <th>Available</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            ${group.rooms.map(room => `
                                <tr>
                                    <td class="font-semibold">
                                        ${escapeHtml(room.room_id)}
                                    </td>

                                    <td class="font-semibold">
                                        ${escapeHtml(room.name)}
                                    </td>

                                    <td>
                                        ₱${Number(room.hourly_rate).toFixed(2)}/hr
                                    </td>

                                    <td>
                                        ${room.max_pax} people
                                    </td>

                                    <td>
                                        <span class="badge ${
                                            room.is_available
                                                ? "badge-success"
                                                : "badge-error"
                                        }">
                                            ${room.is_available ? "Available" : "Unavailable"}
                                        </span>
                                    </td>

                                    <td class="flex gap-2 justify-center">
                                        <a href="/admin/rooms/${room.id}"
                                            class="btn btn-primary btn-xs">
                                            Show
                                        </a>

                                        <a href="/admin/rooms/${room.id}/edit"
                                            class="btn btn-neutral btn-xs">
                                            Edit
                                        </a>

                                        <button
                                            class="btn btn-error btn-xs"
                                            data-action="/admin/rooms/${room.id}"
                                            data-room-name="${escapeAttributes(room.name)}"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            `).join("")}
                        </tbody>
                    </table>
                </div>
            </div>
        `)
        .join("");
}
function openDeleteModal(button) {
    document.getElementById("delete-form").action = button.dataset.action;
    document.getElementById("room-name").textContent = button.dataset.roomName;
    document.getElementById("delete_modal").showModal();
}

const container = document.querySelector("#rooms-container");
container?.addEventListener("click", (event) => {
    const removeButton = event.target.closest("button[data-action]");
    if (removeButton) {
        openDeleteModal(removeButton);
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
            `<tr><td colspan="4" class="text-center py-4 text-error">Search failed</td></tr>`;
    }
}, 500);

document.getElementById("search").addEventListener("input", async (event) => {
    const trimmed = event.target.value.trim();
    const params = new URLSearchParams();
    params.append('search', trimmed);
    debouncedSearch(params);
});
