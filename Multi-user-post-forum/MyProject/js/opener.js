window.onload = function(){
	var img = document.getElementsByTagName('img');
	for(i=0;i<img.length;i++){
		img[i].onclick = function(){
			_opener(this.alt);
		};
	}
};

function _opener(src) {
	//opener is the register.php window,.document means document
	var profileimg = opener.document.getElementById('profileimg').src = src;
	opener.document.register.profile.value = src;
}

