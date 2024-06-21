<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Barcode Scanner</title>
        <style>
            body, html {
                margin: 0;
                padding: 0;
                height: 100%;
            }
            #video-container {
                width: 100px;
                height: 100px;
                position: relative;
            }
            #video {
                width: 50%;
                height: 50%;
                object-fit: cover;
            }
        </style>
    </head>
    <body>
        <button type="button" class="btn btn-success" onclick="scanjob()">Start Scan</button>
        <button type="button" class="btn btn-warning" onclick="stopscan()">Stop Scan</button>
        <div id="video-container"></div>
        <div id="result"></div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="../assets/quagga.min.js" type="text/javascript"></script>

        <script>
            function scanjob() {
                // Initialize QuaggaJS
                Quagga.init({  //configuration
                    inputStream: {
                        name: "Live",
                        type: "LiveStream",
                        target: document.getElementById('video-container')
                    },
                    decoder: { 
                        readers: ["ean_reader"] // Specify the barcode reader type (ean_type)
                    }
                }, function (err) {
                    if (err) {
                        console.error('Error starting Quagga:', err);
                        return;
                    }
                    console.log('Quagga started successfully.');
                    Quagga.start();
                });

                // Add a listener for when a barcode is detected
                Quagga.onDetected(function (result) {
                    console.log('Barcode result:', result.codeResult.code);
                    // Handle the detected barcode
                    alert('Detected barcode: ' + result.codeResult.code);
                    //searchOrder(result.codeResult.code);

                });
            }
            function stopscan() {
                const video = document.querySelector('video');
                const mediaStream = video.srcObject;
                const tracks = mediaStream.getTracks();
                tracks[0].stop();
                tracks.forEach(track => track.stop())
            }

            
                function searchOrder(barcode) { 
                    var str="barcode="+barcode+"&";
                    $.ajax({
                        url: 'search_order.php', // Path to PHP file that checks for new orders
                        type: 'POST',
                        data:str,
                        success: function (response) {

                           $("#result").html(response); //search barcode output

                        },
                        error: function (xhr, status, error) {
                            console.error('Error:', status, error);
                        }
                    });
                }
            
        </script>
    </body>
</html>
