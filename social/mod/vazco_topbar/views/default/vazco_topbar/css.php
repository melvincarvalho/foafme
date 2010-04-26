/*************
Topbar
************/

.link_box_cont .userlinks{
	width:345px;
}

.link_box_cont .boxname{
	width: 100px;
}
.link_box_cont .boxaddr{
	width: 195px;
}

.link_box_cont div,
.link_type div{
	float: left;
	margin: 5px;
}

.link_box input{
	padding: 1px;
	
}
.link_box{
	border: 1px solid #CCCCCC;
	padding: 10px;
	height:25px;
	overflow:hidden;
}

.link_type{
	margin-left: 20px;
}

#loginform_top #login_remember{
	padding:0;
}

#loginform_top,
#loginform_top #searchform{
	float:right;
}

#loginform_top input#username,
#loginform_top input#password,
#searchform input.search_input{
	bottom:2px;
}

#elgg_topbar_container_left .user_mini_avatar{
	margin: 3px 0 0 20px;
}

#elgg_topbar_container_left .avatar_modified {
	float:left;
	margin:0 10px;
}

#elgg_topbar_container_left a.admin_modified{
	margin: 0;
}

ul.topbardropdownmenu{
	margin: 0 10px 0 5px;
}

ul.topbardropdownmenu ul.wide_dropdown{
	width: 260px;
}

#elgg_topbar_container_left a.privatemessages{
	display:block;
	float:left;
	height:15px;
	margin:4px 15px 0 5px;
}

#elgg_topbar_container_left a.privatemessages_new{
	margin:4px 15px 0 5px;
}
#elgg_topbar_container_left a.new_friendrequests{
	margin-top: 2px;
}

#elgg_topbar_container_left .toolbarlinks2{
	margin:0;
}

#elgg_topbar_container_left a.usersettings{
	display:block;
	float:left;
}

/*************
Login box
************/

.loginbox_top_link{
	color:white;
	font-size:90%;
	font-weight:bold;
	margin:0 10px;
	position:relative;
}
.loginbox_top_link:hover{
	color:white;
}
#loginform_top{
	padding: 0 5px 0;
	position:relative;
}

#loginform_top input#password,
#loginform_top input#username,
#searchform input.search_input {
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	background-color:#FFFFFF;
	border:1px solid #BBBBBB;
	color:#999999;
	font-size:11px;
	font-weight:bold;
	margin:1px 0 0 0;
	padding:1px;
	width:180px;
	height:12px;
	position:relative;
	vertical-align:middle;
}

#loginform_top input#username{
	width:90px;
}

#loginform_top input#password{
	width:80px;
}


#loginform_top input.login_button{
	color:#333333;
	background: url(<?php echo $vars['url']; ?>mod/vazco_topbar/graphics/loginbutton.gif) no-repeat left top;
	border:none;
	font-size:11px;
	font-weight:bold;
	margin:1px 0 0 0;
	padding:0px;
	height:17px;
	width:50px;
	cursor:pointer;
	position:relative;
	vertical-align:middle;
	top:-1px;
}
	
#loginform_top input.login_button{
	background: url(<?php echo $vars['url']; ?>mod/vazco_topbar/graphics/loginbutton.gif) no-repeat left top;
}

#loginform_top input.login_button:hover {
	background: url(<?php echo $vars['url']; ?>mod/vazco_topbar/graphics/loginbutton.gif) no-repeat top right;
}

input.login_button{
	margin: 0px;
	display: ;
	padding-left: 2px;
	padding-right: 2px;
	height:20px;
}

.elgg_topbar_loggedout #elgg_topbar_container_search {
	right: 0;
}

.new_friendrequests{
	float: left;
}

#elgg_topbar .flash_icon{
	float:left;
	margin:0 10px;
}

.link_box{
-moz-border-radius:8px;
background:white;
margin:0 0 20px;
padding:0 0 5px;
}