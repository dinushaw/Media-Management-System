<?php

// A list of permitted file extensions
$allowed = array('png', 'jpg', 'mkv','zip','mp4');

if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){

	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

	if(!in_array(strtolower($extension), $allowed)){
		echo '{"status":"error"}';
		exit;
	}

	if(move_uploaded_file($_FILES['upl']['tmp_name'], 'upload/'.$_FILES['upl']['name'])){
		
		try
	{
    $sftp = new SFTPConnection($_POST['devicelist'], 22);
    $sftp->login("pi", "raspberry");
    $sftp->uploadFile("upload/".$_FILES["upl"]["name"], "/opt/pi/".$_FILES["upl"]["name"]);
	//unlink("/var/www/html/upload/".$_FILES["upl"]["name"]);
	//echo "\n File Uploaded Sucessfully to --> ".$_POST['devicelist'];
	//echo '{"status":"success"}';
	exit;
	}
catch (Exception $e)
{
    echo $e->getMessage() . "\n";
  }
  		echo '{"status":"error"}';
		exit;
	}
}

echo '{"status":"error"}';
exit;

?>
<?php
// this class is used to handle file transfer to the raspbery PI. 
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
	
	
	        function scanFilesystem($remote_file) {
              $sftp = $this->sftp;
            $dir = "ssh2.sftp://$sftp$remote_file";  
              $tempArray = array();
            $handle = opendir($dir);
          // List all the files
            while (false !== ($file = readdir($handle))) {
            if (substr("$file", 0, 1) != "."){
              if(is_dir($file)){
//                $tempArray[$file] = $this->scanFilesystem("$dir/$file");
               } else {
                 $tempArray[]=$file;
               }
             }
            }
           closedir($handle);
          return $tempArray;
        }    
///Recieve files from Raspberry PI
    public function receiveFile($remote_file, $local_file)
    {
        $sftp = $this->sftp;
        $stream = @fopen("ssh2.sftp://$sftp$remote_file", 'r');
        if (! $stream)
            throw new Exception("Could not open file: $remote_file");
        $contents = fread($stream, filesize("ssh2.sftp://$sftp$remote_file"));            
        file_put_contents ($local_file, $contents);
        @fclose($stream);
    }
	
	
	
}



?>