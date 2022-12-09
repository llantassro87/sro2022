<div class="col-sm-12 col-md-6">
    <div class="form-group">
        <label style="color: #3b3f5c;">Nombre del producto:</label>
        <input type="text" wire:model.lazy='productName' class="form-control" placeholder="Nombre del producto">
        <div>
            @error('productName')
                <span class="text-danger">
                    <b>{{ $message }}</b>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="col-sm-12 col-md-3">
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

<div class="col-sm-12 col-md-3">
    <div class="form-group">
        <label style="color: #3b3f5c;">Precio de compra:</label>
        <input type="number" maxlength="5" wire:model.lazy='cost' class="form-control" placeholder="0.00">
        <div>
            @error('cost')
                <span class="text-danger">
                    <b>{{ $message }}</b>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="col-sm-12 col-md-3">
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

@if (!$checkProduct == 1)
<div class="col-sm-12 col-md-3">
    <div class="form-group">
        <label style="color: #3b3f5c;">Existencia actual:</label>
        <input type="number" min="1" step="1" wire:model.lazy='stock' class="form-control" placeholder="0.00" {{ $productid > 0 ? 'readonly' : '' }}>
        <div>
            @error('stock')
                <span class="text-danger">
                    <b>{{ $message }}</b>
                </span>
            @enderror
        </div>
    </div>
</div>
@endif

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
        <select wire:model="categoryid" class="form-control" data-live-search="true">
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
    <div class="form-group custom-file" style="margin-top: 2rem;">
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

<hr style="width: 95%; height: 1px; background-color: #3b3f5c;" />

<div class="col-sm-12 col-md-3">
    
</div>

<div class="col-sm-12 col-md-3">
    <div class="form-group">
        <label style="color: #3b3f5c;">Cantidad:</label>
        <input type="number" min="1" wire:model.lazy='quantity' class="form-control"
            placeholder="0.00">
        <div>
            @error('quantity')
            <span class="text-danger">
                <b>{{ $message }}</b>
            </span>
            @enderror
        </div>
    </div>
</div>

<div class="col-sm-12 col-md-3">
    <div class="form-group">
        <label style="color: #3b3f5c;">Total:</label>
        <input type="number" min="1" wire:model.lazy='total' class="form-control"
            placeholder="0.00">
        <div>
            @error('total')
            <span class="text-danger">
                <b>{{ $message }}</b>
            </span>
            @enderror
        </div>
    </div>
</div>