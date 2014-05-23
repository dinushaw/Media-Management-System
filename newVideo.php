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

mysql_select_db($database_myConnection, $myConnection);
$query_DeviceList = "SELECT DeviceName, ipaddress FROM devices";
$DeviceList = mysql_query($query_DeviceList, $myConnection) or die(mysql_error());
$row_DeviceList = mysql_fetch_assoc($DeviceList);
$totalRows_DeviceList = mysql_num_rows($DeviceList);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/mainTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Videos</title>
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
    <td width="830" style="padding:10px;"><!-- InstanceBeginEditable name="EditRegion1" --><br />
     <script src="js/jquery.js" type="text/javascript"></script>
     <script src="jqueryFileTree.js" type="text/javascript"></script>
      <script src="js/jquery.easing.js" type="text/javascript"></script>
		<link href="jqueryFileTree.css" rel="stylesheet" type="text/css" media="screen" />
        <script type="text/javascript">
		
      $(document).ready( function() {
    $('#fillist').fileTree({
        root: 'upload/',
        script: '/connectors/jqueryFileTree.php',
        expandSpeed: 1000,
        collapseSpeed: 1000,
        multiFolder: false
    }, function(file) {
        alert(file);
    });
});      
      </script>
      
         <style type="text/css">
      .demo {
				width: 300px;
				height: 400px;
				border-top: solid 1px #BBB;
				border-left: solid 1px #BBB;
				border-bottom: solid 1px #FFF;
				border-right: solid 1px #FFF;
				background: #FFF;
				overflow: scroll;
				padding: 5px;
				margin-left:10px;
				/*float:right;*/
			}
      
      </style>
               
 
        <table width="700" border="0" cellspacing="0" cellpadding="10">
       
            <tr>
              <td></td>
              <td class="cellbg"><div style="width:200px;float:right"><a href="<?php echo $logoutAction ?>">Logout</a> <?php echo $_SESSION['MM_Username'];?></div><p class="instructions"><strong>Instructions </strong></p>
            <ol>
              <li class="instructions">Select Device from Dropdown list </li>
              <li class="instructions">Press Browse to select file from your computer </li>
              <li class="instructions">Press Submit</li>
              <li class="instructions">This process will take a couple of minutes depending on your video size.</li>
            </ol></td>
            </tr>
            <td>&nbsp;</td>
          <td> <form id="upload" method="post" action="upload.php" enctype="multipart/form-data">
          <div style="color:#FFF">Device:</div>
            <select name="devicelist" id="devicelist">
            <?php
do {  
?>
            <option value="<?php echo $row_DeviceList['ipaddress']?>"><?php echo $row_DeviceList['DeviceName'].' - '.$row_DeviceList['ipaddress']?></option>
            <?php
} while ($row_DeviceList = mysql_fetch_assoc($DeviceList));
  $rows = mysql_num_rows($DeviceList);
  if($rows > 0) {
      mysql_data_seek($DeviceList, 0);
	  $row_DeviceList = mysql_fetch_assoc($DeviceList);
  }
?>
            </select>
            <br />
            
                    		
			<div id="drop">
				Drop Files Here

				<a>Browse</a>
				<input type="file" name="upl" multiple />
			</div>
			<ul>
				<!-- The file uploads will be shown here -->
			</ul>

		</form>
        

		<!--<div id="fillist" class="demo"></div>-->
            </td>
          </tr>
        <tr>
          <td colspan="2"><hr /></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td><p><a href="javascript:ListAllFiles('php_includes/view_files_list.php')"><img src="images/listallvideos.png" alt="List all videos" width="165" height="31" /></a>
          <div id="msg2"></div>
          </p></td>
        </tr>
        <tr>
          <td colspan="2"><hr /></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>
            <p>
              <a href="javascript:confirmDelete('php_includes/removeAllFiles.php')" onclick=""><img src="images/removeall.png" alt="remove all videos" width="165" height="31" /></a>
              
              
              <script>
function confirmDelete(delUrl) {
	
	var e = document.getElementById("devicelist");
var strUser = e.options[e.selectedIndex].value;
var mystr = "?deviceid="+strUser;

  if (confirm("Are you sure you want to delete ALL files from "+strUser)) {
    document.location = delUrl+mystr;
  }
}


function ListAllFiles(Url) {
	
var e = document.getElementById("devicelist");
var strUser = e.options[e.selectedIndex].value;
var mystr = "?deviceid="+strUser;

    $.get(Url+mystr, function (data){
		$("#msg2").empty().append(data);
		
		//alert( "Data Loaded: " + data );	
		}).done($("#msg2").empty().append("Plese Wait..."))
		  .fail($("#msg2").empty().append("Error!!"))
		  .always($("#msg2").empty().append("<img src='images/loading.gif' class='imgs' /> Plese wait. Connecting Device..."));

  
}


function downloadZip(Url) {
	
	var e = document.getElementById("devicelist");
var strUser = e.options[e.selectedIndex].value;
var mystr = "?deviceid="+strUser;

    $.get(Url+mystr, function (data){
		$("#msg3").empty().append(data);
		
		//alert( "Data Loaded: " + data );	
		}).done($("#msg3").empty().append("Plese Wait..."))
		  .fail($("#msg3").empty().append("Error!! JS"))
		  .always($("#msg3").empty().append("<img src='images/loading.gif' class='imgs' /> Plese wait. Preparing Files..."));


}


            </script></p></td>
        </tr>
        <tr>
          <td colspan="2"><hr /></td>
          </tr>

        <tr>
        <td>&nbsp;</td>
          <td colspan="2" class=""><p><a href="javascript:downloadZip('php_includes/dowloadzip.php')"><img src="images/downloadbackup.png" alt="download Backup" width="165" height="31" /></a></p>
          </p>            <div id="msg3"></div></td>
          <td colspan="2"><hr /></td>
        </tr>
        <tr>
          <td colspan="3"><hr /></td>
          <td colspan="2">&nbsp;</td>
        </tr>
        </table>
        </form>
       
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="assets/js/jquery.knob.js"></script>

		<!-- jQuery File Upload Dependencies -->
		<script src="assets/js/jquery.ui.widget.js"></script>
		<script src="assets/js/jquery.iframe-transport.js"></script>
		<script src="assets/js/jquery.fileupload.js"></script>
		
		<!-- Our main JS file -->
		<script src="assets/js/script.js"></script>
        <link href="http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700" rel='stylesheet' />

        
        		
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
mysql_free_result($DeviceList);
?>
