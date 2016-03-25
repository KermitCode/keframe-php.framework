				<div class="span10">
					<h3><?php echo $this->pageName;?></h3>
					<script src="<?php echo $this->getSet('imagesUrl');?>uploadify/jquery.uploadify.min.js"></script>
                    <link href="<?php echo $this->getSet('imagesUrl');?>uploadify/uploadify.css" rel="stylesheet">
					<form id="edit-profile" class="form-horizontal" method="post" action="<?php echo $this->KE('keUrl')->makeUrl('kermit/download/fileadd'); ?>" onsubmit="return checkform()">
						<fieldset>
							<legend></legend>
							<div class="control-group">
								<label class="control-label" for="input01">资源标题：</label>
								<div class="controls">
									<input class="input-large" type="text" style="width:80%;" name="title" value="<?php echo $this->downData['title'];?>" />
								</div>
							</div>
                            <div class="control-group">
								<label class="control-label" for="input01">归类排序：</label>
								<div class="controls">
									<input class="input-large" type="text" name="sortchar" value="<?php echo $this->downData['sortchar'];?>" />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input01">关联文章：</label>
								<div class="controls">
                                	<?php if($this->titleArr){
										$i=1;
										foreach($this->titleArr as $tid=>$title){
											echo "{$i}. $title.<br>";	
										}	
									}else echo '<small>暂未关联文章,发表文章里带上链接后会自动关联文章.</small>';?>
								</div>
							</div>
                            <div class="control-group">
								<label class="control-label" for="input01">文件路径：</label>
								<div class="controls">
									<input class="input-large" type="text" name="filepath" value="<?php echo $this->downData['filepath'];?>" />
								</div>
							</div>
                            <div class="control-group">
								<label class="control-label" for="input01">上传文件：</label>
								<div class="controls">
                                	<div id="queue"></div>
									<input id="file_upload" name="file_upload" type="file" multiple="true">
								</div>
							</div>
							<div class="row text-center" style="padding-left:250px;">
                            	<button type="submit" class="btn btn-primary">保存资源</button>
                                <input type="hidden" name="id" value="<?php echo $this->downData['id'];?>" />
                            </div>
						</fieldset>
					</form>
				</div>
                <script type="text/javascript">
					$(function() {
						$('#file_upload').uploadify({
							'buttonText':'选择文件',
							'swf'      : '<?php echo $this->getSet('imagesUrl');?>uploadify/uploadify.swf',
							'uploader' : '<?php echo $this->KE('keUrl')->makeUrl('kermit/download/upfile'); ?>',
							'removeCompleted' : false,
							'onUploadSuccess' : function(file, data, response) {
								if(data=='0'){alert('上传失败!');}
								else{
									$("input[name='filepath']").val(data);
									alert('上传成功，请点击保存资源');	
								}
							}
						});
					});
				</script>