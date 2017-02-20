/**
 * @file
 * Leaflet map settings.
 */

// Initializes map.
var mac_map = L.map('mac_map').setView([51.696273, 5.298893], 14);

// Sets mapbox tile.
L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/{id}/tiles/256/{z}/{x}/{y}?access_token={accessToken}', {
  attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
  maxZoom: 18,
  id: 'streets-v10',
  accessToken: 'pk.eyJ1IjoiYmF0aWdvbGl4IiwiYSI6ImhCVk1tREEifQ.WuSwjFHzhbzvlbuNIEOOTw'
}).addTo(mac_map);

// Adds a marker.
var marker = L.marker([51.696273, 5.298893]).addTo(mac_map);
