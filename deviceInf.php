<?php require_once('Connections/myConnection.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

//function DeleteDevice(){
	if(!isset($_GET['run'])){
		$_GET['run']='no';
		}
	
	if(isset($_GET['ipaddress'] )&& $_GET['run']=='yes' ){
	
	if ((isset($_GET['ipaddress'])) && ($_GET['ipaddress'] != "")) {
  $deleteSQL = sprintf("DELETE FROM devices WHERE ipaddress=%s",
                       GetSQLValueString($_GET['ipaddress'], "text"));

  mysql_select_db($database_myConnection, $myConnection);
  $Result1 = mysql_query($deleteSQL, $myConnection) or die(mysql_error());

  $deleteGoTo = "home.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$ip_Recordset1 = "0";
if (isset($_GET['ipaddress'])) {
  $ip_Recordset1 =$_GET['ipaddress'];
}
   header( 'Location: /home.php' ) ;

	}
	
	//}

$ip_Recordset1 = "-1";
if (isset($_GET['ipaddress'])) {
  $ip_Recordset1 = $_GET['ipaddress'];
}
mysql_select_db($database_myConnection, $myConnection);
$query_Recordset1 = sprintf("SELECT devices.DeviceName, devices.ipaddress, devices.discription FROM devices WHERE devices.ipaddress=%s", GetSQLValueString($ip_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $myConnection) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/mainTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Device Information</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>

<table width="960" align="center" cellpadding="0" cellspacing="0" class="tableboarder">
  <tr>
    <th colspan="2" bgcolor="#F88200" scope="col"><img src="images/banner.png" width="960" height="110" alt="telstra Header" /></th>
  </tr>
  
  <tr class="tableboarder">
    <td width="250" valign="top" bgcolor="#EEEEEE"><ul id="MenuBar1" class="MenuBarVertical">
      <li><a href="home.php"><img src="images/home.png" width="16" height="16" class="imgs" />Dashboard</a>        </li>
      <li><a href="#" class="MenuBarItemSubmenu"><img src="images/videos.png" width="16" height="16" class="imgs" />Videos </a>
        <ul>
          <li><a href="allfiles2.php">Video Library</a></li>
          <li><a href="newVideo.php">Upload Videos</a></li>
        </ul>
      </li>
      <li><a href="#" class="MenuBarItemSubmenu"><img src="images/Configuration.png" width="16" height="16" class="imgs" />Settings</a>
        <ul>
          <li><a href="newDevice.php">Devices</a></li>
          <li><a href="newuser.php">Users</a></li>
        </ul>
      </li>
      <li><a href="help.php"><img src="images/tool.png" width="16" height="16" class="imgs" />Tools</a></li>
</ul></td>
    <td width="830" style="padding:10px;"><!-- InstanceBeginEditable name="EditRegion1" -->

      
      
      <div style="width:200px;float:right"><a href="<?php echo $logoutAction ?>">Logout</a> <?php echo $_SESSION['MM_Username'];?></div><p><img src="images/tv_icon.png" width="16" height="16" class="imgs" />Device infomation</p>
      
      
      <table width="400" border="0" cellspacing="0" cellpadding="5">
        <tr>
          <td><strong>Name</strong></td>
          <td><?php echo $row_Recordset1['DeviceName']; ?></td>
        </tr>
        <tr>
          <td><strong>IP</strong></td>
          <td><?php echo $row_Recordset1['ipaddress']; ?></td>
          
        </tr>
        <tr>
          <td><strong>Status </strong></td>
          <td><?php echo hostup($row_Recordset1['ipaddress']); ?></td>
        </tr>
        <tr>
          <td><strong>Description</strong></td>
          <td><?php echo $row_Recordset1['discription']; ?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><a href="deviceInf.php?run=yes&amp;ipaddress=<?php echo $row_Recordset1['ipaddress']; ?>"  >Delete Device</a></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>
            <?php 
		  




//echo var_dump($ping);

		  
		   function hostup($link) 
    { 
        
		$ping = exec("ping -c 1 -s 64 -t 64 ".$link);
         if (!$ping) { 
            $text=" <img  src=\"images/red_icon.png\" width=\"16\" height=\"16\" />"; 
         }else{ 
            $text="<img  src=\"images/green_icon.png\" width=\"16\" height=\"16\" /> Connected"; 
         } 
         return $text; 
    }  
		  

		  
		  ?>
            
            
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td></td>
        </tr>
      </table>
      <p>&nbsp;</p>
    <!-- InstanceEndEditable --></td>
  </tr>
 
  <tr class="footer">
    <td colspan="2" align="center" class="footerText"><p><span class="swinLogo"><a href="php_includes/credits.php"><img src="images/swinburneLogo.gif" width="68" height="33" class="swinLogo" /></a></span>  Telstra Museum  © 2014 v. 1.2
    </p>
      <p class="swinLogo">&nbsp;</p>
      <p class="swinLogo">&nbsp;</p>
    <p class="swinLogo">&nbsp;</p>
    <p class="swinLogo">&nbsp;</p>
    <p class="swinLogo">&nbsp;</p>
    <p class="swinLogo">&nbsp;</p>
    <p class="swinLogo">&nbsp;</p>
    <p class="swinLogo"><br />
    </p>
    <p class="swinLogo">&nbsp;</p>
    <p class="swinLogo">&nbsp;</p></td>
  </tr>
</table>

<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgRight:"../SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($Recordset1);
?>
