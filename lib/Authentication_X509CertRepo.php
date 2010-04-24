<?php
//-----------------------------------------------------------------------------------------------------------------------------------
//
// Filename   : Authentication_X509CertRepo.php
// Date       : 26th Mar 2010
//
// Copyright 2008-2010 foaf.me
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU Affero General Public License for more details.
//
// You should have received a copy of the GNU Affero General Public License
// along with this program. If not, see <http://www.gnu.org/licenses/>.
//
// "Everything should be made as simple as possible, but no simpler."
// -- Albert Einstein
//
//-----------------------------------------------------------------------------------------------------------------------------------


/**
 * An X509Certificate repository
 *
 * @author László Török
 */
class Authentication_X509CertRepo
{
    const DEFAULT_IDP = 'foafssl.org';
    
    private $IDPCertificates = array ( self::DEFAULT_IDP =>
"-----BEGIN CERTIFICATE-----
MIIDQzCCAqygAwIBAgIDC3vTMA0GCSqGSIb3DQEBBQUAMFoxCzAJBgNVBAYTAlVT
MRwwGgYDVQQKExNFcXVpZmF4IFNlY3VyZSBJbmMuMS0wKwYDVQQDEyRFcXVpZmF4
IFNlY3VyZSBHbG9iYWwgZUJ1c2luZXNzIENBLTEwHhcNMDkwNTAyMDk0NjUyWhcN
MTAwNjAyMDk0NjUyWjCBsjELMAkGA1UEBhMCRlIxFDASBgNVBAoTC2ZvYWZzc2wu
b3JnMRMwEQYDVQQLEwpHVDI4MTEzNDQ2MTEwLwYDVQQLEyhTZWUgd3d3LnJhcGlk
c3NsLmNvbS9yZXNvdXJjZXMvY3BzIChjKTA5MS8wLQYDVQQLEyZEb21haW4gQ29u
dHJvbCBWYWxpZGF0ZWQgLSBSYXBpZFNTTChSKTEUMBIGA1UEAxMLZm9hZnNzbC5v
cmcwgZ8wDQYJKoZIhvcNAQEBBQADgY0AMIGJAoGBAJ8mIxypIeBmITFG64JczdHh
kyIe6GdPdZzyhsVbVbBwJeAnXLuDBe6T+2A1alMuw6zaguUsb4fwN5oNDUaBxzqP
kLJGftZU4+V/Q6+O3RPXILd5/b/fJgKPcb9jCliMzao1o1IsmY6lfp8vx3QvRB7g
cOtCYZyROjQz8iIHFwABAgMBAAGjgb0wgbowDgYDVR0PAQH/BAQDAgTwMB0GA1Ud
DgQWBBRecxqmtOkjohLmNbyY7QyunrETajA7BgNVHR8ENDAyMDCgLqAshipodHRw
Oi8vY3JsLmdlb3RydXN0LmNvbS9jcmxzL2dsb2JhbGNhMS5jcmwwHwYDVR0jBBgw
FoAUvqigdHJQa0S3ySPY+6j/s1draGwwHQYDVR0lBBYwFAYIKwYBBQUHAwEGCCsG
AQUFBwMCMAwGA1UdEwEB/wQCMAAwDQYJKoZIhvcNAQEFBQADgYEAHz0k4c+sGNu1
Z/JWtoWOo8m4h4fFLFVn2nMur4fC7uKJCS/uUmqrPY3kNCs36Sn9yy6Ek+RMJNnm
9ctec/tRLIQt2pi5M/6A+1so6CDw1gzAGcLlKzzcgU0nI2u3CuyX22VPbeAi21vI
04BmchTSfqsZRx0rzIlznBSVp+4V17I=
-----END CERTIFICATE-----
");
    public function  __construct(array $IDPCertificates = array())
    {
        $this->IDPCertificates =
                array_merge($this->IDPCertificates, $IDPCertificates);
    }

    /**
     * Get the Identity Provider's certificate
     * @param string $IPDDomainName Identity Provider's domain name
     *        (e.g. foafssl.org)
     * @return object requiested x509 certificate content
     *         (or the default IDP's certificate, if the requested is not found)
     */
    public function getIdpCertificate($IDPDomainName)
    {
       return isset($this->IDPCertificates[$IDPDomainName]) ?
               $this->IDPCertificates[$IDPDomainName]
              : $this->IDPCertificates[self::DEFAULT_IDP];
    }
}
?>
