// document is ready to go
(function ($) {
  console.log('hello');
  $(".nav-opener").on({
    click: function () {
      $(".header__searchForm > form").removeClass("shown");

      $(".mainNav").toggleClass("shown");
      
      $(".main").toggleClass("fade");
    },
  });
// yo

  //
  // need to make this toggle want to control visibility with aria hiddens
  //

  // Add aria-haspopup true to links with popups
  $(".mainNav__toggle").prev().attr("aria-haspopup", "true");

  $(".subNav a").attr("tabindex", -1);


  // if a menu-button is clicked...
  $(".mainNav__subNavToggle").click(function (e) {
    var _this = $(this);
    var parent = $(_this.parent());
    var linkContent = $(_this.prev());
    $(this).toggleClass("rotated");

    var next = $(_this.next());

    console.log(linkContent);

    if (!next.hasClass("subNav--expanded")) {
      $(next).addClass("subNav--expanded");
      $(parent).addClass("withSubNav--expanded");
     
      _this.next().find("a").removeAttr("tabindex", -1);

      // remove sub-expaneded
    } else {
      $(next).removeClass("subNav--expanded");
      $(parent).removeClass("withSubNav--expanded");
      _this.next().find("a").attr("tabindex", -1);
    }

  });
})(jQuery);
