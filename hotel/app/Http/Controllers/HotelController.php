<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Inertia\Inertia;


class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotels = Hotel::orderByDesc('created_at')
            ->get()
            ->map(fn (Hotel $hotel) => [
                'id' => $hotel->id,
                'name' => $hotel->hotel_name,
                'address' => $hotel->hotel_address,
                'image' => $hotel->temporary_image_url ?? $hotel->image_url,
            ])
            ->values();

        return Inertia::render('Admin/Hotels/Index', [
            'hotels' => $hotels,
            'copy' => [
                'headTitle' => __('admin.hotels.index.head_title'),
                'backLabel' => __('admin.hotels.index.back'),
                'createLabel' => __('admin.hotels.index.create'),
                'viewLabel' => __('admin.hotels.index.view'),
                'emptyText' => __('admin.hotels.index.empty'),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Hotels/Create', [
            'copy' => [
                'headTitle' => __('admin.hotels.create.head_title'),
                'heading' => __('admin.hotels.create.heading'),
                'description' => __('admin.hotels.create.description'),
                'backLabel' => __('admin.hotels.create.back'),
                'cancelLabel' => __('admin.hotels.create.cancel'),
                'submitLabel' => __('admin.hotels.create.submit'),
                'nameLabel' => __('admin.hotels.create.name_label'),
                'namePlaceholder' => __('admin.hotels.create.name_placeholder'),
                'addressLabel' => __('admin.hotels.create.address_label'),
                'addressPlaceholder' => __('admin.hotels.create.address_placeholder'),
                'imageLabel' => __('admin.hotels.create.image_label'),
            ],
        ]);
    }

    /**
     * Public landing page rendered via Inertia.
     */
    public function hub(Request $request)
    {
        $destination = trim((string) $request->query('destination', ''));

        return Inertia::render('Hub', [
            'destination' => $destination,
            'suggestUrl' => route('hotels.suggest'),
            'hero' => [
                'kicker' => __('hub.hero.kicker'),
                'heading' => __('hub.hero.heading'),
                'body' => __('hub.hero.body'),
                'primaryCta' => __('hub.hero.primary_cta'),
                'secondaryCta' => __('hub.hero.secondary_cta'),
                'primaryUrl' => '#',
                'secondaryUrl' => '#offers',
            ],
            'search' => [
                'action' => route('hotels.catalog'),
                'labels' => [
                    'destination' => __('hub.search.destination'),
                    'checkIn' => __('hub.search.check_in'),
                    'checkOut' => __('hub.search.check_out'),
                    'guests' => __('hub.search.guests'),
                    'submit' => __('hub.search.submit'),
                ],
                'placeholders' => [
                    'destination' => __('hub.search.destination_placeholder'),
                    'date' => __('hub.search.date_placeholder'),
                ],
                'defaults' => [
                    'guests' => 2,
                ],
            ],
            'collections' => [
                'heading' => __('hub.collections.heading'),
                'body' => __('hub.collections.body'),
                'cta' => __('hub.collections.cta'),
                'ctaUrl' => '#',
            ],
            'offers' => [
                'heading' => __('hub.offers.heading'),
                'body' => __('hub.offers.body'),
                'badges' => array_values(
                    array_filter([
                        __('hub.offers.badges.discount'),
                        __('hub.offers.badges.breakfast'),
                        __('hub.offers.badges.checkout'),
                    ]),
                ),
            ],
            'testimonials' => [
                'heading' => __('hub.testimonials.heading'),
                'items' => array_values((array) __('hub.testimonials.items')),
            ],
        ]);
    }

    /**
     * Public catalog of hotels rendered via Inertia.
     */
    public function catalog(Request $request)
    {
        $destination = trim((string) $request->query('destination', default: ''));

        $hotels = Hotel::query()
            ->when($destination !== '', function ($query) use ($destination) {
                $escaped = str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $destination);
                $likeTerm = '%' . $escaped . '%';

                $query->where(function ($inner) use ($likeTerm) {
                    $inner
                        ->where('hotel_name', 'like', $likeTerm)
                        ->orWhere('hotel_address', 'like', $likeTerm);
                });
            })
            ->withCount('rooms')
            ->orderByDesc('created_at')
            ->get()
            ->map(function (Hotel $hotel) {
                $roomsCount = (int) $hotel->rooms_count;

                return [
                    'id' => $hotel->id,
                    'name' => $hotel->hotel_name,
                    'address' => $hotel->hotel_address,
                    'imageUrl' => $hotel->image_url,
                    'temporaryImageUrl' => $hotel->temporary_image_url,
                    'roomsCount' => $roomsCount,
                    'roomsCountLabel' => trans_choice('catalog.rooms_count', $roomsCount, ['count' => $roomsCount]),
                    'detailUrl' => Route::has('admin.hotels.show')
                        ? route('admin.hotels.show', $hotel)
                        : null,
                ];
            })
            ->values();

        return Inertia::render('Catalog', [
            'destination' => $destination,
            'hotels' => $hotels,
            'copy' => [
                'badge' => __('catalog.badge'),
                'heading' => __('catalog.heading'),
                'body' => __('catalog.body'),
                'searchPlaceholder' => __('catalog.search_placeholder'),
                'searchButton' => __('catalog.search_button'),
                'resultsPrefix' => __('catalog.results_prefix'),
                'availableRoomsBadge' => __('catalog.available_rooms_badge'),
                'noImageLabel' => __('catalog.no_image'),
                'viewDetailsLabel' => __('catalog.view_details'),
                'emptyHeading' => __('catalog.empty_heading'),
                'emptyBody' => __('catalog.empty_body'),
                'searchAction' => route('hotels.catalog'),
            ],
        ]);
    }

    /**
     * Provide basic hotel suggestions for the hub search box.
     */
    public function suggest(Request $request)
    {
        $term = trim((string) $request->query('q', ''));

        if (strlen($term) < 2) {
            return response()->json([
                'results' => [],
            ]);
        }

        $escaped = str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $term);
        $likeTerm = '%' . $escaped . '%';

        $results = Hotel::query()
            ->select(['id', 'hotel_name', 'hotel_address'])
            ->where(function ($query) use ($likeTerm) {
                $query
                    ->where('hotel_name', 'like', $likeTerm)
                    ->orWhere('hotel_address', 'like', $likeTerm);
            })
            ->orderBy('hotel_name')
            ->limit(10)
            ->get()
            ->map(function (Hotel $hotel) {
                $parts = array_filter([$hotel->hotel_name, $hotel->hotel_address]);

                return [
                    'id' => $hotel->id,
                    'name' => $hotel->hotel_name,
                    'address' => $hotel->hotel_address,
                    'label' => implode(' • ', $parts),
                ];
            })
            ->values();

        return response()->json([
            'results' => $results,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hotel_name' => 'required|string|max:255',
            'hotel_address' => 'required|string|max:255',
            'hotel_image' => 'required|image|max:2048',
        ]);

        $imagePath = $this->uploadHotelImage($request->file('hotel_image'));

        if (!$imagePath) {
            return back()
                ->withErrors(['hotel_image' => __('admin.hotels.create.upload_error')])
                ->withInput();
        }

        Hotel::create([
            'hotel_name' => $validated['hotel_name'],
            'hotel_address' => $validated['hotel_address'],
            'image_path' => $imagePath,
        ]);

        return redirect()
            ->route('admin.hotels.index')
            ->with('status', __('admin.hotels.flash.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $hotel = Hotel::findOrFail($id);

        return Inertia::render('Admin/Hotels/Show', [
            'hotel' => [
                'id' => $hotel->id,
                'name' => $hotel->hotel_name,
                'address' => $hotel->hotel_address,
                'image' => $hotel->temporary_image_url ?? $hotel->image_url,
                'createdAt' => $this->formatDate($hotel->created_at),
                'updatedAt' => $this->formatDate($hotel->updated_at),
            ],
            'canEdit' => Route::has('admin.hotels.edit'),
            'canDelete' => Route::has('admin.hotels.destroy'),
            'copy' => [
                'headTitle' => __('admin.hotels.show.head_title', ['name' => $hotel->hotel_name]),
                'backLabel' => __('admin.hotels.show.back'),
                'idLabel' => __('admin.hotels.show.id_label'),
                'profileLabel' => __('admin.hotels.show.profile_label'),
                'createdLabel' => __('admin.hotels.show.created'),
                'updatedLabel' => __('admin.hotels.show.updated'),
                'actionsTitle' => __('admin.hotels.show.actions_title'),
                'actionsDescription' => __('admin.hotels.show.actions_description'),
                'editLabel' => __('admin.hotels.show.edit'),
                'deleteLabel' => __('admin.hotels.show.delete'),
                'deleteUnavailable' => __('admin.common.delete_unavailable'),
                'editUnavailable' => __('admin.common.edit_unavailable'),
                'confirmDelete' => __('admin.common.confirm_delete', ['name' => $hotel->hotel_name]),
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $hotel = Hotel::findOrFail($id);

        return Inertia::render('Admin/Hotels/Edit', [
            'hotel' => [
                'id' => $hotel->id,
                'name' => $hotel->hotel_name,
                'address' => $hotel->hotel_address,
                'image' => $hotel->temporary_image_url ?? $hotel->image_url,
            ],
            'copy' => [
                'headTitle' => __('admin.hotels.edit.head_title', ['name' => $hotel->hotel_name]),
                'heading' => __('admin.hotels.edit.heading'),
                'description' => __('admin.hotels.edit.description'),
                'backLabel' => __('admin.hotels.edit.back'),
                'cancelLabel' => __('admin.hotels.edit.cancel'),
                'submitLabel' => __('admin.hotels.edit.submit'),
                'nameLabel' => __('admin.hotels.create.name_label'),
                'addressLabel' => __('admin.hotels.create.address_label'),
                'imageLabel' => __('admin.hotels.create.image_label'),
                'currentImageHint' => __('admin.hotels.edit.current_image_hint'),
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $hotel = Hotel::findOrFail($id);

        $validated = $request->validate([
            'hotel_name' => 'required|string|max:255',
            'hotel_address' => 'required|string|max:255',
            'hotel_image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'hotel_name' => $validated['hotel_name'],
            'hotel_address' => $validated['hotel_address'],
        ];

        if ($request->hasFile('hotel_image')) {
            if ($hotel->image_path) {
                Storage::disk('s3')->delete($hotel->image_path);
            }

            $newPath = $this->uploadHotelImage($request->file('hotel_image'));

            if (!$newPath) {
                return back()
                    ->withErrors(['hotel_image' => __('admin.hotels.create.upload_error')])
                    ->withInput();
            }

            $data['image_path'] = $newPath;
        }

        $hotel->update($data);

        return redirect()
            ->route('admin.hotels.index')
            ->with('status', __('admin.hotels.flash.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $hotel = Hotel::findOrFail($id);

        if ($hotel->image_path) {
            Storage::disk('s3')->delete($hotel->image_path);
        }

        $hotel->delete();

        return redirect()
            ->route('admin.hotels.index')
            ->with('status', __('admin.hotels.flash.deleted'));
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

    private function uploadHotelImage(UploadedFile $file): ?string
    {
        if (!$file->isValid()) {
            logger()->error('Hotel image invalid upload', [
                'error_code' => $file->getError(),
                'error_message' => $file->getErrorMessage(),
                'size' => $file->getSize(),
            ]);
            return null;
        }
        $disk = Storage::disk('s3');
        $extension = $file->guessExtension() ?: $file->getClientOriginalExtension() ?: 'jpg';
        $path = 'hotels/' . Str::uuid()->toString() . '.' . $extension;
        try {
            $stream = fopen($file->getRealPath(), 'rb');
            if (!$stream) {
                logger()->error('Hotel image upload failed to open stream', [
                    'path' => $file->getRealPath(),
                ]);
                return null;
            }
            $uploaded = $disk->put($path, $stream, ['visibility' => 'private']);
        } catch (\Throwable $e) {
            logger()->error('Hotel image upload exception', [
                'message' => $e->getMessage(),
            ]);
            $uploaded = false;
        } finally {
            if (isset($stream) && is_resource($stream)) {
                fclose($stream);
            }
        }
        if (!$uploaded) {
            logger()->error('Hotel image upload failed', [
                'error_code' => $file->getError(),
                'error_message' => $file->getErrorMessage(),
                'path' => $path,
            ]);
            return null;
        }
        return $path;
    }
}
