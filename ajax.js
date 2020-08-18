// Capture form posts, AJAX post instead, get back JSON w/instructions
// operations: redirect, reload (special case redirect), replace,
// change css styling (visibility), add/remove for popups
// Use document.querySelector and CSS targetting
window.addEventListener('load', function() {
	var rebindListeners;

	function performAction(data) {
		var action = data[0];
		var el;
		switch (action) {
			case 'replace':
				//console.log('replacing', data[1], 'with', data[2]);
				document.querySelector(data[1]).outerHTML = data[2];
				rebindListeners();
				break;
			case 'attr':
				document.querySelector(data[1])[data[2]] = data[3];
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
				el = document.createElement('div');
				el.innerHTML = data[2];
				//console.log('at', data[1], 'appending', el.firstChild);
				document.querySelector(data[1]).appendChild(el.firstChild);
				el = undefined; // don't know if it would leak memory w/o this
				rebindListeners();
				break;
			case 'remove':
				//console.log('removing', data[1]);
				el = document.querySelector(data[1]);
				el.parentNode.removeChild(el);
				el = undefined;
				break;
		}
	}

	var button;
	function processForm(formE) {
		formE.preventDefault();

		var xhr = new XMLHttpRequest();
		var form = formE.target;

		xhr.addEventListener('load', function(xhrE) {
			var actions;
			try {
				actions = JSON.parse(xhrE.target.response);
			} catch (e) {
				console.error(e);
				return;
			}

			for (var i = 0; i < actions.length; i++) {
				performAction(actions[i]);
			}
		});
		xhr.addEventListener('error', function(xhrE) {
			console.error(xhrE);
			formE.target.submit();
		});

		// FormData is better... IE 11
		var data = [];
		var fields = form.querySelectorAll('input, textarea, select');
		for (var i = 0; i < fields.length; i++) {
			if (!fields[i].name)
				continue;
			// TODO: probably should support checkboxes too
			if (fields[i].type !== 'radio' || fields[i].checked)
				data.push(encodeURIComponent(fields[i].name) + '=' + encodeURIComponent(fields[i].value));
		}
		if (button && button.name)
			data.push(encodeURIComponent(button.name) + '=' + encodeURIComponent(button.value));
		data.push('ajax=true');

		xhr.open('POST', form.action);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		//console.log(data);
		xhr.send(data.join('&'));

		return false;
	}

	function buttonActive(buttonE) {
		//console.log('Button active', buttonE);
		var target = buttonE.target;
		while (target && target.tagName.toLowerCase() !== 'button')
			target = target.parentElement;
		if (target)
			button = target;
	}

	rebindListeners = function() {
		// form submit event submitter is better - IE 11.
		var buttons = document.querySelectorAll('button:not([type]), button[type="submit"], input[type="submit"]');
		for (var i = 0; i < buttons.length; i++) {
			buttons[i].removeEventListener('mousedown', buttonActive);
			buttons[i].removeEventListener('keydown', buttonActive);
			buttons[i].addEventListener('mousedown', buttonActive);
			buttons[i].addEventListener('keydown', buttonActive);
		}

		var forms = document.querySelectorAll('form');
		for (var i = 0; i < forms.length; i++) {
			forms[i].removeEventListener('submit', processForm);
			forms[i].addEventListener('submit', processForm);
		}
	};

	// credit: https://stackoverflow.com/a/32107845/118153
	function Check_Version(){
		var rv = -1; // Return value assumes failure.

		if (navigator.appName == 'Microsoft Internet Explorer'){

			var ua = navigator.userAgent,
				re  = new RegExp("MSIE ([0-9]{1,}[\\.0-9]{0,})");

			if (re.exec(ua) !== null){
				rv = parseFloat( RegExp.$1 );
			}
		}
		else if(navigator.appName == "Netscape"){
			/// in IE 11 the navigator.appVersion says 'trident'
			/// in Edge the navigator.appVersion does not say trident
			if(navigator.appVersion.indexOf('Trident') === -1) rv = -1;
			else rv = 11;
		}

		return rv;
	}

	// I give up. No IE _anything_.
	if (Check_Version() !== -1)
		return;

	rebindListeners();
});
