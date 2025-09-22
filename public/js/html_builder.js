function newEl(tagName, innerHTML, properties, children) {
	let element = document.createElement(tagName);

	if (innerHTML != null && innerHTML != undefined) {
		element.innerHTML = innerHTML;
	}

	if (properties != null) {
		Object.entries(properties).forEach(property => {
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
