<?php

	/**
	 * Elgg Market Plugin
	 * @package market (forked from webgalli's Classifieds Plugin)
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author slyhne
	 * @copyright TechIsUs
	 * @link www.techisus.dk
	 */

	// Get plugin settings
		$allowhtml = get_plugin_setting('market_allowhtml', 'market');
		$numchars = get_plugin_setting('market_numchars', 'market');
		if($numchars == ''){
			$numchars = '250';
		}

	// Set title, form destination
		if (isset($vars['entity'])) {
			$title = sprintf(elgg_echo("market:editpost"),$object->title);
			$action = "market/edit";
			$title = $vars['entity']->title;
			if ($allowhtml != 'yes') {
				$body = strip_tags($vars['entity']->description);
			} else {
				$body = $vars['entity']->description;
			}
			$price = $vars['entity']->price;
			$custom = $vars['entity']->custom;
			$tags = $vars['entity']->tags;
			$access_id = $vars['entity']->access_id;
		} else {
			$title = elgg_echo("market:addpost");
			$action = "market/add";
			$tags = "";
			$title = "";
			$price = "";
			$custom = "";
			$description = "";
			$access_id = 1;
		}

	// Just in case we have some cached details
		if (isset($vars['markettitle'])) {
			$title = $vars['markettitle'];
			$body = $vars['marketbody'];
			$price = $vars['marketprice'];
			$custom = $vars['marketcustom'];
			$tags = $vars['markettags'];
		}


?>
<script type="text/javascript">
function textCounter(field,cntfield,maxlimit) {
	// if too long...trim it!
	if (field.value.length > maxlimit) {
		field.value = field.value.substring(0, maxlimit);
	} else {
		// otherwise, update 'characters left' counter
		cntfield.value = maxlimit - field.value.length;
	}
}
function acceptTerms() {
	error = 0;
	if(!(document.marketForm.accept_terms.checked) && (error==0)) {		
		alert('<?php echo elgg_echo('market:accept:terms:error'); ?>');
		document.marketForm.accept_terms.focus();
		error = 1;		
	}
	if(error == 0) {
		document.marketForm.submit();	
	}
}
</script>

<div class="contentWrapper">

	<form action="<?php echo $vars['url']; ?>action/<?php echo $action; ?>" enctype="multipart/form-data" method="post" name="marketForm" onsubmit="acceptTerms();return false;">
  <?php echo elgg_view('input/securitytoken') ?>
  <p> 
    <label><?php echo elgg_echo("title"); ?>&nbsp;<small><small><?php echo elgg_echo("market:title:help"); ?></small></small><br />
    <?php
	echo elgg_view("input/text", array(
					"internalname" => "markettitle",
					"value" => $title,
					));
    ?>
    </label>
  </p>

<?php
	$marketcategories = elgg_view('market/marketcategories',$vars);
	if (!empty($marketcategories)) {
    		echo "<p>{$marketcategories}</p>";
	}

	if(get_plugin_setting('market_custom', 'market') == 'yes'){
		$marketcustom = elgg_view('market/custom',$vars);
		if (!empty($marketcustom)) {
    			echo "<p>{$marketcustom}</p>";
		}
	}
?>
  <table border="0" cellpadding="40" width="100%">
    <tr>
      <td>
		<p>
			<label><?php echo elgg_echo("market:text"); ?><br>
<?php
	if ($allowhtml != 'yes') {
?>
		<small><small><?php echo sprintf(elgg_echo("market:text:help"), $numchars); ?></small></small><br />
		<textarea name='marketbody' class='mceNoEditor' rows="8" cols="40" onKeyDown="textCounter(document.marketForm.marketbody,document.marketForm.remLen1,<?php echo $numchars; ?>)" onKeyUp="textCounter(document.marketForm.marketbody,document.marketForm.remLen1,<?php echo $numchars; ?>)"><?php echo $body; ?></textarea><br />
		</label>
      		<div class='market_characters_remaining'><input readonly type="text" name="remLen1" size="3" maxlength="3" value="<?php echo $numchars; ?>" class="market_characters_remaining_field"><?php echo elgg_echo("market:charleft"); ?></div>
<?php
	} else {
		echo elgg_view("input/longtext", array("internalname" => "marketbody", "value" => $body));
		echo "</label>";
	}
?>
		</p>
      </td>
      <td width="220px">
		<p>
			<label><?php echo elgg_echo("market:image"); ?><br />
			<center><img src="<?php echo $CONFIG->wwwroot; ?>mod/market/icon.php?marketguid=<?php echo $vars['entity']->guid; ?>&size=large"></center><br />
			</label>
		</p>
      </td>
    <tr>
  </table>
		
		    <p> 
    <label><?php echo elgg_echo("market:price"); ?>&nbsp;<small><small><?php echo elgg_echo("market:price:help"); ?></small></small><br />
    <?php

				echo elgg_view("input/text", array(
									"internalname" => "marketprice",
									"value" => $price,
													));
			
			?>
    </label>
  </p>
  

				<p>
			<label><?php echo elgg_echo("market:tags"); ?>&nbsp;<small><small><?php echo elgg_echo("market:tags:help"); ?></small></small><br />
    <?php

				echo elgg_view("input/tags", array(
									"internalname" => "markettags",
									"value" => $tags,
													));
			
			?>
			 </label>
  </p>	

        <!-- display upload if action is edit or add -->
        		<?php
				if ($action == "market/add" || $action == "market/edit") {	
				?>
        				<p>
   					     	<label><?php echo elgg_echo("market:uploadimages"); ?><br />
   				     		   <small><small><?php echo elgg_echo("market:imagelimitation"); ?></small></small><br />
							<?php
									echo elgg_view("input/file",array('internalname' => 'upload'));
					
							?>
 				           </label>
 				        </p>
 		        <?php
					}
				?>
         <!-- display upload if action is edit or add end -->
		<p>
		<label>
			<?php echo elgg_echo('access'); ?>&nbsp;<small><small><?php echo elgg_echo("market:access:help"); ?></small></small><br />
			<?php echo elgg_view('input/access', array('internalname' => 'access_id','value' => $access_id)); ?>
		</label>
		</p>
		<p>
		<?php
		if (isset($vars['entity'])) {
			echo "<input type=\"hidden\" name=\"marketpost\" value=\"".$vars['entity']->getGUID()."\" />";
		}

		// Terms checkbox and link 
		$termslink = "<a href=\"".$CONFIG->wwwroot."mod/market/terms.php\" rel=\"facebox\">".elgg_echo('market:terms:title')."</a>";
		$termsaccept = sprintf(elgg_echo("market:accept:terms"),$termslink);
		?>

		</p>
		<input type="checkbox" name="accept_terms"><?php echo $termsaccept; ?>
		</p>
		<p>
			<input type="submit" name="submit" value="<?php echo elgg_echo('save'); ?>" />
		</p>
	
	</form></div>
