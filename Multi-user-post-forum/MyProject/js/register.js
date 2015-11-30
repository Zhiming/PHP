/**
 * 
 */
	//wait till the web is completely loaded
	window.onload = function(){
		code();
		var profileimg = document.getElementById('profileimg');
		if(profileimg != null){
			profileimg.onclick = function(){
				window.open('profile.php','profile','width=400,height=400,top=0,left=0,scrollbars=1');
			}
		}
		
	//Form Validation
	var fm = document.getElementsByTagName('form')[0];
	if(fm == undefined){
		return;
	}
	fm.onsubmit = function(){
		//leave fiedls that could be validated by client here
		//validate username
		if(fm.username.value.length<2 || fm.username.value.length >20){
			alert('The lenghth of a username must be between 2-20 characters');
			fm.username.value = '';//clear username field
			fm.username.focus();//move focus to username field
			return false;
		}  
		if (/[<>\'\"\ \¡¡]/.test(fm.username.value)) {
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
		//validate password confirmation
		if(fm.password.value != fm.notpassword.value){
			alert('Password does not match');
			fm.password.value = '';//clear password field
			fm.notpassword.value = '';//clear password confirmation field
			fm.password.focus();//move focus to password field
			return false;
		} 
		//validate password hint
		if(fm.question.value.length<4 || fm.question.value.length>20){
			alert('The length of the password question must be between 4-20 characters');
			fm.question.value = '';//clear question field
			fm.question.focus();//move focus to question field
			return false;
		} 
		//validate password question answer
		if(fm.answer.value.length<4 || fm.answer.value.length>20){
			alert('The length of the password answer must be between 4-20 characters');
			fm.answer.value = '';//clear answer field
			fm.answer.focus();//move focus to answer field
			return false;
		}
		if(fm.answer.value == fm.question.value){
			alert('The question answer could not be the same to password question');
			fm.answer.value = '';//clear answer field
			fm.answer.focus();//move focus to answer field
			return false;
		}
		//validate email address
		if (!/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test(fm.email.value)) {
			alert('illegal email address format');
			fm.email.value = ''; //clear email address
			fm.email.focus(); //move focus to email field
			return false;
		}
		//validate msn address
		if(fm.msn.value != ''){
			if (!/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test(fm.msn.value)) {
				alert('illegal msn account format');
				fm.msn.value = ''; //clear msn address
				fm.msn.focus(); //move focus to msn field
				return false;
			}
		}
		//validate URL
		if (fm.url.value != '' && fm.url.value != 'http://') {
			if (!/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/.test(fm.url.value)) {
				alert('Wrong URL format');
				fm.url.value = ''; //clear url 
				fm.url.focus(); //move focus to URL field
				return false;
			}
		}
		//validate identifing code
		if (fm.code.value.length != 4) {
			alert('The identifing code is 4 digits');
			fm.code.value = ''; 
			fm.code.focus(); 
			return false;
		}
		return true;
	};

};

	
	
	