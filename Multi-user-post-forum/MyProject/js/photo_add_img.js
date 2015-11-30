window.onload = function () {
	var up = document.getElementById('up');
	up.onclick = function () {
		centerWindow('upimg.php?dir='+this.title,'up','100','400');
	};
	var fm = document.getElementsByTagName('form')[0];
	fm.onsubmit = function () {
		if (fm.name.value.length < 2 || fm.name.value.length > 20) {
			alert('The length of the name of a picture is between 2-20 characters');
			fm.name.focus(); 
			return false;
		}
		if (fm.url.value == '') {
			alert('The URL field could not be empty');
			fm.url.focus();
			return false;
		}
		return true;
	};
};

function centerWindow(url,name,height,width) {
	var left = (screen.width - width) / 2;
	var top = (screen.height - height) / 2;
	window.open(url,name,'height='+height+',width='+width+',top='+top+',left='+left);
}