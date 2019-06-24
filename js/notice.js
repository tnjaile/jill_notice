$(function () {
  $("#notice_sort").sortable({
    opacity: 0.6,
    cursor: "move",
    start: function () {
      $("#notice_sort_save_msg").empty();
    } ,
    update: function () {
      var order = $(this).sortable("serialize");

      $.post("notice_sort.ajax.php", order, function(theResponse){
        $("#notice_sort_save_msg").html(theResponse);
      });
    }
  });
});