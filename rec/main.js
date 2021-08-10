(() => {
	'use strict';

	function format(d) {
		return `<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">
      <tr>
        <td>Full name:</td>
        <td>${d.name}</td>
      </tr>
      <tr>
        <td>Extension number:</td>
        <td>${d.phone}</td>
      </tr>
      <tr>
        <td>Extra info:</td>
        <td>And any further details here (images etc)...</td>
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

	loadSelectize();
})();
