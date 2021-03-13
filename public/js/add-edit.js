
// Событие выбора изображения
const inputFile = document.querySelector('.form__file');
const label = inputFile.nextElementSibling;
const labelValue = label.innerHTML;
	
inputFile.onchange = (e) => {
	
	const file = e.target.files[0];
	const fileName = file.name;
	
	if (fileName) {
		label.querySelector('strong').innerHTML = fileName;
		const image = document.querySelector('.form__image');
		
		const reader = new FileReader();
		reader.addEventListener('load', (event) => {
			image.src = event.target.result;
		});
		reader.readAsDataURL(file);
		
		image.classList.remove('form__image_disable');
	}
	else
		label.innerHTML = labelValue;
	
};

// Событие добавления и редактирования новости
const submitBtn = document.querySelector('.form__btn-pos');
submitBtn.oncklick = async (e) => {
	e.preventDefault();
	
	const files = document.querySelector('[type=file]').files;
	const formData = new FormData();
	
	if (files.length != 0) {
		formData.append('file', files[0]);
	}
	
	const url = window.location.pathname;
	
	await fetch(url, {
		method: 'POST',
		body: formData
	});
	
};

// Событие удаления новости
if (window.location.pathname.split('/')[2] === 'edit') {
	
	const deleteBtn = document.querySelector('.form__btn-neg');
	deleteBtn.oncklick = async (e) => {
		
		const url = window.location.pathname;
		
		await fetch(url, {
			method: 'POST'
		});
	
	};
	
}
