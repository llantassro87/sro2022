<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b> Caja </b>
                </h4>
            </div>

            <div class="widget-content">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <h6>Usuario:</h6>
                            <select wire:model='userid' class="form-control">
                                <option value="0" disabled>Elegir</option>
                                @foreach ($users as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <h6>Fecha de inicio:</h6>
                            <input type="date" wire:model.lazy='fromDate' class="form-control">
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <h6>Fecha de fin:</h6>
                            <input type="date" wire:model.lazy='toDate' class="form-control">
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3 align-self-center d-flex justify-content-around">
                        <div class="form-group" style="margin-top: 2rem;">
                            @if ($userid > 0 && $fromDate != null && $toDate != null)
                                <button wire:click.prevent="Consultar()" type="button" class="btn btn-dark">Consultar</button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-sm-12 col-md-4 mbmobile">
                        <div class="connect-sorting bg-dark">
                            <h5 class="text-white">Ventas totales: ${{ number_format($total, 2) }}</h5>
                            <h5 class="text-white">Productos: {{ $items }}</h5>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mt-1 text-center">
                                <thead class="text-white" style="background: #3b3f5c">
                                    <tr>
                                        <th class="table-th text-white">FOLIO</th>
                                        <th class="table-th text-white">TOTAL</th>
                                        <th class="table-th text-white">ITEMS</th>
                                        <th class="table-th text-white">FECHA</th>
                                        <th class="table-th text-white"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($total <= 0)
                                        <tr>
                                            <td colspan="5">
                                                <h6 class="text-center">No hay ventas entre las fechas</h6>
                                            </td>
                                        </tr>
                                    @endif

                                    @foreach ($sales as $row)
                                    <tr>
                                        <td>
                                            <h6>{{ $row->id }}</h6>
                                        </td>
                                        <td>
                                            <h6>${{ number_format($row->total, 2) }}</h6>
                                        </td>
                                        <td>
                                            <h6>{{ $row->items }}</h6>
                                        </td>
                                        <td>
                                            <h6>{{ $row->created_at }}</h6>
                                        </td>
                                        <td>
                                            <button wire:click.prevent="viewDetails({{$row}})" class="btn btn-dark btn-sm">
                                                <i class="fas fa-list"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.cashout.detail')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    
            window.livewire.on('show-modal' , msg =>{
                $('#modal-details').modal('show');
            });

        });
    </script>
</div>