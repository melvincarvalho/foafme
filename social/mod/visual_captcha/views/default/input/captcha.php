<?php
/**
 * Elgg visual captcha plugin captcha hook view override.
 *
 * @package ElggVisualCaptcha
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Brett Profitt
 * @copyright Brett Profitt 2008-2009
 * @link http://elgg.org/
 */

// create a new instances for this.
$captcha = new ElggVisualCaptcha();
$images = $captcha->images;

$instance_token_field = elgg_view('input/hidden', array(
	'internalname' => 'visual_captcha_token',
	'value' => $captcha->token
));

$click_order_field = elgg_view('input/hidden', array(
	'internalname' => 'visual_captcha_click_order',
	'value' => ''
));

$language_hints = $captcha->getLanguageHintStrings();
$click_order = '';
$i = 1;
$count = count($language_hints);

foreach ($language_hints as $string) {
	$comma = ($i != $count) ? ',' : '';
	$click_order .= "<span class=\"visual_captcha_languagehint hintnumber$i\">$string$comma</span>";
	$i++;
}

$selection = '<ul class="visual_captcha_choices clearfloat">';

foreach ($images as $image) {
	$url = $image->getImgURL($captcha->token);
	$token = $image->getImgToken($captcha->token);

	$selection .= "<li><a><img src=\"$url\" id=\"$token\" width=\"75\" height=\"75\" /></a></li>";
}

$selection .= '</ul>';

$reset_link = "<a class='visual_captcha_reset'>" . elgg_echo('visual_captcha:reset_images') . '</a>';

?>

<div class="visual_captcha" id="<?php echo $captcha->token; ?>">
	<label><?php echo elgg_echo('visual_captcha:enter_captcha'); ?><br />
	<?php echo $click_order?></label>
	<?php echo $reset_link; ?>
	<?php echo $selection; ?>
	<?php echo $instance_token_field; ?>
	<?php echo $click_order_field; ?>
</div>

<script type="text/javascript">
$(document).ready(function() {
	var imgMax = <?php echo $vars['config']->visual_captcha_images_match; ?>;
	var token = '<?php echo $captcha->token; ?>';
	var clickOrderTokens = [];
	var numClicked = 0;

	$('#' + token + ' ul.visual_captcha_choices li a img').click(function() {
		// you lie, jQuery docs. This is supposed to return an empty string
		// if it's not been set...
		clicked = $(this).data('clicked');
		clicked = (typeof clicked == 'undefined') ? false : clicked;

		if (!clicked && numClicked++ < imgMax) {
			// mark as clicked
			$(this).data('clicked', true).addClass('clicked');			

			// mark off language hint
			$('#' + token + ' .hintnumber' + numClicked).css('text-decoration', 'line-through');

			// set click order
			clickOrderTokens.push($(this).attr('id'));

			// grey out other choices when at max
			if (numClicked == imgMax) {
				$('#' + token + ' ul.visual_captcha_choices li a img').each(function(i, e) {
					clicked = $(e).data('clicked');
					clicked = (typeof clicked == 'undefined') ? false : clicked;

					if (!clicked) {
						$(e).css('opacity', .15);
					}
				});
			}
		}
	});

	// reset all attributes
	$('#' + token + ' .visual_captcha_reset').click(function() {
		numClicked = 0;
		clickOrderTokens = [];
		$('#' + token + ' .visual_captcha_languagehint').css('text-decoration', 'inherit');

		$('#' + token + ' ul.visual_captcha_choices li a img').each(function(i, e) {
			clicked = $(e).data('clicked');
			clicked = (typeof clicked == 'undefined') ? false : clicked;
			$(e).css('opacity', 1);

			if (clicked) {
				$(e).data('clicked', false).removeClass('clicked');
			}
		});
	});

	// save data when submitting the parent form.
	$('#' + token).parents('form').submit(function() {
		orderInput = $('#' + token + ' input[name=visual_captcha_click_order]');
		orderInput.val(clickOrderTokens.join(','));

		return true;
	});
});
</script>