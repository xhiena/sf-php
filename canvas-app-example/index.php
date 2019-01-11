<?php
//turn on reporting for all errors and display
error_reporting(E_ALL);
ini_set("display_errors", 1);

include("lib/httpful.phar");

//In Canvas via SignedRequest/POST, the authentication should be passed via the signed_request header
//You can also use OAuth/GET based flows
$signedRequest = $_REQUEST['signed_request'];
$consumer_secret = '6942953739291922585';

if ($signedRequest == null || $consumer_secret == null) {
   echo "Error: Signed Request or Consumer Secret not found";
}

//decode the signedRequest
$sep = strpos($signedRequest, '.');
$encodedSig = substr($signedRequest, 0, $sep);
$encodedEnv = substr($signedRequest, $sep + 1);
$calcedSig = base64_encode(hash_hmac("sha256", $encodedEnv, $consumer_secret, true));
if ($calcedSig != $encodedSig) {
   echo "Error: Signed Request Failed.  Is the app in Canvas?";
}

//decode the signed request object
$sr = base64_decode($encodedEnv);

$sf=json_decode($sr);

$access_token = $sf->client->oauthToken;
$instance_url = $sf->client->instanceUrl;
$queryUrl= $sf->context->links->queryUrl;

//define your URI based on the user's instance

$uri = $instance_url.$queryUrl."?q=SELECT+ID,NAME+FROM+ACCOUNT";

echo "Hola ".$sf->context->user->fullName;

$result = \Httpful\Request::get($uri)
    ->Authorization("OAuth ".$access_token)
    ->addHeader("Content-Type","application/json")
    ->send();
$result = json_decode($result);
echo "<pre>";print_r ($result);echo "</pre>";
while($result->done!=1){
	$uri=$instance_url.$result->nextRecordsUrl;
	$result = \Httpful\Request::get($uri)
    ->Authorization("OAuth ".$access_token)
    ->addHeader("Content-Type","application/json")
    ->send();
	$result = json_decode($result);
	echo "<pre>";print_r ($result);echo "</pre>";
}
?>
