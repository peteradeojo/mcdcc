'use strict';

const get = async (url, mode = 'json') => {
	try {
		const res = await fetch(url);
		let data;
		switch (mode) {
			case 'text':
				data = await res.text();
				break;
			default:
				data = await res.json();
		}

		// console.log(data);
		return data;
	} catch (error) {
		console.error(error);
	}
};

const loadIntoPlace = (data, destination) => {
	// console.log(data);
	const dest = document.querySelector(destination);
	dest.innerHTML = data;
};