<?php
/**
 * Elgg visual captcha plugin css.
 *
 * @package ElggVisualCaptcha
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Brett Profitt
 * @copyright Brett Profitt 2008-2009
 * @link http://elgg.org/
 */

?>
.visual_captcha a {
	cursor: pointer;
	border: 0;
}
.visual_captcha_languagehint {
	padding-right: 0.5em;
	color:#0054A7;
}
.visual_captcha_choices {
	margin-top:5px;
}
ul.visual_captcha_choices li {
	float: left;
	padding: 2px 4px 2px 0;
	list-style-type: none;
}
ul.visual_captcha_choices li img {
	padding: 2px;
}
ul.visual_captcha_choices li img.clicked {
	background-color: #4690D6;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;	
}