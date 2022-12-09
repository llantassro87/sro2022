<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b> {{ $componentName }} | </b>{{ $pageTitle }}
                </h4>
                @can('crear compras')
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu"  style="background-color: #3b3f5c;" data-toggle="modal" data-target="#theModal">Agregar</a>
                    </li>
                </ul>
                @endcan
            </div>
            @can('buscar compras')
                @include('common.searchbox')  
            @endcan

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1 text-center">
                        <thead class="text-white" style="background: #3b3f5c">
                            <tr>
                                <th class="table-th text-white">PROVEEDOR</th>
                                <th class="table-th text-white">PRODUCTO</th>
                                <th class="table-th text-white">REGISTRO</th>
                                <th class="table-th text-white">CANTIDAD</th>
                                <th class="table-th text-white">TOTAL</th>
                                <th class="table-th text-white">FECHA</th>
                            </tr>
                        </thead>
                        <tbody wire:loading.class.delay="opacity-25">
                            
                            @forelse ($purchases as $purchase)
                            <tr>
                                <td>
                                    <h6>{{ $purchase->supplier }}</h6>
                                </td>
                                <td>
                                    <h6>{{ $purchase->products }}</h6>
                                </td>
                                <td>
                                    <h6>{{ $purchase->user }}</h6>
                                </td>
                                <td>
                                    <h6>{{ number_format($purchase->quantity) }}</h6>
                                </td>
                                <td>
                                    <h6>${{ number_format($purchase->total, 2) }}</h6>
                                </td>
                                <td>
                                    <h6>{{ \Carbon\Carbon::parse($purchase->date)->format('d-m-Y H:i:s') }}</h6>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    <h5>Sin resultados.</h5>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.purchase.form')
    <script>
            document.addEventListener('DOMContentLoaded', function() {

                window.livewire.on('purchase-added' , msg => {
                    $('#theModal').modal('hide');
                    noty(msg);
                });

                window.livewire.on('purchase-updated' , msg => {
                    $('#theModal').modal('hide');
                    noty(msg);
                });

                window.livewire.on('purchase-deleted' , msg => {
                    noty(msg);
                });

                window.livewire.on('purchase-error' , msg => {
                    noty(msg,2);
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
            
    </script>
</div>