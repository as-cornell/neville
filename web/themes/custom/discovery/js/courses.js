
(function ($) {
  console.log('tablesbaby');
  $('#courses--table').DataTable( {
    "order": [[0, "asc"]],
    "paging": false
  });
  $('.toggle--course-detail').on({
    click: function () {
      console.log('clickarusky');
      $(this).parent().next().toggleClass("shown");
    },
  });
})(jQuery);