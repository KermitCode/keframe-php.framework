				<div class="span10">
					<h3><?php echo $this->pageName;?></h3>
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>序号</th>
								<th>用户唯一标记</th>
                                <th>页面标题</th>
                                <th>访问时间</th>
                                <th>访问IP</th>
							</tr>
						</thead>
						<tbody>
                        <?php 
						$i=1;foreach($this->visitData as $k=>$row){?>
							<tr>
								<td><?php echo $i;?></td>
								<td><a href="<?php echo $this->KE('keUrl')->makeUrl('kermit/visit/user',array('uid'=>$row['uid']));?>"><?php echo $row['uid'];?></a></td>
								<td><a href="<?php echo $row['url'];?>" target="_blank"><?php echo $row['title'];?></a></td>
                                <td><?php echo date('Y-m-d H:i:s',$row['cometime']);?></td>
                                <td><?php echo $row['ip'];?></td>
							</tr>
                            <tr>
                            	<td colspan="5">Agent：<?php echo $row['content'];?><br />来源：<?php echo $row['fromurl'];?></td>
                            </tr>
                        <?php $i++;}?>
						</tbody>
					</table>
                     <div class="text-right pagination" style="text-align:right;">
                        <ul>
                            <?php echo $this->KE('kePage')->makeBootpage(8,array('uid'));?>
                        </ul>
                     </div>
                 </div>
                 