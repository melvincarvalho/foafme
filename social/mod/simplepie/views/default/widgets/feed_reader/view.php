<div class="contentWrapper">
<?php
  global $CONFIG;
    
  if (!class_exists('SimplePie'))
  {
    require_once $CONFIG->pluginspath . '/simplepie/simplepie.inc';
  }
  
  $blog_tags = '<a><p><br><b><i><em><del><pre><strong><ul><ol><li>';
  $feed_url = $vars['entity']->feed_url;
  if($feed_url){

    $excerpt   = $vars['entity']->excerpt;
    $num_items = $vars['entity']->num_items;
    $post_date = $vars['entity']->post_date;
     
    $cache_loc = $CONFIG->pluginspath . '/simplepie/cache';
    
    $feed = new SimplePie($feed_url, $cache_loc);
    
    // doubles timeout if going through a proxy
    //$feed->set_timeout(20);
    
    $num_posts_in_feed = $feed->get_item_quantity();
    
    // only display errors to profile owner
    if (get_loggedin_userid() == page_owner())
    {        
      if (!$num_posts_in_feed)
        echo '<p>' . elgg_echo('simplepie:notfind') . '</p>';
    }
?>
  <div class="simplepie_blog_title">
    <h2><a href="<?php echo $feed->get_permalink(); ?>"><?php echo $feed->get_title(); ?></a></h2>
  </div>
<?php
  if ($num_items > $num_posts_in_feed)
    $num_items = $num_posts_in_feed;
    
  foreach ($feed->get_items(0,$num_items) as $item):
?>
 
		<div class="simplepie_item">
		  <div class="simplepie_title">
			  <h4><a href="<?php echo $item->get_permalink(); ?>"><?php echo $item->get_title(); ?></a></h4>
      </div>
			<?php 
        if ($excerpt)
        {
          echo '<div class="simplepie_excerpt">' . strip_tags($item->get_description(true),$blog_tags) . '</div>';
        }

        if ($post_date) 
        {
      ?>
        <div class="simplepie_date">Posted on <?php echo $item->get_date('j F Y | g:i a'); ?></div>
      <?php } ?>
		</div>
 
	<?php endforeach; ?>

<?php 
  } else {
  
    if (get_loggedin_userid() == page_owner())        
      echo '<p>' . elgg_echo('simplepie:notset') . '</p>';      
  }
?>
</div>
