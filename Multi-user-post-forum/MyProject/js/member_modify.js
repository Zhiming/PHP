/**
 * 
 */
window.onload = function(){
	code();
	//form validation
	fm.onsubmit = function(){
		if(fm.password.value != ''){
			if(fm.password.value.length<6){
			alert('The lenghth of a password must be bigger than 6 characters');
			fm.password.value = '';//clear password field
			fm.password.focus();//move focus to password field
			return false;
			}
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