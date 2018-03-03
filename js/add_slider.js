function toggle_slider (id) {
	var labels = document.querySelectorAll ('[data-label=s_slider_' + id + ']');
	var value = document.querySelectorAll ('[data-for=s_slider_' + id + ']')[0];
	var td = document.querySelectorAll ('[data-for=checkit' + id + ']')[0];
	if (td.style.display == 'none') {
		td.style.display = 'table-cell';
		value.style.display = 'table-cell';
		value.className += 'slider_text';
		for(var i = 0 ; i < 2 ; i += 1) {
			labels [i].style.display = 'table-cell';
		}
	}
	else {
		td.style.display = 'none';
		value.style.display = 'none';
		value.className = '';
		for(var i = 0 ; i < 2 ; i += 1) {
			labels [i].style.display = 'none';
		}
	}
	if (td.innerHTML == '') {
		td.innerHTML = '<input onchange="showNums();" type="range" name="s_slider_'+ id +'" class="timed s_slider" value="1" min="1" max="10" step="1"/>';
		value.innerHTML = "1";
	}
	else {
		td.innerHTML = '';
		value.innerHTML = "";
	}
}