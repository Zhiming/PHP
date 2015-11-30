<?php 
if (isset($_POST["address"]) && $_POST["address"]!==""){
	$path = $_POST['address'];
	$value = $_POST['search'];
	$word = $_POST['word'];
	//echo "word= ".$word."<br>";
	if("text_search" == $value)
		$flag = 1;
	else if("mega_search" == $value)
		$flag = 2;
	else 
		$flag = 3;
	//echo "flag = ".$flag;
	//echo "value = ".$value."<br>";
	//$path = "D:\Program Files\wamp";
	//chdir($path);
	include("db.php");
	include("InsertWord.php");
	include("Search.php");
	$db = new database();
	//echo "path: ".$path."<br>";
	GetAllH($path, $db);
	Search($flag, $word, $db);
	
}
?>	


<?php 
	function GetAllH($path, $db)
	{
		$CurrentD = $path;
		chdir($CurrentD);
		if(false !== ($handle = opendir($CurrentD)))
		{
			while (false !== ($Name = readdir($handle)))
			{
				if($Name != "." && $Name != "..")
					if(is_dir($CurrentD."\\".$Name))
					{
						$New_dir = $CurrentD."\\".$Name;
						GetAllH($New_dir, $db);
						
					}
					else 
					{
						$i = strrpos($Name, ".");
						$extension = strtoupper(substr($Name, $i));
						if($extension == ".HTML" ||$extension == ".HTM")
						{
							//echo $Name."<br>";
							$url = $CurrentD."\\".$Name;
							$id = $db->InsertFilename($Name, $url);
							WordIntoDB($url, $id, $db);
							if(-1 == $id)
							{
								echo $Name." exists.<br>";
							}
							else 
							{
								if ($tags = get_meta_tags($url, false))
								{
									foreach ($tags as $name => $content)
										$db->insertMeta($id, $name, $content);
									echo $Name."'s Metatag information added.<br>";
								}
								else 
									echo "No metatag information.<br>";
							}
						}					
							
					}
			}
		}
	}
?>