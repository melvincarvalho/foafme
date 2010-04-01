<?php

 /**
 * Elgg OpenID login form
 * 
 * @package Elgg
 * @subpackage openid_client
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine, Radagast Solutions
 * @copyright Curverider Ltd 2008-2009
 * @link http://elgg.org/
 */
	 
?>
<script type="text/javascript">
$(document).ready(function() {
    $('div#openid_login').hide();
   $('#openid_show').click(function(){
     $('div#openid_login').slideToggle('medium');
   });
 });
</script>
<div class="contentWrapper">
<a id="openid_show"><img src="<?php echo $vars['url']; ?>mod/openid_client/graphics/openid.jpg" alt="OpenID" /></a>

<div id="openid_login">
<div id="login-box">
    <h2><?php echo elgg_echo('openid_client_login_title'); ?></h2>
    <form action="<?php echo $vars['url']; ?>action/openid_client/login" method="post">
    <?php echo elgg_view('input/securitytoken'); ?>
    <input type="hidden" name="passthru_url" value="http://<?php echo $_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'] ?>" />
            <table>
                <tr>
                    <td><p>
                        <label><?php echo elgg_echo('openid_client_login_service'); ?><br /><select name="externalservice">
                            <option value="">OpenID</option>
                            <option value="aim">AIM</option>
                            <option value="livejournal">LiveJournal</option>
                            <option value="vox">Vox</option>
                            <option value="pip">Verisign PIP</option>
                            <option value="wordpress">Wordpress.com</option>
                            </select>
                        </label></p>
                </tr>
                <tr>
                    <td><div class="loginbox">
                        <label><?php echo elgg_echo('username'); ?><br /><input class="openid_login" type="text" name="username" id="username" style="size: 200px" /></label>
						<input type="submit" name="submit" value="<?php echo elgg_echo('openid_client_go'); ?>" />
						<div id="persistent_login"><label><input type="checkbox" name="remember" checked="checked" /><?php echo elgg_echo('openid_client_remember_login'); ?></label></div>
                        </div>
                    </td>
                </tr>            
            </table>
    </form>
</div>
</div>

</div>