
(function ($) {
  console.log('tablesbaby');
  $('#courses--table').DataTable( {
    "order": [[ 2, "desc" ]]
  });
  $('.toggle--course-detail').on({
    click: function () {
      console.log('clickarusky');
      $(this).parent().next().toggleClass("shown");
    },
  });
})(jQuery);