(function() {
	const form = document.querySelector('#the_form');
	const startTime = new Date();
	
	const domainTimes = {};

	form.addEventListener('click', (ev) => {
		if(!ev.target.classList.contains('timed')) {
			return;
		}
		const domain = ev.target.name;
		
		// Get current timezone offset for host device
		//domainTimes[domain] = new Date();   // 1.Отчита времето в JS формат
		//domainTimes[domain] = new Date() - startTime; // 2.Времето на цъкане като разлика от момента на зареждане на страницата
		//domainTimes[domain] = new Date().toISOString().slice(0, 19).replace('T', ' ');// 3.Превръща отчетеното време от JS в Mysql формат
		//domainTimes[domain] = new Date().toLocaleString().slice(0, 19).replace('T', ' ');
		
		Date.prototype.toIsoString = function() {
			var tzo = -this.getTimezoneOffset(),
			dif = tzo >= 0 ? '+' : '-',
			pad = function(num) {
				var norm = Math.floor(Math.abs(num));
				return (norm < 10 ? '0' : '') + norm;
			};
			return this.getFullYear() +
			'-' + pad(this.getMonth() + 1) +
			'-' + pad(this.getDate()) +
			' ' + pad(this.getHours()) +
			':' + pad(this.getMinutes()) +
			':' + pad(this.getSeconds()) /*+
			dif + pad(tzo / 60) +
			':' + pad(tzo % 60)*/;
		}
		var dt = new Date();
		domainTimes[domain] = dt.toIsoString();
		
		/*var dt = new Date().toLocaleString();
		domainTimes[domain] = dt.getFromFormat('yyyy-mm-dd hh:ii:ss');*/
		});

	form.addEventListener('submit', () => {
		//alert (Object.keys(domainTimes))
		for(const domain in domainTimes) {
			const hiddenInput = document.createElement('input');
			hiddenInput.type = 'hidden';
			hiddenInput.name = 'time-' + domain;
			hiddenInput.value = domainTimes[domain];
			form.appendChild(hiddenInput);
		}
	});
})();
