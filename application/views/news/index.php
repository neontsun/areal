
<div class="news">
	
	<div class="news__header">
		<div class="news__filter">
			<span class="news__filter-title">Сортировать по дате:</span>
			<div class="news__filter-btn">
				<span class="news__filter-value">сначала новые</span>
				<svg xmlns="http://www.w3.org/2000/svg" 
						 viewBox="0 0 16 16"
						 class="news__filter-icon">
					<path fill-rule="evenodd"
						d="M12.2928932,5.29289322 C12.6834175,4.90236893 
						13.3165825,4.90236893 13.7071068,5.29289322 
						C14.0976311,5.68341751 14.0976311,6.31658249 
						13.7071068,6.70710678 L8.70710678,11.7071068 
						C8.31658249,12.0976311 7.68341751,12.0976311 
						7.29289322,11.7071068 L2.29289322,6.70710678 
						C1.90236893,6.31658249 1.90236893,5.68341751 
						2.29289322,5.29289322 C2.68341751,4.90236893 
						3.31658249,4.90236893 3.70710678,5.29289322 
						L8,9.58578644 L12.2928932,5.29289322 Z" />
				</svg>
			</div>
		</div>
		<a href="news/add">
			<button class="btn news__btn">Добавить новость</button>
		</a>
	</div>
	
	<?php foreach ($data['news'] as $item): ?>
		
		<div class="news__item">
			<img 
				src="<?= $item['image_path']; ?>"
				class="news__img">
			<div class="news__text">
				<div class="news__desc">
					<div class="news__title">
						<?= $item['title']; ?>
					</div>
					<div class="news__description">
						<?= $item['description']; ?>
					</div>
				</div>
				<div class="news__item-footer">
					<div class="news__date">
						<?= $item['created_at']; ?>
					</div>
					<a
						href="news/edit/<?= $item['row_id']; ?>" 
						class="news__link">
						Редактировать
					</a>
				</div>
			</div>
		</div>
	
	<?php endforeach ?>
	
	<div class="news__paginate">
		
		<?php if ($data['page'] != $data['paginate']['first_page']): ?>
				
			<div class="news__page-btn" 
					 data-page="<?= $data['page'] - 1; ?>">
				Предыдущая
			</div>
		
		<?php else: ?>
		
			<div></div>
			
		<? endif ?>
	
		<?php if ($data['page'] != $data['paginate']['last_page']): ?>
				
			<div class="news__page-btn" 
					 data-page="<?= $data['page'] + 1; ?>">
				Следующая
			</div>
			
		<?php else: ?>
			
			<div></div>
			
		<? endif ?>
		
	</div>
	
</div>

<div class="modal modal_disable">
	<div class="modal__btn modal__btn_active">сначала новые</div>
	<div class="modal__btn">сначала старые</div>
</div>

<script src="/public/js/index.js"></script>
