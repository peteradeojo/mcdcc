(() => {
	$('#table').DataTable();
	document
		.querySelector('#query-exec')
		.addEventListener('submit', async function (e) {
			e.preventDefault();
			const query = this.query.value;
			const formdata = new FormData();
			formdata.append('query', query);
			try {
				const data = await post('/ict/records/api/index.php', formdata);
				console.log(data);
			} catch (error) {
				console.error(error);
			}
		});
})();
