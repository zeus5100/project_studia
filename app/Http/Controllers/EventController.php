<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use Inertia\Inertia;

class EventController extends Controller
{
    public function create()
    {
        return Inertia::render('Auth/Event');
    }

    public function store(EventRequest $request)
    {
        Event::create($request->validated());
    }
}
