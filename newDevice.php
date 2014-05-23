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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO devices (DeviceName, ipaddress, discription) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['deviceName'], "text"),
                       GetSQLValueString($_POST['ipaddress'], "text"),
                       GetSQLValueString($_POST['discription'], "text"));

  mysql_select_db($database_myConnection, $myConnection);
  $Result1 = mysql_query($insertSQL, $myConnection) or die(mysql_error());

  $insertGoTo = "home.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if(!isset($_GET['run'])){
		$_GET['run']='no';
		}
		
		if(isset($_GET['ipaddress'] )&& $_GET['run']=='yes' ){


if ((isset($_GET['ipaddress'])) && ($_GET['ipaddress'] != "")) {
  $deleteSQL = sprintf("DELETE FROM devices WHERE ipaddress=%s",
                       GetSQLValueString($_GET['ipaddress'], "text"));

  mysql_select_db($database_myConnection, $myConnection);
  $Result1 = mysql_query($deleteSQL, $myConnection) or die(mysql_error());

  $deleteGoTo = "newDevice.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $deleteGoTo));
  
}
		}

mysql_select_db($database_myConnection, $myConnection);
$query_Recordset1 = "SELECT devices.DeviceName, devices.ipaddress, devices.discription FROM devices";
$Recordset1 = mysql_query($query_Recordset1, $myConnection) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/mainTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Device</title>
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
      <form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
        <p><strong>All Available Devices:        </strong></p>
        <table border="0" cellpadding="5" class="cellbg">
          <tr>
            <td><strong>DeviceName</strong></td>
            <td><strong>ipaddress</strong></td>
            <td><strong>Discription</strong></td>
            <td>&nbsp;</td>
          </tr>
          <?php do { ?>
            <tr>
              <td><?php echo $row_Recordset1['DeviceName']; ?></td>
              <td><?php echo $row_Recordset1['ipaddress']; ?></td>
              <td><?php echo $row_Recordset1['discription']; ?></td>
              <td><a href="newDevice.php?run=yes&amp;ipaddress=<?php echo $row_Recordset1['ipaddress']; ?>"><img src="images/Delete.png" width="16" height="16" /></a></td>
            </tr>
            <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
        </table>
        <p>&nbsp;</p>
        <hr />
        <p><strong>Add New Device:</strong></p>
        <table width="400" border="0" cellspacing="0" cellpadding="10">
          <tr>
            <td>Name</td>
            <td><label for="deviceName"></label>
            <input type="text" name="deviceName" id="deviceName" /></td>
          </tr>
          <tr>
            <td>IPAddress</td>
            <td><label for="ipaddress"></label>
            <input type="text" name="ipaddress" id="ipaddress" /> </td>
          </tr>
          <tr>
            <td valign="top">Discription</td>
            <td><label for="discription"></label>
            <textarea name="discription" id="discription" cols="45" rows="5"></textarea></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="submit" id="submit" value="Save" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1" />
      </form>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>
        
      </p>
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
