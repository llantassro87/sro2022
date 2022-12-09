<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b> {{ $componentName }} | </b>{{ $pageTitle }}
                </h4>
                @can('crear roles')
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu"  style="background-color: #3b3f5c;" data-toggle="modal" data-target="#theModal">Agregar</a>
                    </li>
                </ul>
                @endcan
            </div>
            @can('buscar roles')
                @include('common.searchbox')
            @endcan
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1 text-center">
                        <thead class="text-white" style="background: #3b3f5c">
                            <tr>
                                <th class="table-th text-white">ID</th>
                                <th class="table-th text-white">DESCRIPCIÓN</th>
                                <th class="table-th text-white">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody wire:loading.class.delay="opacity-25">
                            @forelse ($roles as $rol)
                            <tr>
                                <td>
                                    <h6>{{ $rol->id }}</h6>
                                </td>
                                <td>
                                    <h6>{{ $rol->name }}</h6>
                                </td>
                                <td class="text-center">
                                    @can('actualizar roles')
                                    <a href="javascript:void(0)" wire:click="Edit({{ $rol->id }})" class="btn btn-dark mtmobile" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3">
                                    <h5>Sin resultados.</h5>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.roles.form')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    
            window.livewire.on('show-modal' , msg =>{
                $('#theModal').modal('show');
            });
    
            window.livewire.on('role-added' , msg =>{
                $('#theModal').modal('hide');
                noty(msg);
            });
    
            window.livewire.on('role-updated' , msg => {
                $('#theModal').modal('hide');
                noty(msg);
            });

            window.livewire.on('role-deleted' , msg => {
                noty(msg);
            });

            window.livewire.on('role-exist' , msg => {
                noty(msg);
            });

            window.livewire.on('role-error' , msg => {
                noty(msg);
            });

            $("#theModal").on('hide.bs.modal', function () {
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