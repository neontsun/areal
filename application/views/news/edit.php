
<div class="edit">
	
	<form class="form" method="POST" enctype="multipart/form-data">
		<div class="form__title">Редактировать новость</div>
		<input type="text" 
					 name="title" 
					 placeholder="Заголовок" 
					 class="form__input" 
					 value="<?= $data['title']; ?>"
					 required>
		<input type="text" 
					 name="description" 
					 placeholder="Описание" 
					 class="form__input"
					 value="<?= $data['description']; ?>"
					 required>
		<div class="form__choose">
			<input type="file" 
						 name="file" 
						 id="file" 
						 class="form__file" 
						 accept=".jpg, .png, .jpeg"
						 value="<?= $data['real_path']; ?>">
			<label for="file" class="form__file-label">
				<strong><?= $data['image_name']; ?></strong>
			</label>
		</div>
		<img src="<?= $data['image_path']; ?>" 
				 class="form__image" />
		<div style="display: flex; justify-content: flex-end;">
			<input type="submit"
						 value="Удалить" 
						 class="btn form__btn-neg"
						 name="action">
			<input type="submit" 
						 value="Добавить"
						 class="btn form__btn-pos"
						 name="action">
		</div>
	</form>
	
</div>

<script src="/public/js/main.js"></script>
