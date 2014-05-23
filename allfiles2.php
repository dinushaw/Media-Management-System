<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/mainTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>View All Files</title>
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


<!-- jQuery and jQuery UI (REQUIRED) -->
		<link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css">
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>

		<!-- elFinder CSS (REQUIRED) -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/elfinder.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/theme.css">

		<!-- elFinder JS (REQUIRED) -->
		<script type="text/javascript" src="js/elfinder.min.js"></script>

		<!-- elFinder translation (OPTIONAL) -->
		<script type="text/javascript" src="js/i18n/elfinder.ru.js"></script>

		<!-- elFinder initialization (REQUIRED) -->
		<script type="text/javascript" charset="utf-8">
			$().ready(function() {
				var elf = $('#elfinder').elfinder({
					url : 'php/connector.php',  // connector URL (REQUIRED)
					//lang: 'en',             // language (OPTIONAL)
					resizable: false
				}).elfinder('instance');
			});
		</script>


	<!-- Element where elFinder will be created (REQUIRED) -->
    <h2>Video Library</h2>
		<div id="elfinder"></div>


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