<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b> {{ $componentName }} </b>
                </h4>
            </div>

            <div class="widget-content">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="row">
                            <div class="col-sm-12">
                                <h6>Usuario:</h6>
                                <select wire:model='userId' class="form-control">
                                    <option value="0" selected disabled>Elegir</option>
                                    @foreach ($users as $u)
                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12">
                                <h6>Tipo de reporte:</h6>
                                <select wire:model='reportType' class="form-control">
                                    <option value="0">Ventas del día</option>
                                    <option value="1">Ventas por fechas</option>
                                </select>
                            </div>
                            <div class="col-sm-12">
                                <h6>Fecha de inicio:</h6>
                                <input type="date" wire:model="fromDate" class="form-control flatpickr" {{ $reportType == 0 ? 'disabled' : '' }} placeholder="Click para elegir">
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <h6>Fecha de fin:</h6>
                                    <input type="date" wire:model="toDate" class="form-control flatpickr" {{ $reportType == 0 ? 'disabled' : '' }} placeholder="Click para elegir">
                                </div>
                            </div>
        
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button wire:click="$refresh" type="button" class="btn btn-dark btn-block">Consultar</button>
                                    <a class="btn btn-dark btn-block {{ count($data) < 1 ? 'disabled' : '' }}" href="{{ url('reportes/pdf/' . $userId . '/' .  $reportType . '/' . $fromDate . '/' . $toDate . '/') }}" target="_blank">Generar PDF <i class="fas fa-file-pdf fa-lg"></i></a>
                                    <a class="btn btn-dark btn-block {{ count($data) < 1 ? 'disabled' : '' }}" href="{{ url('reportes/excel/' . $userId . '/' .  $reportType . '/' . $fromDate . '/' . $toDate . '/') }}" target="_blank">Exportar Excel <i class="fas fa-file-excel fa-lg"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

 
                    <div class="col-sm-12 col-md-9">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mt-1 text-center">
                                <thead class="text-white" style="background: #3b3f5c">
                                    <tr>
                                        <th class="table-th text-white">FOLIO</th>
                                        <th class="table-th text-white">TOTAL</th>
                                        <th class="table-th text-white">ITEMS</th>
                                        <th class="table-th text-white">ESTADO</th>
                                        <th class="table-th text-white">USUARIO</th>
                                        <th class="table-th text-white">FECHA</th>
                                        <th class="table-th text-white" width="50px"></th>
                                    </tr>
                                </thead>
                                <tbody>       
                                    @forelse ($data as $d)
                                    <tr>
                                        <td>
                                            <h6>{{ $d->id }}</h6>
                                        </td>
                                        <td>
                                            <h6>${{ number_format($d->total, 2) }}</h6>
                                        </td>
                                        <td>
                                            <h6>{{ $d->items }}</h6>
                                        </td>
                                        <td>
                                            <h6>{{ $d->status }}</h6>
                                        </td>
                                        <td>
                                            <h6>{{ $d->user }}</h6>
                                        </td>
                                        <td>
                                            <h6>{{ \Carbon\Carbon::parse($d->created_at)->format('d-m-Y') }}</h6>
                                        </td>
                                        <td>
                                            <h6>
                                                <button wire:click.prevent="getDetails({{$d->id}})" width="50px" class="btn btn-dark btn-sm">
                                                    <i class="fas fa-list"></i>
                                                </button>
                                            </h6>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7">
                                            <h5 class="text-center">Sin resultados.</h5>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.reports.sale-detail')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            window.livewire.on('show-modal' , msg =>{
                $('#modalDetails').modal('show');
            });

            window.livewire.on('report-error' , msg =>{
                noty(msg, 2);
            });

        });
    </script>
</div>
