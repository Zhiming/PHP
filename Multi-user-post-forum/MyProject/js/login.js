window.onload = function(){
	code();
	//Login Validation
	var fm = document.getElementsByTagName('form')[0];
	fm.onsubmit = function(){
		if(fm.username.value.length<2 || fm.username.value.length >20){
			alert('The lenghth of a username must be between 2-20 characters');
			fm.username.value = '';//clear username field
			fm.username.focus();//move focus to username field
			return false;
		}
		if (/[<>\'\"\ ]/.test(fm.username.value)) {
			alert('The username cannot contain special character');
			fm.username.value = '';//clear username field
			fm.username.focus();//move focus to username field
			return false;
		}
		//validate password
		if(fm.password.value.length<6){
			alert('The lenghth of a password must be bigger than 6 characters');
			fm.password.value = '';//clear password field
			fm.password.focus();//move focus to password field
			return false;
		}
		//validate identifing code
		if (fm.code.value.length != 4) {
			alert('The identifing code is 4 digits');
			fm.code.value = ''; 
			fm.code.focus(); 
			return false;
		}
	};
};
