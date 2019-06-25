<div class="container">
  <{if $AllNotice}>
    <{includeq file="$xoops_rootpath/modules/jill_notice/templates/snippet_notice_table.tpl"}>
    <{if $smarty.session.notice_adm || $can_notice}>
      <div class="text-right">
        <a href="<{$action}>?op=notice_form" class="btn btn-info"><{$smarty.const._TAD_ADD}></a>
      </div>
    <{/if}>
    <{includeq file="$xoops_rootpath/modules/jill_notice/templates/snippet_page.tpl"}>
  <{else}>
    <div class="jumbotron text-center">
      <{if $smarty.session.notice_adm || $can_notice}>
        <a href="<{$action}>?op=notice_form" class="btn btn-info"><{$smarty.const._TAD_ADD}></a>
      <{else}>
        <h3><{$smarty.const._MD_JILLNOTICE_ERRORLOGION}></h3>
      <{/if}>
    </div>
  <{/if}>
</div>