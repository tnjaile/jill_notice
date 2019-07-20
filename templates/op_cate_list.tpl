<{$jquery}>
    <script type="text/javascript" src="<{$xoops_url}>/modules/jill_notice/js/cate.js"></script>
    <{if $AllCate}>
        <div id="cate_sort_save_msg"></div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <!--分類標題-->
                    <th class="col-sm-2">
                        <{$smarty.const._MA_JILL_NOTICE_CATE_TITLE}>
                    </th>
                    <!--分類說明-->
                    <th class="col-sm-2">
                        <{$smarty.const._MA_JILL_NOTICE_CATE_DESC}>
                    </th>
                    <!--可發佈群組-->
                    <th class="col-sm-2">
                        <{$smarty.const._MA_JILLNOTICE_POST_GROUP}>
                    </th>
                    <!--可讀取群組-->
                    <th class="col-sm-2">
                        <{$smarty.const._MA_JILLNOTICE_READ_GROUP}>
                    </th>
                    <!--審核人員-->
                    <th class="col-sm-2">
                        <{$smarty.const._MA_JILLNOTICE_AUDITORS}>
                    </th>
                    <th>
                        <{$smarty.const._TAD_FUNCTION}>
                    </th>
                </tr>
            </thead>

            <tbody id="cate_sort">
                <{foreach from=$AllCate item=data}>
                    <tr id="tr_<{$data.cate_sn}>">

                        <!--分類標題-->
                        <td>
                            <a href="<{$action}>?cate_sn=<{$data.cate_sn}>">
                                <{$data.cate_title}>
                            </a>
                        </td>

                        <!--分類說明-->
                        <td>
                            <{$data.cate_desc}>
                        </td>
                        <!--可發佈群組-->
                        <td>
                            <{$data.post_group}>
                        </td>
                        <!--可讀取群組-->
                        <td>
                            <{$data.read_group}>
                        </td>
                        <!--審核人員-->
                        <td>
                            <{if $data.auditors}>
                                <{$data.auditors}>
                                    <{else}>
                                        <img src="<{$xoops_url}>/modules/jill_notice/images/no.gif" style="cursor: s-resize;margin:0px 4px;" alt="<{$smarty.const._NO}>" title="<{$smarty.const._NO}>">
                                        <{/if}>
                        </td>
                        <{if $smarty.session.notice_adm}>
                            <td>
                                <a href="javascript:delete_cate_func(<{$data.cate_sn}>);" class="btn btn-xs btn-danger">
                                    <{$smarty.const._TAD_DEL}>
                                </a>
                                <a href="<{$action}>?op=cate_form&cate_sn=<{$data.cate_sn}>" class="btn btn-xs btn-warning">
                                    <{$smarty.const._TAD_EDIT}>
                                </a>
                                <a href="<{$xoops_url}>/modules/jill_notice/admin/auditors.php?cate_sn=<{$data.cate_sn}>" class="btn btn-sm btn-primary">
                                    <{$smarty.const._MI_JILLNOTICE_ADMENU2}>
                                </a>
                                <i class="fa fa-sort" aria-hidden="true" title="<{$smarty.const._TAD_SORTABLE}>"></i>
                            </td>
                            <{/if}>
                    </tr>
                    <{/foreach}>
            </tbody>
        </table>

        <{if $smarty.session.notice_adm}>
            <div class="text-right">
                <a href="<{$action}>?op=cate_form" class="btn btn-info">
                    <{$smarty.const._TAD_ADD}>
                </a>
            </div>
            <{/if}>
                <{includeq file="$xoops_rootpath/modules/jill_notice/templates/snippet_page.tpl" }>
                    <{else}>
                        <div class="jumbotron text-center">
                            <{if $smarty.session.notice_adm}>
                                <a href="<{$xoops_url}>/modules/jill_notice/admin/cate.php?op=cate_form" class="btn btn-info">
                                    <{$smarty.const._TAD_ADD}>
                                </a>
                                <{else}>
                                    <h3>
                                        <{$smarty.const._TAD_EMPTY}>
                                    </h3>
                                    <{/if}>
                        </div>
                        <{/if}>