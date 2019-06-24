<div class="container">
    <h2 class="text-center"><{$OneCate.cate_title}></h2>
    <!--分類說明-->
    <div class="row">
        <label class="col-sm-3 text-right">
            <{$smarty.const._MA_JILL_NOTICE_CATE_DESC}>
        </label>
        <div class="col-sm-9">
            <{$OneCate.cate_desc}>
        </div>
    </div>
    <div class="text-right">
        <{if $smarty.session.notice_adm}>
            <a href="javascript:delete_cate_func(<{$OneCate.cate_sn}>);" class="btn btn-xs btn-danger"><{$smarty.const._TAD_DEL}></a>
            <a href="<{$action}>?op=cate_form&cate_sn=<{$OneCate.cate_sn}>" class="btn btn-xs btn-warning"><{$smarty.const._TAD_EDIT}></a>
            <a href="<{$action}>?op=cate_form" class="btn btn-info"><{$smarty.const._TAD_ADD}></a>
        <{/if}>
        <a href="<{$action}>" class="btn btn-success"><{$smarty.const._MA_JILL_BACK}></a>
    </div>
</div>


