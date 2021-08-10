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

const loadSelectize = () => {
	const selects = document.querySelectorAll('select[data-src]');

	selects.forEach((sel) => {
		const url = sel.getAttribute('data-src');
		(async () => {
			try {
				const { data } = await get(url);
				data.forEach((opt) => {
					let option = document.createElement('option');
					option.value = opt.value;
					option.innerHTML = opt.title;
					sel.appendChild(option);
					// console.log(sel);
				});
				$("select[data-type='selectize']").selectize();
			} catch (error) {}
		})();
	});
};
