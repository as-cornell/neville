// document is ready to go
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