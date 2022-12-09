<script>
document.addEventListener('DOMContentLoaded', function() {
    $('.tblscroll').niceScroll({
        cursoscolor : "#515365",
        cursorwidth : "15px",
        background : "rgba(20, 20, 20, 0.3)",
        cursorborder : "0px",
        cursorborderradius : "3px"
    });

    $('#modalSearchProduct').on('shown.bs.modal', function() {
        $('#modal-search-product').focus();
    });
});

    function Confirm(id, eventName, text) {

        swal({
            title: 'CONFIRMAR',
            text: text,
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#FFF',
            confirmButtonColor: '#3b3f5c',
            confirmButtonText: 'Aceptar'
        })
        .then(function(result) {
            if (result.value) {
                window.livewire.emit(eventName, id);
                swal.close();
            }
        });

    }

</script>