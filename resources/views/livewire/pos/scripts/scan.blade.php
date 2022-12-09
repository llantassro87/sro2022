<script>

    try {

        onScan.attachTo(document, {
            suffixKeyCodes: [13],
            reactToPaste: true,
            onScan: function(barcode) {
                window.livewire.emit('scan-code', barcode);
            },
            onScanError: function(e){
                console.log(e);
            }
        });

        console.log('Scaner listo.');
        
    } catch (e) {
        console.log('Error en la lectura. ', e);
    }
</script>