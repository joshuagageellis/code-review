(function () {
	const form = document.querySelector('#palette-form');
	const results = document.querySelector('#palette-results');

	form.addEventListener('submit', async (event) => {
		event.preventDefault();
		const response = await fetch('/wp-json/wideeye/v1/palette');
		const data = await response.json();
		console.log(data);
	});
})();