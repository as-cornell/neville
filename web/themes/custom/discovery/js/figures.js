
(function ($) {
  console.log('it figures');
  $(".article__thumbnail > .figure--hasCaption, .pcWrapper--ftb .figure--hasCaption").addClass("active").append("<button class='toggle--figcaption'><svg class='icon' viewbox='0 0 68 80'><use xlink:href='#figure-caption'></use></svg></button>");

  $(".toggle--figcaption").on({
    click: function () {
      var toggle = $(this);
      $(toggle).attr("")
      $(toggle).prev().toggleClass("shown");
      $(toggle).parent().toggleClass("showCaption");
    }
  });
  // set this to this figure
  // add class
  // add button
  // when button clicked toggle class "shown" on figcaption
})(jQuery);

