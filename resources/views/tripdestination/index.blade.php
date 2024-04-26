<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY_HERE&callback=initMap" defer></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY_HERE&callback=initMap" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</head>
<body>
    <div class="container mt-n10">





      
                            <div class="col-lg-7">
                                <div class="map-container">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.974524277812!2d125.00002971460278!3d7.830166206334908!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a19ef2f6bccecb%3A0x6314d748b7b1971f!2sV362%2B285%2C%20Maramag%2C%20Bukidnon!5e0!3m2!1sen!2sph!4v1649703720009!5m2!1sen!2sph" frameborder="0" style="border:0; width: 100%; height: 290px;" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <form id="mapForm">
        <input type="text" id="startPoint" name="startPoint" placeholder="Starting Point">
        <input type="text" id="endPoint" name="endPoint" placeholder="End Point">
        <button type="submit">Submit</button>
    </form>
    <div id="map"></div>

    <script>
        var map, startPointMarker;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 37.7749, lng: -122.4194}, // Default center (San Francisco)
                zoom: 12
            });

            // Listen for click event on map
            google.maps.event.addListener(map, 'click', function(event) {
                placeMarker(event.latLng);
            });

            function placeMarker(location) {
                if (startPointMarker) {
                    startPointMarker.setPosition(location);
                } else {
                    startPointMarker = new google.maps.Marker({
                        position: location,
                        map: map,
                        draggable: true
                    });

                    google.maps.event.addListener(startPointMarker, 'dragend', function(event) {
                        updateStartPoint(event.latLng);
                    });
                }

                updateStartPoint(location);
            }

            function updateStartPoint(location) {
                $('#startPoint').val(location.lat() + ',' + location.lng());
            }
        }

        $(document).ready(function(){
            $('#mapForm').submit(function(e){
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: '/admin/tripdestination',
                    method: 'POST',
                    data: formData,
                    success: function(response){
                        // Process the response and display the map with navigation
                    }
                });
            });
        });
    </script>
</body>
</html>
