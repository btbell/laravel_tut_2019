<?php

namespace App\Http\Controllers;

use App\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$bookings = DB::table('bookings')->get();
        $bookings = Booking::paginate(6);
        return view('bookings.index')
            ->with('bookings', $bookings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = DB::table('users')->get()->pluck('name', 'id')->prepend('none');
        $rooms = DB::table('rooms')->get()->pluck('number', 'id');
        return view('bookings.create')
            ->with('users', $users)
            ->with('booking', (new Booking() ))
            ->with('rooms', $rooms);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // programatic approach to saving to database
        //$id = DB::table('bookings')->insertGetId([
        //    'room_id' => $request->input('room_id'),
        //    'start' => $request->input('start'),
        //    'end' => $request->input('end'),
        //    'is_reservation' => $request->input('is_reservation', false),
        //    'is_paid' => $request->input('is_paid', false),
        //    'notes' => $request->input('notes'),
        $booking = Booking::create($request->input());
        DB::table('bookings_users')->insert([
            //'booking_id' => $id,
            'booking_id' => $booking->id,
            'user_id' => $request->input('user_id'),
        ]);
        return redirect()->action('BookingController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        return view('bookings.show', ['booking' => $booking]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        $users = DB::table('users')->get()->pluck('name', 'id')->prepend('none');
        $rooms = DB::table('rooms')->get()->pluck('number', 'id');
        $bookingsUser = DB::table('bookings_users')->where('booking_id', $booking->id)->first();
        return view('bookings.edit')
            ->with('bookingsUser', $bookingsUser)
            ->with('users', $users)
            ->with('rooms', $rooms)
            ->with('booking', $booking);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        $booking->fill($request->input());
        $booking->save();
        //DB::table('bookings')
        //->where('id', $booking->id)
        //->update([
        //    'room_id' => $request->input('room_id'),
        //    'start' => $request->input('start'),
        //    'end' => $request->input('end'),
        //    'is_reservation' => $request->input('is_reservation', false),
        //    'is_paid' => $request->input('is_paid', false),
        //    'notes' => $request->input('notes'),
        //]);
        DB::table('bookings_users')
        ->where('booking_id', $booking->id)
        ->update([
            'user_id' => $request->input('user_id'),
        ]);
        return redirect()->action('BookingController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        DB::table('bookings_users')->where('booking_id', $booking->id)->delete();

        //DB::table('bookings')->where('id', $booking->id)->delete();
        $booking->delete();
        return redirect()->action('BookingController@index');
    }
}