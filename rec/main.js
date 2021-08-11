(() => {
	'use strict';

	function format(d) {
		return `<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">
      <tr>
        <td>Full name:</td>
        <td>${d.name}</td>
      </tr>
      <tr>
        <td>Date of Birth:</td>
        <td>${d.birthdate}</td>
      </tr>
      <tr>
        <td>
					<a href="/rec/patient.php?id=${d.cardnumber}" class="btn btn-dark">View</a>
				</td>
      </tr>
    </table>`;
	}

	document.addEventListener('DOMContentLoaded', async () => {
		try {
			const patientCount = await get(
				'/api/patients.php?data=patients&return=count'
			);
			loadIntoPlace(patientCount.data, 'div h1#patients');
			const treatmentCount = await get(
				'/api/patients.php?data=treatments&return=count'
			);
			loadIntoPlace(treatmentCount.data, 'div h1#treatments');
		} catch (error) {}
	});

	document.addEventListener('DOMContentLoaded', () => {
		try {
			let table = $('table#patients').DataTable({
				ajax: { url: '/api/patients.php', dataSrc: 'data' },
				columns: [
					{
						data: null,
						defaultContent: '',
						className: 'details-control',
						orderable: false,
					},
					{ data: 'cardnumber' },
					{ data: 'name' },
					{ data: 'phone' },
					// { data: 'cardnumber' },
					// { data: 'cardnumber' },
				],
				order: [[1, 'asc']],
			});

			$('table#patients').on('click', 'td.details-control', function () {
				let tr = $(this).closest('tr');
				let row = table.row(tr);

				if (row.child.isShown()) {
					row.child.hide();
					tr.removeClass('shown');
				} else {
					row.child(format(row.data())).show();
					tr.addClass('shown');
				}
			});
		} catch (error) {}
	});

	document.addEventListener('DOMContentLoaded', () => {
		try {
			const generateNumberButton = document.querySelector('#generate-number');
			generateNumberButton.addEventListener('click', async () => {
				const category = document.querySelector('select#category').value;
				try {
					// console.log(category);
					const { data } = await get(
						`/api/patients.php?data=new&category=${category}`
					);
					document.querySelector('input#cardnumber').value = data;
				} catch (err) {}
			});
		} catch (error) {}
	});

	document.addEventListener('DOMContentLoaded', async () => {
		if (document.getElementById('appointments-display')) {
			try {
				let content = '';
				const { id } = Qs.parse(location.search.slice(1), {
					ignoreQueryPRefix: true,
				});
				if (!id) {
					throw new Error('Invalid Parameters passed');
				}
				const appointments = await get(
					`/api/patients.php?data=appointments&id=${id}`
				);
				if (appointments.data.length) {
					let today = new Date();
					today = new Date(
						today.getFullYear(),
						today.getMonth(),
						today.getDate()
					);
					appointments.data.forEach((appointment) => {
						const date = new Date(appointment.acc_date.date);
						content += `<li class='list-group-item d-flex'>
							<div class="col-9">
								<p class='m-0'><span class="label">Date:</span>${appointment.date}</p>
								<p class='m-0'><span class="label">Status:</span>${appointment.status_msg}</p>
							</div>
							<div class="col-3">
								${
									date.valueOf() === today.valueOf() && appointment.status == 0 
										? `<button class="btn btn-primary" onclick="checkInForAppointment('${id}', '${appointment.date}')">Check In</button>`
										: ''
									// `<button class="btn btn-primary" onclick="checkInForAppointment('${id}', '${appointment.date}')">Check In</button>`
								}
							</div>
						</li>`;
					});
				} else {
					content = `<li class='list-group-item'>No recent appointments</li>`;
				}
				loadIntoPlace(content, '#appointments-display');
			} catch (e) {
				console.error(e);
			}
		}
	});
})();

$(() => {
	loadSelectize();
});
