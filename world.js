function seedQuestWorldRelayout() {
	var maxLoops = 100; // usually 20-50 in Sorc Tower; pathological would never terminate

	// can't have offsetLeft < 0, offsetLeft + offsetWidth > document.body.offsetWidth
	// If overlap 2 in one direction, push this one 2x, etc
	// draw lines, under the interactibles, to their original location

	var items = document.getElementsByClassName('item');
	var container = document.getElementById('world');

	var canvas = document.createElement('canvas');
	container.appendChild(canvas);
	canvas.width = container.offsetWidth;
	canvas.height = container.offsetHeight;
	canvas.style.width = '100%';
	canvas.style.height = '100%';
	var ctx = canvas.getContext('2d');

	var instance = 0;

	function coords(item) {
		return {
			left: item.offsetLeft,
			right: item.offsetLeft + item.offsetWidth,
			top: item.offsetTop,
			bottom: item.offsetTop + item.offsetHeight,
		};
	}
	function between(x, min, max) {
		return x > min && x < max;
	}
	function clamp(x, min, max) {
		return Math.max(min, Math.min(max, x));
	}
	// credit: https://codegolf.stackexchange.com/a/191245/9109
	function roundAwayFromZero(n) {
		return n < 0 ? ~-n : -~n;
	}

	function bump(item, overlap) {
		// no bump
		if (!overlap.length)
			return;

		// we want to bump proportional to how big a factor this direction is vs _all other_ directions

		// Only respect the smaller paired overlap
		var left = 0, top = 0;
		for (var i = 0; i < overlap.length; i++) {
			var amount = overlap[i][1];
			//console.log(item, overlap[i][0], amount);
			// Adjust only the side with the least overlap; perfectly even counts as maximal overlap
			if (amount.left === 0) {
				top += amount.top / 2;
			} else if (amount.top === 0) {
				left += amount.left / 2;
			} else if (Math.abs(amount.top) < Math.abs(amount.left)) {
				top += amount.top / 2;
			} else if (Math.abs(amount.top) > Math.abs(amount.left)) {
				left += amount.left / 2;
			} else {
				left += amount.left / 2;
				top += amount.top / 2;
			}
		}

		//console.log({ item, instance, left, top });

		item.style.left = clamp(item.offsetLeft + roundAwayFromZero(left), 0, (container.offsetWidth - item.offsetWidth)) + 'px';
		item.style.top = clamp(item.offsetTop + roundAwayFromZero(top), 0, (container.offsetHeight - item.offsetHeight)) + 'px';
	}

	function findOverlaps() {
		var overlaps = [];
		for (var i = 0; i < items.length; i++) {
			overlaps[i] = [];
		}

		// find overlaps
		var count = 0;
		for (var i = 0; i < items.length; i++) {
			var pos = coords(items[i]);
			for (var j = i + 1; j < items.length; j++) {
				var other = coords(items[j]);
				var overlap = {
					left: between(pos.left, other.left, other.right),
					right: between(pos.right, other.left, other.right),
					top: between(pos.top, other.top, other.bottom),
					bottom: between(pos.bottom, other.top, other.bottom),
					alignX: pos.left == other.left && pos.right == other.right,
					alignY: pos.top == other.top && pos.bottom == other.bottom,
				};

				if (overlap.left && overlap.top) {
					count++;
					overlaps[items[i].dataset.item].push([items[j].dataset.item, {
						left: other.right - pos.left,
						top: other.bottom - pos.top,
					}]);
					overlaps[items[j].dataset.item].push([items[i].dataset.item, {
						left: pos.left - other.right,
						top: pos.top - other.bottom,
					}]);
				}
				if (overlap.left && overlap.bottom) {
					count++;
					overlaps[items[i].dataset.item].push([items[j].dataset.item, {
						left: other.right - pos.left,
						top: other.top - pos.bottom,
					}]);
					overlaps[items[j].dataset.item].push([items[i].dataset.item, {
						left: pos.left - other.right,
						top: pos.bottom - other.top,
					}]);
				}
				if (overlap.right && overlap.top) {
					count++;
					overlaps[items[i].dataset.item].push([items[j].dataset.item, {
						left: other.left - pos.right,
						top: other.bottom - pos.top,
					}]);
					overlaps[items[j].dataset.item].push([items[i].dataset.item, {
						left: pos.right - other.left,
						top: pos.top - other.bottom,
					}]);
				}
				if (overlap.right && overlap.bottom) {
					count++;
					overlaps[items[i].dataset.item].push([items[j].dataset.item, {
						left: other.left - pos.right,
						top: other.top - pos.bottom,
					}]);
					overlaps[items[j].dataset.item].push([items[i].dataset.item, {
						left: pos.right - other.left,
						top: pos.bottom - other.top,
					}]);
				}

				if (overlap.alignX && overlap.top) {
					count++;
					overlaps[items[i].dataset.item].push([items[j].dataset.item, {
						left: 0,
						top: other.bottom - pos.top,
					}]);
					overlaps[items[j].dataset.item].push([items[i].dataset.item, {
						left: 0,
						top: pos.top - other.bottom,
					}]);
				}
				if (overlap.alignX && overlap.bottom) {
					count++;
					overlaps[items[i].dataset.item].push([items[j].dataset.item, {
						left: 0,
						top: other.top - pos.bottom,
					}]);
					overlaps[items[j].dataset.item].push([items[i].dataset.item, {
						left: 0,
						top: pos.bottom - other.top,
					}]);
				}
				if (overlap.alignY && overlap.left) {
					count++;
					overlaps[items[i].dataset.item].push([items[j].dataset.item, {
						left: other.right - pos.left,
						top: 0,
					}]);
					overlaps[items[j].dataset.item].push([items[i].dataset.item, {
						left: pos.left - other.right,
						top: 0,
					}]);
				}
				if (overlap.alignY && overlap.right) {
					count++;
					overlaps[items[i].dataset.item].push([items[j].dataset.item, {
						left: other.left - pos.right,
						top: 0,
					}]);
					overlaps[items[j].dataset.item].push([items[i].dataset.item, {
						left: pos.right - other.left,
						top: 0,
					}]);
				}
			}
		}

		return [overlaps, count];
	}

	function tweak() {
		var foundOverlaps = findOverlaps();
		//console.log(foundOverlaps);
		if (!foundOverlaps[1] || instance++ > maxLoops) {
			console.log(instance, 'loops');
			return false;
		}

		var overlaps = foundOverlaps[0];
		// find the worst overlap, and fix it

		// push everything apart
		for (var i = 0; i < items.length; i++) {
			var item = items[i];
			var overlap = overlaps[item.dataset.item];
			bump(item, overlap);
		}

		return true;
	}

	function drawLines() {
		for (var i = 0; i < items.length; i++) {
			var item = items[i];
			ctx.beginPath();
			ctx.moveTo(item.offsetLeft + item.offsetWidth / 2, item.offsetTop + item.offsetHeight / 2);
			ctx.lineTo(
				item.dataset.left * container.offsetWidth - item.offsetWidth / 2,
				item.dataset.top * container.offsetHeight + item.offsetHeight / 2
			);
			ctx.closePath();
			ctx.stroke();
		}
	}

	/*
	var interval = setInterval(function() {
		if (!tweak())
			clearInterval(interval);
	}, 1500);

	var button = document.createElement('button');
	document.getElementsByTagName('header')[0].appendChild(button);
	button.style.position = 'absolute';
	button.style.top = '1em';
	button.style.left = '10em';
	button.innerText = 'Reflow';
	button.addEventListener('click', function () {
		clearInterval(interval);
		tweak();
	});
	*/

	function reposition() {
		while (tweak()); // repeat until no overlaps remain
		drawLines();
	}

	// fixup and store original coords before anything else
	var percentPos = /([\d.]+)%/;
	for (var i = 0; i < items.length; i++) {
		var item = items[i];

		if (item.offsetLeft < 0)
			item.style.left = 0;
		if ((item.offsetLeft + item.offsetWidth) > container.offsetWidth)
			item.style.left = 'calc(100% - ' + item.offsetWidth + 'px)';
		if (item.offsetTop < 0)
			item.style.top = 0;
		if ((item.offsetTop + item.offsetHeight) > container.offsetHeight)
			item.style.top = 'calc(100% - ' + item.offsetHeight + 'px)';

		item.dataset.top = parseFloat(item.style.top.match(percentPos)[1]) / 100;
		item.dataset.left = parseFloat(item.style.left.match(percentPos)[1]) / 100;
	}

	reposition();

	// Reset to initial position on resize and re-run
	window.addEventListener('resize', function() {
		// reset everything to initial position
		for (var i = 0; i < items.length; i++) {
			var item = items[i];
			item.style.left = 'calc(' + (item.dataset.left * 100) + '% - ' + item.offsetWidth + 'px)';
			item.style.top = (item.dataset.top * 100) + '%';
		}
		// clear canvas
		ctx.clearRect(0, 0, canvas.width, canvas.height);
		canvas.width = container.offsetWidth;
		canvas.height = container.offsetHeight;

		instance = 0;
		reposition();
	});
}

window.addEventListener('load', seedQuestWorldRelayout);
