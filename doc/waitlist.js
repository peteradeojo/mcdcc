document.addEventListener('DOMContentLoaded', () => {
	// console.log('hello');
	const table = $('table#waitlist-table').DataTable({
		columns: [{}, { searchable: false }, { orderable: false }],
	});
});
