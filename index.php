<?

include('head.php'); 
include('header.php'); ?>


		<!-- start tabs container -->
        <div style="display:none" typeof="foaf:PersonalProfileDocument" about="">
		    <span rel="foaf:maker" href="#me"></span>
		    <span rel="foaf:primaryTopic" href="#me"></span>
		</div>

        <div id="container" typeof="foaf:Person" about="me">
		<ul>
			<li style="list-style-image: none"><a href="#me"><span>Me</span></a></li>
			<li style="list-style-image: none"><a href="#friends"><span>Friends</span></a></li>
			<li style="list-style-image: none"><a href="#accounts"><span>Accounts</span></a></li>
			<li style="list-style-image: none"><a href="#security"><span>Security</span></a></li>
<?php
if ($agent) {
?>
			<li style="list-style-image: none"><a href="#activity"><span>Activity</span></a></li>
<? } else { ?>
			<li style="list-style-image: none"><a href="#interests"><span>Interests</span></a></li>
<? } ?>
		</ul>

            <!-- start me tab -->
			<div id="me" class="inputArea">
                <?php include('tabme.php'); ?>
			</div>
            <!-- end me tab -->


            <!-- start friends tab -->
			<div id="friends" class="inputArea">
				<?php include ("tabfriends.php"); ?>
			</div>
            <!-- end friends tab -->

<?
if ($agent) {
?>
            <!-- start activites tab -->
            <div id="activity">Loading...
            </div>
            <!-- end activities tab -->
<? } ?>

            <!-- start accounts tab -->
			<div id="accounts" class="inputArea">
				<?php include ("tabaccounts.php"); ?>
			</div>
            <!-- end accounts tab -->

            <!-- start interests tab -->
            <div id="interests">
			  <table id="intereststable">
			  <tr><td></td><td>Description</td></tr>
			  <tr typeof="foaf:OnlineAccount"><td>Interest: </td><td><input size="20" rel="foaf:interest" id="interest1" onchange="makeTags()" type="text" name="interest1" /></td></tr>
			  <tr typeof="foaf:OnlineAccount"><td>Interest: </td><td><input size="20" rel="foaf:interest" id="interest2" onchange="makeTags()" type="text" name="interest2" /></td></tr>			  
			  </table>
			  <a href="#" onclick="javascript:addi()">Add</a>
            </div>
            <!-- end interests tab -->

            <!-- start security tab -->
            <div id="security">Loading...
            </div>
            <!-- end security tab -->

        </div>
		<!-- end tabs container -->

		<!-- start foaf file -->
                        <script type="text/javascript"> $("#activity").load("tabactivity.php?webid=<?= $agent ?>");</script>
                        <script type="text/javascript"> $("#security").load("tabsecurity.php?webid=<?= $agent ?>");</script>

<?php
if ($agent) {
?>
<? } else { ?>
		<div id="form">
		<form name="results" action="store.php" method="POST" >
		<p>Your FOAF file:</p>
		<textarea id="rdf" name="rdf" cols="80" rows="20"></textarea>
		<br/>
		<? echo $_SERVER['HTTP_HOST'] ?>/<input id="uri" value="" type="text" name="uri"> <button type="submit">Save!</button>
 
		<br/><br/>
		<p style='display:none' id="saving">Saving will give you the <a href="http://esw.w3.org/topic/WebID">Web ID</a> = <span style="color:blue" id="displayname"></span></p>

		<p style='display:none'><input value="" type="checkbox" name="spamProtect" checked> Protect email addresses from spammers</p>
		</form>
<? } ?>
		<!-- end foaf file -->

		
			
		
<?php include('footer.php'); ?>
