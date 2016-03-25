				<div class="span10">
					<h3><?php echo $this->pageName;?></h3>
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>序</th>
								<th>归类</th>
                                <th>资源标题</th>
                                <th>加入时间</th>
                                <th>下载URL</th>
                                <th>下载</th>
                                <th>操作</th>
							</tr>
						</thead>
						<tbody>
                        <?php 
						$i=1;foreach($this->downData as $k=>$row){?>
							<tr>
								<td><?php echo $i;?></td>
                                <td><?php echo $row['sortchar'];?></td>
								<td><a href="<?php echo $this->KE('keUrl')->makeUrl('download/view',array('id'=>$row['id']));?>" target="_blank"><?php echo $row['title'];?></a>
                                <br /><?php echo $row['filepath'];?></td>
                                <td><?php echo date('m-d H:i:s',$row['addtime']);?></td>
                                <td><?php echo $this->getSet('baseUrl')."download/{$row['id']}.html";?></td>
                                <td><?php echo $row['downloads'];?></td>
                                <td><?php 
									echo "<a href='".$this->KE('keUrl')->makeUrl('kermit/download/add',array('id'=>$row['id']))
				."'><button class='btn btn-success btn-small' type='button' >修改</button></a>&nbsp;&nbsp;";
									echo "<a href='".$this->KE('keUrl')->makeUrl('kermit/download/delete',array('id'=>$row['id']))
				."'><button class='btn btn-info btn-small' type='button' >删除</button></a>";?>
                                </td>
							</tr>
                        <?php $i++;}?>
						</tbody>
					</table>
                     <div class="text-right pagination" style="text-align:right;">
                        <ul>
                            <?php echo $this->KE('kePage')->makeBootpage(8);?>
                        </ul>
                     </div>
                 </div>
                 