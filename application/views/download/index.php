	<article id="post-582" class="entry post publish author-hwijaya post-582 format-video category-post-formats post_tag-embeds-2 post_tag-post-formats post_tag-video post_tag-wordpress-tv" itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
		<?php foreach($this->pageData as $k=>$row){?>
                <div class="entry-wrap">
                    <header class="entry-header">	
                        <h5 class="entry-title" itemprop="headline">
                        	<a href="<?php echo $this->makeUrl('download/down',array('id'=>$row['id']));?>" rel="nofollow"><span class="text-success">点击下载</span></a>&nbsp;&nbsp;
                            <a href="<?php echo $this->makeUrl('download/down',array('id'=>$row['id']));?>" rel="nofollow" title="<?php echo $row['title'];?>"><?php echo $row['title'];?></a>
                            <span> <small> 下载次数 (<?php echo $row['downloads'];?>)</small></span>
                        </h5>
                  </header>
                </div>
        <?php }?>
		<div class="row">
            <div class="pagination">
                <ul>
                    <?php //echo $this->KE('kePage')->makeNowpage(8);?>
                </ul>
            </div>
        </div>
    </article>