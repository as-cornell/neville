// (function ($) {
//   var $targets = $('.views-row .teaser');
  
//   $('.searchbox').on('input', function () {
//     $targets.show();

//     var text = $(this).val().toLowerCase();
//     if (text) {
//       console.log(text);
//       $targets.filter(':visible').each(function () {
//         var $target = $(this);
//         var $matches = 0;
//         // Search only in targeted element
//         $target.find('h2, h3, h4, p').add($target).each(function () {
//           if ($(this).text().toLowerCase().indexOf("" + text + "") !== -1) {
//             $matches++;
//           }
//         });
//         if ($matches === 0) {
//           $target.hide();
//         }
//       });
//     }
//   });
// })(jQuery);

(function($) {
  var $input = $(".searchbox"),
    $context = $(".teaser");
  $input.on("input", function() {
    var term = $(this).val();
    $context.show().unmark();
    if (term) {
      $context.mark(term, {
        done: function() {
          $context.not(":has(mark)").hide();
        }
      });
    }
  });
})(jQuery);
