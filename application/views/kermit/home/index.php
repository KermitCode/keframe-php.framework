				<div class="span10">
					<h3><?php echo $this->pageName;?></h3>
					<div class="well summary">
						<ul>
							<li><span class="count"><?php echo $this->pagenum;?></span> 总文章数</li>
                            <li><span class="count"><?php echo $this->viewnum;?></span> 文章总浏览人次</li>
							<li><span class="count"><?php echo $this->commentnum;?></span>总评论数</li>
                            <li><?php if($this->daynum){?>
                            
								<?php if($this->daynum!=1){?>
								<span class="count"><?php echo $this->daynum;?></span>天没发表新文章了
								<?php }else{ 
										echo '<span class="count">^_^</span>今天未发表';
								}?>
								</li>
							<?php }else{?>
                            <span class="count">^_^</span>.....today 已发表文章</li>
							<?php }?>
						</ul>
                        <ul>
							<li><span class="count"><?php echo $this->webviewnum;?></span>今日网站浏览量</li>
							<li><span class="count"><?php echo $this->usersday;?></span>今日来访用户数</li>
                            <li><span class="count"><?php echo $this->commentday;?></span>今日评论数</li>
							<li><span class="count"><?php echo $this->spriderday;?></span>今日蜘蛛抓取数</li>
                        </ul>
					</div>
                    <div id="stat" style="min-width:310px; height: 400px; margin: 0 auto;"></div>
                    <script type="text/javascript" src="<?php echo $this->getSet('imagesUrl');?>highcharts/js/modules/exporting.js"></script>
                    <script type="text/javascript" src="<?php echo $this->getSet('imagesUrl');?>highcharts/js/highcharts.js"></script>
					<script type="text/javascript">
					$(function() {
							$('#stat').highcharts({
								chart: {type: 'line'},
								title: {text: '近一个月网站浏览量变化'},
								xAxis: {categories: [<?php echo $this->dayChar;?>]},
								yAxis: {title: {text: '次数'},min:0},
								plotOptions: {line: {dataLabels: {enabled: true},enableMouseTracking: false}},
								series: [
								{name: '网站总浏览量',data: [<?php echo implode(',',$this->dayStat);?>]},
								{name: '独立访问用户数',data: [<?php echo implode(',',$this->userStat);?>]},
								{name: '百度抓取数',data: [<?php echo implode(',',$this->EngineStat);?>]},
								]
							});
						});
					</script>
                 </div>