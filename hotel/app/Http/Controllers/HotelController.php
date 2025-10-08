<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.hotels.browse', [
            'hotels' => Hotel::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.hotels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $hotelCreated = DB::table('hotels')->insert($request->all('hotel_name', 'hotel_address'));
        if ($hotelCreated) {
            return redirect('admin/hotels');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $hotel = DB::table('hotels')->find($id);
        // dump($hotel);
        return view('admin.hotels.hotel', compact('hotel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $hotel = DB::table('hotels')->find($id);
        return view('admin.hotels.edit', compact('hotel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $hotelUpdated = DB::table('hotels')->where('id', $id)->update($request->all('hotel_name', 'hotel_address'));
        if ($hotelUpdated) {
            return redirect('admin/hotels');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $hotelDestroyed = DB::table('hotels')->delete($id);
        if ($hotelDestroyed) {
            return redirect('admin/hotels');
        }
    }
}