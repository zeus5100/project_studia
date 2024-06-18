<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityRequest;
use App\Models\Activity;
use Inertia\Inertia;

class ActivityController extends Controller
{
    public function index()
    {
    }

    public function create()
    {
        return Inertia::render('Auth/Activity');
    }

    public function store(ActivityRequest $request)
    {
        Activity::create($request->validated());
    }
}
