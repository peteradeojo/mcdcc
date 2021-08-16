'use strict';

const spinnerDiv = document.createElement('div');
spinnerDiv.appendChild(document.createElement('div'));
spinnerDiv.classList.add('spinner-image');
const showSpinner = () => {
	document.body.appendChild(spinnerDiv);
};
const removeSpinner = () => {
	document.body.removeChild(spinnerDiv);
};

/**
 *
 * @param {string} url The URL of the request
 * @param {string} mode JSON/text/ the method used to parse the response
 * @returns *
 */
const get = async (url, mode = 'json') => {
	try {
		const res = await fetch(url);
		if (res.ok) {
			let data;
			switch (mode) {
				case 'text':
					data = await res.text();
					break;
				default:
					data = await res.json();
			}
			return data;
		}
	} catch (error) {
		console.error(error);
	}
};

/**
 *
 * @param {string} url TheURL of the request
 * @param {*} body The body of the request, recommended JSON.stringify
 * @param {Object} headers Request Headers
 * @param {*} mode JSON/text/ the method used to parse the response
 * @returns
 */
const post = async (url, body, headers = {}, mode = 'json') => {
	try {
		const res = await fetch(url, { method: 'POST', body, headers });
		if (res.ok) {
			let data;
			switch (mode) {
				case 'text':
					data = await res.text();
					break;
				default:
					data = await res.json();
			}
			return data;
		}
	} catch (error) {
		throw error;
	}
};

/**
 * Check in a patient to take vital signs
 * @param {string} id
 */
const checkInForAppointment = async (id, date) => {
	try {
		showSpinner();
		const formdata = new FormData();
		formdata.append('id', id);
		formdata.append('date', date);
		const data = await post(`/api/patients.php?data=check-in`, formdata);
		console.log(data);
	} catch (error) {
		console.error(error);
	} finally {
		removeSpinner();
		location.reload();
	}
};

/**
 * Insert string to the innerHTML of any html element
 * @param {string} data
 * @param {HTMLElement} destination
 * @returns {undefined}
 */
const loadIntoPlace = (data, destination) => {
	// console.log(data);
	const dest = document.querySelector(destination);
	dest.innerHTML = data;
};

document.addEventListener('DOMContentLoaded', () => {
	const closeBtn = document.querySelector('.btn#close-sidenav');
	const openBtn = document.querySelector('.btn#open-sidenav');
	const sidenav = $('#sidenav');
	const main = $('main');
	closeBtn.addEventListener('click', () => {
		sidenav.hide();
		main.css('width', '100%');
		main.css('margin-left', '0');
	});
	openBtn.addEventListener('click', () => {
		sidenav.show();
		main.css('width', '80%');
		main.css('margin-left', '20%');
	});
});
