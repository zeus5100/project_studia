<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\Room;
use Inertia\Inertia;

class EventController extends Controller
{
    public function index()
    {
        return response()->json(Event::select('id', 'name', 'date', 'description', 'room_id')
            ->paginate(10));
    }

    public function create()
    {
        return Inertia::render('Auth/Event/Event', [
            'rooms' => Room::all(),
        ]);
    }

    public function store(EventRequest $request)
    {
        Event::create($request->validated());
    }

    public function edit(Event $event)
    {
        return Inertia::render('Auth/Event/Edit', [
            'event' => $event,
            'rooms' => Room::all(),
        ]);
    }

    public function update(EventRequest $request, Event $event)
    {
        $event->update($request->validated());

        return redirect()->route('admin.manage', ['table' => 'events'])
            ->with('notification', 'wydarzenie');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json([
            'message' => 'Wydarzenie zostało pomyślnie usunięte',
        ]);
    }
}
