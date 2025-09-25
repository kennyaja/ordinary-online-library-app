function newEl(tagName, innerHTML, properties, children) {
	let element = document.createElement(tagName);

	if (innerHTML != null && innerHTML != undefined) {
		element.innerHTML = innerHTML;
	}

	if (properties != null) {
		Object.entries(properties).forEach(property => {
			if (property[0].substring(0, 7) == "_event_") {
				const event_name = property[0].substring(7);
				element.addEventListener(event_name, (event) => property[1](event, element));
				return;
			}

			element.setAttribute(property[0], property[1]);
		});
	}

	if (children != null) {
		children.forEach(child => {
			element.appendChild(child);
		});
	}

	return element;
}

function el(selector) {
	return document.querySelector(selector);
}
