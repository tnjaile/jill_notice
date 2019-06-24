<{if $smarty.session.notice_adm}><{$jquery}><{/if}>
<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/jeditable/jquery.jeditable.mini.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/jill_notice/js/pass.js"></script>
<div class="row">
  <div class="col-sm-3">
      <select name="cate_sn" id="cate_sn" class="form-control" size="<{$size}>" onChange="location.href='<{$action}>?cate_sn='+this.value">
        <{foreach from=$allCate key=cate_sn item=cate_title}>
          <option value=<{$cate_sn}> <{if $def_cate_sn==$cate_sn}>selected<{/if}> ><{$cate_title}></option>
        <{/foreach}>
      </select>
  </div>
  <div class="col-sm-9">
    <p>
        <{foreach from=$statusArr key=k item=status}>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="status" id="status" value="<{$k}>" onClick="notice_list('<{$k}>','<{$def_cate_sn}>')">
          <label class="form-check-label" for="status"><{$status}></label>
        </div>
        <{/foreach}>
    </p>
    <{if $def_cate_sn}>
      <table class="table table-striped table-hover">
        <thead>
          <tr class="info">
              <th>
                  <!--分類-->
                  <{$smarty.const._MD_JILLNOTICE_CATE}>
              </th>
              <th>
                <!--下架時間-->
                <{$smarty.const._MD_JILLNOTICE_DEADLINE}>
              </th>
              <th>
                <!--類型-->
                <{$smarty.const._MD_JILLNOTICE_TYPE}>
              </th>

              <th>
                <!--標題-->
                <{$smarty.const._MD_JILLNOTICE_TITLE}>
              </th>
              <th>
                <!--申請人員-->
                <{$smarty.const._MD_JILLNOTICE_UID}>
              </th>
              <th>
                <!--是否啟用-->
                <{$smarty.const._MD_JILLNOTICE_STATUS}>
              </th>
              <!--<th>
                備註
                <{$smarty.const._MD_JILLNOTICE_NOTE}>
              </th>-->
              <th><{$smarty.const._TAD_FUNCTION}></th>
          </tr>
        </thead>

        <tbody id="notice_sort"></tbody>
      </table>
    <{/if}>
  </div>
</div>