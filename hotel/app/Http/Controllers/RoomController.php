<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Carbon;
use Inertia\Inertia;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::with('hotel')
            ->orderByDesc('created_at')
            ->get()
            ->map(fn (Room $room) => [
                'id' => $room->id,
                'roomNumber' => $room->room_number,
                'roomType' => $room->room_type,
                'pricePerNight' => $room->price_per_night,
                'hotelId' => $room->hotel_id,
                'hotelName' => $room->hotel?->hotel_name,
            ])
            ->values();

        return Inertia::render('Admin/Rooms/Index', [
            'rooms' => $rooms,
            'copy' => [
                'headTitle' => __('admin.rooms.index.head_title'),
                'backLabel' => __('admin.rooms.index.back'),
                'createLabel' => __('admin.rooms.index.create'),
                'viewLabel' => __('admin.rooms.index.view'),
                'emptyText' => __('admin.rooms.index.empty'),
                'priceSuffix' => __('admin.common.price_suffix'),
                'hotelLabel' => __('admin.common.hotel_label'),
                'roomNumberPrefix' => __('admin.common.room_number_prefix'),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hotels = Hotel::orderBy('hotel_name')
            ->get()
            ->map(fn (Hotel $hotel) => [
                'id' => $hotel->id,
                'name' => $hotel->hotel_name,
            ])
            ->values();

        return Inertia::render('Admin/Rooms/Create', [
            'hotels' => $hotels,
            'copy' => [
                'headTitle' => __('admin.rooms.create.head_title'),
                'heading' => __('admin.rooms.create.heading'),
                'description' => __('admin.rooms.create.description'),
                'backLabel' => __('admin.rooms.create.back'),
                'cancelLabel' => __('admin.rooms.create.cancel'),
                'submitLabel' => __('admin.rooms.create.submit'),
                'typeLabel' => __('admin.rooms.create.type_label'),
                'typePlaceholder' => __('admin.rooms.create.type_placeholder'),
                'priceLabel' => __('admin.rooms.create.price_label'),
                'pricePlaceholder' => __('admin.rooms.create.price_placeholder'),
                'numberLabel' => __('admin.rooms.create.number_label'),
                'numberPlaceholder' => __('admin.rooms.create.number_placeholder'),
                'hotelLabel' => __('admin.rooms.create.hotel_label'),
                'noHotelsNotice' => __('admin.rooms.create.no_hotels_notice'),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_type' => ['required', 'string', 'max:255'],
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'room_number' => ['required', 'string', 'max:255'],
            'hotel_id' => ['required', 'exists:hotels,id'],
        ]);

        Room::create($validated);

        return redirect()
            ->route('admin.rooms.index')
            ->with('status', __('admin.rooms.flash.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $room = Room::with('hotel')->findOrFail($id);

        return Inertia::render('Admin/Rooms/Show', [
            'room' => [
                'id' => $room->id,
                'roomNumber' => $room->room_number,
                'roomType' => $room->room_type,
                'pricePerNight' => $room->price_per_night,
                'hotelId' => $room->hotel_id,
                'hotelName' => $room->hotel?->hotel_name,
                'createdAt' => $this->formatDate($room->created_at),
                'updatedAt' => $this->formatDate($room->updated_at),
            ],
            'canEdit' => Route::has('admin.rooms.edit'),
            'canDelete' => Route::has('admin.rooms.destroy'),
            'copy' => [
                'headTitle' => __('admin.rooms.show.head_title', ['number' => $room->room_number]),
                'backLabel' => __('admin.rooms.show.back'),
                'idLabel' => __('admin.rooms.show.id_label'),
                'profileLabel' => __('admin.rooms.show.profile_label'),
                'priceLabel' => __('admin.rooms.show.price'),
                'hotelLabel' => __('admin.rooms.show.hotel'),
                'createdLabel' => __('admin.rooms.show.created'),
                'updatedLabel' => __('admin.rooms.show.updated'),
                'actionsTitle' => __('admin.rooms.show.actions_title'),
                'actionsDescription' => __('admin.rooms.show.actions_description'),
                'editLabel' => __('admin.rooms.show.edit'),
                'deleteLabel' => __('admin.rooms.show.delete'),
                'deleteUnavailable' => __('admin.common.delete_unavailable'),
                'editUnavailable' => __('admin.common.edit_unavailable'),
                'roomNumberPrefix' => __('admin.common.room_number_prefix'),
                'confirmDelete' => __('admin.common.confirm_delete', [
                    'name' => str_replace(
                        ':number',
                        $room->room_number,
                        __('admin.common.room_number_prefix')
                    ),
                ]),
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $room = Room::findOrFail($id);

        $hotels = Hotel::orderBy('hotel_name')
            ->get()
            ->map(fn (Hotel $hotel) => [
                'id' => $hotel->id,
                'name' => $hotel->hotel_name,
            ])
            ->values();

        return Inertia::render('Admin/Rooms/Edit', [
            'room' => [
                'id' => $room->id,
                'roomNumber' => $room->room_number,
                'roomType' => $room->room_type,
                'pricePerNight' => $room->price_per_night,
                'hotelId' => $room->hotel_id,
            ],
            'hotels' => $hotels,
            'copy' => [
                'headTitle' => __('admin.rooms.edit.head_title', ['number' => $room->room_number]),
                'heading' => __('admin.rooms.edit.heading'),
                'description' => __('admin.rooms.edit.description'),
                'backLabel' => __('admin.rooms.edit.back'),
                'cancelLabel' => __('admin.rooms.edit.cancel'),
                'submitLabel' => __('admin.rooms.edit.submit'),
                'typeLabel' => __('admin.rooms.edit.type_label'),
                'priceLabel' => __('admin.rooms.edit.price_label'),
                'numberLabel' => __('admin.rooms.edit.number_label'),
                'hotelLabel' => __('admin.rooms.edit.hotel_label'),
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $room = Room::findOrFail($id);

        $validated = $request->validate([
            'room_type' => ['required', 'string', 'max:255'],
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'room_number' => ['required', 'string', 'max:255'],
            'hotel_id' => ['required', 'exists:hotels,id'],
        ]);

        $room->update($validated);

        return redirect()
            ->route('admin.rooms.show', $room)
            ->with('status', __('admin.rooms.flash.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect()
            ->route('admin.rooms.index')
            ->with('status', __('admin.rooms.flash.deleted'));
    }

    private function formatDate(?Carbon $date): string
    {
        if (!$date) {
            return __('admin.common.not_available');
        }

        return $date
            ->copy()
            ->locale(app()->getLocale())
            ->translatedFormat(__('admin.common.datetime_format'));
    }
}
