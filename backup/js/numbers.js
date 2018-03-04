<script>
function showNums(){
	var slider=document.getElementsByClassName("e_slider");
	var slider_text=document.getElementsByClassName("slider_text");
	for(var i=0; i<slider.length; i++){
		slider_text[i].innerHTML = ""+slider[i].value;
	}
}
</script>