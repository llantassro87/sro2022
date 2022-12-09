<div class="col-sm-12 col-md-6">
    <div class="form-group">
        <label style="color: #3b3f5c;">Nombre del proveedor:</label>
        <input type="text" wire:model.lazy='supplierName' class="form-control" placeholder="Nombre del proveedor">
        <div>
            @error('supplierName')
                <span class="text-danger">
                    <b>{{ $message }}</b>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="col-sm-12 col-md-6">
    <div class="form-group">
        <label style="color: #3b3f5c;">Teléfono del proveedor:</label>
        <input type="tel" id="supplierPhone" class="form-control" wire:model.lazy='supplierPhone' placeholder="1234-5678" pattern="[0-9]{4}-[0-9]{4}" required>
        <div>
            @error('supplierPhone')
                <span class="text-danger">
                    <b>{{ $message }}</b>
                </span>
            @enderror
        </div>
    </div>
    <script>
        var phonenumber = document.getElementById('supplierPhone');
        var maskOptions = {
            mask: '0000-0000'
        };
        var mask = IMask(phonenumber, maskOptions);
    </script>
</div>