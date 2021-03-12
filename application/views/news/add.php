
<div class="add">
	
	<form class="form" method="POST" enctype="multipart/form-data">
		<div class="form__title">Добавить новость</div>
		<input type="text" 
					 name="title" 
					 placeholder="Заголовок" 
					 class="form__input" 
					 required>
		<input type="text" 
					 name="description" 
					 placeholder="Описание" 
					 class="form__input" 
					 required>
		<div class="form__choose">
			<input type="file" 
						 name="file" 
						 id="file" 
						 class="form__file" 
						 accept=".jpg, .png, .jpeg"
						 required>
			<label for="file" class="form__file-label">
				<strong>Изображение</strong>
			</label>
		</div>
		<img src="" class="form__image form__image_disable" />
		<div style="display: flex; justify-content: space-between;">
			<div></div>
			<input type="submit" 
						 value="Добавить" 
						 class="btn form__btn-pos">
		</div>
	</form>
	
</div>

<script src="/public/js/main.js"></script>
