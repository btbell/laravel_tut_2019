<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShowRoomsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $roomType = null)
    {
        //return response('A listing of rooms', 200);
        //$rooms = DB::table('rooms')->get(); query without using a model
        //programmatic way to get room by id
        //$rooms = Room::get();
        //if ($request->query('id') !==null) {
            //$rooms = $rooms->where('room_type_id', $request->query('id'));

        //return response()->json($rooms);
        $rooms = Room::byType($roomType)->get();
        return view('rooms.index', ['rooms' => $rooms]);
    }
}
