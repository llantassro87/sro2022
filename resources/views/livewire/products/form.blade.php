@include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label style="color: #3b3f5c;">Nombre del producto:</label>
            <input type="text" wire:model.lazy='name' class="form-control" placeholder="Nombre del producto">
            <div>
                @error('name')
                    <span class="text-danger">
                        <b>{{ $message }}</b>
                    </span>
                @enderror
            </div>
        </div>
    </div>
    
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label style="color: #3b3f5c;">Código de barra:</label>
            <input type="text" wire:model.lazy='barcode' class="form-control" placeholder="Código de barra">
            <div>
                @error('barcode')
                    <span class="text-danger">
                        <b>{{ $message }}</b>
                    </span>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label style="color: #3b3f5c;">Precio de compra:</label>
            <input type="number" maxlength="5" wire:model.lazy='cost' class="form-control" readonly>
            <div>
                @error('cost')
                    <span class="text-danger">
                        <b>{{ $message }}</b>
                    </span>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label style="color: #3b3f5c;">Precio de venta:</label>
            <input type="number" maxlength="5" wire:model.lazy='price' class="form-control" placeholder="0.00">
            <div>
                @error('price')
                    <span class="text-danger">
                        <b>{{ $message }}</b>
                    </span>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label style="color: #3b3f5c;">Existencia:</label>
            <input type="number" min="1" step="1" wire:model.lazy='stock' class="form-control" readonly>
            <div>
                @error('stock')
                    <span class="text-danger">
                        <b>{{ $message }}</b>
                    </span>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label style="color: #3b3f5c;">Alertas | Inv. Mínimo:</label>
            <input type="number" min="1" step="1" wire:model.lazy='alert' class="form-control" placeholder="0.00">
            <div>
                @error('alert')
                    <span class="text-danger">
                        <b>{{ $message }}</b>
                    </span>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label style="color: #3b3f5c;">Categoría:</label>
            <select wire:model="categoryid" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>                    
                @endforeach
            </select>
            <div>
				@error('categoryid')
					<span class="text-danger">
						<b>{{ $message }}</b>
					</span>
				@enderror
			</div>
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label style="color: #3b3f5c;">Estado:</label>
            <select wire:model="status" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                <option value="1">Activo</option>
                <option value="0">Desactivo</option>
            </select>
            <div>
				@error('status')
					<span class="text-danger">
						<b>{{ $message }}</b>
					</span>
				@enderror
			</div>
        </div>
    </div>

    @if ($selected_id > 0)
        <div class="col-sm-12 col-md-2">
            
        </div>

        <div class="col-sm-12 col-md-8">
            <img src="{{ $actImage == null ? asset('storage/products/noimg.jpg') : asset('storage/products/'. $actImage) }}" class="rounded mx-auto d-block mt-2 mb-2" height="200px" width="200px" alt="{{ $name }}">
        </div>
        <div class="col-sm-12 col-md-2">
            
        </div>
    @endif

    <div class="col-sm-12 col-md-2">
        
    </div>

    <div class="col-sm-12 col-md-8">
        <div class="form-group custom-file">
            <input type="file" class="custom-file-input form-control" wire:model="image"  accept="image/x-png, image/gif/, image/jpg">
            <label class="custom-file-label">Imágen</label>
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