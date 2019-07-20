<div class="container">
    <!--套用formValidator驗證機制-->
    <form action="<{$action}>" method="post" id="myForm" role="form">
        <!--分類標題-->
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">
                <{$smarty.const._MA_JILL_NOTICE_CATE_TITLE}>
            </label>
            <div class="col-sm-6">
                <input type="text" name="cate_title" id="cate_title" class="form-control  validate[required]" value="<{$OneCate.cate_title}>" placeholder="<{$smarty.const._MA_JILL_NOTICE_CATE_TITLE}>">
            </div>
        </div>

        <!--分類說明-->
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">
                <{$smarty.const._MA_JILL_NOTICE_CATE_DESC}>
            </label>
            <div class="col-sm-10">
                <input type="text" name="cate_desc" id="cate_desc" class="form-control " value="<{$OneCate.cate_desc}>" placeholder="<{$smarty.const._MA_JILL_NOTICE_CATE_DESC}>">
            </div>
        </div>

        <!--發布群組-->
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">
                <{$smarty.const._MA_JILLNOTICE_POST_GROUP}>
            </label>
            <div class="col-sm-10">
                <select name="post_group[]" class="form-control" size='10' multiple>
                    <{foreach from=$post_group key=k item=unit}>
                    <option value=<{$k}> <{if $k|in_array:$OneCate.post_group}>selected<{/if}> >
                      <{$unit}>
                    </option>
                    <{/foreach}>
                  </select>
            </div>
        </div>
        <!--閱讀群組-->
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">
                <{$smarty.const._MA_JILLNOTICE_READ_GROUP}>
            </label>
            <div class="col-sm-10">
                <select name="read_group[]" class="form-control" size='10' multiple>
                    <{foreach from=$read_group key=r item=read}>
                    <option value=<{$r}> <{if $r|in_array:$OneCate.read_group}>selected<{/if}> >
                      <{$read}>
                    </option>
                    <{/foreach}>
                  </select>
            </div>
        </div>

        <div class="text-center">
            <{$token_form}>
                <input type="hidden" name="next_op" value="<{$next_op}>">
                <input type="hidden" name="op" value="<{$now_op}>">
                <input type="hidden" name="cate_sn" value="<{$OneCate.cate_sn}>">
                <input type="submit" name="send" value="<{$smarty.const._TAD_SAVE}>" class="btn btn-primary" />
        </div>
    </form>
</div>