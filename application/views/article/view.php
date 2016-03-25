    <link rel="stylesheet" href="<?php echo $this->imagesUrl;?>frontdir/highlight/styles/default.css">
    <script src="<?php echo $this->imagesUrl;?>frontdir/highlight/highlight.min.js"></script>
	<article id="post-358" class="entry post publish author-hwijaya post-358 format-standard category-post-formats post_tag-post-formats post_tag-readability post_tag-standard-2">	
		<div class="entry-wrap">
			<header class="entry-header">
            	<h1 class="entry-title"><?php echo $this->pageData['ar_title'];?></h1>
                <div class="entry-meta">
                    <time class="entry-time"><?php echo date('H:i:s F j, Y -l',$this->pageData['ar_time']);?></time>
                    <span class="entry-author" >by <a href="<?php echo $this->webUrl;?>" title="04007.cn" rel="author" class="url fn n"><span itemprop="name">04007</span></a> <span style="margin-left:100px;font-size:11px;font-family:楷体gb2312;font-style:normal;color:#993;">本站原创文章,转载请注明文章出处：www.04007.cn</span></span>	
                </div>
            </header>
                            
            <div class="entry-content" itemprop="articleBody">
                <?php echo $this->pageData['ar_text'];?>
            </div>
            <footer class="entry-footer">
                 <div class="entry-meta right">
                     <span class="entry-terms post_tag">
                       Tags：<?php $tagArr=explode(',',$this->pageData['ar_tags']);
					   foreach($tagArr as $value){
						   if($value) echo "<a href='javascript:void(0);' rel='tag'>{$value}</a>,";
					   }?> View(<?php echo $this->pageData['ar_view'];?>)
                     </span>	
                  </div>
             </footer>
         </div>
    </article>
    
    <div style="display:none;" id="loadimg">
    	<div class="text-center"><img src="<?php echo $this->imagesUrl;?>frontdir/load.gif" /></div>
    </div>
    <article id="pagecomment" class="entry post publish">
    </article>
    
    <article id="post-358" class="entry post publish author-hwijaya">
        <form>
            <textarea name="textarea" class="irt-message" id="comarea"></textarea>
            <div class="zhan" id="zhan">
    限制<INPUT disabled class="charn" value="200"> 已用 <INPUT disabled name="used" class="charn" value="0">剩余<INPUT disabled name="remain" class="charn" value="200">&nbsp;<input type="button" id="subcomment" value="提交评论" class="irt-message-submit"/>
            <input type="hidden" id="arid" value="<?php echo $this->pageData['id']?>" />
            </div>
        </form>
    </article>
    <script language="javascript">
	hljs.initHighlightingOnLoad();
	$(document).ready(function(){
		$.getLen=function(str){return str.replace(/[^\x00-\xff]/g, '**').length;};
		$.cutstr=function(str,len){    
			 var str_length = 0;    
			 var str_len = 0;    
			 str_cut = new String();    
			 str_len = str.length;    
			 for(var i = 0; i < str_len; i++)    {    
				 a = str.charAt(i);    
				 str_length++;    
				 if(escape(a).length >4){str_length++;    }    
				 str_cut = str_cut.concat(a);    
				 if(str_length>=len){    
					 str_cut = str_cut.concat("...");    
					 return str_cut;}    
				 }        
			 if(str_length < len){return str;}    
		};
		$.gbcount=function(){
			var message=$("#comarea");
			var used=$("input[name='used']");
			var remain=$("input[name='remain']");
			var len=$.getLen(message.val());
			if(len>200){
				message.val($.cutstr(message.val(),200));
				used.val(200);remain.val(0);
				alert("留言不能超过200个字符!");
			}else {used.val(len);remain.val(200 - len);}
		};
		$("#comarea").keyup(function(){$.gbcount();});
		$("#subcomment").click(function(){
			var mess=$.trim($("#comarea").val());
			if(mess=='' || mess.length<5){alert('评论未写或字数过少');return false;}
			var id=$("#arid").val();
			$.post("<?php echo $this->makeUrl('article/comment');?>",{"mess":mess,'id':id},
				function(data){
					if(data.rs==0){alert(data.message);}
					else{
						$("#pagecomment").html(data.message+$("#pagecomment").html());
						$("#comarea").val('');
					}
				}
			,'json');
		});
		//评论加载
		$("#pagecomment").html($("#loadimg").html());
		$.get("<?php echo $this->makeUrl('article/loadcom',array('id'=>$this->pageData['id']));?>",{},
			function(data){
				$("#pagecomment").html(data);
			}
		,'text');
		$('#pagecomment').delegate('.pagination a', 'click', function(e) {
			e.preventDefault();
			$('#pagecomment').html($("#loadimg").html());
			$('#pagecomment').load(this.href);
			$('#pagecomment').fadeIn('fast');
		});
	});
    </script>
