<div class="container">
  <div class="row">
      <div class="col-sm-2">
        <label><{$smarty.const._MI_JILLNOTICE_NOTICE_GROUP}></label>
        <p class="help-block"><{$smarty.const._MI_JILLNOTICE_NOTICE_GROUP_DESC}></p>
      </div>
      <div class="col-sm-10">
        <form action="<{$action}>" method="post" id="myForm" enctype="multipart/form-data" class="form-horizontal" role="form">
          <div class="row">
            <select name="notice_group[]" class="form-control" size='20'  multiple>
              <{foreach from=$group_list key=k item=unit}>
              <option value=<{$k}> <{if $k|in_array:$def_groups}>selected<{/if}> >
                <{$unit}>
              </option>
              <{/foreach}>
            </select>
          </div>
          <hr>
          <div class="text-center">
              <input type="hidden" name="op" value="update_xoops_config">
              <button type="submit" class="btn btn-primary"><{$smarty.const._TAD_SAVE}></button>
          </div>
        </form>
      </div>
  </div>
</div>
