<?php

	/**
	 * Elgg Market Plugin
	 * @package market (forked from webgalli's Classifieds Plugin)
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author slyhne
	 * @copyright TechIsUs
	 * @link www.techisus.dk
	 */

	$english = array(
	
	/**
	 * Menu items and titles
	 */
	
	'market' => "Market post",
	'market:posts' => "Market Posts",
	'market:title' => "The Market",
	'market:user' => "%s's posts on The Market",
	'market:user:link' => "%s's Market",
	'market:user:friends' => "%s's friends' posts on The Market",
	'market:your' => "Your Market Posts",
	'market:your:title' => "Your posts on The Market",
	'market:posttitle' => "%s's Market item: %s",
	'market:friends' => "Friends' Market Posts",
	'market:yourfriends' => "Your friends' posts on The Market",
	'market:everyone:title' => "Everything on The Market",
	'market:everyone' => "All Market Posts",
	'market:read' => "View post",
	'market:addpost' => "Create New Post",
	'market:addpost:title' => "Create a new post on The Market",
	'market:editpost' => "Edit post",
	'market:imagelimitation' => "Must be JPG, GIF or PNG.",
	'market:text' => "Give a brief description about the item",
	'market:uploadimages' => "Would you like to upload an image for your item?",
	'market:image' => "Item image",
	'market:imagelater' => "",
	'market:strapline' => "Created",
	'item:object:market' => 'Market posts',


	/**
	* market widget
	**/
	'market:widget' => "My Market",
	'market:widget:description' => "Showcase your posts on The Market",
	'market:widget:viewall' => "View all my posts on The Market",
	'market:num_display' => "Number of posts to display",
	'market:icon_size' => "Icon size",
	'market:small' => "small",
	'market:tiny' => "tiny",
		
	/**
	* market river
	**/
	        
	//generic terms to use
        'market:river:created' => "%s wrote",
        'market:river:updated' => "%s updated",
        'market:river:posted' => "%s posted",
        //these get inserted into the river links to take the user to the entity
        'market:river:create' => "a new Market post titled",
        'market:river:update' => "the Market post titled",
        'market:river:annotate' => "a reply on the Market post titled",
	
	/**
	* Status messages
	*/
	'market:posted' => "Your Market post was successfully posted.",
	'market:deleted' => "Your Market post was successfully deleted.",
	'market:uploaded' => "Your image was succesfully added.",

	/**
	* Error messages
	*/
	
	'market:save:failure' => "Your Market post could not be saved. Please try again.",
	'market:blank' => "Sorry; you need to fill in both the title and body before you can make a post.",
	'market:tobig' => "Sorry; your file is bigger then 1MB, please upload a smaller file.",
	'market:notjpg' => "Please make sure the picture inculed is a .jpg, .png or .gif file.",
	'market:notuploaded' => "Sorry; your file doesn't apear to be uploaded.",
	'market:notfound' => "Sorry; we could not find the specified Market post.",
	'market:notdeleted' => "Sorry; we could not delete this Market post.",
	'market:tomany' => "Error: Too many Market posts",
	'market:tomany:text' => "You have reached the maximum number of Market posts pr. user. Please delete some first!",
	'market:accept:terms:error' => "You must accept the terms of use!",

	/**
	* Settings
	*/
	'market:max:posts' => "Max. number of market posts pr. user:",
	'market:unlimited' => "Unlimited",
	'market:allowhtml' => "Allow HTML in market posts:",
	'market:numchars' => "Max. number of characters in market post (only valid without HTML):",
	'market:pmbutton' => "Enable private message button:",
	'market:adminonly' => "Only admin can create market posts:",
	'market:comments' => "Allow comments:",

	/**
	* Tweeks new version
	*/
	'market:pmbuttontext' => "Send Private Message",
	'market:price' => "Price",
	'market:price:help' => "(ex. 200EUR)",
	'market:text:help' => "(No HTML and max. 250 characters)",
	'market:title:help' => "(1-3 words)",
	'market:tags' => "Tags",
	'market:tags:help' => "(Separate with commas)",
	'market:access:help' => "(Who can see this market post)",
	'market:replies' => "Replies",
	'market:created:gallery' => "Created by %s <br>at %s",
	'market:created:listing' => "Created by %s at %s",
	'market:showbig' => "Show larger picture",
	'market:type' => "Type",
	'market:charleft' => "characters left",
	'market:accept:terms' => "I have read and accepted the %s of use.",
	'market:terms' => "terms",
	'market:terms:title' => "Terms of use",
	'market:terms' =>	"<li>The Market is for buying or selling used itemts among members.</li>
			<li>No more than %s Market posts are allowed pr. user at the same time.</li>
			<li>Only one Market post is allowed pr. item.</li>
			<li>A Market post may only contain one item, unless related.</li>
			<li>The Market is for used/second hand items only.</li>
			<li>The Market post must be deleted when it's no longer relevant.</li>
			<li>The Market are not for business use, unless you have our consent.</li>
			<li>We reserve the right to delete any Market posts violating our terms of use.</li>
			<li>Terms are subject to change over time.</li>
			",

		// market categories
		'market:categories' => 'Market categories',
		'market:categories:choose' => 'Choose type',
		'market:categories:settings' => 'Market Categories:',	
		'market:categories:explanation' => 'Set some predefined categories for posting to the market.<br>Categories could be "market:clothes, market:footwear or market:buy,market:sell etc...", seperate each category with commas - remember to put them in your language files',	
		'market:categories:save:success' => 'Site market categories were successfully saved.',
		'market:categories:settings:categories' => 'Market Categories',
		'market:all:categories' => "All Categories",
		'market:category' => "Category : %s",

		/**
		 * Categories
		 */
		 'market:buy' => "Buying",
		 'market:sell' => "Selling",
		 'market:swap' => "Swap",
		 'market:free' => "Free",

		/**
		 * Custom select
		 */
		'market:custom:select' => "Item condition",
		'market:custom:text' => "Condition",
		'market:custom:activate' => "Enable Custom Select:",
		'market:custom:settings' => "Custom Select Choices:",
		'market:custom:choices' => "Set some predefined choices for the custom select dropdown box.<br>Choices could be \"market:new,market:used...etc\", seperate each choice with commas - remember to put them in your language files",

		/**
		 * Custom choises
		 */
		 'market:na' => "No information",
		 'market:new' => "New",
		 'market:unused' => "Unused",
		 'market:good' => "Good",
		 'market:fair' => "Fair",
		 'market:poor' => "Poor",
	);
					
	add_translation("en",$english);

?>
