// So, plan is, capture form posts, AJAX post instead, get back a JSON structure w/instructions
// operations: redirect, update (multiple) - attributes or adding HTML found w/document.querySelector, add, remove
// Add has a selector for the parent and a string of html
// Need add/remove for the popup (well, _could_ update, but KISS and same as SSR)

window.addEventListener('load', function() {
	function performAction(data) {
		var action = data[0];

		switch (action) {
			case 'replace':
				//console.log('replacing', data[1], 'with', data[2]);
				document.querySelector(data[1]).outerHTML = data[2];
				break;
			case 'style':
				//console.log('setting', data[1], 'style', data[2], 'to', data[3]);
				document.querySelector(data[1]).style[data[2]] = data[3];
				break;

			case 'reload':
				window.location.reload();
				break;
			case 'redirect':
				window.location.href = data[1];
				break;

			case 'add':
				//console.log('at', data[1], 'appending', data[2]);
				var el = document.createElement('div');
				el.innerHTML = data[2];
				document.querySelector(data[1]).appendChild(el.firstChild);
				el = undefined; // don't know if it would leak memory w/o this
				break;
			case 'remove':
				//console.log('removing', data[1]);
				var el = document.querySelector(data[1]);
				el.parentNode.removeChild(el);
				break;
		}
	}

	function processForm(e) {
		e.preventDefault();

		var XHR = new XMLHttpRequest();
		var form = e.target;

		XHR.addEventListener('load', function(e) {
			var actions;
			try {
				actions = JSON.parse(e.target.response);
			} catch (e) {
				console.error(e);
				return;
			}

			for (var i = 0; i < actions.length; i++) {
				performAction(actions[i]);
			}
		});
		XHR.addEventListener('error', function(e) {
			console.error(e);
		});

		var data = new FormData(form);
		data.set(e.submitter.name, e.submitter.value);
		data.set('ajax', true);
		//console.log([...data.entries()]);

		XHR.open('POST', form.action);
		XHR.send(data);

		return false;
	}

	var forms = document.querySelectorAll('form');
	for (var i = 0; i < forms.length; i++)
		forms[i].addEventListener('submit', processForm);
});
