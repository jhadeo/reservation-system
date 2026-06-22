window.debounce = function debounce(fn, delay) {
    let timer;

    return function (...args) {
        clearTimeout(timer);

        timer = setTimeout(() => {
            fn(...args);
        }, delay);
    };
};

window.search = async function search(url, text = "") {
    const response = await fetch(`${url}?search=${encodeURIComponent(text)}`, {
        headers: {
            Accept: "application/json",
        },
    });
    if (!response.ok) throw new Error("Search failed");

    return await response.json();
};

window.escapeHtml = function (text) {
    const div = document.createElement("div");
    div.textContent = text ?? "";
    return div.innerHTML;
};

window.escapeAttributes = function (text) {

    return (text ?? "")
        .replaceAll("&", "&amp;")
        .replaceAll("<", "&lt;")
        .replaceAll(">", "&gt;")
        .replaceAll('"', "&quot;")
        .replaceAll("'", "&#039;");
};
