<{$jquery}>
<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/jeditable/jquery.jeditable.mini.js"></script>
<div class="alert alert-primary">
  <form action="<{$action}>" method="post" id="myForm" class="form-inline" role="form">
    <div class="form-group mr-2">
      <select name="cate_sn" id="cate_sn" class="form-control">
        <{foreach from=$allCate key=cate_sn item=cate_title}>
          <option value=<{$cate_sn}> <{if $def_cate_sn==$cate_sn}>selected<{/if}> ><{$cate_title}></option>
        <{/foreach}>
      </select>
    </div>
    <div class="form-group">
      <{foreach from=$statusArr key=k item=status}>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="status" id="status" value="<{$k}>" <{if $def_status==$k}>checked<{/if}>>
          <label class="form-check-label" for="status"><{$status}></label>
        </div>
      <{/foreach}>
    </div>
    <div class="form-group ml-2">
      <input type="submit" name="send" value="<{$smarty.const._TAD_SEARCH}>" class="btn btn-primary" />
    </div>
  </form>
</div>

<div class="container">
  <{if $AllNotice}>
    <{includeq file="$xoops_rootpath/modules/jill_notice/templates/snippet_notice_table.tpl"}>
    <{includeq file="$xoops_rootpath/modules/jill_notice/templates/snippet_page.tpl"}>
  <{else}>
    <div class="jumbotron text-center">
        <h3><{$smarty.const._MD_JILLNOTICE_NODATA}></h3>
    </div>
  <{/if}>
</div>