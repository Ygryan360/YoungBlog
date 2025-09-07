import "./bootstrap";
import "@fontsource-variable/rubik";
import hljs from "highlight.js";
import "highlight.js/styles/tokyo-night-dark.css";

document.addEventListener("DOMContentLoaded", () => {
    hljs.highlightAll();
});

const showToast = (htmlContent, duration = 3000) => {
    const wrapper = document.createElement("div");
    wrapper.className =
        "toast toast-top toast-center transition-opacity duration-300";
    wrapper.innerHTML = htmlContent;
    document.body.appendChild(wrapper);
    setTimeout(() => {
        wrapper.classList.add("opacity-0");
        setTimeout(() => wrapper.remove(), 300);
    }, duration);
};

const copyToClipboard = async (text) => {
    try {
        navigator.clipboard.writeText(text);
        showToast(
            `<div class="alert alert-success"><span>Lien copié</span></div>`,
            3000
        );
    } catch (err) {
        showToast(
            `<div class="alert alert-error"><span>Erreur lors de la copie</span></div>`,
            3000
        );
        console.error("Copy failed", err);
    }
};

window.copyToClipboard = copyToClipboard;
