@include('common.modalHead')

<div class="row">
	<div class="col-sm-12">
		<label style="color: #3b3f5c;">Nombre Categoria:</label>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
				</span>
			</div>
			<input type="text" wire:model.lazy="name" class="form-control" placeholder="Escribir el nombre de la categoría">
		</div>
		<div>
			@error('name')
				<span class="text-danger">
					<b>{{ $message }}</b>
				</span>
			@enderror
		</div>
	</div>

	<div class="col-sm-12">
		<label style="color: #3b3f5c;">Descripción Categoria:</label>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
				</span>
			</div>
			<input type="text" wire:model.lazy="description" class="form-control" placeholder="Escribir la descripción de la categoría">
		</div>
		<div>
			@error('description') 
				<span class="text-danger">
					<b>{{ $message }}</b>
				</span>
			@enderror
		</div>
	</div>

	<div class="col-sm-12">
		<label style="color: #3b3f5c;">Imágen Categoria:</label>
		<div class="form-group custom-file">
			<input type="file" class="custom-file-input form-control" wire:model="image" accept="image/x-png, image/gif/, image/jpg">
			<label class="custom-file-label">Imágen {{$image}}</label>
			<div>
				@error('image')
					<span class="text-danger">
						<b>{{ $message }}</b>
					</span>
				@enderror
			</div>
		</div>
	</div>
</div>

@include('common.modalFooter')