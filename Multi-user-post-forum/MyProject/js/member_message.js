window.onload = function(){
	//receive the id='all' in member_message
	var all = document.getElementById('all');
	//receive the form information in member_message
	var fm = document.getElementsByTagName('form')[0];
	all.onclick = function(){
		//receive all messages and a label and a button in form in member_message
		//by form.elements
		//alert(form.elements.length);
		for(var i=0;i<fm.elements.length;i++){
			//if it is not the 'All' label, it means the current form td is a message
			if(fm.elements[i].name != 'chkall'){
				//when 'All' label is checked, assign this status to each message
				fm.elements[i].checked = fm.chkall.checked;
			}
		}
	};
	fm.onsubmit = function(){
		if(confirm('Delete the selected item(s)?')){
			return true;
		}
		return false;
	};
};