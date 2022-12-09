<div wire:ignore.self class="modal fade" id="modal-details" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Detalle de venta # {{ $saleId }}</b>
                </h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1 text-center">
                        <thead class="text-white" style="background: #3b3f5c">
                            <tr>
                                <th class="table-th text-white">PRODUCTO</th>
                                <th class="table-th text-white">CANTIDAD</th>
                                <th class="table-th text-white">PRECIO</th>
                                <th class="table-th text-white">DESCUENTO (%)</th>
                                <th class="table-th text-white">IMPORTE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $d)
                            <tr>
                                <td>
                                    <h6>{{ $d->product }}</h6>
                                </td>
                                <td>
                                    <h6>{{ $d->quantity }}</h6>
                                </td>
                                <td>
                                    <h6>${{ number_format($d->price, 2) }}</h6>
                                </td>
                                <td>
                                    <h6>
                                        @if ($d->discount > 0)
                                            ${{ number_format((100 - $d->discount) * $d->price / 100, 2) }}
                                            ({{ round($d->discount) }}%)
                                        @else
                                            {{ round($d->discount) }}%
                                        @endif
                                    </h6>
                                </td>
                                <td>
                                    <h6>
                                        @if ($d->discount > 0)
                                            @php
                                            $disc = ((100 - $d->discount) * $d->price) / 100;
                                            @endphp
                                            ${{ number_format($disc * $d->quantity, 2) }}     
                                        @else
                                            ${{ number_format($d->price * $d->quantity, 2) }}
                                        @endif
                                    </h6>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <td class="text-right">
                                <h6 class="text-info">TOTALES:</h6>
                            </td>
                            <td>
                                @if ($details)
                                    <h6 class="text-info">{{ $details->sum('quantity') }}</h6>
                                @endif
                            </td>
                            @if ($details)
                                <td></td>
                                <td></td>
                                <td>
                                    <h6 class="text-info">${{ number_format($sumDetails ,2) }}</h6>
                                </td>
                            @endif
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-dark btn-close text-info" data-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>
</div>