// jQuery
jQuery(document).ready(function ($) {
  // Link Truendo
  jQuery(".j-cookie-policy").click(function () {
    Truendo.openCookieSettings();

    return false;
  });

  jQuery(".j-privacy-policy").click(function () {
    Truendo.openYourRights();

    return false;
  });

  // Load Scripts deferred
  setTimeout(function () {
    // JS
    const scripts = document.querySelectorAll("script[data-src]");

    scripts.forEach((script) => {
      script.src = script.dataset.src;
    });
  }, 1500);
});
