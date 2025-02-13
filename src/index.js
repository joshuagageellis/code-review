(function () {
	const form = document.querySelector('#palette-form');
	const results = document.querySelector('#palette-results');

	form.addEventListener('submit', async (event) => {
		event.preventDefault();
		const params = new URLSearchParams(new FormData(form));
		const requestUrl = `/wp-json/wideeye/v1/palette?${params.toString()}`;
		const response = await fetch(requestUrl, {
			method: 'GET',
		});
		
		if (response.ok) {
			// Create palette elements.
			const data = await response.json();
			const items = [];
			console.log(data);
			data.result.forEach((color) => {
				const colorElement = document.createElement('div');
				colorElement.classList.add('palette-color');
				colorElement.style.backgroundColor = `rgb(${color[0]}, ${color[1]}, ${color[2]})`;
				items.push(colorElement);
			});
			results.innerHTML = '';
			items.forEach((item) => {
				results.appendChild(item);
			});
		} else {
			results.innerHTML = `<p>${data
				.message}</p>`;
		}
	});
})();