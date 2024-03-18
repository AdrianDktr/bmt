<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function create()
{
    return view('events.create-event');
}

public function store(Request $request)
{
    Event::create($request->all());
    return redirect()->route('index-news');
}

public function edit(Event $event)
{
    return view('events.edit-event', compact('event'));
}

public function update(Request $request, Event $event)
{
    $event->update($request->all());
    return redirect()->route('index-news');
}

public function destroy(Event $event)
{
    $event->delete();
    return redirect()->route('index-news');
}
}
