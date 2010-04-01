<?php

     /**
	 * Elgg OpenID login form css
	 * 
	 * @package Elgg
	 * @subpackage openid_client
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Kevin Jardine, Radagast Solutions
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.org/
	 */
	 
?>



.river_user_openid_friend {
	background: url(<?php echo $vars['url']; ?>_graphics/river_icons/river_icon_friends.gif) no-repeat left -1px;
}
.river_user_openid_update {
	background: url(<?php echo $vars['url']; ?>_graphics/river_icons/river_icon_profile.gif) no-repeat left -1px;
}
.river_user_openid_messageboard {
	background: url(<?php echo $vars['url']; ?>_graphics/river_icons/river_icon_comment.gif) no-repeat left -1px;
}

#openid_login #login-box h2 {
	margin:0;
	padding:5px 0 10px 0;
}
#openid_login #login-box form {
	margin:0;
	padding:0;
}
input.openid_login {
	background: url(<?php echo $vars['url']; ?>mod/openid_client/graphics/login-bg.gif) no-repeat;
	background-color: #fff;
	background-position: 0 50%;
	color: #000;
	width: 160px;
}
#openid_show {
	cursor:pointer;
}