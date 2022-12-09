<div class="layout-px-spacing">
    <div class="page-header">
        <div class="page-title">
            <h3>Panel</h3>
        </div>
    </div>
    @if (count($stockProducts) > 0)
    <div class="row layout-top-spacing analytics">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-activity-three">

                <div class="widget-heading">
                    <h5 class="">Notificaciones</h5>
                </div>

                <div class="widget-content" style="max-height: 200px; overflow: auto;">

                    <div class="mt-container mx-auto">
                        <div class="timeline-line">
                            
                            @forelse ($stockProducts as $stockProduct)
                            <div class="item-timeline timeline-new">
                                <div class="t-dot" data-original-title="" title="">
                                    <div class="t-{{ $stockProduct->stock == 0 ? 'danger' : 'warning' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    </div>
                                </div>
                                <div class="t-content">
                                    <div class="t-uppercontent">
                                        <h5>{{ $stockProduct->name }}</h5>
                                    </div>
                                    @if ($stockProduct->stock == 0)
                                        <p style="color: gray;">Sin existencias | <strong>total: {{ $stockProduct->stock }}</strong></p>
                                        <div class="tags">
                                            <div class="badge badge-danger">Sin existencias</div>
                                        </div>
                                    @else
                                        <p style="color: gray;">Se cuenta con pocas existencias | <strong>total: {{ $stockProduct->stock }}</strong></p>
                                        <div class="tags">
                                            <div class="badge badge-warning">Pocas existencias</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @empty
                                <div>
                                    <p>Sin notificaciones.</p>
                                </div>
                            @endforelse                                   
                        </div>                                    
                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 325px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 197px;"></div></div></div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="row layout-top-spacing">

        <div class="col-xl-1">
        </div>

        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-chart-two">
                <div class="widget-heading">
                    <h5 class="">Ventas por categorías</h5>
                </div>
                <div class="widget-content">
                    @if (empty($names) || empty($sales))
                        <div class="text-center">
                            <h6 style="color: gray;">No hay ventas para generar la gráfica.</h6>
                        </div>
                    @else
                        <div id="chart-2" class=""></div>
                    @endif
                </div>
            </div>
        </div>

        <script>
            var names = @json($names);
            var sales = @json($sales);
            var salesInt = sales.map(Number);
            var options = {
                    chart: {
                        type: 'donut',
                        width: 380
                    },
                    colors: ['#1b55e2', '#009688', '#e7515a', '#e2a03f'],
                    dataLabels: {
                    enabled: false
                    },
                    legend: {
                        position: 'bottom',
                        horizontalAlign: 'center',
                        fontSize: '14px',
                        markers: {
                        width: 10,
                        height: 10,
                        },
                        itemMargin: {
                        horizontal: 0,
                        vertical: 8
                        }
                    },
                    plotOptions: {
                    pie: {
                        donut: {
                        size: '65%',
                        background: 'transparent',
                        labels: {
                            show: true,
                            name: {
                            show: true,
                            fontSize: '29px',
                            fontFamily: 'Nunito, sans-serif',
                            color: undefined,
                            offsetY: -10
                            },
                            value: {
                            show: true,
                            fontSize: '26px',
                            fontFamily: 'Nunito, sans-serif',
                            color: '20',
                            offsetY: 16,
                            formatter: function (val) {
                                return val
                            }
                            },
                            total: {
                            show: true,
                            showAlways: true,
                            label: 'Total',
                            color: '#888ea8',
                            formatter: function (w) {
                                return w.globals.seriesTotals.reduce( function(a, b) {
                                return a + b
                                }, 0)
                            }
                            }
                        }
                        }
                    }
                    },
                    stroke: {
                    show: true,
                    width: 25,
                    },
                    
                    series: salesInt,
                    labels: names,
                    responsive: [{
                        breakpoint: 1599,
                        options: {
                            chart: {
                                width: '350px',
                                height: '400px'
                            },
                            legend: {
                                position: 'bottom'
                            }
                        },

                        breakpoint: 1439,
                        options: {
                            chart: {
                                width: '250px',
                                height: '390px'
                            },
                            legend: {
                                position: 'bottom'
                            },
                            plotOptions: {
                            pie: {
                                donut: {
                                size: '65%',
                                }
                            }
                            }
                        },
                    }]
                }
        </script>

        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-table-three">

                <div class="widget-heading">
                    <h5 class="">Top 10 productos más vendidos</h5>
                </div>

                <div class="widget-content" style="max-height: 385px; overflow: auto;">
                    <div class="mt-container mx-auto" style="overflow: auto;">
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th><div class="th-content">Producto</div></th>
                                    <th><div class="th-content th-heading">Precio</div></th>
                                    <th><div class="th-content th-heading">Descuento</div></th>
                                    <th><div class="th-content">Vendidos</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($topProducts as $product)
                                    <tr>
                                        <td>
                                            <div class="td-content product-name">
                                            {{ $product->name }}
                                        </div>
                                        </td>
                                        <td>
                                            <div class="td-content">
                                                <span class="pricing">${{ number_format($product->price, 2) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="td-content">
                                                <span class="discount-pricing">{{ $product->discount }}%</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="td-content">{{ $product->sold }}</div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">No hay ventas para generar la gráfica.</td>
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
</div>