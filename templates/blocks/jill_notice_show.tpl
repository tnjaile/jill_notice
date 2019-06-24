<style>
  .container-fluid{
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
<div class="container-fluid">
  <{foreach from=$block.content key=cate item=c}>    
    <{if $cate=="url"}>
      <div class="list-group">
        <{foreach from=$c item=data }>          
          <li class="list-group-item">
            <a href="<{$data.content}>" target="_blank"><{$data.title}></a>
          </li>          
        <{/foreach}>
      </div>
    <{elseif $cate=="img"}>
      <div class='row' > 
        <{foreach from=$c item=data}>
          <{if $data.content}>
            <div class="col-sm-12 col">
              <div class="media">
                <div class="media-left">
                  <a href="#">
                    <img src="<{$xoops_url}>/uploads/jill_notice/image/sn_1_1.png" alt="<{$data.title}>" class="media-object" ></a>
                </div>              
                  <div class="media-body">
                    <h4 class="media-heading"><a href="#"><{$data.title}></a></h4>
                    <p><{$data.content}></p>
                  </div>
              </div>
          <{else}>
            <div class="col-xs-6 col-sm-6 col">
              <a href="#" class="thumbnail">
                <img src="<{$xoops_url}>/uploads/jill_notice/image/sn_1_1.png" alt="<{$data.title}>" >
              </a>
            </div>
          <{/if}>
          </div>
        <{/foreach}>
      </div>
    <{elseif $cate=="textarea"}>
      <div class="list-group">
        <{foreach from=$c item=data}>          
          <h4 class="list-group-item-heading"><{$data.title}></h4>
          <p class="list-group-item-text"><{$data.content}></p>        
        <{/foreach}>
      </div>
    <{else}>
      <ul class="list-group">
        <{foreach from=$c item=data }>          
          <li class="list-group-item list-group-item-info"><{$data.title}></li>
        <{/foreach}>
      </ul>
    <{/if}>    
  <{/foreach}>
</div>
