var checked = 0, radios;
function ready (id) {
	document.getElementById ("slider").style.display = 'none';
	
	for (let i = 0 ; i < radios.length ; i += 1) {
		radios [i].removeAttribute ('disabled');
	}
	
	let input_value = document.querySelector(`[name=e_slider_${id}]`).value;
	let input = document.querySelector(`[name=e_slider_${id}]`).outerHTML;
	document.getElementById('the_form').innerHTML += input.replace('type="range"', 'type="hidden"').replace(' class="e_slider" value="1" min="1" max="10" step="1" onchange="showNums()"', '').replace('type="hidden"', `type="hidden" value=${input_value}`);
	let domain = document.getElementById ('input' + id).name;
	//console.log (id);
	//console.log (document.getElementById ('input' + id));
	//console.log (domain);
	let branch = document.querySelectorAll (`[name="${domain}"]`);
	//console.log (branch.length);
	for (let i = 0 ; i < branch.length ; i += 1) {
		//console.log (branch [i].value);
		//console.log (branch [i].getAttribute ('id'));
		if (branch [i].value == id) {
			branch [i].setAttribute ('checked', '');
		}
		else {
			branch [i].setAttribute ('disabled', '');
		}
	}
}

function show_slider (id) {
	checked ++;
	
	if (checked >= 2) {
		document.getElementById ('-1').disabled = false;
		document.getElementById ('-1').value = document.getElementById ('-1').getAttribute('data-value');
	}
	
	radios = document.querySelectorAll ('[type="radio"]:not([disabled=""])');
	
	for (let i = 0 ; i < radios.length ; i += 1) {
		radios [i].setAttribute ('disabled', '');
	}
	
	document.getElementById ("slider").style.display = 'block';
	document.getElementById ("slider").innerHTML = `
		<center>
			<table>
				<tr><td></td></tr>
				<tr><td colspan=4><center><b>Как отминават избраните състояния?</b></center></td></tr>
				<tr><td></td></tr>
				<tr>
					<td class="slider_text">&nbsp;1</td>
					<td>Много бързо</td>
					<td><input type="range" name="e_slider_${id}" class="e_slider" value="1" min="1" max="10" step="1" onchange="showNums()"/></td>
					<td>Много бавно</td>
				</tr>
				<tr><td></td></tr>
				<tr><td colspan="4"><button onclick="ready (${id});">Избери други</button></td></tr>
			</table>
		</center>`;
}