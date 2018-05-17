function checkValid (id) {
	//check if all values are set
	var s_slider = document.querySelectorAll('input[name="s_slider_' + id + '"]')[0];
	var n_slider = document.querySelectorAll('input[name="n_slider_' + id + '"]')[0];
	//console.log (s_slider);
	if (n_slider.length == 0 || s_slider.length == 0 || s_slider.value == 0) {
		var a = document.getElementsByClassName('' + id);
		var pre_button = a [a.length - 1].childNodes[1].childNodes [0];
		pre_button.innerHTML = '<p class="danger">Не е оценена силата.</p>' + pre_button.innerHTML;
		return true;
	}

}
function next (id) {
	if (checkValid(id)) return;
	//Show next/Hide current
	var divsToHide = document.getElementsByClassName("" + id); //divsToHide is an array
    for(var i = 0; i < divsToHide.length; i++){
        //divsToHide[i].style.visibility = "hidden"; // or
        divsToHide[i].style.display = "none"; // depending on what you're doing
    }
	id ++;
	divsToHide = document.getElementsByClassName("" + id); //divsToHide is an array
    for(var i = 0; i < divsToHide.length; i++){
        //divsToHide[i].style.visibility = "hidden"; // or
        divsToHide[i].style.display = "table-row"; // depending on what you're doing
    }
}