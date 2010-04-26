<?php
	/**
	 * Elgg Market Plugin
	 * @package market (forked from webgalli's Classifieds Plugin)
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author slyhne
	 * @copyright TechIsUs
	 * @link www.techisus.dk
	 */

	if (isset($vars['entity'])) {

		$delete_button = elgg_view("output/confirmlink",array(
				'href' => $vars['url'] . "action/market/delete?marketpost=" . $vars['entity']->getGUID(),
				'text' => elgg_echo('delete'),
				'confirm' => elgg_echo('deleteconfirm'),
				'class' => "market_delete_button"
								));

		$edit = elgg_echo('edit');
		$url = $vars['url'];
		$itemlink = $vars['entity']->getURL();
		$GUID = $vars['entity']->getGUID();
		$edit_button = "<a class=\"market_button\" href=\"{$url}mod/market/edit.php?marketpost={$GUID}\">{$edit}</a>";
		$pmbuttontext = elgg_echo('market:pmbuttontext');
		$ownerGUID = $vars['entity']->getOwnerEntity()->guid;
		// Get the owner and a link to their gallery
		$user_gallery = $CONFIG->wwwroot . "pg/market/" . $vars['entity']->getOwnerEntity()->username;
		// Get custom select
		$custom = $vars['entity']->custom;
		
		// Should we show full view?
		if (isset($vars['full']) && $vars['full'] == true) {
				$fullview = true;
		}

		// Get plugin settings
		$allowhtml = get_plugin_setting('market_allowhtml', 'market');

		//display comments link?
		if (get_plugin_setting('market_comments', 'market') == 'no') {
			$comments_on = false;
		} else {
			$comments_on = true;
		}


		if (isset($vars['entity']) && $vars['entity'] instanceof ElggEntity) {
			$selected_marketcategory = $vars['entity']->marketcategory;
		}
	
		if (get_context() == "search") {
				
			//display the correct layout depending on gallery or list view
			if (get_input('search_viewtype') == "gallery") {

				//display the gallery view
       				echo elgg_view("market/gallery",$vars);

			} else {
				
				echo elgg_view("market/listing",$vars);

			}
				
		} else {
?>
		<div class="contentWrapper singleview">
		<h4><?php echo sprintf(elgg_echo('market:category'), elgg_echo($selected_marketcategory)); ?></h4>

		<!-- displaying header -->
		<div class="market_title_owner_wrapper">
		 
		<div class="market_owner_holder">
		<a href="<?php echo $user_gallery; ?>"><?php echo sprintf(elgg_echo("market:user:link"), $vars['entity']->getOwnerEntity()->name); ?></a><br>
		<?php echo elgg_view("profile/icon",array('entity' => $vars['entity']->getOwnerEntity(), 'size' => 'small')); ?>
		</div>
		
		<div class="market_title">
		<h3><a href="<?php echo $itemlink ?>"><?php echo $vars['entity']->title; ?></a></h3>
		</div>

		<div class="market_details_holder">
		<p class="strapline">
		<?php
		if(isset($custom) && get_plugin_setting('market_custom', 'market') == 'yes'){
			echo "<strong>" . elgg_echo('market:custom:text') . " : </strong>";
			echo elgg_echo($custom);
		}
		echo "<br>";
		echo "<strong>" . elgg_echo("market:strapline") . " : </strong>";
		echo date("j/m-Y",$vars['entity']->time_created);

		// display tags
		echo "<br><strong>" . elgg_echo('tags') . " : </strong>";
		echo elgg_view('output/tags', array('tags' => $vars['entity']->tags));

		// Display number of comments on item
		if($comments_on && $vars['entity'] instanceof ElggObject){
			//get the number of comments
			$num_comments = elgg_count_comments($vars['entity']);
			echo "<br><strong>" . elgg_echo('market:replies') . " : </strong>";
			echo $num_comments;
		}
		?>
		</p>
		</div>

		</div>

  <!-- display the actual market post with image -->
  <table border="0" width="100%">
    <tr>
      <td>
	<p>
	<?php
	if ($allowhtml != 'yes') {
		echo strip_tags($vars['entity']->description);
	} else {
		echo $vars['entity']->description;
	}
	?>
	</p>
      </td>
	<td width="300px" height="160px">
	<center>
	<?php
	if ($fullview == true) {
        ?>
		<a href="<?php echo $CONFIG->wwwroot; ?>mod/market/viewimage.php?marketguid=<?php echo $vars['entity']->guid; ?>" rel="facebox"><img src="<?php echo $CONFIG->wwwroot; ?>mod/market/icon.php?marketguid=<?php echo $vars['entity']->guid; ?>&size=large" border="2"></a>
        <?php
	} else {
        ?>
		<a href="<?php echo $itemlink; ?>"><img src="<?php echo $CONFIG->wwwroot; ?>mod/market/icon.php?marketguid=<?php echo $vars['entity']->guid; ?>&size=medium" border="2"></a>
        <?php
        }
        ?>
	</center>
	</td>
    </tr>
    <tr>
	<td>
	</td>
	<td>
	</td>
    </tr>
    <tr>
	<td>
	<!-- display edit options if it is the market post owner -->
	<p class="options">
	<?php
	if(get_plugin_setting('market_pmbutton', 'market') == 'yes') {
		echo "<a class=\"market_button\" href=\"{$url}mod/messages/send.php?send_to={$ownerGUID}\">{$pmbuttontext}</a>&nbsp;&nbsp;";
	}
	// Display edit options if it is the market post owner
	if ($vars['entity']->canEdit()) {
		echo "{$edit_button}&nbsp;&nbsp;{$delete_button}&nbsp;&nbsp;";

		// Allow the menu to be extended
		echo elgg_view("editmenu",array('entity' => $vars['entity']));
	}
	?>
	</p>
      </td>
      <td>
	<center>
	<span class="market_pricetag"><strong><?php echo elgg_echo('market:price'); ?></strong>&nbsp;&nbsp;<?php echo $vars['entity']->price; ?></span>
	</center>
      </td>
    </tr>
  </table>

</div>
<?php
	if($comments_on && $vars['entity'] instanceof ElggObject){
		// If we've been asked to display the full view
		if ($fullview == true) {
			echo elgg_view_comments($vars['entity']);
		}
	}

	}
}
?>
