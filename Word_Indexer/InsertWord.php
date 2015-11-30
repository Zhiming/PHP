<?php
	function WordIntoDB($url, $fileID, $db)
	{
	$path = $url;
	$fp = fopen($path, 'r');
	$contents = stream_get_contents($fp);
	$contents = strip_tags($contents);
	$contents = strtolower($contents);
	$i = 0;
	$sep = " \n\t\"\'!,.()''\"~!@#$%^&*(),./<>\+_=-|?;:[]{}`бу^1234567890";
	$acontents[$i++] = trim(strtok($contents, $sep));
	while ($token = strtok($sep))
		$acontents[$i++] = trim($token);
	$count = array_count_values($acontents);
	ksort($count);
	if( !ini_get('safe_mode') )
	{
       	set_time_limit(0);
   	} 
	foreach ($count as $row => $times) 
	{
		//echo $row."=>".$times."<br>";
		$word_id = $db->InsertWord($row);
		$db->InsertFileWords($fileID, $word_id, $times);
	}
	fclose($fp);
	}
?>