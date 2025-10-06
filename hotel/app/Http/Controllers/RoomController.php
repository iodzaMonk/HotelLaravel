<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.rooms.browse', [
            'rooms' => Room::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $roomCreated = Room::create($request->all('room_number', 'room_type', 'price_per_night', 'hotel_id'));
        if ($roomCreated) {
            return redirect('admin/rooms');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $room = DB::table('rooms')->find($id);
        return view('admin.rooms.', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $hotel = DB::table('rooms')->find($id);
        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $roomUpdated = DB::table('rooms')->where('id', $id)->update($request->all('room_number', 'room_type', 'price_per_night', 'hotel_id'));
        if ($roomUpdated) {
            return redirect('admin/rooms');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $roomDestroyed = DB::table('rooms')->where('id', $id)->delete($id);
        if ($roomDestroyed) {
            return redirect('admin/rooms');
        }
    }
}