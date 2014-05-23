<?php


$connection = ssh2_connect($_GET['deviceid'], 22);
$ipadd =$_GET['deviceid'];
ssh2_auth_password($connection, 'pi', 'raspberry');
//echo 'okay !!!';

//$stream = ssh2_exec($connection, 'zip /opt/pi/backup.zip *');
$stream = ssh2_exec($connection, 'tar -cf /opt/pi/backup.tar /opt/pi/zzz/');
//$stream = ssh2_exec($connection, 'chmod 755 /opt/pi/backup.tar.gz');

//echo "Backup Created Succesfully ".$stream;
	try {
			$sftp = new SFTPConnection($ipadd, 22);
			//echo 'Connection Created!!!';
    		$sftp->login("pi", "raspberry");
			//echo 'Logged in to device!!!';
    		$sftp->receiveFile("/opt/pi/backup.tar",$_SERVER['DOCUMENT_ROOT']."/upload/backup.tar");
			
			//echo "file recieved";
			$stream = ssh2_exec($connection, 'rm /opt/pi/backup.tar');
			echo '<a href="/upload/backup.tar"> Click here to download file (.tar format)</a>';
		}
		catch (Exception $e){
			echo 'Error Main!!!';
		}

?>
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
        $size = $this->getFileSize($remote_file);            
        $contents = '';
        $read = 0;
        $len = $size;
        while ($read < $len && ($buf = fread($stream, $len - $read))) {
          $read += strlen($buf);
          $contents .= $buf;
        }        
        file_put_contents ($local_file, $contents);
        @fclose($stream);
    }
	
	public function getFileSize($file){
      $sftp = $this->sftp;
        return filesize("ssh2.sftp://$sftp$file");
    }
	
	
	
}



?>