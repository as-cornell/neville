
(function ($) {
  console.log('it figures');
  $(".figure--hasCaption").addClass("active").append("<button class='toggle--figcaption'><svg class='icon' viewbox='0 0 52 32'><use xlink:href='#burger'></use></svg></button>");

  $(".toggle--figcaption").on({
    click: function () {
      var toggle = $(this);
      $(toggle).prev().toggleClass("shown");
      $(toggle).parent().toggleClass("showCaption");
    }
  });
  // set this to this figure
  // add class
  // add button
  // when button clicked toggle class "shown" on figcaption
})(jQuery);

{/* <svg class='icon icon--search' viewbox='0 0 52 32'> */}
					// <use xlink:href='#search'></use>
				// </svg>