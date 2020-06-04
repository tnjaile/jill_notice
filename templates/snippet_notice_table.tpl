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

  <tbody id="notice_sort">
    <{foreach from=$AllNotice item=data}>
      <tr id="tr_<{$data.sn}>">
          <td>
            <!--分類-->
            <{$data.cate_title}>
          </td>
          <td>
            <!--建立時間-->
            <{$data.list_file}><{$data.deadline}>
          </td>

          <td>
            <!--類型-->
            <{$data.type_name}>
          </td>

          <td>
            <!--標題-->
            <{if $data.type=='ckeditor'}>
              <a href="<{$action}>?op=notice_show_one&sn=<{$data.sn}>"><{$smarty.const._MD_JILLNOTICE_CONTENT}>
              </a>
            <{else}>
              <a href="<{$action}>?op=notice_show_one&sn=<{$data.sn}>"><{$data.title}></a>
            <{/if}>
          </td>

          <td>
            <!--申請人員-->
            <{$data.uid_name}>
          </td>

          <td class="jq_select" id="status:<{$data.sn}>">
            <!--是否啟用-->
            <{$data.status_name}>
          </td>

          <!--<td>
            備註

          </td>-->
          <td>
            <a href="javascript:delete_notice_func(<{$data.sn}>);" class="btn btn-xs btn-danger"><{$smarty.const._TAD_DEL}></a>
            <a href="<{$action}>?op=notice_form&sn=<{$data.sn}>" class="btn btn-xs btn-warning"><{$smarty.const._TAD_EDIT}></a>
          </td>

      </tr>
    <{/foreach}>
  </tbody>
</table>