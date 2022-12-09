@include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label style="color: #3b3f5c;">Nombre del usurio:</label>
            <input type="text" wire:model.lazy='name' class="form-control" placeholder="Nombre del usuario">
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
            <label style="color: #3b3f5c;">Télefono del usuario:</label>
            <input type="tel" id="userPhone" wire:model.lazy='phone' class="form-control" placeholder="1234-5678" pattern="[0-9]{4}-[0-9]{4}" required>
            <div>
                @error('phone')
                    <span class="text-danger">
                        <b>{{ $message }}</b>
                    </span>
                @enderror
            </div>
        </div>
        <script>
            var phonenumber = document.getElementById('userPhone');
            var maskOptions = {
                mask: '0000-0000'
            };
            var mask = IMask(phonenumber, maskOptions);
        </script>
        
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label style="color: #3b3f5c;">Correo:</label>
            <input type="email" wire:model.lazy='email' class="form-control" placeholder="Correo">
            <div>
                @error('email')
                    <span class="text-danger">
                        <b>{{ $message }}</b>
                    </span>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label style="color: #3b3f5c;">Contraseña:</label>
            <input type="password" wire:model.lazy='password' class="form-control">
            <div>
                @error('password')
                    <span class="text-danger">
                        <b>{{ $message }}</b>
                    </span>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label style="color: #3b3f5c;">Estado:</label>
            <select wire:model.lazy='status' class="form-control">
                <option value="Elegir" selected disabled>Elegir</option>
                <option value="ACTIVE">Activo</option>
                <option value="LOCKED">Bloqueado</option>
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

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label style="color: #3b3f5c;">Asignar un rol:</label>
            <select wire:model.lazy='profile' class="form-control">
                <option value="Elegir" selected disabled>Elegir</option>
                @foreach ($roles as $rol)
                    <option value="{{ $rol->name }}">{{ $rol->name }}</option>
                @endforeach
            </select>
            <div>
                @error('profile')
                    <span class="text-danger">
                        <b>{{ $message }}</b>
                    </span>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-8">
        <label style="color: #3b3f5c;">Imágen del usuario:</label>
        <div class="form-group custom-file">
            <input type="file" class="custom-file-input form-control" wire:model="image"  accept="image/x-png, image/gif/, image/jpg">
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