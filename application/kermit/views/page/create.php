				<div class="span10">
                <style>form {margin: 0;}textarea {display: block;}</style>
                <link rel="stylesheet" href="<?php echo $this->imagesUrl;?>kindeditor4.1/themes/default/default.css" />
				<script charset="utf-8" src="<?php echo $this->imagesUrl;?>kindeditor4.1/kindeditor-min.js"></script>
                <script charset="utf-8" src="<?php echo $this->imagesUrl;?>kindeditor4.1/lang/zh_CN.js"></script>
					<h3><?php echo $this->pageName;?></h3>
					<form id="edit-profile" class="form-horizontal" method="post" action="<?php echo $this->makeUrl('page/pagesub'); ?>" onsubmit="return checkform()">
						<fieldset>
							<legend></legend>
							<div class="control-group">
								<label class="control-label" for="input01">文章标题：</label>
								<div class="controls">
									<input class="input-large" type="text" style="width:80%;" name="ar_title" value="<?php echo $this->pageData['ar_title'];?>" />
								</div>
							</div>
                            <div class="control-group">
								<label class="control-label" for="input01">是否推荐：</label>
								<div class="controls">
									<?php echo HtmlHelp::radio('ar_tui',array(1=>'推荐',0=>'不推荐'),$this->pageData['ar_tui']);?>
								</div>
							</div>
                            <div class="control-group">
								<label class="control-label" for="input01">发表在哪类：</label>
								<div class="controls">
									<?php echo HtmlHelp::select('ar_cid',$this->category,$this->pageData['ar_cid']);?>
								</div>
							</div>
                            <div class="control-group">
								<label class="control-label" for="input01">文章标签：</label>
								<div class="controls">
									<input class="input-large"  style="width:60%;" type="text" name="ar_tags" value="<?php echo $this->pageData['ar_tags'];?>" />
								</div>
							</div>
                            <small class="text-success">要插入php代码，请在PHP代码前换行输入 phpcode-再换行展示代码，结束后换后输入:-phpcode再换行</small>
							<div class="control-group">
                            <textarea class="input-large" style="width:100%;min-height:500px;" name="ar_text" /><?php echo stripslashes($this->pageData['ar_text']);?></textarea>
							</div>
    
							<div class="row text-center" style="padding-left:250px;">
                            	<button type="submit" class="btn btn-primary">保存文章</button>
                                <input type="hidden" name="id" value="<?php echo $this->pageData['id'];?>" />
                            </div>
                            <script>
								KindEditor.ready(function(K) {
									K.create('textarea[name="ar_text"]', {
										autoHeightMode : true,
										uploadJson : '<?php echo $this->makeUrl('page/upload');?>',
										afterCreate : function() {
											this.loadPlugin('autoheight');
										}
									});
								});
								function checkform(){
									KindEditor.sync();	
									if(document.getElementsByName('ar_title')[0].value=='' ||
									   document.getElementsByName('ar_tags')[0].value==''){
										alert('未填写完整!');return false;
									}else{return true;}
								}
							</script>
						</fieldset>
					</form>
				</div>