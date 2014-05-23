<?php require_once('Connections/myConnection.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}
if (!isset($_GET["msg"])){
	$_GET["msg"] = "";
	} 

if (isset($_POST['f_username'])) {
  $loginUsername=$_POST['f_username'];
  $password=$_POST['f_password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "home.php";
  $MM_redirectLoginFailed = "Login.php?msg=Username or Password incorrect";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_myConnection, $myConnection);
  
  $LoginRS__query=sprintf("SELECT username, password FROM `user` WHERE username=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $myConnection) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/LoginTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Login</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="960" border="0" align="center" cellpadding="0" cellspacing="0" class="tableboarder">
  <tr>
    <th colspan="2" bgcolor="#00B1EC" scope="col"><img src="images/banner.png" width="960" height="110" alt="telstra Header" /></th>
  </tr>
  <tr>
    <td width="199" valign="top">&nbsp;</td>
    <td width="761">
	<H2>Video Management System</H2>
	<!-- InstanceBeginEditable name="EditRegion3" -->
	<form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>"><table width="500" border="0" cellspacing="0" cellpadding="3">
	  <tr>
	    <td align="right">Username</td>
	    <td><label for="f_username"></label>
	      <input type="text" name="f_username" id="f_username" /></td>
	    </tr>
	  <tr>
	    <td align="right">Password</td>
	    <td><label for="f_password"></label>
	      <input type="password" name="f_password" id="f_password" /></td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td><input type="submit" name="Login" id="Login" value="Login" /><div style="color:#C00;padding:5px;"><?php echo $_GET["msg"];?> </div></td>
	    </tr>
	  </table>
	
	  </form>
	<!-- InstanceEndEditable --></td>
  </tr>
  <tr class="footer">
    <td colspan="2" align="center" bgcolor="#F88200" class="footerText"><img src="images/swinburneLogo.gif" width="66" height="33" class="swinLogo" />Telstra Museum  © 2014 v. 1.2</td>
  </tr>
</table>
</body>
<!-- InstanceEnd --></html>