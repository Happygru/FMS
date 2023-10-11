
  $('.select').select2();
  var map;
  var markers = [];
  var lines=[];
  var lineOptions;
  var path;
  var carIcon;
  $('#vehicle_id').on('change',function(){
    var vehicle_id=$('#vehicle_id').val();
    console.log(vehicle_id);
    if(vehicle_id != null){
    location.href="{{url('admin/vehicles-track')}}/"+vehicle_id;
    }else{
      location.href="{{url('admin/vehicles-track')}}";
    }
  });
// Initialize the map and markers
        function initialize() {
                              // car icon call only one time
                                var carIcon = {
                                    url: '{{asset("assets/image/small-car.png")}}',
                                    scaledSize: new google.maps.Size(50, 50),
                                };
                                var dotIcon = {
                                    path: google.maps.SymbolPath.CIRCLE,
                                    fillOpacity: 1,
                                    fillColor: "#ffffff",
                                    strokeOpacity: 1,
                                    strokeColor: "#ff0000",
                                    strokeWeight: 1,
                                    scale: 4,
                                };
                                    //intial map
                                    // Set the initial center of the map
                                    var myLatlng = new google.maps.LatLng(20.593683,78.962883); // San Francisco
                                    // Map options
                                    var mapOptions = {
                                        zoom: 9,
                                        center: myLatlng
                                    };
                                 map = new google.maps.Map(document.getElementById("map"), mapOptions);
                                 @if($vehicle_data != null)
                                    @foreach($vehicle_data as $v)
                                    
                                          var myLatlng{{$v->id}} = new google.maps.LatLng({{$v->position['latitude']}},{{$v->position['longitude']}});
                                                        var marker = new google.maps.Marker({
                                                            position: myLatlng{{$v->id}},
                                                            map: map,
                                                            icon: carIcon,
                                                            title: '{{$v->model_name}}'
                                                        });
                                          $('table thead').after("<tbody><tr><td>{{$v->model_name}}</td><td>{{$v->position['speed']}}</td><td>{{$v->bookings->pickup ?? '-'}}</td><td>{{$v->bookings->driver->name ?? '-'}}</td></tr></tbody></table>");
                                          markers[{{$v->id}}] = marker;
                                          console.log(markers[{{$v->id}}]);
                                   
                                    @endforeach
                                    @endif
          }
                          // Update the marker position for the given vehicle
                                function updateMarker(vehicleId, lat, lng,speed,model_name,bookings_name,bookings_driver) {
                                    var marker = markers[vehicleId];
                                    if (marker) {
                                    
                        
                                        $('table thead').after("<tbody><tr><td>"+model_name+"</td><td>"+speed+"</td><td>"+bookings_name+"</td><td>"+bookings_driver+"</td></tr></tbody>");
                                        var myLatlng = new google.maps.LatLng(lat, lng);
                                        marker.setPosition(myLatlng);
                                    }
                                }
                          // Poll the server for all vehicles' locations every 10 seconds
                          function pollServer() {
                              setInterval(function() {
                                var vehicle_id= $('#vehicle_id').val();
                                vehicle_id!=null ? url='{{url("admin/track/")}}/'+vehicle_id : url='{{url("admin/track")}}';
                                  // Make an AJAX request to the server to get the current locations of all vehicles
                                  $.ajax({  
                                      url:url ,
                                      headers: {
                                          'Accept': 'application/json',
                                          'Content-Type': 'application/json',
                                          'Authorization': 'Basic ' + "{{base64_encode('vijaytorani@hyvikk.com:vijay')}}"
                                      },
                                      type: "GET",
                                      dataType: "json",
                                      success: function(response) {
                                        console.log(response);
                                          // Update the marker positions for all vehicles
                                          $('tbody').text('');
                                        response.forEach(function(element){
                                          console.log(element);
                                          updateMarker(element.id, element.position.latitude, element.position.longitude,element.position.speed,element.model_name,element.bookings_name,element.bookings_driver);
                                        })
                                      },
                                      error: function(xhr, status, error) {
                                          console.log("Error: " + error);
                                      }
                                  });
                              }, 10000); // 10 seconds
                          }

// Initialize the map and start polling the server
                          $(document).ready(function() {
                              initialize();
                              @if($message_traccar_fail==null)
                              pollServer();
                              @endif
                          });
