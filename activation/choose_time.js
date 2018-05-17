function CoreChoiceTimer (_counter_max, change_counter, on_end) {
	let counter_max = _counter_max;
	const counter_step = -1;
	
	function one_change_counter (s) {
		if (s <= -1) {
			on_end ();
			return ;
		}
		setTimeout(() => {
			change_counter (s);
			console.log ("event:", counter_step);
			one_change_counter (s + counter_step);
		}, 1000);
	};
	
	return {
	// Object functions
		counter_start: function () { one_change_counter (counter_max - 1); },
	};
}