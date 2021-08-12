(() => {
	document.addEventListener('DOMContentLoaded', () => {
		if (document.getElementById('staff-table')) {
			const format = (d) => {
				return `<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">
          <tr>
            <td>Full name:</td>
            <td>${d.name}</td>
          </tr>
          <tr>
            <td>Phone Number:</td>
            <td>${d.phone}</td>
          </tr>
          <tr>
            <td>E-mail Address:</td>
            <td>${d.email}</td>
          </tr>
          <tr>
            <td>
              <a href="/ict/staff.php?id=${d.id}" class="btn btn-dark">View</a>
            </td>
          </tr>
        </table>`;
			};
			const table = $('#staff-table').DataTable({
				ajax: {
					url: '/api/staff.php',
				},
				columns: [
					{
						data: null,
						defaultContent: '',
						orderable: false,
						className: 'details-control',
					},
					{ data: 'title', defaultContent: 'Mr.', searchable: false },
					{ data: 'name' },
					{ data: 'post' },
				],
			});

			$('table#staff-table').on('click', 'td.details-control', function () {
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
		}

		if (document.getElementById('new-staff-form')) {
			document
				.getElementById('new-staff-form')
				.addEventListener('submit', async function (e) {
					e.preventDefault();

					const username = this.username.value;
					console.log(username);
					const check = await get(
						`/api/staff.php?data=find&username=${username}`
					);
					// console.log(check.length);
					if (check.length) {
						alert('Username already exists');
						return;
					}
					// this.submit();
					// e.initEvent('submit');
					const formdata = new FormData(this);
					const res = await post(this.action, formdata);
					console.log(res);
					if (res.ok) {
						location.href = '/ict/staff.php';
					}
				});
		}
	});
})();
