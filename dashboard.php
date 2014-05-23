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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "jump")) {
  $insertSQL = sprintf("INSERT INTO devices (DeviceName, ipaddress) VALUES (%s, %s)",
                       GetSQLValueString($_POST['DeviceName'], "text"),
                       GetSQLValueString($_POST['ipaddress'], "text"));

  mysql_select_db($database_myConnection, $myConnection);
  $Result1 = mysql_query($insertSQL, $myConnection) or die(mysql_error());

  $insertGoTo = "dashboard.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_GET['ipaddress'])) && ($_GET['ipaddress'] != "")) {
  $deleteSQL = sprintf("DELETE FROM devices WHERE ipaddress=%s",
                       GetSQLValueString($_GET['ipaddress'], "text"));

  mysql_select_db($database_myConnection, $myConnection);
  $Result1 = mysql_query($deleteSQL, $myConnection) or die(mysql_error());

  $deleteGoTo = "dashboard.php?ipaddress=''";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$maxRows_devices = 10;
$pageNum_devices = 0;
if (isset($_GET['pageNum_devices'])) {
  $pageNum_devices = $_GET['pageNum_devices'];
}
$startRow_devices = $pageNum_devices * $maxRows_devices;

mysql_select_db($database_myConnection, $myConnection);
$query_devices = "SELECT * FROM devices";
$query_limit_devices = sprintf("%s LIMIT %d, %d", $query_devices, $startRow_devices, $maxRows_devices);
$devices = mysql_query($query_limit_devices, $myConnection) or die(mysql_error());
$row_devices = mysql_fetch_assoc($devices);

if (isset($_GET['totalRows_devices'])) {
  $totalRows_devices = $_GET['totalRows_devices'];
} else {
  $all_devices = mysql_query($query_devices);
  $totalRows_devices = mysql_num_rows($all_devices);
}
$totalPages_devices = ceil($totalRows_devices/$maxRows_devices)-1;$maxRows_devices = 10;
$pageNum_devices = 0;
if (isset($_GET['pageNum_devices'])) {
  $pageNum_devices = $_GET['pageNum_devices'];
}
$startRow_devices = $pageNum_devices * $maxRows_devices;

mysql_select_db($database_myConnection, $myConnection);
$query_devices = "SELECT * FROM devices";
$query_limit_devices = sprintf("%s LIMIT %d, %d", $query_devices, $startRow_devices, $maxRows_devices);
$devices = mysql_query($query_limit_devices, $myConnection) or die(mysql_error());
$row_devices = mysql_fetch_assoc($devices);

if (isset($_GET['totalRows_devices'])) {
  $totalRows_devices = $_GET['totalRows_devices'];
} else {
  $all_devices = mysql_query($query_devices);
  $totalRows_devices = mysql_num_rows($all_devices);
}
$totalPages_devices = ceil($totalRows_devices/$maxRows_devices)-1;
?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/templeate.dwt" codeOutsideHTMLIsLocked="false" -->
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <!-- InstanceBeginEditable name="doctitle" -->
  <title>Dashboard</title>
  <link href="SpryAssets/SpryAccordion.css" rel="stylesheet" type="text/css" />
  <!-- InstanceEndEditable -->
  <link href="style.css" rel="stylesheet" type="text/css" />
  <!-- InstanceBeginEditable name="head" -->
  <script src="SpryAssets/SpryAccordion.js" type="text/javascript"></script>
  <!-- InstanceEndEditable -->
  </head>
  
  <body>
  <img src="images/hd-telstra-museums.png" width="594" height="110" alt="Telstra Museums" />
  <h1>Museum Display Management Portal</h1>

  <hr />
  <div>
  <!-- InstanceBeginEditable name="EditRegion1" -->
    <h4>Dashbord
      <script language="javascript1.2" type="text/javascript">
function  changeLocation(locationUrl)
{
 document.getElementById('iframetest').src=locationUrl

}
      </script>
</head>

<body>
</h4>
  <form method="POST" action="<?php echo $editFormAction; ?>" name="jump" target="iframetest">
    <div style="text-align:left" ><p>
	<?php echo $_SESSION['MM_Username'];?> 
	
	<?php if(isset($_SESSION['MM_Username'])){
			echo '<a href="'.$logoutAction.'"> Logout </a>';
		}else{
			echo " ";
			} ?>
            
            </p></div>
    <div id="Accordion1" class="Accordion" tabindex="0">
      <div class="AccordionPanel">
        <div class="AccordionPanelTab"><strong>Register New Raspberry Pi</strong></div>
        <div class="AccordionPanelContent">
          <table align="left">
            <tr valign="baseline">
            <td nowrap="nowrap" align="right">DeviceName:</td>
            <td><input type="text" name="DeviceName" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Ipaddress:</td>
            <td><input type="text" name="ipaddress" value="" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Register Device" /></td>
          </tr>
      </table>
        <input type="hidden" name="MM_insert" value="jump" />
        </div>
      </div>
      <div class="AccordionPanel">
        <div class="AccordionPanelTab"><strong>Available Devices</strong></div>
        <div class="AccordionPanelContent">
          <p>
            <?php do { ?>
              &nbsp;<?php echo $row_devices['DeviceName']; ?>   <?php echo $row_devices['ipaddress']; ?> 
              <a href="<?php echo '/dashboard.php?ipaddress='.$row_devices['ipaddress'];?> ">Delete </a><p >
              
<?php } while ($row_devices = mysql_fetch_assoc($devices)); ?>
          
          <p>&nbsp;</p>
       
        </div>
      </div>
    </div>
    <p>&nbsp;</p>
    <p>&nbsp;
      
  Add New User    
    <p><a href="viewer.php">Viewer</a>    
    <p>    
  </form>
  <p>&nbsp;</p>
  <p>&nbsp;</p>

  <!-- InstanceEndEditable -->
    
    <p>&nbsp;</p>
  </div>
  <hr />
  <p>Copyright &copy; 2014</p>
  </body>
  <!-- InstanceEnd --></html>
  <?php
mysql_free_result($devices);
?>
