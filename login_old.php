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

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "access";
  $MM_redirectLoginSuccess = "dashboard.php";
  $MM_redirectLoginFailed = "index.php?msg=\"Invalid Username or Password\"";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_myConnection, $myConnection);
  	
  $LoginRS__query=sprintf("SELECT username, password, access FROM `user` WHERE username=%s AND password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $myConnection) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'access');
    
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
  <html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/templeate.dwt" codeOutsideHTMLIsLocked="false" -->
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <!-- InstanceBeginEditable name="doctitle" -->
  <title>Login : Display Management System</title>
  <!-- InstanceEndEditable -->
  <link href="style.css" rel="stylesheet" type="text/css" />
  <!-- InstanceBeginEditable name="head" -->
  <!-- InstanceEndEditable -->
  </head>
  
  <body>
  <img src="images/hd-telstra-museums.png" width="594" height="110" alt="Telstra Museums" />
  <h1>Museum Display Management Portal</h1>

  <hr />
  <div><!-- InstanceBeginEditable name="EditRegion1" --><form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
    <table width="366" border="0" align="left">
      <tr>
        <td width="64" scope="col">Username</td>
        <th width="292" align="left" scope="col">
          <label for="username"></label>
          <input type="text" name="username" id="username" />
   </th>
      </tr>
      <tr>
        <td>Password</td>
        <td><label for="password"></label>
        <input type="password" name="password" id="password" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>
          <input type="submit" name="Login" id="Login" value="Login" /> 
          <a href="#">Forgot Password?</a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;<div style="color:#F30;" ><?php echo $_GET["msg"];?></div></td>
      </tr>
    </table>     
    </form>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
  <!-- InstanceEndEditable -->
    
    <p>&nbsp;</p>
  </div>
  <hr />
  <p>Copyright &copy; 2014</p>
  </body>
  <!-- InstanceEnd --></html>
