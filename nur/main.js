(() => {
	document.addEventListener('DOMContentLoaded', async () => {
		if (document.querySelector('#waitlist-count')) {
			try {
				const { data } = await get(
					'/api/patients.php?data=waitlisted&return=count'
				);
				loadIntoPlace(data.num, '#waitlist-count');
			} catch (error) {
				console.error(error);
			}
		}
	});

	document.addEventListener('DOMContentLoaded', async () => {
		try {
			const { data } = await get('/api/patients.php?data=waitlist');
			// console.log(data);
			let li = '';
			if (!data.length) {
				li = `<li class='list-group-item'>No patients in the waiting area</li>`;
			}
			data.forEach((datum) => {
				li += `<li class="list-group-item">
					<p>${datum.lastname} ${datum.firstname}</p>
					<p>${datum.date} ${datum.status}</p>
					<a href="/nur/vitals.php?patient=${datum.cardnumber}" class="btn btn-warning">Take Vital Signs</a>
				</li>
				`;
			});
			loadIntoPlace(li, '#waitlist');
		} catch (error) {
			console.error(error);
		}
	});
})();
