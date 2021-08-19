<{if $def_type=="img"}>
  <!--標題-->
  <div class="form-group row">
    <label class="col-sm-2 col-form-label text-md-right">
      <{$smarty.const._MD_JILLNOTICE_TITLE}>
    </label>
    <div class="col-sm-10">
      <input type="text" name="title" id="title" class="form-control validate[required]" value="<{$OneNotice.title}>" placeholder="<{$smarty.const._MD_JILLNOTICE_TITLE}>" maxlength="40" minlength="2" title='notice'>
    </div>
  </div>
  <!--內文-->
  <div class="form-group row">
    <label class="col-sm-2 col-form-label text-md-right">
      <{$smarty.const._MD_JILLNOTICE_CONTENT}>
    </label>
    <div class="col-sm-10">
      <textarea name="content" rows=8 id="content" class="form-control " placeholder="<{$smarty.const._MD_JILLNOTICE_CONTENT}>"><{$OneNotice.content}></textarea>
    </div>
  </div>
  <!--上傳-->
  <div class="form-group row">
    <label class="col-sm-2 col-form-label text-md-right">
      <{$smarty.const._MD_JILLNOTICE_SHOW_SN_IMG}>
      <p class="help-block"><{$smarty.const._MD_JILLNOTICE_SQUARE}></p>
    </label>
    <div class="col-sm-10">
      <{$up_sn_form}>
    </div>
  </div>
<{elseif $def_type=="textarea"}>
  <!--標題-->
  <div class="form-group row">
    <label class="col-sm-2 col-form-label text-md-right">
      <{$smarty.const._MD_JILLNOTICE_TITLE}>
    </label>
    <div class="col-sm-10">
      <input type="text" name="title" id="title" class="form-control" value="<{$OneNotice.title}>" placeholder="<{$smarty.const._MD_JILLNOTICE_TITLE}>" title='notice'>
    </div>
  </div>
  <!--內文-->
  <div class="form-group row">
    <label class="col-sm-2 col-form-label text-md-right">
      <{$smarty.const._MD_JILLNOTICE_CONTENT}>
    </label>
    <div class="col-sm-10">
      <textarea name="content" rows=8 id="content" class="form-control " placeholder="<{$smarty.const._MD_JILLNOTICE_CONTENT}>"><{$OneNotice.content}></textarea>
    </div>
  </div>
<{elseif $def_type=="ckeditor"}>
  <!--內文-->
  <div class="form-group row">
    <label class="col-sm-2 col-form-label text-md-right">
      <{$smarty.const._MD_JILLNOTICE_CONTENT}>
    </label>
    <div class="col-sm-10">
      <{$editor_content}>
    </div>
  </div>
<{elseif $def_type=="url"}>
  <!--標題-->
  <div class="form-group row">
    <label class="col-sm-2 col-form-label text-md-right">
      <{$smarty.const._MD_JILLNOTICE_TITLE}>
    </label>
    <div class="col-sm-10">
      <input type="text" name="title" id="title" class="form-control validate[required]" value="<{$OneNotice.title}>" placeholder="<{$smarty.const._MD_JILLNOTICE_TITLE}>" title='notice'>
    </div>
  </div>
  <!--網址-->
  <div class="form-group row">
    <label class="col-sm-2 col-form-label text-md-right">
      <{$smarty.const._MD_JILLNOTICE_URL}>
    </label>
    <div class="col-sm-10">
      <input type="text" name="content" id="content" class="form-control validate[required,custom[url]]" value="<{$OneNotice.content}>" placeholder="<{$smarty.const._MD_JILLNOTICE_URL}>" title='notice'>
    </div>
  </div>
  <!--上傳-->
  <div class="form-group row">
    <label class="col-sm-2 col-form-label text-md-right">
      <{$smarty.const._MD_JILLNOTICE_SHOW_SN_IMG}>
      <p class="help-block"><{$smarty.const._MD_JILLNOTICE_RECTANGLE}></p>
    </label>
    <div class="col-sm-10">
      <{$up_sn_form}>
    </div>
  </div>
<{else}>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label text-md-right">
      <{$smarty.const._MD_JILLNOTICE_TITLE}>
    </label>
    <div class="col-sm-10">
      <input type="text" name="title" id="title" class="form-control validate[required]" value="<{$OneNotice.title}>" placeholder="<{$smarty.const._MD_JILLNOTICE_TITLE}>" title='notice'>
    </div>
  </div>
  <!--上傳-->
  <div class="form-group row">
    <label class="col-sm-2 col-form-label text-md-right">
      <{$smarty.const._MD_JILLNOTICE_SHOW_SN_FILES}>
    </label>
    <div class="col-sm-10">
      <{$up_sn_form}>
    </div>
  </div>
<{/if}>
