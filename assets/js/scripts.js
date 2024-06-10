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
    const scripts = document.querySelectorAll("script[data-trp_src]");

    scripts.forEach((script) => {
      script.src = script.dataset.trp_src;
    });
  }, 1500);

  //FANCYBOX
  if (phpVars.fancybox) {
    Fancybox.bind(".wp-block-gallery img", {
      groupAll: true,
    });
  }
});
