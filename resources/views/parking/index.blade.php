@extends('layouts.app')
@section('content')
    <style>
        /* Add your custom CSS styles here */
        .parking-spot {
            width: 50px;
            height: 50px;
            justify-content: center;
            background-color: #ccc;
            border: 1px solid #888;
            display: inline-block;
            margin: 100px;
            text-align: center;
            line-height: 50px;
            cursor: pointer;
        }
        .occupied {
            background-color: #ff6347; /* Tomato */
        }
        .available {
            background-color: #90ee90; /* Lightgreen */
        }
        #summary {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Parking Area</h1>
    <div id="parking-area">
        <!-- This is where the parking spots will be dynamically added -->
    </div>
    <div id="summary">
        Available Spots: <span id="available-count">0</span> / Total Spots: <span id="total-count">0</span>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
     $(document).ready(function() {
    var totalSpots = 20; // Total parking spots
    var spots = [];

    // Initialize parking spots
    for (var i = 1; i <= totalSpots; i++) {
        spots.push({
            id: i,
            available: true,
            vehicleName: '' // Initially empty
        });
        $('#parking-area').append('<div class="parking-spot" id="spot-' + i + '">Spot ' + i + '</div>');
    }

    // Handle click event on parking spots
    $('.parking-spot').click(function() {
        var spotId = $(this).attr('id').replace('spot-', '');
        spots[spotId - 1].available = !spots[spotId - 1].available;

        // Example: Prompt user for vehicle name
        var vehicleName = prompt('Enter vehicle name:');
        spots[spotId - 1].vehicleName = vehicleName || ''; // Set vehicle name or empty string if canceled
        $(this).toggleClass('available').text(vehicleName || 'Spot ' + spotId); // Update spot text

        updateSummary();
    });

    // Update summary of available spots
    function updateSummary() {
        var availableCount = spots.filter(function(spot) {
            return spot.available;
        }).length;
        $('#available-count').text(availableCount);
        $('#total-count').text(totalSpots);
    }

    // Initial summary update
    updateSummary();
});

    </script>
    @endsection

</body>
</html>
