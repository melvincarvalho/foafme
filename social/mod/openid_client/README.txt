/**
 * Login using OpenID
 * 
 * @package openid_client
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Curverider 2008-2009
 * @link http://radagast.biz/
 * 
 */
 
 Just unzip into your Elgg mod directory and activate.
 
 There are several configuration options that you can use to add fancier
 features. These are available through the "Configure OpenID client" link
 in the admin sidebar. But they are not needed for basic operation.
 
 *Single Sign-On Link*
 
 You can optionally configure a single-sign-on link of the form:
 
 http://url-for-your-elgg/pg/openid_client/sso?username=XXX
 
 where XXX is an OpenID.
 
 This can be useful if you are integrating Elgg into another application.
 Just put that link into your application navigation, and your user will be
 automatically logged-in to Elgg using OpenID.
 
 This feature is turned off by default. You can activate it on the admin page.
 
 This link may be insecure because it routes around the XSS protection system
 normally used by the plugin. You have been warned.
 
 *Reset page*
 
 When logged-in as a site admin, you can visit:
 
  http://url-for-your-elgg/pg/openid_client/reset
  
  to reset all your OpenID associations and nonces. This may help if your
  association data with a particular OpenID server has become corrupted.
  
  These are just cached values and will temporarily slow down the next people
  who login to your site using OpenID, but not by a large amount. Once the
  cache is refreshed, things should be back to normal.