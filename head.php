<?php 

session_start();

$agent = (!empty($_SESSION['auth']) && $_SESSION['auth']['subjectAltName'])? $_SESSION['auth']['subjectAltName'] : '';
$agent = isset($_REQUEST['webid']) ? $_REQUEST['webid'] : $agent;

/*
 * Settings for the IdP. The following two variables may change with
 * another IdP.
 */

$sigalg = "rsa-sha1";
$idp_certificate = "foafssl.org-cert.pem";

/*
 * Verifies the WebID
 */

$webid = "";

/* Reconstructs the signed message: the URI except the 'sig' parameter */
$full_uri = ($_SERVER["HTTPS"] == "on" ? "https" : "http")
. "://" . $_SERVER["HTTP_HOST"]
. ($_SERVER["SERVER_PORT"] != ($_SERVER["HTTPS"] == "on" ? 443 : 80) ? ":".$_SERVER["SERVER_PORT"] : "")
. $_SERVER["REQUEST_URI"];

$signed_info = substr($full_uri, 0, -5-strlen(urlencode($_GET["sig"])));

/* Extracts the signature */
$signature = base64_decode($_GET["sig"]);

/* Only rsa-sha1 is supported at the moment. */
if ($sigalg == "rsa-sha1") {
        /*
         * Loads the trusted certificate of the IdP: its public key is used to
         * verify the integrity of the signed assertion.
         */
        $fp = fopen($idp_certificate, "r");
        $cert = fread($fp, 8192);
        fclose($fp);

        $pubkeyid = openssl_get_publickey($cert);

        /* Verifies the signature */
        $verified = openssl_verify($signed_info, $signature, $pubkeyid);
        if ($verified == 1) {
                // The verification was successful.
                $webid = $_GET["webid"];
        } elseif ($verified == 0) {
                // The signature didn't match.
                $webid = "";
        } else {
                // Error during the verification.
                $webid = "";
        }

        openssl_free_key($pubkeyid);
} else {
        // Unsupported signature algorithm.
        $webid = "";
}

?>
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<!-- <base href="<?= $agent ?>"> -->
<title>FOAF Me</title>
<link rel="stylesheet" href="css/jquery.tabs.css" type="text/css" media="print, projection, screen" />
<!--
<link rel="shortcut icon" href="/img/favicon.png" type="image/png" />	
-->
<link rel="stylesheet" type="text/css" title="default" href="css/main.css" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script type="text/javascript" src="js/jquery/1.3.1/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery/jquery.tabs.pack.js"></script>
<script type="text/javascript" src="js/jquery.rdfquery.core-1.0.js"></script>
<script type="text/javascript" src="js/jquery.rdfquery.rdfa-1.0.js"></script>
<script type="text/javascript" src="js/jquery.rdfquery.rules-1.0.js"></script>
<script type="text/javascript" src="js/jquery.editinplace.js"></script>
<script type="text/javascript" src="js/jquery.json-1.3.js"></script>


<link rel="stylesheet" href="jquery.tabs-ie.css" type="text/css" media="projection, screen" />
	
	
<script type="text/javascript">
// <!--

/* JQuery Script */
/*****************/       

$(function() {
	$('#container').tabs({ fxFade: true, fxSpeed: 'fast' });
	gGeneratorAgent = 'http://<?php echo $_SERVER['HTTP_HOST'] ?>';
	gErrorReportsTo = 'mailto:error@<?php echo $_SERVER['HTTP_HOST'] ?>';
	sparul();
});



function del(el) {
	str = "#" + el;
	frag = $(str).parent().parent().rdf().databank.triples()[0].subject.value;

	var re = new RegExp("[0-9A-Za-z]*$","ig");
    var resultArray = re.exec(frag);

	while (resultArray) {
		frag = resultArray[0];
		resultArray = re.exec(str);
	}

	frag = "<?= $agent ?>#" + frag;
	//alert("sparul.php?uri=<?= $agent ?>&delete=" + escape(frag));
	$.post("sparul.php?uri=<?= $agent ?>&delete=" + escape(frag));

	$(str).parent().parent().remove();
	//location.reload();

}

function addf(el) {

	if ($("#friendstable tr:last td:last input").attr("name") == "friend1") {

		var about = $("#friendstable tr:last").attr("about");
		var lastFriend = about != undefined? about.replace(/.*friend/, "") : -1;
		lastFriend++;
		//alert (lastFriend)

		var clone = $("#friendstable tr:last").clone();
		clone.attr({about : '#friend' + lastFriend });

		clone.appendTo("#friendstable");
		return;
	}

	var last = $("#friendstable tr:last");
	if (last == null) {
	} else {
		var about = $("#friendstable tr:last").attr("about");
		var lastFriend = about != undefined? about.replace(/.*friend/, "") : -1;
		lastFriend++;
		//alert (lastFriend)
		$("#friendstable tr:last").after("<tr about=<?= $agent ?>#friend"+lastFriend+" typeof=foaf:Person property=foaf:knows><td>Friend</td><td><span property=foaf:name></span></td><td><a rel=refs:seeAlso></a></td><td><a>x</a></td></tr>");
		sparul();
	}
}


function sparul() {
	$("span[property]").editInPlace({ url: 'sparul.php' , params: 'uri=<?= $agent ?>' })
	$("span[rel]").editInPlace({ url: 'sparul.php' , params: 'uri=<?= $agent ?>' })
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

    rdf  = '<rdf:RDF xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"\n      ' +
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

// -->
</script>

	
	

</head>

<? $headedLoaded = true ?>