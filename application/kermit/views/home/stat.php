				<div class="span10">
					<h3><?php echo $this->pageName;?>---待后期续</h3>
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
								{name: '网站总浏览量',data: [<?php //echo implode(',',$this->dayStat);?>]},
								{name: '独立访问用户数',data: [<?php //echo implode(',',$this->userStat);?>]},
								{name: '百度抓取数',data: [<?php //echo implode(',',$this->EngineStat);?>]},
								]
							});
						});
					</script>
                 </div>