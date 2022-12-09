<div class="modal fade" id="modalSearchProduct" wire:ignore.self tabindex="-1" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">

                <div class="input-group">
                    <input type="text" class="form-control" wire:model='search' id="modal-search-product" placeholder="Buscar el producto por nombre o código de barra">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-gp">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                </div>

            </div>
            <div class="modal-body">
                <div class="row p-2">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mt-1 text-center">
                            <thead class="text-white" style="background: #3b3f5c">
                                <tr>
                                    <th width="4%"></th>
                                    <th class="table-th text-white">NOMBRE</th>
                                    <th class="table-th text-white">PRECIO</th>
                                    <th class="table-th text-white">CATEGORÍA</th>
                                    <th class="table-th text-white">
                                        <button wire:click.prevent="addAll" class="btn btn-info" {{ count($products) > 0 ? '' : 'disabled' }}>
                                            <i class="fas fa-check"></i>
                                            Agregar todos
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody wire:loading.class.delay="opacity-25">
                                @forelse ($products as $product)
                                <tr>
                                    <td>
                                        <span>
                                            <img src="{{ asset('storage/products/'. $product->imagen) }}" alt="Imagen del producto" height="50" width="80" class="rounded">
                                        </span>
                                    </td>
                                    <td>
                                        <h6><b>{{ $product->name }}</b></h6>
                                        <small class="text-info">{{ $product->barcode }}</small>
                                    </td>
                                    <td>
                                        ${{ number_format($product->price, 2) }}
                                    </td>
                                    <td>
                                        <h6>{{ $product->category }}</h6>
                                    </td>
                                    <td>
                                        <button wire:click.prevent="$emit('scan-code-byId', {{ $product->id }})" class="btn btn-dark">
                                            <i class="fas fa-cart-arrow-down mr-1"></i>
                                            Agregar
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5">
                                        <h5>Sin resultados.</h5>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="rstui" wire:click.prevent="ResetUI()" class="d-none" data-dismiss="modal">Reset</button>
                <button type="button" class="btn btn-dark close-btn text-info" data-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#modalSearchProduct').on('hide.bs.modal', function () {
                document.getElementById('modal-search-product').value = '';
            });

            $('#modalSearchProduct').on('hidden.bs.modal', function (e) {
                document.getElementById('rstui').click();
            });
        });
    </script>
</div>