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


$ip_Recordset1 = $_GET['ipaddress'];
if(isset($_GET['ipaddress'])) {
  $ip_Recordset1 = $_GET['ipaddress'];
}

mysql_select_db($database_myConnection, $myConnection);
$query_Recordset1 = sprintf("SELECT DeviceName, ipaddress, discription, dateadded FROM devices  WHERE devices.ipaddress=%s", GetSQLValueString($ip_Recordset1, "text"));
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
      <p>Device Information </p>
      <table width="400" border="0" cellspacing="0" cellpadding="10">
        <tr>
          <td>Name</td>
          <td><?php echo $row_Recordset1['DeviceName']; ?></td>
        </tr>
        <tr>
          <td>IP Address</td>
          <td><?php echo $row_Recordset1['ipaddress']; ?></td>
        </tr>
        <tr>
          <td>Discription </td>
          <td><?php echo $row_Recordset1['discription']; ?></td>
        </tr>
        <tr>
          <td>Date Added</td>
          <td><?php echo $row_Recordset1['dateadded']; ?></td>
        </tr>
		<?php
mysql_free_result($Recordset1);
?>
      </table>
  
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