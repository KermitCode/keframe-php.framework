				<div class="span10">
					<h3><?php echo $this->pageName;?></h3>
					<form id="edit-profile" class="form-horizontal" method="post" action="<?php echo $this->KE('keUrl')->makeUrl('kermit/setting/friend');?>">
						<fieldset>
							<legend></legend>
							<div class="control-group">
								<label class="control-label" for="input01">友情链接列表：</label>
								<div class="controls">
									<textarea class="input-large" style="width:800px;height:600px;" name="link" /><?php echo $this->link;?></textarea>
								</div>
							</div>
							<div class="row text-center" style="padding-left:250px;">
                            	<button type="submit" class="btn btn-primary">保存链接数据</button>
                            </div>
                            <!--<h4>网站基本信息设置：</h4>-->
						</fieldset>
					</form>
				</div>