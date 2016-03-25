				<div class="span10">
					<h3><?php echo $this->pageName;?></h3>
					<form id="edit-profile" class="form-horizontal" method="post" action="<?php echo $this->makeUrl('setting/save');?>">
						<fieldset>
							<legend></legend>
                            <h4>网站基本信息设置：</h4>
							<div class="control-group">
								<label class="control-label" for="input01">网站状态：</label>
								<div class="controls">
									<?php echo HtmlHelp::radio('web_open',array(0=>'关闭',1=>'运行'),$this->setting['web_open']);?>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input01">网站关闭时显示信息：</label>
								<div class="controls">
									<textarea class="input-large" style="width:80%;height:50px;" name="web_close_words" /><?php echo $this->setting['web_close_words'];?></textarea>
								</div>
							</div>
                            <div class="control-group">
								<label class="control-label" for="input01">网站名称：</label>
								<div class="controls">
									<input class="input-large" type="text" name="web_name" value="<?php echo $this->setting['web_name'];?>" />
								</div>
							</div>
                            <div class="control-group">
								<label class="control-label" for="input01">网站关键词设置：</label>
								<div class="controls">
									<input class="input-large" type="text" style="width:80%;" name="web_keyword" value="<?php echo $this->setting['web_keyword'];?>" />
								</div>
							</div>
                            <div class="control-group">
								<label class="control-label" for="input01">网站关描述信息：</label>
								<div class="controls">
									<textarea class="input-large" style="width:80%;height:50px;" name="web_description" /><?php echo $this->setting['web_description'];?></textarea>
								</div>
							</div>
                            <div class="control-group">
								<label class="control-label" for="input01">网站备案号：</label>
								<div class="controls">
									<input type="text" class="input-middle" name="web_beian" value="<?php echo $this->setting['web_beian'];?>" />
                                </div>
							</div>
                            
                            
							<div class="control-group">
								<label class="control-label" for="input01">网站统计代码：</label>
								<div class="controls">
									<textarea class="input-large" style="width:80%;height:80px;" name="web_stat" /><?php echo $this->setting['web_stat'];?></textarea>
								</div>
							</div>
							<div class="row text-center" style="padding-left:250px;">
                            	<button type="submit" class="btn btn-primary">保存设置数据</button>
                            </div>
                            

                            <!--<h4>网站基本信息设置：</h4>-->
						</fieldset>
					</form>
				</div>