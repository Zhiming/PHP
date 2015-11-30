<?php

/**
 * delete a directory-_remove_Dir
 * @access public
 * @param string $dirName
 */
function _remove_Dir($dirName)
{
    if(! is_dir($dirName))
    {
        return false;
    }
    $handle = opendir($dirName);
    while(($file = readdir($handle)) !== false)
    {
        if($file != '.' && $file != '..')
        {
            $dir = $dirName . '/' . $file;
            is_dir($dir) ? _remove_Dir($dir) : @unlink($dir);
        }
    }
    closedir($handle);
    return rmdir($dirName) ;
} 

/**
 * protect from illegal accessing management-_manage_login()
 * @access public
 * @return void
 */
function _manage_login() {
	if ((!isset($_COOKIE['username'])) || (!isset($_SESSION['admin']))) {
		_alert_close('No authority to access');
	}	
}

/**
 * measure the time between each post-_timed()
 * @access public
 * @param int $_now_time
 * @param int $_pre_time
 * @param int $_second
 * @return void
 */
function _timed($_now_time,$_pre_time,$_second=60){
	if($_now_time - $_pre_time < $_second){
		_alert_back('Please take a rest');
	}
}

//To measure the loading time
//@access public
//@return double
function _runtime() {
	$_mtime = explode(' ',microtime());
	return $_mtime[1] + $_mtime[0];
}

//_alert_back() is a JS popup function returning to the former window
//@access public
//param $_info
//@return void
function _alert_back($_info){
	echo "<script type='text/javascript'>alert('$_info');history.back();</script>";
	exit();
}

/**
 * Pop a notification window and close current window-_alert_close()
 * @access public
 * @param string $_info
 * @return void
 */
function _alert_close($_info){
	echo "<script type='text/javascript'>alert('$_info');window.close();</script>";
	exit();
}

function _location($_info,$_url) {
	if(!empty($_info)){
		echo "<script type='text/javascript'>alert('$_info');location.href='$_url';</script>";
		exit();
	} else{
		header('Location:'.$_url);
	}
}

function _login_state(){
	if(isset($_COOKIE['username'])){
		_alert_back('Fail to do this in login state');
	}
}

/**
 * check whether the unique identifier abnormal
 * @access public
 * @param long $_mysql_uniqid
 * @param long $_cookie_uniqid
 * return void
 */
function _uniqid($_mysql_uniqid, $_cookie_uniqid){
	if($_mysql_uniqid != $_cookie_uniqid){
		_alert_back('abnormal unique identifier');
	}
}

/**
 * Scale a picture back-_thumb()
 * @access public
 * @param string $_filename
 * @param int $_percent
 * @return void
 */
function _thumb($_filename,$_percent) {
	//create a png header
	header('Content-type: image/png');
	$_n = explode('.',$_filename);
	//obtain the lenght and width of a picture
	list($_width, $_height) = getimagesize($_filename);
	//scaled length and width back 
	$_new_width = $_width * $_percent;
	$_new_height = $_height * $_percent;
	//create a base with 30% scale
	$_new_image = imagecreatetruecolor($_new_width,$_new_height);
	//create a base for the original picture
	switch ($_n[1]) {
		case 'jpg' : $_image = imagecreatefromjpeg($_filename);
			break;
		case 'png' : $_image = imagecreatefrompng($_filename);
			break;
		case 'gif' : $_image = imagecreatefrompng($_filename);
			break;
	}
	//scale the original picture to the base
	imagecopyresampled($_new_image, $_image, 0, 0, 0, 0, $_new_width,$_new_height, $_width, $_height);
	imagepng($_new_image);
	imagedestroy($_new_image);
	imagedestroy($_image);
}

/**
 * create a xml file-_set_xml()
 * @access public
 * @param string $_xmlfile
 * @param array $_clean
 * @return void
 */
function _set_xml($_xmlfile,$_clean) {
	$_fp = @fopen('new.xml','w');
	if (!$_fp) {
		exit('The file does not exist');
	}
	flock($_fp,LOCK_EX);
	
	$_string = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n";
	fwrite($_fp,$_string,strlen($_string));
	$_string = "<vip>\r\n";
	fwrite($_fp,$_string,strlen($_string));
	$_string = "\t<id>{$_clean['id']}</id>\r\n";
	fwrite($_fp,$_string,strlen($_string));
	$_string = "\t<username>{$_clean['username']}</username>\r\n";
	fwrite($_fp,$_string,strlen($_string));
	$_string = "\t<sex>{$_clean['sex']}</sex>\r\n";
	fwrite($_fp,$_string,strlen($_string));
	$_string = "\t<profile>{$_clean['profile']}</profile>\r\n";
	fwrite($_fp,$_string,strlen($_string));
	$_string = "\t<email>{$_clean['email']}</email>\r\n";
	fwrite($_fp,$_string,strlen($_string));
	$_string = "\t<url>{$_clean['url']}</url>\r\n";
	fwrite($_fp,$_string,strlen($_string));
	$_string = "</vip>";
	fwrite($_fp,$_string,strlen($_string));
	
	flock($_fp,LOCK_UN);
	fclose($_fp);
}

/**
 * Read information in a XML file-_get_xml()
 * @access public
 * @param string $_xmlfile
 * @return array
 */
function _get_xml($_xmlfile) {
	$_html = array();
	if (file_exists($_xmlfile)) {
		$_xml = file_get_contents($_xmlfile);
		preg_match_all('/<vip>(.*)<\/vip>/s',$_xml,$_dom);
		foreach ($_dom[1] as $_value) {
			preg_match_all('/<id>(.*)<\/id>/s',$_value,$_id);
			preg_match_all('/<username>(.*)<\/username>/s',$_value,$_username);
			preg_match_all( '/<sex>(.*)<\/sex>/s', $_value, $_sex);
			preg_match_all( '/<profile>(.*)<\/profile>/s', $_value, $_face);
			preg_match_all( '/<email>(.*)<\/email>/s', $_value, $_email);
			preg_match_all( '/<url>(.*)<\/url>/s', $_value, $_url);
			$_html['id'] = $_id[1][0];
			$_html['username'] = $_username[1][0];
			$_html['sex'] = $_sex[1][0];
			$_html['face'] = $_face[1][0];
			$_html['email'] = $_email[1][0];
			$_html['url'] = $_url[1][0];
		}
	} else {
		echo 'This file does not exist';
	}
	return $_html;
}

/**
 * show html style on website-_ubb()
 * @access public
 * @param string $_string
 * @return string
 */
function _ubb($_string){
	$_string = nl2br($_string);
	$_string = preg_replace('/\[size=(.*)\](.*)\[\/size\]/U','<span style="font-size:\1px">\2</span>',$_string);
	$_string = preg_replace('/\[b\](.*)\[\/b\]/U','<strong>\1</strong>',$_string);
	$_string = preg_replace('/\[i\](.*)\[\/i\]/U','<em>\1</em>',$_string);
	$_string = preg_replace('/\[u\](.*)\[\/u\]/U','<span style="text-decoration:underline">\1</span>',$_string);
	$_string = preg_replace('/\[s\](.*)\[\/s\]/U','<span style="text-decoration:line-through">\1</span>',$_string);
	$_string = preg_replace('/\[color=(.*)\](.*)\[\/color\]/U','<span style="color:\1">\2</span>',$_string);
	$_string = preg_replace('/\[url\](.*)\[\/url\]/U','<a href="\1" target="_blank">\1</a>',$_string);
	$_string = preg_replace('/\[email\](.*)\[\/email\]/U','<a href="mailto:\1">\1</a>',$_string);
	$_string = preg_replace('/\[img\](.*)\[\/img\]/U','<img src="\1" alt="picture" />',$_string);
	$_string = preg_replace('/\[flash\](.*)\[\/flash\]/U','<embed style="width:480px;height:400px;" src="\1" />',$_string);
	return $_string;
}

/**
 * Intercept character- _title() 
 * @access public
 * @param string $_string
 * @return string
 */
function _title($_string, $_length=30){
	if(strlen($_string)>$_length){
		$_string = substr($_string,0,$_length).'...';
	}
	return $_string;
}

/**
 * escaping html codes _html()
 * @access public
 * @param string $_string or string array
 * @return string
 */
function _html($_string){
	if(is_array($_string)){
		foreach ($_string as $_key => $_value){
			//recursive calls
			$_string[$_key] = _html($_value);
		}
	}else{
		$_string = htmlspecialchars($_string);
	}
	return $_string;
}

/**
 * calculate how many pages are needed 
 * @access public
 * @param a SQL statement $_sql
 * @param int $_pagesize represents how many records in a page
 * @return void
 */
function _page($_sql,$_size){
	//paging module
	//the following variables are global so that they are visible outside this page
	global $_page, $_pagesize, $_pagenum, $_pageabsolute, $_num;
	//fault tolerant processing
	if(isset($_GET['page'])){
		$_page = $_GET['page'];
	if(empty($_page)||$_page<=0||!is_numeric($_page)){
		$_page = 1;
	}else{
		$_page = intval($_page);//no decimal page
	}
	}else{
		$_page = 1;
	}
	$_pagesize = $_size;
	
	//Get the total number of record in database
	$_num = _num_rows(_query($_sql));
	if($_num==0){
		$_pageabsolute = 1;
	}else{
		$_pageabsolute = ceil($_num/$_pagesize);
	}
	//No proceeding the max page number
	if($_page>$_pageabsolute){
		$_page = $_pageabsolute;
	}
	$_pagenum = ($_page -1)*$_pagesize;
}

/**
 * Choose a type of paging, one stands for number paging; 2 for text paging
 * @access public
 * @param int $_type type represents two type methods paging with number(1) or text(2)
 * @return void
 */
function _paging($_type){
	global $_page, $_pageabsolute,$_num,$_id;
	if($_type == 1){
		echo'<div id="page_num">';
		echo'<ul>';
		for($i=0;$i<$_pageabsolute;$i++){
			if ($_page == ($i+1)){
				echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($i+1).'"class="selected">'.($i+1).'</a></li>';
				}else{
				echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($i+1).'">'.($i+1).'</a></li>';
				}
		}
		echo'</ul>';
	echo'</div>';
	}elseif ($_type ==2){
		echo'<div id="page_text">';
		echo'<ul>';
			echo'<li>'.$_page.'/'.$_pageabsolute.' | </li>';
			echo'<li>Total <strong>'.$_num.'</strong> records | </li>';
				if($_page == 1){
					echo'<li>First Page | </li>';
					echo'<li>Previous Page | </li>';
				}else{
					echo'<li><a href="'.SCRIPT.'.php">First Page</a> | </li>';
					echo'<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page-1).'">Previous Page</a> | </li>';
				}
				if($_page == $_pageabsolute){
					echo'<li>Next Page | </li>';
					echo'<li>Last Page</li>';
				}else{
					echo'<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page+1).'">Next Page</a> | </li>';
					echo'<li><a href="'.SCRIPT.'.php?'.$_id.'page='.$_pageabsolute.'">Last Page</a></li>';
				}
		echo'</ul>';
	echo'</div>';
	}
}

/**
 * 
 * _session_destroy clears information in a session
 * @access public
 * @return void
 */
function _session_destroy(){
	if(isset($_SESSION)){
		session_destroy();
	}
}

/**
 * _unsetcookies() deletes cookies and session for logout
 * @access public
 * @return void 
*/
function _unsetcookies(){
	setcookie('username','',time()-1);
	setcookie('uniqid','',time()-1);
	_session_destroy();
	_location(null, 'index.php');
	
}

/**
 * Generate a unique identifier _sha1_uniqid()
 * @access public
 * @return string
 */
function _sha1_uniqid(){
	return _mysql_string(sha1(uniqid(rand(),TRUE)));
}


//Fuction _RandCode generates a randdom code
//@access public
//@param int $_weight is the length of a random code
//@param int $_height is the height of a random code
//@param int $_rnd_digit is the number of digit in a random code
//@param bool $_flag is whether a black border is needed
//@return void
function _RandCode($_width=75,$_height=25,$_rnd_digit = 4,	$_flag = false){
	
	//create a random number
	for($i=0;$i<4;$i++){
		if($i==0){
			$_RandCode = dechex(mt_rand(0,15));
		}
		else{
			$_RandCode .= dechex(mt_rand(0,15));
		}
	}
	//echo $_RandCode;
	
	//keep the random number created above in session
	
	$_SESSION['RandCode'] = $_RandCode;
	
	
	//create a picture for random number
	$_img = imagecreatetruecolor( $_width , $_height );
	
	//a white background picture
	$_white = imagecolorallocate($_img, 255, 255, 255);
	
	//fill in
	imagefill($_img, 0, 0, $_white);
	
	if($_flag){
	//black border
	$_black = imagecolorallocate($_img, 0, 0, 0);
	imagerectangle($_img, 5, 0, $_width-1, $_height-1, $_black);
	}
	
	//random lines
	for($i=0;$i<6;$i++){
		$_rnd_color = imagecolorallocate($_img, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
		imageline($_img, mt_rand(0, $_width-6), mt_rand(0, $_height-1), mt_rand(0, $_width), mt_rand(0, $_height), $_rnd_color);
	}
	
	//random background
	for($i=0;$i<100;$i++){
		$_rnd_color = imagecolorallocate($_img, mt_rand(200,255), mt_rand(200,255), mt_rand(200,255));
		imagestring($_img, 1, mt_rand(5,$_width-1), mt_rand(1, $_height-1), '*', $_rnd_color);
	}
	
	//output the random code
	for ($i=0;$i<strlen($_SESSION['RandCode']);$i ++){
	imagestring($_img,mt_rand(3,5),$i*$_width/4 +mt_rand(1,10),
	mt_rand(1,$_height/2), $_SESSION ['RandCode'][$i],
	imagecolorallocate($_img ,mt_rand(0,100),
	mt_rand(0,150),mt_rand(0, 200)));
	}


	//output the picture above
	header('Content-Type:image/png');
	imagepng( $_img );
	imagedestroy($_img);
	}

/**
 * 
 * _mysql_string to check whether automatic escaping is on
 * @access public
 * @param string or array $_string
 * return string $_string an escaped string
 */
function _mysql_string($_string){
	//if get_magic_quotes_gpc() is on, escaping is not necessary
	if (!GPC) {
		if (is_array($_string)) {
			foreach ($_string as $_key => $_value) {
				$_string[$_key] = _mysql_string($_value);   
			}
		} else {
			$_string = mysql_real_escape_string($_string);
		}
	} 
	return $_string;
}
	
/**
 * 
 * _check_code for matching identifing code
 * @access public
 * @param string $_first_code
 * @param string $_end_code
 * @return void match identifing code
 */
function _check_code($_first_code, $_end_code){
	if($_first_code != $_end_code){
		_alert_back('Wrong identifing code');
	}
}


?>