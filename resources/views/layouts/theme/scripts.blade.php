<script src="{{ asset('assets/js/libs/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>

<script>
    $(document).ready(function() {
        App.init();
    });
</script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/notification/snackbar/snackbar.min.js') }}"></script>.
<script src="{{ asset('plugins/nicescroll/nicescroll.js') }}"></script>
<script>
    function noty(msg, option = 1) {

        Snackbar.show({
            text: msg.toUpperCase(),
            actionText: 'CERRAR',
            actionTextColor: '#FFF',
            backgroundColor: option == 1 ? '#3b3f5c' : '#e7515a',
            pos: 'top-right'
        });

    }
</script>

@if (request()->is('dashboard'))
<script src="{{ asset('plugins/apex/apexcharts.min.js') }}"></script>
<script>
    var chart = new ApexCharts(
        document.querySelector("#chart-2"),
        options
    );

    chart.render();
</script>    
@endif

@livewireScripts