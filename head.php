<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">  
<!--
 * FOAF Me : FOAF Me Home Page and FOAF creator wizard.
 * Copyright (c) http://foaf.me/
 * Dual licensed under the MIT (MIT-license.txt)
 * and GPL (GPL-license.txt) licenses.
 *
-->
<html xmlns="http://www.w3.org/1999/xhtml"
  xmlns:xsd="http://www.w3.org/2001/XMLSchema#"
  xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
  xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#"
  xmlns:dc="http://purl.org/dc/elements/1.1/"
  xmlns:dcterms="http://purl.org/dc/terms/"
  xmlns:foaf="http://xmlns.com/foaf/0.1/"
  xmlns:vcard="http://www.w3.org/2006/vcard/ns#"
  xmlns:biografr="http://biografr.com/ontology#">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<title>FOAF Me</title>
<link rel="stylesheet" href="css/jquery.tabs.css" type="text/css" media="print, projection, screen">
<!--
<link rel="shortcut icon" href="/img/favicon.png" type="image/png" />	
-->
<link rel="stylesheet" type="text/css" title="default" href="css/main.css" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script type="text/javascript" src="js/jquery/1.3.1/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery/jquery.tabs.pack.js"></script>
 <!--
<script src="jquery.history_remote.pack.js" type="text/javascript"></script>
<script type="text/javascript" src="jquery.uri.js"></script>
<script type="text/javascript" src="jquery.xmlns.js"></script>
<script type="text/javascript" src="jquery.curie.js"></script>
<script type="text/javascript" src="jquery.datatype.js"></script>
<script type="text/javascript" src="jquery.rdf.js"></script>
<script type="text/javascript" src="jquery.rdfa.js"></script>
-->
<script language="javascript" type="text/javascript" src="js/sha1.js"></script>

<link rel="stylesheet" href="jquery.tabs-ie.css" type="text/css" media="projection, screen" />
	
	
<script type="text/javascript">

/* JQuery Script */
/*****************/       

$(function() {
	$('#container').tabs({ fxFade: true, fxSpeed: 'fast' });
	gGeneratorAgent = 'http://<?php echo $_SERVER['HTTP_HOST'] ?>';
	gErrorReportsTo = 'mailto:error@<?php echo $_SERVER['HTTP_HOST'] ?>';
});

function addf() {
  $("#friends tr:last").clone().appendTo("#friendstable");
  //alert($("#friends tr:last").html());
}

function adda() {
  $("#accounts tr:last").clone().appendTo("#accountstable");
}

function addi() {
  $("#interests tr:last").clone().appendTo("#intereststable");
}

function makeTags() {
	
	// set uri from nick
	if ( $("#nick").val() != "" )
	{
        $("#uri").val($("#nick").val());
	}

	// set homepage from nick
	if ( $("#homepage").val() == "")
	{
        $("#homepage").val( "http://<?php echo $_SERVER['HTTP_HOST'] ?>/" + $("#nick").val() );
	}

    rdf  = '<rdf:RDF\n      xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"\n      ' +
                  'xmlns:rdfs=\"http://www.w3.org/2000/01/rdf-schema#\"\n      ' +
                  'xmlns:foaf=\"http://xmlns.com/foaf/0.1/\"\n      ' +
                  'xmlns:rsa=\"http://www.w3.org/ns/auth/rsa#\"\n      ' +
                  'xmlns:cert=\"http://www.w3.org/ns/auth/cert#\"\n      ' +
                  'xmlns:admin=\"http://webns.net/mvcb/\">\n';

    // preprocess

    // PersonalProfileDocument
    $("[typeof=foaf:PersonalProfileDocument]") .each(function (i) {
	    rdf += makeStartTag(this);
	    $(this).find("[property],[rel]").each( function(){ rdf += (makeTag(this)) ; }  );
		rdf += makeEndTag(this);

    });

    // Person #me
    $("[typeof=foaf:Person]:first").each(function (i) {

	    // Profile
	    rdf += makeStartTag(this);
	    $("#me").find("[property],[rel]").each( function(){ rdf += (makeTag(this)) }  );
	    $("#accounts").find("[property],[rel]").each( function(){ rdf += (makeTag(this)) }  );
	    $("#interests").find("[property],[rel]").each( function(){ rdf += (makeTag(this)) }  );

		// Friends tab
		var friends = '';
		$("#friends [typeof=foaf:Person]").each(function (i) {
		    var friend = ''
			$(this).find("[property],[rel]").each( function(){ friend += '' + makeTag(this)? '        ' + makeTag(this):'' ; }  );
            if (friend) {
	            friends = '        ' + makeStartTag(this);
				friends += friend;
	            friends += '        ' + makeEndTag(this);
				rdf += '    <foaf:knows>\n';
				rdf += friends;
				rdf += '    </foaf:knows>\n';
            }
		});

	    rdf += makeEndTag(this);
    });

	// Security tab
	var id = '';
	var cert = '';
	$("#security [typeof]").each(function (i) {
		$(this).parent().find("[property],[rel]").each( function(){ cert += '' + makeTag(this)? '        ' + makeTag(this):'' ; }  );
		if (cert) {
			id += '    ' + makeStartTag(this);
			id += cert;
			id += '    ' + makeEndTag(this);
		}
	});
	if (id) {
		rdf += '<rdf:Description>\n<rdf:type rdf:resource="http://www.w3.org/ns/auth/rsa#RSAPublicKey"/>\n<cert:identity rdf:resource="#me"/>\n';
		rdf += cert;
		rdf += '</rdf:Description>\n';
	}

    rdf += '</rdf:RDF>\n'
    //alert(rdf);
	$("#rdf").val(rdf);
}

function makeStartTag(el) {
    var about = $(el).attr("about") ? $(el).attr("about") : $(el).find("[rel]").val() ;
    return '<' + $(el).attr("typeof")  + (about?(' rdf:ID="'+about+'"'):(' rdf:about=""'))  + '>\n';
}

function makeEndTag(el) {
    return '</' + $(el).attr("typeof") + '>\n';
}


function makeTag(el) {
    var prop   = $(el).attr("property");
    var type   = $(el).attr("typeof");
    var about  = $(el).attr("about");
    var rel    = $(el).attr("rel");
	var val    = $(el).val();
	var inner  = $(el).attr("inner");
    var href   = $(el).attr("href")?$(el).attr("href"):val;

	if (!val && !href) return '';
	if (rel)           return '    <' + rel  + ' rdf:resource="'+ href +'"' + '/>\n';
	if (prop)          return '    <' + prop + ((inner)?' rdf:parseType="Resource"':'') + '>' + (inner?'<'+inner+'>':'') + val + (inner?'</'+inner+'>':'') + '</' + prop + '>' + '\n';
	if (type)          return '    <' + type + ' rdf:ID="'+ about +'"' + '>' + '</' + type + '>' + '\n';

}

</script>

	
	

</head>

