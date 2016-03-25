				<div class="span10">
					<h3><?php echo $this->pageName;?></h3>
					<form id="edit-profile" class="form-horizontal" method="post" action="<?php echo $this->makeUrl('class/postclass');?>">
						<fieldset>
							<legend></legend>
							<div class="control-group">
								<label class="control-label" for="input01">类目名称：</label>
								<div class="controls">
									<input type="text" class="input-middle"  name="class_name" value="<?php 
									echo isset($this->classData['class_name'])?$this->classData['class_name']:'';?>" />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input01">类目完整名称：</label>
								<div class="controls">
									<input type="text" class="input-middle" name="class_fname" value="<?php 
									echo isset($this->classData['class_fname'])?$this->classData['class_fname']:'';?>" />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input01">类目排序值：</label>
								<div class="controls">
									<input type="text" class="input-small" name="class_sort" value="<?php 
									echo isset($this->classData['class_sort'])?$this->classData['class_sort']:'';?>" />
								</div>
							</div>
							<div class="row text-center" style="padding-left:250px;">
                            	<input type="hidden" name="id" value="<?php 
								echo isset($this->classData['id'])?$this->classData['id']:'';?>"  />
                            	<button type="submit" class="btn btn-primary">保存类目</button>
                            </div>
						</fieldset>
					</form>
				</div>