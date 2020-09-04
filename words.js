window.addEventListener('load', function() {
	var submit = document.querySelector('button');
	submit.disabled = true;

	var success = document.querySelectorAll('.success');
	var warning = document.querySelectorAll('.warning');

	function check(words) {
		//console.log('checking:', words);
		var xhr = new XMLHttpRequest();

		xhr.addEventListener('load', function(xhrE) {
			var good;
			try {
				good = JSON.parse(xhrE.target.response);
			} catch (e) {
				console.error(e);
				return;
			}

			if (good) {
				for (var i = 0; i < warning.length; i++)
					warning[i].style.display = 'none';
				for (var i = 0; i < success.length; i++)
					success[i].style.display = 'block';
			} else {
				for (var i = 0; i < success.length; i++)
					success[i].style.display = 'none';
				for (var i = 0; i < warning.length; i++)
					warning[i].style.display = 'block';
			}
			submit.disabled = !!good;
		});
		xhr.addEventListener('error', function(xhrE) {
			console.error(xhrE);
		});

		xhr.open('POST', window.location.href);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send('check=true&words=' + encodeURIComponent(words));
	}

	var timeout;
	function input(e) {
		clearTimeout(timeout);
		timeout = setTimeout(function() {
			check(e.target.value);
		}, 300); // debounce
	}
	document
		.querySelector('input[name="words"]')
		.addEventListener('input', input);
});
