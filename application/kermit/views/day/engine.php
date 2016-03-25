				<div class="span10">
					<h3><?php echo $this->pageName;?></h3>
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>序号</th>
								<th>搜索引擎</th>
                                <th>访问日期</th>
                                <th>访问次数</th>
                                <th>引擎抓取记录</th>
							</tr>
						</thead>
						<tbody>
                        <?php 
						$i=1;foreach($this->pageData as $k=>$row){?>
							<tr>
								<td><?php echo $i;?></td>
								<td><a href="<?php echo $this->makeUrl('visit/engine',array('sprider'=>$row['sprider']));?>"><?php echo $row['sprider'];?></a></td>
                                <td><?php echo $row['date'];?></td>
                                <td><?php echo $row['nums'];?></td> 
                                <td><a href="<?php echo $this->makeUrl('visit/engine',array('sprider'=>$row['sprider']));?>">引擎行为记录</a></td> 
							</tr>
                        <?php $i++;}?>
						</tbody>
					</table>
                     <div class="text-right pagination" style="text-align:right;">
                        <ul>
                            <?php echo $this->KePage->makeBootpage(8);?>
                        </ul>
                     </div>
                 </div>
                 