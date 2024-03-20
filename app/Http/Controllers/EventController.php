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
        'thumbnail_event' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Allowed image types and maximum file size in KB
    ]);

    $imageName = null;
    
            if ($request->hasFile('thumbnail_event')) {
                $file = $request->file('thumbnail_event');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/assets/events', $imageName);
                $file->move(public_path('assets/events'), $imageName);
            }

         Event::create([
            'title' => $request->title,
            'date' => $request->date,
            'location' => $request->location,
            'thumbnail_event' => $imageName
        ]);

        return redirect()->route('admin-index');
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

        $event->update(array_merge($request->all(), ['thumbnail_event' => $thumbnailFileName]));

        return redirect()->route('admin-index');
    }


    public function delete(Event $event)
    {
        $thumbnailPath = public_path('assets/events/' . $event->thumbnail_event);
        if (file_exists($thumbnailPath)) {
            unlink($thumbnailPath);
        }

        $event->delete();
        return redirect()->route('admin-index');
    }
}
