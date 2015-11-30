/**
 * 
 */
//wait till the web is completely loaded
window.onload = function(){
	var profileimg = document.getElementById('profileimg');
	var RandCode = document.getElementById('RandCode');
	profileimg.onclick = function(){
		window.open('profile.php','profile','width=400,height=400,top=0,left=0,scrollbars=1');
	}
	RandCode.onclick = function(){
		this.src='Randomcode.php?tm='+Math.random();
	};
}