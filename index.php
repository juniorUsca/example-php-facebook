<?php
/*
include_once("php-graph-sdk/src/Facebook/Authentication/AccessToken.php");
include_once("php-graph-sdk/src/Facebook/Authentication/OAuth2Client.php");
include_once("php-graph-sdk/src/Facebook/FileUpload/FacebookFile.php");
include_once("php-graph-sdk/src/Facebook/FileUpload/FacebookResumableUploader.php");
include_once("php-graph-sdk/src/Facebook/FileUpload/FacebookTransferChunk.php");
include_once("php-graph-sdk/src/Facebook/FileUpload/FacebookVideo.php");
include_once("php-graph-sdk/src/Facebook/GraphNodes/GraphEdge.php");
include_once("php-graph-sdk/src/Facebook/Url/UrlDetectionInterface.php");
include_once("php-graph-sdk/src/Facebook/Url/FacebookUrlDetectionHandler.php");
include_once("php-graph-sdk/src/Facebook/PseudoRandomString/PseudoRandomStringGeneratorFactory.php");
include_once("php-graph-sdk/src/Facebook/PseudoRandomString/PseudoRandomStringGeneratorInterface.php");
include_once("php-graph-sdk/src/Facebook/HttpClients/HttpClientsFactory.php");
include_once("php-graph-sdk/src/Facebook/PersistentData/PersistentDataFactory.php");
include_once("php-graph-sdk/src/Facebook/PersistentData/PersistentDataInterface.php");
include_once("php-graph-sdk/src/Facebook/Helpers/FacebookCanvasHelper.php");
include_once("php-graph-sdk/src/Facebook/Helpers/FacebookJavaScriptHelper.php");
include_once("php-graph-sdk/src/Facebook/Helpers/FacebookPageTabHelper.php");
include_once("php-graph-sdk/src/Facebook/Helpers/FacebookRedirectLoginHelper.php");
include_once("php-graph-sdk/src/Facebook/Exceptions/FacebookSDKException.php");
include_once("php-graph-sdk/src/Facebook/FacebookApp.php");
include_once("php-graph-sdk/src/Facebook/Facebook.php");
include_once("php-graph-sdk/src/Facebook/FacebookApp.php");
include_once("php-graph-sdk/src/Facebook/FacebookClient.php");
 */

require "php-graph-sdk/src/Facebook/autoload.php";
if(!session_id()) {
    session_start();
}

/*$helper = new \Facebook\FacebookRedirectLoginHelper('localhost/php-facebook');
try {
    $session = $helper->getSessionFromRedirect();
} catch(FacebookRequestException $ex) {
    // When Facebook returns an error
} catch(\Exception $ex) {
    // When validation fails or other local issues
}
if ($session) {
  // Logged in.
  echo "log";
}*/

//$fb = new \Facebook\Facebook([
$fb = new \Facebook\Facebook([
  'app_id' => '861138777347588',
  'app_secret' => 'f043fc439d5bae2f87550b7a7f73c753',
  'default_graph_version' => 'v2.8',
  //'default_access_token' => '{access-token}', // optional
]);

echo json_encode ($fb);

// Use one of the helper classes to get a Facebook\Authentication\AccessToken entity.
   $helper = $fb->getRedirectLoginHelper();
//   $helper = $fb->getJavaScriptHelper();
//   $helper = $fb->getCanvasHelper();
//   $helper = $fb->getPageTabHelper();


//$helper = $fb->getRedirectLoginHelper();
try {
  $accessToken = $helper->getAccessToken();
  echo $accessToken;
  echo "getted?";
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo "here";
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (isset($accessToken)) {
  // Logged in!
  echo $accessToken;
  echo "Logged in!";
  $_SESSION['facebook_access_token'] = (string) $accessToken;

  // Now you can redirect to another page and use the
  // access token from $_SESSION['facebook_access_token']
}
else {

  $permissions = ['email'];
$loginUrl = $helper->getLoginUrl('http://localhost/php-facebook/', $permissions);
header('Location: '.$loginUrl);

}




try {
  // Get the \Facebook\GraphNodes\GraphUser object for the current user.
  // If you provided a 'default_access_token', the '{access-token}' is optional.
  $response = $fb->get('/me?fields=id,name,email,first_name,last_name', $accessToken);
} catch(\Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(\Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$me = $response->getGraphUser();
echo 'Logged in as ' . $me->getName();

echo json_encode ($response->getDecodedBody());
