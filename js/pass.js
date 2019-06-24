$(function () {
  var urlParams = new URLSearchParams(window.location.search);
  var cate_sn=urlParams.get('cate_sn');
  if (typeof cate_sn !== 'undefined') {
    // 設定狀態
    var $radios = $('input:radio[name=status]');
    if($radios.is(':checked') === false) {
        $radios.filter('[value=0]').prop('checked', true);
    }
    notice_list($radios.value,cate_sn);
  }
});

function notice_list(status,cate_sn){
  $.post('notice_list.ajax.php', {status:status,cate_sn:cate_sn},
  function(data){
   $('#notice_sort').html(data);
  });
}