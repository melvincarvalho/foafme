<?php 

session_name('phpMyID_Server');
session_start();

include('head.php'); ?>

<body id="tools_scrollable">

	<div id="wrap">	
			
        <?php include('header.php'); ?>


            <h2>News</h2>
            <p>Mailing list up and running: <a href="http://groups.google.com/group/foafme?lnk=srg&hl=en&ie=UTF-8&oe=utf-8">http://groups.google.com/group/foafme</a></p>

            <h2>About</h2>
            <p>

                FOAF Me is a resource designed for use by the FOAF development community.  The aim is to provide a persisent storage area and generator for RDF files in the FOAF format.  The website is a work in progress, and feedback is appreciated.
            </p>

            <p>
            The goals of the project are:

            <p>
                <ul>
                    <li>To create a user friendly 'wizard' for creating FOAF files</li>
                    <li>To allow persisent storage (and eventually editing) of FOAF files</li>
                    <li>To aid with experimentation in the FOAF community for things such as access control, markup, webdav, tabulator, foaf+ssl etc.</li>
                </ul>
            </p>

            <p>
                It's very much a work in progress, but hopefully will evolve over time into a useful tool.
            </p>

            <p>
                Licence:  The licence will conform to other open projects such as identi.ca and libre.fm, thereby offering AGPL for the source, and GPL for desktop apps (in progress).
            </p>


            <h2>FOAF+SSL</h2>
            <p>
                There are some recipes on this site for the FOAF+SSL protocol, a starting page can be seen <a href="test.php">here</a>

            </p>

            <h2>In Progress</h2>
            <p>SPARUL Support:  Allow editing of FOAF via SPARUL / ARC2.  (partially complete)</p>
            <p>FOAF Vix Integration:  Currently via iframe.  <a href="http://foaf.me/danbri">Example</a> (Tabulator takes precidence)</p>
            <p>Knowee Integration:  Would like to add activity streams and foaf inferences.  <a href="http://foaf.me/knowee">Knowee</a></p>
            <p>Certification Service:  User friendly wizard for creating and deploying certificates, with documentation.  <a href="http://foaf.me/simpleCreateClientCertificate.php">Alpha.</a></p>
            <p>FOAF+SSL+OpenID:  Allow you to use your FOAF+SSL certificate as an OpenID. (partially complete) </p>
            <p>Search:  search FOAFs in the linked data cloud.  <a href="search.php">Pre-Release</a></p>
            <p>FOAF+SSL Container: Should be relatively easy to host 3rd party FOAF+SSL apps, say in an iframe. (partially complete)</p>
            <p>FOAF activity stream:  search FOAFs in the linked data cloud.  <a href="activity.php">Pre-Release</a></p>
            <p>Forum:  aim is to make a login system via FOAF+SSL or OpenID.  <a href="forum">Alpha</a> (partially complete)</p>
            <p>Complete RDFa Support </p>
            <p>WebDAV Support:  Allow editing of FOAF via WebDAV.  </p>

            <p>
                Contact details:  look in on #swig if you have any issues -- Or make post on the forum.
            </p>

        </div>

    </body>

</html>
