(() => {
	document.addEventListener('DOMContentLoaded', async () => {
		try {
			const { data } = await get(
				'/api/patients.php?data=waitlisted&return=count'
			);
			loadIntoPlace(data.num, '#waitlist-count');
			console.log(data);
		} catch (error) {}
	});
})();
