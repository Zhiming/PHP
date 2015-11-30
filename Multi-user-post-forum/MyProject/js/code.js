function code(){
	var RandCode = document.getElementById('RandCode');
	if(RandCode == null){
		return;
	}
	RandCode.onclick = function(){
		this.src='Randomcode.php?tm='+Math.random();
	};
}