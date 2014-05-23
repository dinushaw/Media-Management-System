<code><?php
$allowedExts = array("mp3", "mp4", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if ((($_FILES["file"]["type"] == "audio/mp3")
|| ($_FILES["file"]["type"] == "video/mp4")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] > 1)
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

    if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $_FILES["file"]["name"]);
      echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
	 
	  
	 //$output = shell_exec('sshpass -p \'raspberry\' scp upload/'.$_FILES["file"]["name"].' pi@'.$_POST['devicelist'].':/opt/pi');
//echo "<pre>$output</pre>";
/* ?>*/
 /*
 $hostname = $_POST['devicelist']; 
$username = "pi"; 
$password = "raspberry"; 
$sourceFile = "/var/www/html/upload/".$_FILES["file"]["name"]; 
$targetFile = "/opt/pi/".$_FILES["file"]["name"];
//chmod($sourceFile,0644);
$connection = ssh2_connect($hostname, 22); 
ssh2_auth_password($connection, $username, $password);
//ssh2_sftp_chmod($sftp, "upload/".$_FILES["file"]["name"], 0755);
ssh2_scp_send($connection, $sourceFile, $targetFile, 0644);
//ssh2_unlink($connection,"/var/www/html/upload/video.mp4");

    unlink("/var/www/html/upload/".$_FILES["file"]["name"]);
	echo "\n File Uploaded Sucessfully to --> ".$_POST['devicelist'];
	

*/
	
	try
{
    $sftp = new SFTPConnection($_POST['devicelist'], 22);
    $sftp->login("pi", "raspberry");
    $sftp->uploadFile("upload/".$_FILES["file"]["name"], "/opt/pi/".$_FILES["file"]["name"]);
	unlink("/var/www/html/upload/".$_FILES["file"]["name"]);
	echo "\n File Uploaded Sucessfully to --> ".$_POST['devicelist'];
}
catch (Exception $e)
{
    echo $e->getMessage() . "\n";
}




$SSH_CONNECTION= ssh2_connect($_POST['devicelist'], 22);
ssh2_auth_password($SSH_CONNECTION, 'pi', 'raspberry');
//------------------------------------------------------------------- 
//this function finds all files within  given directory and returns them
function scanFilesystem($dir) {
    $tempArray = array();
    $handle = opendir($dir);
  // List all the files
    while (false !== ($file = readdir($handle))) {
    if (substr("$file", 0, 1) != "."){
           if(is_dir($file)){
            $tempArray[$file]=scanFilesystem("$dir/$file");
        } else {
            $tempArray[]=$file;
        }
    }
    }
   closedir($handle); 
  return $tempArray;
}

//------------------------------------------------------------------- 
$sftp = ssh2_sftp($SSH_CONNECTION);

//code to get listing of all OUTGOING files
$dir = "ssh2.sftp://$sftp/home/pi/Desktop";
$outgoing = scanFilesystem($dir);
sort($outgoing);
//print_r($outgoing);
/*	<?php */
	
	
/*	
	$srcFile = "upload/".$_FILES["file"]["name"];
$dstFile = "/opt/pi/".$_FILES["file"]["name"];
 
$host = '192.168.34.5';
$port = '22';
$username = 'pi';
$password = 'raspberry';
 
// Create connection the the remote host
$conn = ssh2_connect($host, $port);
ssh2_auth_password($conn, $username, $password);
 
// Create SFTP session
$sftp = ssh2_sftp($conn);
 
$sftpStream = fopen('ssh2.sftp://'.$sftp.$dstFile, 'w');
 
try {
 
    if (!$sftpStream) {
        throw new Exception("Could not open remote file: $dstFile");
    }
 
    $data_to_send = file_get_contents($srcFile);
 
    if ($data_to_send === false) {
        throw new Exception("Could not open local file: $srcFile.");
    }
 
    if (fwrite($sftpStream, $data_to_send) === false) {
        throw new Exception("Could not send data from file: $srcFile.");
    }
 
    fclose($sftpStream);
 
} catch (Exception $e) {
    error_log('Exception: ' . $e->getMessage());
    fclose($sftpStream);
}
	*/  
	

      }
    }
  }
else
  {
  echo "Invalid file";
  $output = shell_exec('ls -l upload/');
echo "<pre>$output</pre>";
  }
?></code>


<?php

class SFTPConnection
{
    private $connection;
    private $sftp;

    public function __construct($host, $port=22)
    {
        $this->connection = @ssh2_connect($host, $port);
        if (! $this->connection)
            throw new Exception("Could not connect to $host on port $port.");
    }

    public function login($username, $password)
    {
        if (! @ssh2_auth_password($this->connection, $username, $password))
            throw new Exception("Could not authenticate with username $username " .
                                "and password $password.");

        $this->sftp = @ssh2_sftp($this->connection);
        if (! $this->sftp)
            throw new Exception("Could not initialize SFTP subsystem.");
    }

    public function uploadFile($local_file, $remote_file)
    {
        $sftp = $this->sftp;
        $stream = @fopen("ssh2.sftp://$sftp$remote_file", 'w');
		echo "sucess!";
		
		//$result=exec('sshpass -p \"raspberry\" scp -v  /home/pi/Desktop/vids/*.mp4 pi@192.168.35.111:/home/pi/Desktop/',$output,$returnval);
		
		//shell_exec('/home/pi/Desktop/vids/mysc.sh');
		//shell_exec('ls -al');
		//echo "/n Script Executed";

        if (! $stream)
            throw new Exception("Could not open file: $remote_file");

        $data_to_send = @file_get_contents($local_file);
        if ($data_to_send === false)
            throw new Exception("Could not open local file: $local_file.");

        if (@fwrite($stream, $data_to_send) === false)
            throw new Exception("Could not send data from file: $local_file.");

        @fclose($stream);
    }
}



?>