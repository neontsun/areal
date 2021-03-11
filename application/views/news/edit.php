
<div class="edit">
	
	<form action="/news/add" class="form" method="POST">
		<div class="form__title">Редактировать новость</div>
		<input type="text" name="title" placeholder="Заголовок" class="form__input" required>
		<input type="text" name="description" placeholder="Описание" class="form__input" required>
		<div class="form__image">
			<input type="file" name="file" id="file" class="form__file" required>
			<label for="file" class="form__file-label">Изображение</label>
		</div>
		<div style="display: flex; justify-content: flex-end;">
			<input type="button" value="Удалить" class="btn form__btn-neg">
			<input type="submit" value="Редактировать" class="btn form__btn-pos">
		</div>
	</form>
	
</div>
