<?php

namespace App\Http\Controllers;

use App\Models\Room;

class RoomController extends Controller
{
    public function index()
    {
        return response()->json(Room::select('id', 'room_number', 'capacity', 'description')->paginate(10));
    }

    public function select()
    {
        return response()->json(Room::select('id', 'room_number', 'capacity', 'description')
            ->get());
    }
}
