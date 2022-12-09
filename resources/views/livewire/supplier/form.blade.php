@include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label style="color: #3b3f5c;">Nombre del proveedor:</label>
            <input type="text" wire:model.lazy='name' class="form-control" placeholder="Nombre del proveedor">
            <div>
                @error('name')
                    <span class="text-danger">
                        <b>{{ $message }}</b>
                    </span>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label style="color: #3b3f5c;">Télefono del proveedor:</label>
            <input type="tel" id="supplierPhone" wire:model.lazy='phone' class="form-control" placeholder="1234-5678" pattern="[0-9]{4}-[0-9]{4}" required>
            <div>
                @error('phone')
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

</div>

@include('common.modalFooter')