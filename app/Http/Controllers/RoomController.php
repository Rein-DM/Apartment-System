<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\ApartmentRoom;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve the number of entries to display per page from the request or set a default value
        $perPage = $request->input('per_page', 10); // default to 10 entries per page
        
        // Get the search term from the request
        $search = $request->input('search');
    
        // Paginate the rooms, filtering by search term if provided
        $rooms = Room::when($search, function ($query, $search) {
            return $query->where('room_number', 'like', "%{$search}%")
                         ->orWhere('type', 'like', "%{$search}%")
                         ->orWhere('description', 'like', "%{$search}%");
        })->paginate($perPage);
        
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function show($id)
    {
        $room = Room::findOrFail($id);
        $events = ApartmentRoom::where('id', $id)->get();
        return view('booking.forms', compact('room', 'events')); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'price' => 'required|string|regex:/^\d+(\.\d{1,2})?$/',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'available' => 'required|boolean',
            'apartment_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bathroom_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'outside_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'occupied_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'vacant_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Check if the room number already exists
        if (Room::where('room_number', $request->room_number)->exists()) {
            return redirect()->back()->with('error', 'Room number already exists.')->withInput();
        }
    
        // Create new room instance
        $room = new Room();
        $room->room_number = $request->room_number;
        $room->type = $request->type;
        $room->price = $request->price;
        $room->capacity = $request->capacity;
        $room->description = $request->description;
        $room->available = $request->available;
    
        // Handle image uploads
        $imageFields = ['apartment_image', 'bathroom_image', 'outside_image', 'occupied_image', 'vacant_image'];
        
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                $room->$field = $request->file($field)->store('rooms/', 'public');
            }
        }
    
        // Save room to the database
        $room->save();
    
        return redirect()->route('rooms.index')->with('success', 'Room added successfully.');
    }
    
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'room_number' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'price' => 'required|numeric',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'available' => 'required|boolean',
            'apartment_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bathroom_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'outside_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'occupied_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'vacant_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Check if the room number already exists (excluding the current room)
        if (Room::where('room_number', $request->room_number)->where('id', '!=', $room->id)->exists()) {
            return redirect()->back()->with('error', 'Room number already exists.')->withInput();
        }
    
        // Update room instance
        $room->room_number = $request->room_number;
        $room->type = $request->type;
        $room->price = $request->price;
        $room->capacity = $request->capacity;
        $room->description = $request->description;
        $room->available = $request->available;
    
        // Handle image updates
        $imageFields = ['apartment_image', 'bathroom_image', 'outside_image', 'occupied_image', 'vacant_image'];
    
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old image if it exists
                if ($room->$field) {
                    Storage::disk('public')->delete($room->$field);
                }
                $room->$field = $request->file($field)->store('rooms/', 'public');
            }
        }
    
        // Save updates to the database
        $room->save();
    
        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }    

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    // public function update(Request $request, Room $room)
    // {
    //     $request->validate([
    //         'room_number' => 'required|string|max:255|unique:rooms,room_number,' . $room->id,
    //         'type' => 'required|string|max:255',
    //         'price' => 'required|numeric',
    //         'capacity' => 'required|integer|min:1',
    //         'description' => 'nullable|string',
    //         'available' => 'required|boolean',
    //         'apartment_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'bathroom_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'outside_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'occupied_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'vacant_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     // Update room instance
    //     $room->room_number = $request->room_number;
    //     $room->type = $request->type;
    //     $room->price = $request->price;
    //     $room->capacity = $request->capacity;
    //     $room->description = $request->description;
    //     $room->available = $request->available;

    //     // Handle image updates
    //     $imageFields = ['apartment_image', 'bathroom_image', 'outside_image', 'occupied_image', 'vacant_image'];

    //     foreach ($imageFields as $field) {
    //         if ($request->hasFile($field)) {
    //             // Delete old image if it exists
    //             if ($room->$field) {
    //                 Storage::disk('public')->delete($room->$field);
    //             }
    //             $room->$field = $request->file($field)->store('rooms/images', 'public');
    //         }
    //     }

    //     // Save updates to the database
    //     $room->save();

    //     return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    // }

    public function destroy($id)
    {
        // Find room or fail
        $room = Room::findOrFail($id);

        // Check if the user is authorized
        if (!in_array(Auth::user()->role, ['admin', 'seller'])) {
            abort(403); // Return a 403 error if user is unauthorized
        }
    
        // Set the room's status to 0 instead of deleting it
        $room->status = 0; // Mark as deleted
        $room->save();
    
        // Delete images from storage if they exist
        $imageFields = ['apartment_image', 'bathroom_image', 'outside_image', 'occupied_image', 'vacant_image'];
    
        foreach ($imageFields as $field) {
            if ($room->$field) {
                // Check if the image exists before attempting to delete
                if (Storage::disk('public')->exists($room->$field)) {
                    Storage::disk('public')->delete($room->$field);
                }
            }
        }

        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.'); // Redirect after deletion
    }

    public function restore($id)
    {
        if (!in_array(Auth::user()->role, ['admin', 'users'])) {
            return response()->json(['success' => false, 'message' => 'Unauthorized action.'], 403);
        }
        
        $room = Room::findOrFail($id);
        
        // Check if the room is already marked as deleted
        if ($room->status === 0) {
            // Restore the room by setting the status back to 1
            $room->status = 1;
            $room->save();
    
            // Set a success message in session
            return response()->json(['success' => true, 'message' => 'Room restored successfully!']);
        }
    
        // Set an error message in session if the room is not deleted
        return response()->json(['success' => false, 'message' => 'Room is not deleted or already restored.']);
    }    
}
