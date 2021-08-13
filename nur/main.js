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
					<div class="d-flex align-items-center align-content-center">
						<div class="col-sm-9">
							<p>${datum.name}</p>
							<p>${datum.date} ${datum.status}</p>
						</div>
						<div class="col-sm-3">
							${
								datum.appointment_status < '1'
									? `<button class="btn btn-danger">Direct to Records</button>`
									: ''
							}
							${
								datum.appointment_status > '1'
									? `<a href="/nur/vitals.php?patient=${datum.cardnumber}" class="btn btn-primary">View</a>`
									: ''
							}
							${
								datum.status == 'Waitlisted'
									? `<a href="/nur/vitals.php?patient=${datum.cardnumber}" class="btn btn-warning">Take Vital Signs</a>`
									: ''
							}
						</div>
					</div>
				</li>
				`;
			});
			loadIntoPlace(li, '#waitlist');
		} catch (error) {
			console.error(error);
		}
	});
})();
