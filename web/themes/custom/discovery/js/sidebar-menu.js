// document is ready to go
(function ($) {

  $(".nav-toggle--sidebar").on({
    click: function () {
      var toggle = $(this);
      $(toggle).toggleClass("active");
      $(toggle).next().toggleClass("shown");
    },
  });

  // $(".subnav-toggle--sidebar").on({
  //   click: function () {
  //     var toggle = $(this);
  //     $(toggle).toggleClass("active");
  //     // $(toggle).parent().toggleClass("active");
  //     $(toggle).next().toggleClass("shown");
  //   },
  // });

  // $(".subnav-closed > .subnav-toggle--sidebar").on({
  //   click: function () {
  //     var toggle = $(this);
  //     // $(toggle).toggleClass("active");
  //     // console.log('hello');
  //     $(toggle).parent().toggleClass("subnav-open");
  //     // $(toggle).next().toggleClass("shown");
  //   },
  // });
  $(".subnav-toggle--sidebar").on({
    click: function () {
      var toggle = $(this);
      // $(toggle).toggleClass("active");
      // console.log('bye bye');
      $(toggle).parent().toggleClass("subnav-open");
      // $(toggle).next().toggleClass("shown");
    },
  });

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
