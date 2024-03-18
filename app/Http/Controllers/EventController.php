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


        $request->validate([
        'title' => 'required|max:255',
        'date' => 'required|date',
        'location' => 'nullable',
        // 'thumbnail_event' => 'nullable'

    ]);
    if ($request->hasFile('thumbnail_event')) {
        $file = $request->file('thumbnail_event');
        $imageFileName = time() . '_' . $request->name . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/assets/events', $imageFileName);
        $file->move(public_path('assets/events'), $imageFileName);
        // Lakukan penyimpanan data event atau operasi lainnya di sini
    } else {
        // Handle jika file thumbnail tidak ditemukan dalam request
        // Misalnya, tampilkan pesan error atau kembalikan pengguna ke halaman sebelumnya
    }


    Event::create($request->all());
    return redirect()->route('index-news');
}

public function edit(Event $event)
{
    return view('events.edit-event', compact('event'));
}

public function update(Request $request, Event $event)
{
    $thumbnailFileName = null;
        if ($request->hasFile('thumbnail_event')) {

            if ($event->thumbnail_event) {
                $oldThumbnailPath = public_path('assets/events/' . $event->thumbnail_event);
                if (file_exists($oldThumbnailPath)) {
                    unlink($oldThumbnailPath);
                }
            }

            $thumbnailFile = $request->file('thumbnail_event');
            $thumbnailFileName = time() . '_' . $thumbnailFile->getClientOriginalName();
            $thumbnailFile->move(public_path('assets/events'), $thumbnailFileName);
        } else {
            $thumbnailFileName = $event->thumbnail_event;
        }
    $request->validate([
        'title' => 'required|max:255',
        'date' => 'required|date',
        'location' => 'nullable',
        // 'thumbnail_event' => 'nullable'
    ]);
    $event->update($request->all());
    return redirect()->route('index-news');
}

public function delete(Event $event)
{
    $event->delete();
    return redirect()->route('index-news');
}
}
