// jQuery
jQuery(document).ready(function ($) {
    // Load Scripts deferred
    setTimeout(function () {
        // JS
        const scripts = document.querySelectorAll("script[data-src]");

        scripts.forEach((script) => {
            script.src = script.dataset.src;
        });
    }, 1500);
});
