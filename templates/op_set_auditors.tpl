<script type="text/javascript" src="<{$xoops_url}>/modules/jill_notice/js/tmt_core.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/jill_notice/js/tmt_spry_linkedselect.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/jill_notice/js/auditors.js"></script>
<div class="container">
    <h2 class="text-center">
        <a href="<{$xoops_url}>/modules/jill_notice/admin/main.php">
            <{$OneCate.cate_title}> <i class="fa fa-external-link" aria-hidden="true"></i>
        </a>

    </h2>
    <form action="<{$action}>" method="post" id="myForm" enctype="multipart/form-data" class="form-horizontal" role="form">
        <input type='hidden' name='auditors' id='auditors' value='<{$OneCate.auditors}>'>
        <input type="hidden" name="cate_sn" value="<{$OneCate.cate_sn}>">
        <div class="row">
            <div class="col-sm-5">
                <h3 class="text-center text-info">
                    <{$smarty.const._MA_JILLNOTICE_ALLUSERS}>
                </h3>
                <select name='repository' id='repository' size='12' multiple='multiple' tmt:linkedselect='true' class='col-sm-12'>
            <{foreach from=$user_menu key=uid item=data}>
              <option value="<{$uid}>">
                <{$data}>
              </option>
            <{/foreach}>
          </select>
            </div>
            <div class="col-sm-2">
                <p class="lead" style="margin-top: 50px">
                    <button type="button" class="btn  btn-block" onclick="tmt.spry.linkedselect.util.moveOptions('repository', 'destination');gettmtOptions();"><img src="../images/right.png"></button>
                    <button type="button" class="btn  btn-block" onclick="tmt.spry.linkedselect.util.moveOptions('destination', 'repository');gettmtOptions();"><img src="../images/left.png"></button><br>
                    <input type="hidden" name="op" value="update_auditors">
                    <input type="submit" name="send" value="<{$smarty.const._TAD_SAVE}>" class="btn-lg btn-block btn-primary" />
                </p>
                <{$token_form}>
            </div>
            <div class="col-sm-5">
                <h3 class="text-info text-center">
                    <{$smarty.const._MA_JILLNOTICE_AUDITORS}>
                </h3>
                <select name='destination' id='destination' size='12' multiple='multiple' tmt:linkedselect='true' class='col-sm-12'>
            <{if $OneCate.auditor_group}>
              <{foreach from=$OneCate.auditor_group key=uid_auditor item=auditor}>
                <option value="<{$uid_auditor}>">
                  <{$auditor}>
                </option>
              <{/foreach}>
            <{/if}>
          </select>
            </div>
        </div>
    </form>
</div>