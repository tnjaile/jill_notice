$(function () {
  $("#cate_sort").sortable({
    opacity: 0.6,
    cursor: "move",
    start: function () {
      $("#cate_sort_save_msg").empty();
    } ,
    update: function () {
      var order = $(this).sortable("serialize");
      $.post("cate_sort.ajax.php", order, function(theResponse){
        $("#cate_sort_save_msg").html(theResponse);
      });
    }
  });
});