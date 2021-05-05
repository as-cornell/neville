// all form related funcitons, even ones that hide and show items in here
(function ($) {
  console.log("hiya");
  $(".search-opener").on({
    click: function () {
      $(".mainNav").removeClass("shown");
      $(".header__searchForm > form").toggleClass("shown");
      
      $(".main").toggleClass("fade");
    },
  });
})(jQuery); 