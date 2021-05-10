// document is ready to go
(function ($) {
  console.log('hello');
  $(".nav--main-opener").on({
    click: function () {
      $(".header__searchForm > form").removeClass("shown");

      $(".nav--main").toggleClass("shown");
      
      $(".main").toggleClass("fade");
    },
  });
// yo

  //
  // need to make this toggle want to control visibility with aria hiddens
  //

  // Add aria-haspopup true to links with popups
  $(".nav--main-opener").prev().attr("aria-haspopup", "true");

  $(".subNav a").attr("tabindex", -1);


  // if a menu-button is clicked...
  $(".subNavToggle").click(function (e) {
    // the button
    var _this = $(this);
    // the LI
    var parent = $(_this.parent());
    // the preceding <a>
    var linkContent = $(_this.prev());
    // rotate the button
    $(this).toggleClass("rotated");
    // the child list
    var next = $(_this.next());

    console.log(linkContent);

    if (!next.hasClass("expanded")) {
      $(next).addClass("expanded");
      $(parent).addClass("expanded");
     
      _this.next().find("a").removeAttr("tabindex", -1);

      // remove sub-expaneded
    } else {
      $(next).removeClass("expanded");
      $(parent).removeClass("expanded");
      _this.next().find("a").attr("tabindex", -1);
    }

  });
})(jQuery);
