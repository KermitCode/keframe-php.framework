				<div class="span9">
					<h3>后台管理首页</h3>
					<div class="well summary">
						<ul>
							<li><span class="count"><?php #echo $this->showData['tokennum'];?></span> 个TOKEN授权</li>
                            <li><span class="count"><?php #echo $this->showData['adminnum'];?></span> 名管理员</li>
							<li><span class="count"><?php #echo $this->showData['adtimes'];?></span> 管理员登录次数</li>
                            <li><span class="count"><?php #echo $this->showData['record'];?></span> 接口调用次数</li>
						</ul>
                        <ul>
							<li><span class="count"><?php #echo $this->showData['pvid'];?></span> PVID值个数</li>
							<li><span class="count"><?php ##echo $this->showData['tbsearch'];?></span> 条搜索数据缓存</li>
							<li><span class="count"><?php #echo $this->showData['tbproduct'];?></span> 条产品数据缓存</li>
							<li><span class="count"><?php #echo $this->showData['tbcomment'];?></span> 条评论数据缓存</li>
                        </ul>
					</div>
					<h3>接口半月调用次数统计</h3>
                    <div id="stat" style="min-width:310px; height: 400px; margin: 0 auto;"></div>
                    <script type="text/javascript" src="<?php #echo JSURL;?>/highcharts/js/modules/exporting.js"></script>
                    <script type="text/javascript" src="<?php #echo JSURL;?>/highcharts/js/highcharts.js"></script>
					<script type="text/javascript">
					$(function() {
							$('#stat').highcharts({
								chart: {type: 'line'},
								title: {text: '接口半月调用次数统计'},
								subtitle: {text: 'Source: Arbion'},
								xAxis: {categories: [<?php #echo $this->showData['days'];?>]},
								yAxis: {title: {text: 'Times'},min:0},
								plotOptions: {line: {dataLabels: {enabled: true},enableMouseTracking: false}},
								series: [
								{name: '日总调用',data: [<?php #echo $this->showData['daynum'];?>]},
								{name: '搜索调用',data: [<?php #echo $this->showData['daynumSearch'];?>]}, 
								{name: '产品详情调用',data: [<?php #echo $this->showData['daynumProduct'];?>]},
								{name: '评论调用',data: [<?php #echo $this->showData['daynumComment'];?>]}
								]
							});
						});
					</script>
                </div>