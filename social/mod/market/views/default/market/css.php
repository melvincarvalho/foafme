<?php

	/**
	 * Elgg Market Plugin
	 * @package market (forked from webgalli's Classifieds Plugin)
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author slyhne
	 * @copyright TechIsUs
	 * @link www.techisus.dk
	 */

?>


.market_post {
	margin-bottom: 15px;
	border-bottom: 1px solid #aaaaaa;
}

.market_post_icon {
	float:left;
	margin:3px 0 0 0;
	padding:0;
}

.market_post h3 {
	font-size: 150%;
	margin-bottom: 5px;
}

.market_post h3 a {
	text-decoration: none;
}

.market_post p {
	margin: 0 0 5px 0;
}

.market_post .strapline {
	margin: 0 0 0 35px;
	padding:0;
	color: #666666;
	line-height:1em;
}
.market_post p.tags {
	background:transparent url(<?php echo $vars['url']; ?>_graphics/icon_tag.gif) no-repeat scroll left 2px;
	margin:0 0 0 35px;
	padding:0pt 0pt 0pt 16px;
	min-height:22px;
}
.market_post .options {
	margin:0;
	padding:0;
}

.market_post_body img[align="left"] {
	margin: 10px 10px 10px 0;
	float:left;
}
.market_post_body img[align="right"] {
	margin: 10px 0 10px 10px;
	float:right;
}

.market-comments h3 {
	font-size: 150%;
	margin-bottom: 10px;
}
.market-comment {
	margin-top: 10px;
	margin-bottom:20px;
	border-bottom: 1px solid #aaaaaa;
}
.market-comment img {
	float:left;
	margin: 0 10px 0 0;
}
.market-comment-menu {
	margin:0;
}
.market-comment-byline {
	background: #dddddd;
	height:22px;
	padding-top:3px;
	margin:0;
}
.market-comment-text {
	margin:5px 0 5px 0;
}
.market-largethumb {
	text-align:center;
	height: 153px;
	background: #ffffff;
	margin:5px;
}

.market-largethumb #largethumb {
	height: 153px;
	width: 153px;
	margin: 2px;
	text-align:center;
	border-color: #000000;
	border-width: 1px;
	border-style: solid;
}
.market-largethumb a:hover {
	border-color: #dddddd;
}
.market-smallthumb a {
	height: 60px;
	width: 60px;
	margin: 2px;
	float: left;
	border-color: #000000;
	border-width: 1px;
	border-style: solid;
}
.market-smallthumb a:hover {
	border-color: #dddddd;
}
.market-tinythumb a {
	height: 25px;
	width: 25px;
	margin: 1px;
	float: left;
	border-color: #000000;
	border-width: 1px;
	border-style: solid;
}
.market-tinythumb a:hover {
	border-color: #dddddd;
}
.market_title_owner_wrapper {
	min-height:75px;
	margin-bottom: 10px;
	padding:0 0 0 10px;
	background-color: #eeeeee;
}
.market_title{
	margin:0;
	padding:6px 5px 0 8px;
	line-height: 1.2em;
}
.market_details_holder {
	padding:0 0 0 10px;
	margin-left: 0px;
	float: left;
	color: #333333;
	font-size:80%;	
}
.market_owner_holder {
	padding:0 10px 0 10px;
	margin-right: 0px;
	float: right;
}
.market_owner_holder .usericon {
	margin-right: 5px;
	margin-top: 5px;
	float: right;
}
/* GALLERY VIEW */

.market_gallery_item {
	margin:0;
	padding:0;
}
.market_gallery_title {
	font-weight: bold;
	margin:0 0 10px 0;
}
.market_gallery_content {
	font-size:90%;
    color:#666666;
	margin:0;
    padding:0;
}

.market_gallery_link {
	float:right;
	margin:5px 5px 5px 50px;
}
.market_gallery_link a {
	padding:2px 25px 5px 0;
	background: transparent url(<?php echo $vars['url']; ?>_graphics/icon_gallery.gif) no-repeat right top;
	display:block;
}
.market_gallery_link a:hover {
	background-position: right -40px;
}

a.market_button {
	font: 12px/100% Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #ffffff;
	background:#4690d6;
	border: 1px solid #4690d6;
	-webkit-border-radius: 4px; 
	-moz-border-radius: 4px;
	width: auto;
	height: 25px;
	padding: 2px 10px 2px 10px;
	margin:10px 0 10px 0;
	cursor: pointer;
}
a.market_button:hover {
	background: #0054a7;
	border-color: #0054a7;
	text-decoration: none;
}
.market_delete_button {
	font: 12px/100% Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #ffffff;
	background:#9F0101;
	border: 1px solid #9F0101;
	-webkit-border-radius: 4px; 
	-moz-border-radius: 4px;
	width: auto;
	height: 25px;
	padding: 2px 10px 2px 10px;
	margin:10px 0 10px 0;
	cursor: pointer;
}
.market_delete_button:hover {
	background: #CB1717;
	border-color: #CB1717;
	text-decoration: none;
	color: #ffffff;
}
.market_links {
	float:right;
	margin: -5px 5px 5px 50px;
}
.market_pricetag {
	font: 12px/100% Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #ffffff;
	background:#00a700;
	border: 1px solid #00a700;
	-webkit-border-radius: 4px; 
	-moz-border-radius: 4px;
	width: auto;
	height: 12px;
	padding: 2px 10px 2px 10px;
	margin:10px 0 10px 0;
}
/* ***************************************
	RIVER
*************************************** */

.river_object_market_create {
	background: url(<?php echo $vars['url']; ?>mod/market/graphics/river_icons/river_icon_market.png) no-repeat left -1px;
}
.river_object_market_update {
	background: url(<?php echo $vars['url']; ?>mod/market/graphics/river_icons/river_icon_market.png) no-repeat left -1px;
}
.river_object_market_comment {
	background: url(<?php echo $vars['url']; ?>mod/market/graphics/river_icons/river_icon_comment.png) no-repeat left -1px;
}

/* ***************************************
	CATEGORIES
*************************************** */

.marketcategories .input-pulldown {
	padding:0;
	margin:2px 5px 0 0;
}
.marketcategories label {
	font-size: 100%;
	line-height:1.2em;
}

#two_column_left_sidebar_maincontent .contentWrapper h2.marketcategoriestitle {
	padding: 0 0 3px 0;
	margin:0;
	font-size:120%;
	color:#ffffff;
}
#two_column_left_sidebar_maincontent .contentWrapper .marketcategories {
	border:1px solid #CCCCCC;
	-webkit-border-radius: 4px; 
	-moz-border-radius: 4px;
	padding:5px;
	margin:0 0 15px 0;	
}
#two_column_left_sidebar_maincontent .contentWrapper .marketcategories p {
	margin:0;	
}
#two_column_left_sidebar_maincontent .contentWrapper .blog_post .marketcategories {
	border:none;
	margin:0;
	padding:0;
}

#two_column_left_sidebar .blog_marketcategories {
	background:white;
	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;
    padding:10px;
    margin:0 10px 10px 10px;
}
#two_column_left_sidebar .blog_marketcategories h2 {
	background:none;
	border-top:none;
	margin:0;
	padding:0 0 5px 0;
	font-size:1.25em;
	line-height:1.2em;
	color:#0054A7;
}
#two_column_left_sidebar .blog_marketcategories ul {
	color:#0054A7;
	margin:5px 0 0 0;
}
#two_column_left_sidebar .sidebarBox h3 {
	margin:20px 0 0 10px;
	color:white;
}
