<?php
require_once 'token.php';
require_once 'common.php';

if (isset($_REQUEST['token'])) {
	$token = $_REQUEST['token'];
}
else {
	$token = $_SESSION['token'];
}

$pathSegments = explode('/',$_SERVER['PHP_SELF']);
$numSegment = count($pathSegments);
$currentFolder = $pathSegments[$numSegment - 2];
$page = $pathSegments[$numSegment -1];

if ($page == "bootstrap-view.php" || $page == "bootstrap.php")
{	
	if ($_SESSION['admin'] != 1){
			$_SESSION['errors'] =  "not admin user";
			#header("Location: index.php");
		}

}
elseif ($currentFolder == "json" && !verify_token($token))
{
	$result = [
            "status"=>"error",
            "message"=>"token is invalid"
        ];
    
 	header('Content-Type: application/json');
 	echo json_encode($result, JSON_PRETTY_PRINT);
 	exit();
}
elseif (!verify_token($token)) {
     $_SESSION['errors'] =  ["token is invalid"];
     
     header("Location: index.php");
}



?>