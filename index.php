<?php 

session_name('phpMyID_Server');
session_start();

$agent = (!empty($_SESSION['auth']) && $_SESSION['auth']['subjectAltName'])? $_SESSION['auth']['subjectAltName'] : '';
$agent = isset($_REQUEST['webid']) ? $_REQUEST['webid'] : $agent;

include('head.php'); ?>

<body id="tools_scrollable">

	<div id="wrap">	
			
        <?php include('header.php'); ?>


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
            <div id="friends">Loading...
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
            <div id="accounts">Loading...
            </div>
            <!-- end accounts tab -->

            <!-- start interests tab -->
            <div id="interests">
			  <table>
			  <table id="intereststable">
			  <tr><td></td><td>Description</td></tr>
			  <tr typeof="foaf:OnlineAccount"><td>Interest: </td><td><input size="20" rel="foaf:interest" id="interest1" onChange="makeTags()" type="text" name="interest1" /></td></tr>
			  <tr typeof="foaf:OnlineAccount"><td>Interest: </td></td><td><input size="20" rel="foaf:interest" id="interest2" onChange="makeTags()" type="text" name="interest2" /></td></tr>			  
			  </table>
			  <a href="#" onclick="javascript:addi()">Add</a>
			  </table>
            </div>
            <!-- end interests tab -->

            <!-- start security tab -->
            <div id="security">Loading...
            </div>
            <!-- end security tab -->

        </div>
		<!-- end tabs container -->

		<!-- start foaf file -->
                        <script> $("#activity").load("tabactivity.php?webid=<?= $agent ?>");</script>
                        <script> $("#friends").load("tabfriends.php?webid=<?= $agent ?>");</script>
                        <script> $("#accounts").load("tabaccounts.php?webid=<?= $agent ?>");</script>
                        <script> $("#security").load("tabsecurity.php?webid=<?= $agent ?>");</script>

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
		<p style='display:none'><input value="" type="checkbox" name="spamProtect" checked> Protect email addresses from spammers</p>
		</form>
<? } ?>
		<!-- end foaf file -->

		
		</div>  
			
		
		
	</div>
	
	
</body>

</html>
