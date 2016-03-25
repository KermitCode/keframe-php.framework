				<div class="span10">
					<h3><?php echo $this->pageName;?></h3>
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>序号</th>
								<th>评价用户</th>
                                <th>文章标题</th>
                                <th>评价时间</th>
                                <th>评价IP</th>
                                <th>操作</th>
							</tr>
						</thead>
						<tbody>
                        <?php 
						$i=1;foreach($this->comData as $k=>$row){?>
							<tr>
								<td><?php echo $i;?></td>
								<td><?php echo $row['com_uid'];?></td>
								<td><a href="<?php echo $this->makeUrl('/article/view',array('id'=>$row['com_arid']));?>" target="_blank"><?php echo $this->titleArr[$row['com_arid']];?></a></td>
                                <td><?php echo date('Y-m-d H:i:s',$row['com_time']);?></td>
                                <td><?php echo $row['com_ip'];?></td>
                                <td><?php 
									echo "<a href='".$this->makeUrl('comment/delete',array('id'=>$row['id']))
				."'><button class='btn btn-info btn-small' type='button' >删除</button></a>";?>
                                </td>
							</tr>
                            <tr><td colspan="6">
                                  评价内容：<?php echo $row['com_text'];?>
                            </td></tr>
                        <?php $i++;}?>
						</tbody>
					</table>
                     <div class="text-right pagination" style="text-align:right;">
                        <ul>
                            <?php echo $this->KePage->makeBootpage(8);?>
                        </ul>
                     </div>
                 </div>
                 