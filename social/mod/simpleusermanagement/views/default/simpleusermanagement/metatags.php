<?php

        /**
         * Elgg simpleusermanagement plugin
         *
         * @package simpleusermanagement
         * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
         * @author Pjotr Savitski
         * @copyright (C) Pjotr Savitski
         * @link http://code.google.com/p/simpleusermanagement/
         **/

    $ts = time();
    $token = generate_action_token($ts);
	$wwwroot = (string) $CONFIG->wwwroot;
?>

	<script type="text/javascript">
	    function simpleusermanagementSearchInvalidUsers() {
            var criteria = jQuery("#search_criteria").attr("value");
			var data = "search_criteria=" + criteria + "&__elgg_ts=<?php echo $ts; ?>&__elgg_token=<?php echo $token; ?>";
			jQuery.ajax({
				url: "<?php echo $wwwroot; ?>mod/simpleusermanagement/actions/search_for_disabled_users.php",
			    type: "POST",
			    data: data,
				success: function (data) {
					jQuery("#simpleusermanagement_disabled_users_content").empty();
					jQuery("#simpleusermanagement_disabled_users_content").append(data);
				},
				error: function() {}
			});
		}

	    function simpleusermanagementDisplayPopup(mask_id, id) {
			var maskHeight = jQuery(document).height();
			var maskWidth = jQuery(document).width();

			jQuery(mask_id).css({'width':maskWidth,'height':maskHeight});

			jQuery(mask_id).fadeIn(1000);
			jQuery(mask_id).fadeTo("slow",0.8);

			var windowHeight = jQuery(window).height();
			var windowWidth = jQuery(window).width();

			jQuery(id).css('top', windowHeight/2-jQuery(id).height()/2);
			jQuery(id).css('left', windowWidth/2-jQuery(id).width()/2);

			jQuery(id).fadeIn(1000);
		}

		function simpleusermanagementShowEmailChange(guid, email) {
			simpleusermanagementDisplayPopup("#simpleusermanagement_email_mask", "#simpleusermanagement_email_form");
			jQuery("input[name='new_email']").val(email);
			jQuery("input[name='user_guid']").val(guid);
		}

		function simpleusermanagementCloseEmailChange() {
			jQuery("#simpleusermanagement_email_mask").hide();
			jQuery("#simpleusermanagement_email_form").hide();

			jQuery("input[name='new_email']").val('');
			jQuery("input[name='user_guid']").val('');
		}
    </script>
