<?

function headerrdf()
{
	$rdf  = '<rdf:RDF xmlns:cert="http://www.w3.org/ns/auth/cert#"
';
	$rdf .= '	xmlns:foaf="http://xmlns.com/foaf/0.1/"
';
    $rdf .= '	xmlns:rsa="http://www.w3.org/ns/auth/rsa#"
';
	$rdf .= '	xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
';
	
	return $rdf;
}

function accountrdf($foafuri, $nicknameuri)
{
    $rdf  = '<foaf:Person rdf:ID="me">
';
    $rdf .= '    <foaf:nick>'. $nicknameuri .'</foaf:nick>
';
    $rdf .= '    <foaf:homepage rdf:resource="'. $foafuri .'"/>
';
	$rdf .= '	 <foaf:holdsAccount>
';
	$rdf .= '		<foaf:OnlineAccount rdf:about="#acct">
';
	$rdf .= '			<foaf:accountServiceHomePage rdf:resource="/cert/"/>
';
	$rdf .= '		</foaf:OnlineAccount>
';
	$rdf .= '	</foaf:holdsAccount>
';
    $rdf .= '</foaf:Person>
';
	
	

	return $rdf;
}

function certrdf($foafuri=NULL, $exp=NULL, $mod=NULL)
{
	$rdf      = '<rsa:RSAPublicKey>
';
	$foaffile = ($foafuri)?$foafuri:'TYPE YOUR WEBID HERE';

	$rdf     .=	'	<cert:identity rdf:resource="#me"/>
';
	$rdf     .= '	<rsa:public_exponent cert:decimal="';

	$exponent = ($exp)?hexdec($exp):'TYPE THE EXPONENT OF YOUR PUBLIC KEY HERE';

	$rdf     .=	$exponent.'"/>
';
	$rdf     .= '	<rsa:modulus cert:hex="';

	$modulus = ($mod)?$mod:'TYPE THE MODULUS OF YOUR PUBLIC RSA KEY HERE';

	$rdf     .=	$modulus.'"/>
';
	$rdf     .=	'</rsa:RSAPublicKey>
';

	return $rdf;
}

function footerrdf()
{
	$rdf = '</rdf:RDF>';

	return $rdf;
}

function generate_rdf($foafuri, $nicknameuri, $key)
{
	$rdf  = headerrdf();
	$rdf .= accountrdf($foafuri, $nicknameuri);
	if ( $nicknameuri && !empty($key) && $key['exponent'] && $key['modulus'] ) {
		$rdf .= certrdf($nicknameuri, $key['exponent'], $key['modulus']);
	}
	$rdf .= footerrdf();

	return $rdf;
}

?>
