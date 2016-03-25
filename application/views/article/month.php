	<article id="post-582" class="entry post publish author-hwijaya post-582 format-video category-post-formats post_tag-embeds-2 post_tag-post-formats post_tag-video post_tag-wordpress-tv" itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
<?php foreach($this->pageData as $k=>$row){?>
		<div class="entry-wrap">
            <header class="entry-header">	
                <h3 class="entry-title" itemprop="headline">
                    <a href="<?php echo $this->KeUrl->makeUrl('Article/view',array('id'=>$row['id']));?>" rel="bookmark" title="<?php echo $row['ar_title'];?>"><?php echo $row['ar_title'];?></a>
                </h3>
                <div class="entry-meta">
                    <time class="entry-time" itemprop="datePublished" title="<?php echo date('F j, Y -l',$row['ar_time']);?>"><?php echo date('F j, Y -l',$row['ar_time']);?></time>
                 </div>
             </header>
        </div>
<?php }?>
		<div class="row">
            <div class="pagination">
                <ul>
                    <?php echo $this->KePage->makeBlogPage(12,array('yd'));?>
                </ul>
            </div>
        </div>
    </article><!-- #post-## -->