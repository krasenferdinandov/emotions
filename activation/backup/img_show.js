function CoreImageShow (_image_number, _counter_max, _counter_step, _image_duration, show_image, hide_image_and_show_counter_and_choices, hide_counter_and_choices, change_counter, reset_modal) {
	/*
		this.counter = counter_max;
		this.counter_step = counter_step;
		this.image_number = image_number;
		
	// HTML core functions for editing live
		this.show_image = show_image;
		this.hide_image_and_show_counter_and_choices = hide_image_and_show_counter_and_choices;
		this.hide_counter_and_choices = hide_counter_and_choices;
		this.change_counter = change_counter;
	*/
	// Object functions
	
		let counter_max = _counter_max;
		let counter_step = _counter_step;
		let image_number = _image_number;
		let image_duration = _image_duration;
		
		function one_change_counter (i, s) {
			if (s <= -1) {
				//0.2s
				setTimeout (function () {
					hide_counter_and_choices (i);
					start_next_image_show (i + 1);
				}, 200);
				return ;
			}
			setTimeout(() => {
				change_counter (i, s);
				console.log ("event:", counter_step);
				one_change_counter (i, s + counter_step);
			}, 1000);
		};
		
		function one_iteration (i) {
			show_image (i);
			//1s
			setTimeout (function () {
				hide_image_and_show_counter_and_choices (i);
				one_change_counter (i, counter_max - 1);
			}, image_duration * 1000);
		};
		
		
		function start_next_image_show (i) {
			reset_modal ();
			console.log ("event start_next_image_show():", counter_step);
			reset_step ();
			if (i == image_number)
				return;
			setTimeout(function() {
				console.log (i);
				one_iteration (i);
			}, 1000);
		};
		
		function pause_state () {
			counter_step = 0;
		};
		
		function skip_image () {
			counter_step = -(counter_max + 1);
		};
		
		function reset_step () {
			console.log ('reset step', counter_step, '->', -1);
			counter_step = -1;
		};
		
		return {
		/*
			counter: counter_max,
			counter_step: counter_step,
			image_number: image_number,
		*/
		// HTML core functions for editing live
		/*
			show_image: show_image,
			hide_image_and_show_counter_and_choices: hide_image_and_show_counter_and_choices,
			hide_counter_and_choices: hide_counter_and_choices,
			change_counter: change_counter,
		*/
	
		// Object functions
			one_change_counter: one_change_counter,
			one_iteration: one_iteration,
			start_next_image_show: start_next_image_show,
			skip_image: skip_image,
			pause_state: pause_state,
			reset_step: reset_step,
		};
}