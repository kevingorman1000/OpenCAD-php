<?php
/**
Open source CAD system for RolePlaying Communities.
Copyright (C) 2017 Shane Gill

This program is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

This program comes with ABSOLUTELY NO WARRANTY; Use at your own risk.
**/

require_once(__DIR__ . "/../oc-config.php");

if (isset($_GET['responder']))
{
	logoutResponder();
}

//Need to make sure they're out of the activeUsers table
function logoutResponder()
{
	$identifier = htmlspecialchars($_GET['responder']);

	try{
		$pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
	} catch(PDOException $ex)
	{
throw_new_error("DB Connection Error", "0xe133fd5eb502 Error Occured: " . $ex->getMessage());
die();
		die();
	}

	$stmt = $pdo->prepare("DELETE FROM ".DB_PREFIX."activeUsers WHERE identifier = ?");
	$result = $stmt->execute(array($identifier));

	if (!$result)
	{
		$_SESSION['error'] = $stmt->errorInfo();
		header(ERRORREDIRECT);
		die();
	}
	$pdo = null;
}

isSessionStarted();
session_unset();
session_destroy();
setcookie($name = htmlspecialchars(COOKIE_NAME), null, -1, "/", null, true, true);

do_hook('logout_success');


header("Location: ".BASE_URL."/index.php?loggedOut=true");
exit();
?>