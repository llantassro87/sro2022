<div class="modal fade" id="theModal" wire:ignore.self tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>{{ $componentName }}</b> | CREAR
                </h5>
                <h6 class="text-center text-warning" wire:loading>Por favor espere...</h6>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <div class="n-chk">
                                <label style="color: #3b3f5c;" class="new-control new-checkbox checkbox-primary">
                                    <input wire:model='checkSupplier' wire:click="$emit('clear-supplier')" type="checkbox" class="new-control-input">
                                    <span class="new-control-indicator"></span><strong>Nuevo Proveedor</strong>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <div class="n-chk">
                                <label style="color: #3b3f5c;"
                                    class="new-control new-checkbox checkbox-primary text-bold">
                                    <input wire:model='checkProduct' wire:click="$emit('clear-product')" id="checkProduct" type="checkbox" class="new-control-input">
                                    <span class="new-control-indicator"></span><strong>Nuevo Producto</strong>
                                </label>
                            </div>
                        </div>
                    </div>

                    <hr style="width: 95%; height: 1.5px; background-color: #3b3f5c;" />

                    @if ($checkSupplier == 1)
                        @include('livewire.purchase.forms.supplier')
                    @else
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label style="color: #3b3f5c;">Buscar proveedor:</label>
                                <div class="input-group-prepend mb-3">
                                    <span class="input-group-text" id="basic-addon1">🔍</span>
                                    <input id="curso" type="text" placeholder="{{ $oldSupplierName == null ? 'Buscar proveedor...' : $oldSupplierName }}" wire:model="searchs" class="form-control">
                                    <br>
                                    <div>
                                        @error('searchs')
                                        <span class="text-danger">
                                            <b>{{ $message }}</b>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <ul class="list-group list-group-flush">
                                    <div wire:loading class="bg-white opacity-75 shadow-lg list-group">
                                        <div class="list-group-item">Buscando...</div>
                                    </div>
                                
                                    @if(!empty($searchs))           
                                        <div class="shadow-lg list-group">
                                            @forelse($suppliers as $supplier)
                                                <li style="color: #3b3f5c;"
                                                    wire:click="SearchSupplier({{ $supplier->id }})"
                                                    class="list-group-item"
                                                >{{ $supplier->name }}</li>
                                            @empty
                                                <div style="color: #3b3f5c;" class="list-group-item">
                                                    <h6>Sin resultados</h6>
                                                </div>
                                            @endforelse
                                        </div>
                                    @endif
                                </ul>
                            </div>
                        </div>

                    @endif

                    <hr style="width: 95%; height: 1.5px; background-color: #3b3f5c;" />

                    @if ($checkProduct == 1)
                        @include('livewire.purchase.forms.product')
                    @else
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label style="color: #3b3f5c;">Buscar el producto:</label>
                                <div class="input-group-prepend mb-3">
                                    <span class="input-group-text" id="basic-addon1">🔍</span>
                                    <input type="text" wire:model="searchp" class="form-control" placeholder="Buscar producto..." aria-describedby="basic-addon1">
                                    <div>
                                        @error('searchp')
                                        <span class="text-danger">
                                            <b>{{ $message }}</b>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <ul class="list-group list-group-flush">
                                    <div wire:loading class="bg-white opacity-75 shadow-lg list-group">
                                        <div class="list-group-item">Buscando...</div>
                                    </div>
                                
                                    @if(!empty($searchp))             
                                        <div class="absolute z-10 w-full bg-white rounded-t-none shadow-lg list-group">
                                            @forelse($products as $product)
                                                <li
                                                    wire:click="Edit({{ $product->id }})"
                                                    class="list-group-item"
                                                >{{ $product->name }}</li>
                                            @empty
                                                <div style="color: #3b3f5c;" class="list-group-item">
                                                    <h6>Sin resultados</h6>
                                                </div>
                                            @endforelse
                                        </div>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        @if ($productid > 0)
                            @include('livewire.purchase.forms.product')

                        @endif

                    @endif

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="rstui" wire:click.prevent="ResetUI()" class="btn btn-dark close-btn text-info"
                    data-dismiss="modal">CERRAR</button>
                <div>
                    <button type="button" wire:click.prevent="Store()" class="btn btn-dark close-modal">GUARDAR</button>
                </div>
            </div>
        </div>
    </div>
</div>