				<div class="span10">
					<h3><?php echo $this->pageName;?></h3>
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>序号</th>
								<th>简短类目名称</th>
                                <th>文章总数</th>
                                <th>详细名称</th>
                                <th>排序值</th>
                                <th>操作</th>
							</tr>
						</thead>
						<tbody>
                        <?php 
						$i=1;foreach($this->classAll as $k=>$row){?>
							<tr>
								<td><?php echo $i;?></td>
								<td><?php echo $row['class_name'];?></td>
                                <td><?php echo isset($this->classNum[$row['id']])?$this->classNum[$row['id']]:0;?></td>
								<td><?php echo $row['class_fname'];?></td>
                                <td><?php echo $row['class_sort'];?></td>
                                <td><?php // if($this->showData['expire'][$k]){
									echo "<a href='".$this->KE('keUrl')->makeUrl('kermit/class/modify',array('id'=>$row['id']))
									."'><button class='btn btn-success btn-small' type='button' >修改</button></a>";?></td>
							</tr>
                        <?php $i++;}?>
						</tbody>
					</table>
                 </div>