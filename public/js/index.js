
// Событие показа модалки
const filterBtn = document.querySelector('.news__filter-btn');
filterBtn.onclick = () => {

	const filterIcon = document.querySelector('.news__filter-icon');
	const coordBtn = filterIcon.getBoundingClientRect();
	const modal = document.querySelector(".modal");
	const clientWidth = document.documentElement.clientWidth;
	
	filterIcon.classList.toggle('news__filter-icon_active');
	modal.classList.toggle('modal_disable');
	
	if (modal.classList.length == 2) {

		modal.style.left = 0 + "px";
		modal.style.top = 0 + "px";

	}
	else {

		if (clientWidth < 767)
			modal.style.left = (clientWidth / 2) - (modal.clientWidth / 2) + "px";
		else
			modal.style.left = coordBtn.right - modal.clientWidth + "px";

		modal.style.top = coordBtn.bottom + pageYOffset + 10 + "px";

	}

	modal.classList.toggle("modal_visible");
	
}

// Событие при изменении размера документа
document.onresize = () => {
	
	const filterIcon = document.querySelector('.news__filter-icon');
	const coordBtn = filterIcon.getBoundingClientRect();
	const modal = document.querySelector(".modal");
	const clientWidth = document.documentElement.clientWidth;
	
	if (clientWidth < 767)
		modal.style.left = (clientWidth / 2) - (modal.clientWidth / 2) + "px";
	else
		modal.style.left = coordBtn.right - modal.clientWidth + "px";
	
	modal.style.top = coordBtn.bottom + pageYOffset + 10 + "px";
	
}

// Событие при загрузке страницы
window.onload = () => {
	
	const params = getParams();
	
	if (params.length > 0) {
		
		params.forEach(param => {
			
			if (param[0] == 'filter') {
				
				const modalBtn = document.querySelectorAll('.modal__btn');
				const filterText = decodeURIComponent(param[1]);
				const filterBtnValue = document.querySelector('.news__filter-value');
				
				modalBtn.forEach(btn => {
					
					btn.classList.remove('modal__btn_active');
					
					if (btn.innerText == filterText) {
						
						btn.classList.add('modal__btn_active');
						filterBtnValue.innerText = filterText;
						
					}
					
				});
				
			}
			
		});
		
	}
	
}

// Событие клика по кнопка модалки
const modalBtn = document.querySelectorAll('.modal__btn');
modalBtn.forEach(btn => {
	
	btn.onclick = () => {
		
		const params = getParams();
		let isFind = true;
		
		if (params.length > 0) {
			
			params.forEach(param => {
			
				if (param[0] == 'filter') {
					
					param[1] = encodeURIComponent(btn.innerText);
					
				}
				else {
					isFind = false;
				}
			
			});
			
		}
		else {
			isFind = false;
		}
		
		if (!isFind) {
			
			params.push(['filter', encodeURIComponent(btn.innerText)]);
			
		}
		
		window.location = buildUrl(params);
		
	}
	
});

// Получение параметров
function getParams() {

	const url = window.location.search.slice(1);

	if (!url) return [];

	const arr = url.split("&");
	let params = [];

	for (let i = 0; i < arr.length; ++i) {

		params.push(arr[i].split("="));

	}

	return params;

}

// Построение ссылки
function buildUrl(params) {

	let str = "?";

	if (params.length != 0) {

		params.forEach(elem => {
		
			str += elem[0] + "=" + elem[1] + "&";

		});

	}
	
	str = str.substring(0, str.length - 1);

	return str == "" ? "/" : str;
	
}
