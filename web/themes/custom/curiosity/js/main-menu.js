// document is ready to go
(function ($) {
  // add active class to current item
  // $(function () {
  //   $('nav a[href^="/' + location.pathname.split("/")[1] + '"]').addClass(
  //     "active"
  //   );
  // });
  $(".nav-opener").on({
    click: function () {
      $(".header__searchForm > form").removeClass("shown");

      $(".mainNav").toggleClass("shown");
      
      $(".main").toggleClass("fade");
    },
  });

  // console.log( "Let's do this!"  );

  // close the menu--secondary
  // $('.menu--secondary a').attr('tabindex', -1);
  // $('.menu--secondary').addClass('close');
  // $(".menu--secondary").before("<button class='menu-toggle' aria-hidden='false' aria-label='menu--secondary is closed'><svg viewBox='0 0 20 20' class='icon--arrow'> <use xlink:href='#shape-icon-down-arrow'></use > </svg ><span class='sr-only'>Show nested menu</span></button>");

  //
  // need to make this toggle want to control visibility with aria hiddens
  //

  // Add aria-haspopup true to links with popups
  $(".mainNav__toggle").prev().attr("aria-haspopup", "true");

  $(".subNav a").attr("tabindex", -1);

  // var linkText = $('.expand-sub').prev().text();
  // // console.log(linkText);

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

    // $('.subNav__link').focus(function(){
    //   $(this).addClass('sub-expanded');
    //   console.log('hiya');
    // });

    // // if the menu--secondary is hidden....
    // if (!_this.next().hasClass('display')) {

    //   // reset menu--secondary + button arrow to start
    //   $('.menu--secondary').removeClass('display');
    //   $('.menu--secondary a').attr('tabindex', -1);
    //   $('.fa').addClass('fa-angle-down');
    //   $('.fa').removeClass('fa-angle-up');
    //   $('.expand-sub').attr('aria-label', 'menu--secondary is closed');

    //   // open menu
    //  // _this.next().addClass('display');
    //   // _this.prev().removeAttr('aria-expanded');
    //   _this.prev().attr('aria-expanded', 'true');
    //   //_this.next().find('a').removeAttr('tabindex', -1);
    //   //_this.children().removeClass('fa-angle-down');
    //  // _this.children().addClass('fa-angle-up');
    //   //_this.attr('aria-label', 'menu--secondary is open');

    //   // if the menu is open then...
    // } else {

    //   // close the menu...
    //  // _this.next().removeClass('display');
    //   _this.prev().attr('aria-expanded', 'false');
    //  // _this.next().find('a').attr('tabindex', -1);
    //  // _this.children().removeClass('fa-angle-up');
    //  // _this.children().addClass('fa-angle-down');
    // //  _this.attr('aria-label', 'menu--secondary is closed');

    // }
  });
})(jQuery);
