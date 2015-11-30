<?php

class database
{
    private $link;
    private $res;
    private $host;
    private $user;  
    private $password;     
    private $db;    
	
	public function __construct()
	{
		$this->host = "localhost";
		$this->user = "root";  // Use your own user name
		$this->password = "";     // Enter your password
		$this->db = "MyDatebase";    // Name of your datebase
	}
	
  public function database()
	{
		$this->__construct();
	}
	
	public function connect()
	{
        if (isset($this->link))
		{
            $this->disconnect();
            $this->connect();
        }
        else
		{
            try
			{
                if (!$this->link=mysql_connect($this->host, $this->user, $this->password))
				{
                    throw new Exception("Cannot connect to ".$this->host);
                }
            } 
			catch (Exception $e)
			{
                echo $e->getMessage()."<br/>";
                exit;
            }
        }
    }
	   
	public function disconnect()
	{
        if (isset($this->link))
		{
            mysql_close($this->link);
            unset($this->link);
        }
    }
	
    public function send_sql($sql)
	{
        if (!isset($this->link))
		{
			$this->connect();
		}
        try
		{
            if (!$succ=mysql_select_db($this->db, $this->link))
			{
				throw new Exception("Cannot select the database ".$this->db);
			}

            if (!$this->res = mysql_query($sql, $this->link))
			{
				throw new Exception("Cannot send query.");
			}
			
        } 
		catch (Exception $e)
		{
            echo $e->getMessage()."<br/>";
            echo mysql_error();
            exit;
        }
        return $this->res;
    }
	
	// Find out the total number of an entry
    public function CountRow()
	{
        if (isset ($this->res))
		{
			return mysql_num_rows($this->res);
		}
		else
		{
        	//echo "Send a query first!";
        	return -1;
		}
    }
    
    
	public function nextRow()
	{
        if (isset($this->res))
		{
			return mysql_fetch_row($this->res);
		}
        return false;
    }
    
	
    public function InsertID()
	{
        if (isset($this->link))
		{
            $id = mysql_insert_id($this->link);
            if ($id == 0)
			{
                echo "The element inserted is not an auto-increment ID<br/>";
			}
            return $id;
        }
        else
		{
            echo "Not connected to the database!<br/>";
		}
        return false;
    }
    
    
	public function InsertFilename($filename, $url)
	{
        $this->connect();
        $sql = "select id_file from files where url='".$url."';";
        $this->send_sql($sql);
		$id = -1;
        if ($this->CountRow()<=0)  
		{
            $sql = "insert into files (name, url) values ('".$filename."','".$url."');";
            $this->send_sql($sql);
            $id = $this->InsertID();
        }
        $this->disconnect();
        return $id;
    }
    
    
    public function InsertWord($word)
	{
        $this->connect();
       
        $sql = "select id_word from words where word='".$word."' ;";
        $this->send_sql($sql);
		
        if ($this->CountRow() <= 0) 
		{	
            $sql = "insert into words (word) values('".$word."');";
            $this->send_sql($sql);
            $id = $this->InsertID();
            //echo "this->InsertID() is executed.<br>";
        }
        else 
		{
            $row = $this->nextRow();
            $id = $row[0];
            //echo "this->nextRow() is executed.<br>";
        }

        $this->disconnect();
		return $id;
	}
	

	public function InsertFileWords($id_file, $id_word,$count )
	{
        $this->connect();
        $sql = "insert into file_word (id_file,id_word,count) values(".$id_file.",".$id_word.",".$count.");";
        $this->send_sql($sql);
        $this->disconnect();
    }
	
	public function InsertMeta($id_file, $type, $content)
	{
        $this->connect();
        $sql = "insert into meta_info (id_file,type,content) values(".$id_file.",'".$type."','".$content."');";
        $this->send_sql($sql);
        $this->disconnect();
    }

    public function SearchWord($word)
    {
    	$this->connect();
    	$sql = "select id_word from Words where word='".$word."';";
    	//$sql = "select id_file from files where url='".$url."';";
    	$this->send_sql($sql);
    	if(mysql_num_rows($this->res) == 0)
    	{
    		echo "There is no ".$word."in database.<br>";
    		return -1;
    	}
    	else
    		$id_word = mysql_fetch_array($this->res);
    	return $id_word[0];
    }

    public function SearchText($id_word)
    {
    	$this->connect();
    	$sql = "select id_file, count from File_Word where id_word='".$id_word."'order by count desc;";
    	$this->send_sql($sql);
    	if(mysql_num_rows($this->res) == 0)
    		echo "There is no file containing this word.<br>";
    	else 
    	{	
    		$TempRef = $this->res;
    		while($row = mysql_fetch_row($TempRef))
    		{
 				$id_file = $row[0];
 				$count = $row[1];
 				$this->connect();
 				$sql = "select name, url from Files where id_file='".$id_file."';";
 				$this->send_sql($sql);
 				while($row = mysql_fetch_row($this->res))
 				{
 					//echo "Name: ".$row[0]."\tURL: ".$row[1]."<br>";
 					echo "<a href = '".$row[1]."'>$row[0]</a>";
 					echo " &nbsp&nbsp Number of iteration in this file: ".$count."<br>";
 				}
    		}
    	}
    	
    }

    
    public function SearchMeta($word)
    {
    	$this->connect();
    	$sql = "select * from Meta_info;";
    	$this->send_sql($sql);
    	if(mysql_num_rows($this->res) == 0)
    		echo "There is no file containing in this file's metatag.<br>";
    	else
    	{
    		$TempRef = $this->res;
    		$i = 0;
    		while($row = mysql_fetch_row($TempRef))
    		{
    			$i = 0;
 				$id_file = $row[0];
 				$type = $row[1];
 				$arr = $row[2];
 				//echo "arr : ".$arr."<br>"; (done)
 				$arr = strtolower($arr);
 				$sep = " \n\t\"\'!,.()''\"~!@#$%^&*(),./<>\+=|?;:[]{}`бу^";
				$finarr[$i++] = strtok($arr, $sep);
				//echo $finarr[$i-1]."<br>"; 
				while ($token = strtok($sep))
				{
					$finarr[$i++] = $token;
					//echo $finarr[$i-1]."<br>"; 
				}
				
				//echo "this is $id_file<br>";
				for($j=0;$j<$i;$j++)
				{
					//echo 1+$j." enters the for loop"; (done)
					//echo $finarr[$j]."<br>";
					if($word == $finarr[$j])
					{
						//echo "if statement was executed";
						$this->connect();
 						$sql = "select name, url from Files where id_file='".$id_file."';";
 						$this->send_sql($sql);
 						//echo "The sql query was sent";
 						while($row = mysql_fetch_row($this->res))
 						{
 							//echo "Name: ".$row[0]."\tURL: ".$row[1]."<br>";
 							echo "<a href = '".$row[1]."'>$row[0]</a>";
 							echo "&nbsp&nbsp Type of this file: ".$type."<br>";
 						}
					}
				}
    		}
    	}
    }
}

?>


