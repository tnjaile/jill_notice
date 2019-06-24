<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/My97DatePicker/WdatePicker.js"></script>
<div class="container">
  <form action="<{$action}>" method="post" id="myForm" role="form" enctype="multipart/form-data">
    <!--類型-->
    <div class="form-group row">
      <label class="col-sm-2 col-form-label text-md-right">
        <{$smarty.const._MD_JILLNOTICE_TYPE}>/分類
      </label>
      <div class="col-sm-10">
          <div class="row">
            <div class="col">
                <{if $OneNotice.sn}>
                  <{$OneNotice.type_name}>
                <input type="hidden" name="type" value="<{$def_type}>">
              <{else}>
                <select name="type" id="type" class="form-control" onchange="location.href='<{$action}>?op=notice_form&type='+this.value">
                  <{foreach from=$typeArr key=k item=c}>
                    <option value=<{$k}> <{if $def_type==$k}>selected<{/if}> ><{$c}></option>
                  <{/foreach}>
                </select>
              <{/if}>
            </div>
            <div class="col">
              <select name="cate_sn" id="cate_sn" class="form-control">
                <{foreach from=$allCate key=cate_sn item=cate_title}>
                  <option value=<{$cate_sn}> <{if $OneNotice.cate_sn==$cate_sn}>selected<{/if}> ><{$cate_title}></option>
                <{/foreach}>
              </select>
            </div>
          </div>
      </div>
    </div>


    <!--下架時間 datetime-->
    <div class="form-group row">
      <label class="col-sm-2 col-form-label text-md-right">
        <{$smarty.const._MD_JILLNOTICE_DEADLINE}>
      </label>
      <div class="col-sm-10">
        <input type="text" name="deadline" id="deadline" class="form-control validate[required]" value="<{$OneNotice.deadline}>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm', startDate:'%y-%M-%d %H:%m',minDate:'%y-%M-%d+1'})" placeholder="<{$smarty.const._MD_JILLNOTICE_DEADLINE}>">
      </div>
    </div>

    <{includeq file="$xoops_rootpath/modules/jill_notice/templates/snippet_layout.tpl"}>

  <div class="text-center">
      <{$token_form}>
      <input type="hidden" name="next_op" value="<{$next_op}>">
      <input type="hidden" name="op" value="<{$now_op}>">
      <input type="hidden" name="sn" value="<{$OneNotice.sn}>">
      <input type="submit" name="send" value="<{$smarty.const._TAD_SAVE}>" class="btn btn-primary" />
  </div>
</form>
</div>
