<div class="connect-sorting mb-2">
    <div class="btn-group">
        <button class="btn btn-dark mr-3" data-toggle="modal" data-target="#modalSearchProduct">
            <i class="fas fa-search"></i>
            Buscar productos
        </button>
    </div>
</div>
<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
<div class="connect-sorting">
    <div class="connect-sorting-content">
        <div class="card simple-title-task ui-sortable-handle">
            <div class="card-body">
            @if ($total > 0)
                <div class="table-responsive" style="max-height: 610px; overflow: auto;">
                    <table class="table table-striped table-bordered text-center mt-1">
                        <thead class="text-white" style="background-color: #3b3f5c;">
                            <tr>
                                <th class="table-th text-white">DESCRIPCIÓN</th>
                                <th class="table-th text-white">PRECIO</th>
                                <th width="14%" class="table-th text-white">CANT</th>
                                <th class="table-th text-white">DESCT %</th>
                                <th class="table-th text-white">SUBTOTAL</th>
                                <th class="table-th text-white">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($cart as $item)
                            <tr>
                                <td>
                                    <h6>
                                        {{ $item->name}}
                                    </h6>
                                </td>
                                <td>
                                    <h6>
                                        ${{ number_format($item->price, 2) }}
                                    </h6>
                                </td>
                                <td>
                                    @if ($item->attributes[0] <= 0)
                                        <h6 class="text-danger"><b>Producto sin existencias, por favor elimine el producto del carrito para continuar con la venta.</b></h6>
                                    @else
                                        <input type="number" id="r{{ $item->id }}" 
                                        wire:change="updateQty({{ $item->id }}, parseInt($('#r' + {{ $item->id }}).val()), parseInt($('#d' + {{ $item->id }}).val()))"
                                        max="{{ $item->attributes[0] }}"
                                        style="font-size: 1rem!important;"
                                        class="form-control"
                                        value="{{ $item->quantity }}">
                                    @endif
                                </td>
                                <td>
                                    <input 
                                    id="d{{ $item->id }}" 
                                    wire:keyup="discount({{ $item->id }}, parseInt($('#d' + {{ $item->id }}).val()))" 
                                    type="number"
                                    min="0"
                                    max="99" 
                                    value="{{ $item->attributes[1] > 0 ? $item->attributes[1] : 0 }}"
                                    class="form-control">
                                </td>
                                <td>
                                    <h6>
                                        @if ($item->attributes[1] > 0)
                                            @php
                                            $disc = ((100 - $item->attributes[1]) * $item->price) / 100;
                                            $sumDisc = $disc * $item->quantity
                                            @endphp
                                            ${{ number_format($disc * $item->quantity,2) }}     
                                        @else
                                            @php
                                                $sumDisc = $item->price * $item->quantity
                                            @endphp
                                            ${{ number_format($item->price * $item->quantity, 2) }}
                                        @endif
                                        @php
                                            $discTotal = $discTotal += $sumDisc
                                        @endphp
                                    </h6>
                                </td>
                                <td>
                                    <button wire:click.prevent="decreaseQty({{ $item->id }}, parseInt($('#d' + {{ $item->id }}).val()))" class="btn-dark btn-sm mbmobile">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button wire:click.prevent="increaseQty({{ $item->id }})" class="btn-dark btn-sm mbmobile">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <button onclick="Confirm('{{ $item->id }}', 'removeItem', '¿Desea eliminar el registro?')" class="btn-sm btn-danger mbmobile">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        @php
                            $this->discTotal -= $discTotal;
                        @endphp
                    </table>
                </div>
            @else
                <h5 class="text-center text-muted">Agregar productos a la venta.</h5>
            @endif
            <div wire:loading.inline wire:target="saveSale">
                <h4 class="text-danger text-center">Guardando venta...</h4>
            </div>
            </div>
        </div>
    </div>
</div>