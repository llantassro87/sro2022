<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b> {{ $componentName }} | </b>{{ $pageTitle }}
                </h4>
                @can('crear denominaciones')
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu"  style="background-color: #3b3f5c;" data-toggle="modal" data-target="#theModal">Agregar</a>
                    </li>
                </ul>
                @endcan
            </div>
            @can('buscar denominaciones')
            @include('common.searchbox')
            @endcan
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1 text-center">
                        <thead class="text-white" style="background: #3b3f5c">
                            <tr>
                                <th class="table-th text-white">TIPO</th>
                                <th class="table-th text-white">VALOR</th>
                                <th class="table-th text-white">IMAGEN</th>
                                <th class="table-th text-white">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody wire:loading.class.delay="opacity-25">
                            @forelse ($data as $coin)
                            <tr>
                                <td>
                                    <h6>{{ $coin->type }}</h6>
                                </td>
                                <td>
                                    <h6>${{ number_format($coin->value, 2) }}</h6>
                                </td>
                                <td class="text-center">
                                    <span>
                                        <img src="{{ asset('storage/denominations/'. $coin->imagen) }}" alt="Imagen de ejemplo" height="70" width="80" class="rounded">
                                    </span>
                                </td>
                                <td class="text-center">
                                    @can('actualizar denominaciones')
                                    <a href="javascript:void(0)" wire:click="Edit({{ $coin->id }})" class="btn btn-dark mtmobile" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan
                                    @can('eliminar denominaciones')
                                    <a href="javascript:void(0)" onclick="Confirm({{ $coin->id }})" class="btn btn-danger" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    @endcan
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">
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
    @include('livewire.denominations.form')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            window.livewire.on('item-added' , msg => {
                $('#theModal').modal('hide');
                noty(msg);
            });

            window.livewire.on('item-updated' , msg => {
                $('#theModal').modal('hide');
                noty(msg);
            });

            window.livewire.on('item-deleted' , msg => {
                noty(msg);
            });

            window.livewire.on('show-modal' , msg => {
                $('#theModal').modal('show');
            });

            window.livewire.on('modal-hide' , msg => {
                $('#theModal').modal('hide');
            });

            $('#theModal').on('hidden.bs.modal', function (e) {
                document.getElementById('rstui').click();
            });

        });

        function Confirm(id) {

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