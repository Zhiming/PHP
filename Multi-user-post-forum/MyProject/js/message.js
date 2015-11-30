 window.onload = function(){
 	code();
 	var fm=document.getElementsByTagName('form')[0];
 	fm.onsubmit = function(){
 		//validate identifing code
		if (fm.code.value.length != 4) {
			alert('The identifing code is 4 digits');
			fm.code.focus(); 
			return false;
		}
		//validate the length of a message
		if(fm.content.value.length<10 ||fm.content.value.length>400 ){
			alert('The length of a message must be bewteen 10 to 400 characters');
			fm.content.focus();//move the focus to content
			return false;
		}
 	};
 };