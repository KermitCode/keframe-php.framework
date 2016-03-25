				<div class="span10">
					<h3><?php echo $this->pageName;?></h3>
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>序</th>
								<th>所属类目</th>
                                <th>文章标题</th>
                                <th>推荐</th>
                                <th>发表时间</th>
                                <th>阅</th>
                                <th>评</th>
                                <th>操作</th>
							</tr>
						</thead>
						<tbody>
                        <?php 
						$i=1;foreach($this->pageData as $k=>$row){?>
							<tr>
								<td><?php echo $i;?></td>
								<td><?php echo $this->cate[$row['ar_cid']]['cn'];?></td>
								<td><a href="<?php echo $this->KE('keUrl')->makeUrl('article/view',array('id'=>$row['id']));?>" target="_blank"><?php echo $row['ar_title'];?></a></td>
                                <td><?php echo $row['ar_tui']?'<font color=red>是</font>':'否';?></td>
                                <td><?php echo date('Y-m-d H:i:s',$row['ar_time']);?></td>
                                <td><?php echo $row['ar_views'];?></td>
                                <td><?php echo $row['ar_comments'];?></td>
                                <td><?php 
									echo "<a href='".$this->KE('keUrl')->makeUrl('kermit/page/create',array('id'=>$row['id']))
				."'><button class='btn btn-success btn-small' type='button' >修改</button></a>&nbsp;&nbsp;";
									echo "<a href='".$this->KE('keUrl')->makeUrl('kermit/page/delete',array('id'=>$row['id']))
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
                 