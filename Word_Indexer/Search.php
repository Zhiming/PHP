<?php

	function Search($flag, $word, $db)
	{
		switch($flag)
		{
			case 1:
				{
					$id_word = $db->SearchWord($word);
					//echo "id_word from SearchWord() $id_word";
					$db->SearchText($id_word);
				}
			case 2:
				{
					$db->SearchMeta($word);
				}
			case 3:
				{
					$id_word = $db->SearchWord($word);
					$db->SearchText($id_word);
					$db->SearchMeta($word);
				}
		}
	}

?>