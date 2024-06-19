<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Models\Room;
use Inertia\Inertia;

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

    public function edit(Room $room)
    {
        return Inertia::render('Auth/Room/Edit', [
            'room' => $room,
        ]);
    }

    public function update(RoomRequest $request, Room $room)
    {
        $room->update($request->validated());

        return redirect()->route('admin.manage', ['table' => 'rooms'])
            ->with('notification', 'salę');
    }

    public function destroy(RoomRequest $room)
    {
        $room->delete();

        return response()->json([
            'message' => 'Sala została pomyślnie usunięta',
        ]);
    }
}
