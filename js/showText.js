<script>
	
	function showText (id) {
		let el = document.getElementById(id);
		if (el.style.display == "none")	el.style.display = "block";
		else if (el.style.display == "block") el.style.display = "none"; 
	}
	
	document.onreadystatechange = document.onload = function () {
		let els = document.getElementsByClassName ("show");
		for (let i = 0 ; i < els.length ; i += 1) {
			els [i].setAttribute ('onclick', "showText(\"" + els [i].getAttribute("data-id") + "\");");
		}
	}
</script>