<script>

    var listener = new window.keypress.Listener();

    listener.simple_combo("f9", function() {
        livewire.emit('saveSale');
    });

    listener.simple_combo("f8", function() {
        document.getElementById('cash').value = '';
        document.getElementById('hiddenTotal').value = '';
        document.getElementById('cash').focus();
    });

    listener.simple_combo("f4", function() {

        var total = parseFloat(document.getElementById('hiddenTotal').value);
        
        if (total > 0) {
            Confirm(0, 'clearCart', '¿Desea eliminar los productos del carrito?');
        } else {
            noty('Agrega productos a la venta', 2);
        }
    });

</script>