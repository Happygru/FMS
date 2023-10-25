<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Model\Bookings;
use App\Model\VehicleModel;
use Exception;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Model\Hyvikk;
use App\Model\Settings;
class TrackerController extends Controller
{
    public function traccar_location($id = null)
    {
        $tarccar_username = Hyvikk::get('traccar_username');
        $tarccar_password = Hyvikk::get('traccar_password');
        $tarccar_server_link = Hyvikk::get('traccar_server_link');
        $tarccar_map_key = Hyvikk::get('traccar_map_key');
       if ($tarccar_username != null && $tarccar_password != null && $tarccar_server_link != null && $tarccar_map_key != null) {
        //getting traccar username and password server link
        $currentTime = now(); // Get the current time
        $vehicle_data = [];
        $select_vehicle = '';
        $message_traccar_fail = null;
        $single_vehicle = true;
        $message = null;
        $positions = [];
        $all_vehicles = VehicleModel::get();
        $active_vehicle = [];
        $active_vehicle_id = [];
        $credentials = base64_encode($tarccar_username . ':' . $tarccar_password);
        try {
            $client = new Client([
                'base_uri' => $tarccar_server_link . '/api/devices',
                'verify' => false,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic ' . $credentials
                ],
                'exceptions' => false,
            ]);
            $response_active_device = $client->get('');
        } catch (Exception $e) {
            //if error occur that retrun
            $data['error'] = $e->getMessage();
            return $data;
        }
        foreach (json_decode($response_active_device->getBody()->getContents()) as $response_active_device) {
            foreach ($all_vehicles as $a) {
                if ($response_active_device->status == 'active') {
                    if ($response_active_device->id == $a->traccar_device_id) {
                        $active_vehicle_id[] = $a->id;
                        $active_vehicle[] = $a;
                    }
                }
            }
        }
            if ($id != null) {
                $vehicles = VehicleModel::find($id);
                $select_vehicle = $vehicles->id;
                $vehicle_data = [];
                $base_uri = $tarccar_server_link . '/api/positions?deviceId=' . $vehicles->getMeta('traccar_device_id');
            } else {
                $vehicles = $active_vehicle;
                $base_uri = $tarccar_server_link . '/api/positions';
            }
            $client = new Client([
                'base_uri' => $base_uri,
                'verify' => false,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic ' . $credentials
                ]
            ]);
            try {
                $response = $client->get('', [
                ]);
            } catch (Exception $e) {
                $data['error'] = $e->getMessage();
                return $data;
            }
            $positions = json_decode($response->getBody()->getContents());
            if ($id != null) {
                foreach ($positions as $position) {
                    if ($position->deviceId == $vehicles->getMeta('traccar_device_id')) {
                        $bookings = Bookings::where('vehicle_id', $vehicles->id)
                            ->where('pickup', '<=', $currentTime)
                            ->where('dropoff', '>=', $currentTime)
                            ->latest()->first();
                        $vehicles['position'] = $position;
                        $vehicles['bookings'] = $bookings;
                        $vehicle_data[] = $vehicles;
                    }
                    $single_vehicle = false;
                }
            } else {
                foreach ($vehicles as $vehicle) {
                    foreach ($positions as $position) {
                        if ($position['deviceId'] == $vehicle->getMeta('traccar_device_id')) {
                            $vehicle['position'] = $position;
                            $bookings = Bookings::where('vehicle_id', $vehicle->id)
                                ->where('pickup', '<=', $currentTime)
                                ->where('dropoff', '>=', $currentTime)
                                ->latest()->first() ?? '';
                            $vehicle['bookings'] = $bookings;
                            $vehicle['bookings_name'] = $bookings->pickup ?? '';
                            $vehicle['bookings_driver'] = $bookings->driver->name ?? '';
                            $vehicle_data[] = $vehicle;
                        }
                    }
                }
            }
            return $data = [
                'vehicle_data' => $vehicle_data,
                'positions' => $positions,
                'active_vehicle' => $active_vehicle,
                'select_vehicle' => $select_vehicle,
                'message' => $message,
                'bookings' => $bookings ?? '',
            ];
        } else {
            $data['message_traccar_fail'] = 'Please Enter Traccar UserName,Password,Traccar Server Url And Google Map key In Traccar Settings To See Your Vehicles In Map!';
            return $data;
        }
    }
    public function traccar_settings(Request $request)
    {
        return view('utilities.traccar_settings');
    }
    public function traccar_settings_store(Request $request)
    {
        $traccar_enable = 0;
        if ($request->traccar_enable == 1) {
            $traccar_enable = 1;
        }
        Settings::where('name', 'traccar_server_link')->update(['value' => $request->traccar_server_link]);
        Settings::where('name', 'traccar_enable')->update(['value' => $traccar_enable]);
        Settings::where('name', 'traccar_username')->update(['value' => $request->traccar_username]);
        Settings::where('name', 'traccar_password')->update(['value' => $request->traccar_password]);
        Settings::where('name', 'traccar_map_key')->update(['value' => $request->traccar_map_key]);
        return redirect()->route('traccar.settings')->with('message','Traccar Settings Updated!');
    }
    public function vehicles_track($id = 2)
    {
        $data = $this->traccar_location($id);
        if (array_key_exists('error', $data)) {
            $response['error_exist'] = $data['error'];
        }
        else{
            if (array_key_exists('message_traccar_fail', $data)) {
                $response['message_traccar_fail'] = $data['message_traccar_fail'];
            }
            else{
                if(count($data['vehicle_data'])==0){
                    $response['message'] = 'Please Check Traccar Device Id Again For Vehicle No Location Found!';
                } else {
                    $response['vehicle_data'] = $data['vehicle_data'];
                    $response['active_vehicle'] = $data['active_vehicle'];
                    $response['message'] = null;
                }
            }
        }
        return view('tracker.map')->with($response);
    }
    public function track($id = null)
    {
        $data = $this->traccar_location($id);
        if (array_key_exists('error', $data)) {
            $response['error_exist'] = $data['error'];
        }
        else{
            if (array_key_exists('message_traccar_fail', $data)) {
                $response['message_traccar_fail'] = $data['message_traccar_fail'];
            }
            else{
                if(count($data['vehicle_data'])==0){
                    $response['message'] = 'Please Check Traccar Device Id Again For Vehicle No Location Found!';
                }
            }
        }
        return response()->json($data['vehicle_data']);
    }
}