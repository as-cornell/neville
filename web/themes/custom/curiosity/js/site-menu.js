// document is ready to go
(function ($) {
  // add active class to current item
  // $(function () {
  //   $('nav a[href^="/' + location.pathname.split("/")[1] + '"]').addClass(
  //     "active"
  //   );
  // });
  $(".siteNavOpener").on({
    click: function () {
      $(".nav--site > .nav").toggleClass("expanded");
    },
  });
})(jQuery);
