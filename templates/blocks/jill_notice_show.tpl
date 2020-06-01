<style>
  .notice-fluid{
    margin:10px 0;
    color: #666;
  }
  .media-heading {
    margin: 5px 0 20px 0;
  }
  .col {
    padding: 20px;
  }
  .media-object{
    height:140px;
    width: 100%*140px;
    display: block;
  }
</style>
<div class="notice-fluid">
  <{foreach from=$block.content key=type item=c}>
    <{if $type=="url"}>
      <ul class="vertical_menu">
        <{foreach from=$c item=data }>
          <li class="list-group-item">
            <a href='<{$data.content}>' target='_blank'><{if $data.list_file}><img src="<{$data.list_file}>" class="img-fluid" alt="<{$data.title}>" style="margin-right: 4px;"><{else}><{$data.title}><{/if}></a>
          </li>
        <{/foreach}>
      </ul>
    <{elseif $type=="img"}>
      <div class='row' >
        <{foreach from=$c item=data}>
          <{if $data.content}>
            <div class="col-sm-12 col">
              <div class="media">
                <div class="media-left mr-2">
                  <{$data.list_file}>
                </div>
                  <div class="media-body">
                    <h4 class="media-heading"><a href="#"><{$data.title}></a></h4>
                    <p><{$data.content|nl2br}></p>
                  </div>
              </div>
          <{else}>
            <div class="col-xs-6 col-sm-6 col">
                <{$data.list_file}>
            </div>
          <{/if}>
          </div>
        <{/foreach}>
      </div>
    <{elseif $type=="textarea" || $type=="ckeditor"}>
      <div class="list-group ml-2">
        <{foreach from=$c item=data}>
          <h4 class="list-group-item-heading"><{$data.title}></h4>
          <p class="list-group-item-text"><{if $type=="textarea"}><{$data.content|nl2br}><{else}><{$data.content}><{/if}></p>
        <{/foreach}>
      </div>
    <{else}>
      <{foreach from=$c item=data }>
        <{if $data.list_file}>
          <{foreach from=$data.list_file key=file_sn item=f }>
            <div class="row ml-2">
              <h5 class="card-title"><a href="<{$xoops_url}>/modules/jill_notice/index.php?op=tufdl&files_sn=<{$file_sn}>#<{$f.show_file_name}>" class="iconize"><{$data.title}></a></h5>
            </div>
          <{/foreach}>
        <{else}>
          <div class="row"">
            <h5 class="card-title text-center"><{$data.title}></h5>
          </div>
        <{/if}>
      <{/foreach}>
    <{/if}>
  <{/foreach}>
</div>
