<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;


class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.hotels.browse', [
            'hotels' => Hotel::all(),
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
     * Public catalog of hotels.
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
            ->orderByDesc('created_at')
            ->get();

        return view('catalog', [
            'hotels' => $hotels,
            'destination' => $destination,
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
                ->withErrors(['hotel_image' => 'Failed to upload the hotel image. Please try again.'])
                ->withInput();
        }

        Hotel::create([
            'hotel_name' => $validated['hotel_name'],
            'hotel_address' => $validated['hotel_address'],
            'image_path' => $imagePath,
        ]);

        return redirect()
            ->route('admin.hotels.index')
            ->with('status', 'Hotel created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $hotel = Hotel::findOrFail($id);

        return view('admin.hotels.hotel', compact('hotel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $hotel = Hotel::findOrFail($id);

        return view('admin.hotels.edit', compact('hotel'));
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
                    ->withErrors(['hotel_image' => 'Failed to upload the hotel image. Please try again.'])
                    ->withInput();
            }

            $data['image_path'] = $newPath;
        }

        $hotel->update($data);

        return redirect()
            ->route('admin.hotels.index')
            ->with('status', 'Hotel updated successfully.');
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
            ->with('status', 'Hotel deleted successfully.');
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