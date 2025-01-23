<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Interaktif Bandara Indonesia</title>

    <link href='https://fonts.googleapis.com/css?family=BioRhyme' rel='stylesheet'>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>

     <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>

     <style>
        body{
            margin-top; 0;
            margin-left: 10px;
            margin-right: 10px;
            padding: 0; 
        }
        #map { 
            height: 700px;
            border-radius: 10px;
        }
        .judul{
            text-align: center;
        }
        .judul,h2{
            font-family: 'BioRhyme';
        }

     </style>
</head>
<body>
    <div class="judul">
        <h2>Peta Interaktif Bandara di Indonesia</h1>
    </div>
    <div id="map"></div>

    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([-1.7768217,106.7847111], 5.91); // Pusat peta di Indonesia

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var airplaneIcon = L.icon({
            iconUrl: '{{ asset('icons/pesawat.png') }}', // URL ikon pesawat
            iconSize: [24, 48], // Ukuran ikon (width, height)
            iconAnchor: [12, 36], // Posisi anchor (tengah-tengah ikon)
            popupAnchor: [0, -16] // Posisi popup di atas ikon
        });

        fetch('{{ asset('data/indo-airports.json') }}')
        .then(response => response.json())
        .then(data => {
            // Iterasi melalui data JSON untuk menampilkan marker di peta
            data.forEach(function(airport) {
                // Tambahkan marker untuk setiap bandara berdasarkan koordinat
                var marker = L.marker([airport.latitude, airport.longitude],{icon: airplaneIcon}).addTo(map);
                
                // Tambahkan popup dengan informasi bandara
                marker.bindPopup('<b>' + airport.name + '</b></br></br>IATA :'+ airport.iata +'</br>ICAO :'+ airport.icao + '<br>Kota :' + airport.city + '</br>Provinsi :' + airport.province + '</br>Negara :' + airport.country);
            });
        })
        .catch(error => console.error('Error:', error));
    </script>
</body>
</html>