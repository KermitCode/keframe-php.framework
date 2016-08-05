	<article id="post-582" class="entry post publish author-hwijaya post-582 format-video category-post-formats post_tag-embeds-2 post_tag-post-formats post_tag-video post_tag-wordpress-tv" itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
<?php foreach($this->pageData as $k=>$row){?>

		<div class="entry-wrap">
            <header class="entry-header">	
                <h3 class="entry-title" itemprop="headline">
                    <a href="<?php echo $this->makeUrl('Article/view',array('id'=>$row['id']));?>" rel="bookmark" title="<?php echo stripslashes($row['ar_title']);?>"><?php echo stripslashes($row['ar_title']);?></a>
                </h3>
                <div class="entry-meta">
                    <time class="entry-time" itemprop="datePublished" title="<?php echo date('F j, Y -l',$row['ar_time']);?>"><?php echo date('F j, Y -l',$row['ar_time']);?></time>
                 </div>
             </header>
                            
             <div class="entry-summary indent" itemprop="description">
                  <p><?php echo StrHelp::substr_zh(stripslashes(StrHelp::DeleteHtml(strip_tags($row['ar_text']))),480);?><span class="more"><a class="more-link" href="<?php echo $this->makeUrl('Article/view',array('id'=>$row['id']));?>">[>>…]</a></span>
                  </p>
                  <?php #提取第一张图片
				  //$img=preg_match("/<img.*src=[\"](.*?)[\"].*\/>/",$row['ar_text'],$match);
                  $img=preg_match('/<img\s*src=\s*\\\?"([^>"\\\]*)\\\?"[^>]*>/i',$row['ar_text'],$match);
				  if($img) echo "<div class='mimg'><a href='".$this->makeUrl('Article/view',array('id'=>$row['id']))."'><img src='{$match[1]}' /></a></div>";
				  ?>
             </div>
             <footer class="entry-footer">
                  <div class="entry-meta right">
                       <span class="entry-terms category" itemprop="articleSection"> 
                       Tags：<?php $tagArr=explode(',',$row['ar_tags']);
					   foreach($tagArr as $value){
						   if($value) echo "<a href='javascript:void(0);' rel='tag'>{$value}</a>,";
					   }?>
                       </span>		
                   </div><!-- .entry-meta -->
             </footer>
        </div>
<?php }?>
		<div class="row">
		<div class="pagination">
            <ul>
                <?php echo $this->KePage->makeBlogPage(12, array('type') );?>
            </ul>
        </div>
        </div>
        
        
        <nav role="navigation" id="nav-below" class="navigation  paging-navigation">
        </nav>
        </article><!-- #post-## -->