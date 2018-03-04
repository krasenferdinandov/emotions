<script>
function showNums(){
	var slider=document.querySelectorAll('input[type=range]');
	var slider_text=document.getElementsByClassName("slider_text");
	console.log (slider);
	console.log (slider_text);
	for(var i=0; i<slider.length; i++){
		slider_text[i].innerHTML = ""+slider[i].value;
	}
}
</script>