<{$toolbar}>
<{if $now_op}>
    <{if $xoops_isuser}>
        <{includeq file="$xoops_rootpath/modules/jill_notice/templates/op_`$now_op`.tpl"}>
    <{else}>
        <div class="jumbotron text-center">
            <h3><{$smarty.const._MD_JILLNOTICE_PLEASELOGION}></h3>
        </div>
    <{/if}>
<{/if}>