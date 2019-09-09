<h2 class="text-center"><{$OneNotice.title}></h2>
  <!--建立時間-->
  <div class="row">
    <label class="col-sm-3 text-right">
      <{$smarty.const._MD_JILLNOTICE_CREATE_DATE}>
    </label>
    <div class="col-sm-9">
      <{$OneNotice.create_date}>
    </div>
  </div>

  <!--類型-->
  <div class="row">
    <label class="col-sm-3 text-right">
      <{$smarty.const._MD_JILLNOTICE_TYPE}>
    </label>
    <div class="col-sm-9">
      <{$OneNotice.type_name}>
    </div>
  </div>

  <!--分類-->
  <div class="row">
    <label class="col-sm-3 text-right">
      <{$smarty.const._MD_JILLNOTICE_CATE}>
    </label>
    <div class="col-sm-9">
      <{$OneNotice.cate_title}>
    </div>
  </div>

  <!--下架時間-->
  <div class="row">
    <label class="col-sm-3 text-right">
      <{$smarty.const._MD_JILLNOTICE_DEADLINE}>
    </label>
    <div class="col-sm-9">
      <{$OneNotice.deadline}>
    </div>
  </div>
  <{if $OneNotice.content}>
    <!--內文-->
    <div class="row">
      <label class="col-sm-3 text-right">
        <{$smarty.const._MD_JILLNOTICE_CONTENT}>
      </label>
      <div class="col-sm-9">
        <div class="jumbotron-fluid">
          <p><{$OneNotice.content|nl2br}></p>
        </div>
      </div>
    </div>
  <{/if}>

  <!--是否啟用-->
  <div class="row">
    <label class="col-sm-3 text-right">
      <{$smarty.const._MD_JILLNOTICE_STATUS}>
    </label>
    <div class="col-sm-9">

      <div class="well">
        <{$OneNotice.status_name}>
      </div>
    </div>
  </div>
  <{if $OneNotice.list_file}>
    <!--上傳圖片-->
    <div class="row">
      <label class="col-sm-3 text-right">
        <{$smarty.const._MD_JILLNOTICE_SHOW_SN_FILES}>
      </label>
      <div class="col-sm-9">
        <{$OneNotice.list_file}>
      </div>
    </div>
  <{/if}>
  <!--申請人員-->
  <div class="row">
    <label class="col-sm-3 text-right">
      <{$smarty.const._MD_JILLNOTICE_UID}>
    </label>
    <div class="col-sm-9">
      <{$OneNotice.uid_name}>
    </div>
  </div>
  <{if $smarty.session.notice_adm}>
    <!--備註-->
    <div class="row">
      <label class="col-sm-3 text-right">
        <{$smarty.const._MD_JILLNOTICE_NOTE}>
      </label>
      <div class="col-sm-9">
        <{$OneNotice.note}>
      </div>
    </div>
  <{/if}>
  <div class="text-right">
      <{if $OneNotice.status=='0' || $OneNotice.status==''}>
        <a href="javascript:delete_notice_func(<{$OneNotice.sn}>);" class="btn btn-danger"><{$smarty.const._TAD_DEL}></a>
        <a href="<{$action}>?op=notice_form&sn=<{$OneNotice.sn}>" class="btn btn-warning"><{$smarty.const._TAD_EDIT}></a>
        <a href="<{$action}>?op=notice_form" class="btn btn-primary"><{$smarty.const._TAD_ADD}></a>
    <{/if}>
    <a href="<{$action}>" class="btn btn-success"><{$smarty.const._TAD_HOME}></a>
  </div>