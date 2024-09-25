<?php
// app/Http/Controllers/BookingController.php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Seat;
use App\Models\Booking;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $routes = Route::all();
        $locations = Location::all();
        return view('booking.index', compact('routes','locations'));
    }

    public function selectSeats(Request $request)
    {
        // return $request->input();
        $route = Route::find($request->route_id);
        $seats = Seat::where('route_id', $route->id)->where('is_booked', false)->get();
        return view('booking.select_seat', compact('route', 'seats'));
    }

    public function confirmBooking(Request $request)
    {
        $seat = Seat::with('route')->find($request->seat_id);

        if (!$seat) {
            return redirect()->back()->withErrors(['msg' => 'Seat not found.']);
        }

        $seat->is_booked = true;
        $seat->save();

        Booking::create([
            'seat_id' => $seat->id,
            'customer_name' => $request->customer_name,
        ]);

        session([
            'route_name' => "{$seat->route->start_location} to {$seat->route->end_location}",
            'seat_number' => $seat->seat_number,
            'customer_name' => $request->customer_name,
        ]);

        return redirect()->route('booking.success');
    }


    public function success()
    {
        return view('booking.success');
    }


    public function getLocation(Request $request)
    {
        if($request->ajax()){
            $from_location = $request->input('from');
            $locations = DB::table('locations')->where('name','!=', $from_location)->get();
            return json_encode($locations);
        };
    }
}

