window.onload = function () {

	var fm = document.getElementsByTagName('form')[0];
	var pass = document.getElementById('pass');
	
	fm[1].onclick = function () {
		pass.style.display = 'none';
	};
	
	fm[2].onclick = function () {
		pass.style.display = 'block';
	};
	
	fm.onsubmit = function () {
		if (fm.name.value.length < 2 || fm.name.value.length > 20) {
			alert('The name of an albums is between 2-20 charaters');
			fm.name.value = ''; 
			fm.name.focus(); 
			return false;
		}
		if (fm[2].checked) {
			if (fm.password.value.length < 6) {
				alert('The length of a password is bigger than 6 digits');
				fm.password.value = ''; 
				fm.password.focus(); 
				return false;
			}
		}
		
		return true;
	};
};