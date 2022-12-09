<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b> {{ $componentName }} | </b>{{ $pageTitle }}
                </h4>
            </div>
            @can('buscar productos')
                @include('common.searchbox')
            @endcan
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1 text-center">
                        <thead class="text-white" style="background: #3b3f5c">
                            <tr>
                                <th wire:click="sortBy('name')" class="table-th text-white">
                                    NOMBRE
                                    @if ($sortField == 'name')
                                        @if ($sortDirection == 'asc')
                                            <i class="fas fa-chevron-up"></i>
                                        @else
                                            <i class="fas fa-chevron-down"></i>
                                        @endif
                                    @endif
                                </th>
                                <th class="table-th text-white">BARCODE</th>
                                <th wire:click="sortBy('category')" class="table-th text-white">
                                    CATEGORÍA
                                    @if ($sortField == 'category')
                                        @if ($sortDirection == 'asc')
                                            <i class="fas fa-chevron-up"></i>
                                        @else
                                            <i class="fas fa-chevron-down"></i>
                                        @endif
                                    @endif
                                </th>
                                <th wire:click="sortBy('price')" class="table-th text-white">
                                    PRECIO VENTA
                                    @if ($sortField == 'price')
                                        @if ($sortDirection == 'asc')
                                            <i class="fas fa-chevron-up"></i>
                                        @else
                                            <i class="fas fa-chevron-down"></i>
                                        @endif
                                    @endif
                                </th>
                                <th wire:click="sortBy('stock')" class="table-th text-white">
                                    EXISTENCIA
                                    @if ($sortField == 'stock')
                                        @if ($sortDirection == 'asc')
                                            <i class="fas fa-chevron-up"></i>
                                        @else
                                            <i class="fas fa-chevron-down"></i>
                                        @endif
                                    @endif
                                </th>
                                <th wire:click="sortBy('status')" class="table-th text-white">
                                    ESTADO
                                    @if ($sortField == 'status')
                                        @if ($sortDirection == 'asc')
                                            <i class="fas fa-chevron-up"></i>
                                        @else
                                            <i class="fas fa-chevron-down"></i>
                                        @endif
                                    @endif
                                </th>
                                <th class="table-th text-white">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody wire:loading.class.delay="opacity-25">
                            @forelse ($data as $product)
                            <tr>
                                <td>
                                    <h6>{{ $product->name }}</h6>
                                </td>
                                <td>
                                    <h6>{{ $product->barcode }}</h6>
                                </td>
                                <td>
                                    <h6>{{ $product->category }}</h6>
                                </td>
                                <td>
                                    <h6>${{ number_format($product->price, 2) }}</h6>
                                </td>
                                <td>
                                    <h6>{{ $product->stock }}</h6>
                                </td>
                                <td>
                                    <span class="badge {{ $product->status == 1 ? 'badge-success' : 'badge-danger' }}">
                                        {{ $product->status == 1 ? 'ACTIVO' : 'DESACTIVO' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @can('actualizar productos')
                                    <a href="javascript:void(0)" wire:click="Edit({{ $product->id }})" class="btn btn-dark mtmobile" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">
                                    <h5>Sin resultados.</h5>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.products.form')
    <script>
            document.addEventListener('DOMContentLoaded', function() {

                window.livewire.on('product-added' , msg => {
                    $('#theModal').modal('hide');
                    noty(msg);
                });

                window.livewire.on('product-updated' , msg => {
                    $('#theModal').modal('hide');
                    noty(msg);
                });

                window.livewire.on('product-deleted' , msg => {
                    noty(msg);
                });

                window.livewire.on('show-modal' , msg => {
                    $('#theModal').modal('show');
                });

                window.livewire.on('modal-hide' , msg => {
                    $('#theModal').modal('hide');
                });

                $('#theModal').on('hide.bs.modal', function () {
                    document.getElementById('rstui').click();
                });

            });

            function Confirm(id, products) {

                if (products > 0) {
                    swal({
                        type: 'error',
                        title: 'Oops...',
                        text: 'No se puede eliminar está categoría, porqué tiene productos relacionados.',
                        confirmButtonColor: '#3b3f5c',
                        confirmButtonText: 'Aceptar'
                    });
                    return;
                }

                swal({
                    title: 'CONFIRMAR',
                    text: '¿Desea eliminar el registro?',
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Cerrar',
                    cancelButtonColor: '#FFF',
                    confirmButtonColor: '#3b3f5c',
                    confirmButtonText: 'Aceptar'
                })
                .then(function(result) {
                    if (result.value) {
                        window.livewire.emit('deleteRecord', id);
                        swal.close();
                    }
                });
            }

            
    </script>
</div>