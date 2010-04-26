<?php

	/**
	 * Elgg vazco_topbar plugin
	 *
	 * @author Michal Zacher [michal.zacher@gmail.com]
	 * @website www.elggdev.com
	 */
    require_once(dirname(__FILE__)."/models/model.php");

    function vazco_topbar_init() {
		
    	global $CONFIG;
		
		
		extend_view('css','vazco_topbar/css');
		extend_view('vanillaforum/topbar_css','vazco_topbar/css');
		
		
		register_action("vazco_topbar/edit",false,$CONFIG->pluginspath . "vazco_topbar/actions/edit.php");
		register_action("vazco_topbar/userlinks",false,$CONFIG->pluginspath . "vazco_topbar/actions/userlinks.php");
    }
		
	function logoutbar_enabled()
    {
		$enabled = get_plugin_setting('loginbar', 'vazco_topbar');
		//make sure there's at least one way to log in
		if (!loginbox_enabled())
			$enabled = "yes";
		return ($enabled == "no") ? false : true;
    }
    function loginbox_enabled()
    {
		$enabled = get_plugin_setting('loginbox','vazco_topbar');
		return ($enabled == "no") ? false : true;
    }
    
    function vazco_topbar_submenus()
    {
		global $CONFIG;
		if (isadminloggedin() && get_context() == 'admin' || get_context() == 'vazco_topbar')
			add_submenu_item ( elgg_echo ( 'vazco_topbar:menu:short' ), $CONFIG->wwwroot . 'mod/vazco_topbar/edit.php' );
	}
		
     // Make sure the status initialisation function is called on initialisation
	register_elgg_event_handler('init','system','vazco_topbar_init');
	register_elgg_event_handler('pagesetup','system','vazco_topbar_submenus');
	
?>
