<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomPicture;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'house_id' => ['required', 'integer'],
            'name' => ['required', 'string'],
            'capacity' => ['required', 'integer'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'picture' => ['required','mimes:jpg,jpeg,png,','max:2048']
        ]);

        try{
            $room = new Room();
            $room->house_id = $request->house_id;
            $room->name = $request->name;
            $room->capacity = $request->capacity;
            $room->description = $request->description;
            $room->price = $request->price;
            $room->status = 'AVAILABLE';
            $room->save();

            $file = $request->file('picture');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $request->picture->move(public_path('images/rooms'), $filename);
            $image = new RoomPicture();
            $image->room_id = $room->id;
            $image->picture = $filename;
            $image->save();


            return redirect()->back()->with('success', 'Successfully added new room');

        }catch(\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $room = Room::findOrFail($id);
            $room_pictures = RoomPicture::where('house_id', $id)->get();
            return view('landlord.room', [
                'room' => $room,
                'room_pictures' => $room_pictures
            ]);

        }catch(\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'capacity' => ['required', 'integer'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
        ]);

        if($request->hasFile('picture'))
        {
            $request->validate([
                'picture' => ['required','mimes:jpg,jpeg,png,','max:2048']
            ]);
        }

        try{
            $room = Room::findOrFail($id);
            $room->name = $request->name;
            $room->capacity = $request->capacity;
            $room->description = $request->description;
            $room->price = $request->price;
            $room->save();

            if ($request->hasfile('picture')) {
                RoomPicture::where('room_id', $id)->get()->delete();
                $file = $request->file('picture');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $request->picture->move(public_path('images/rooms'), $filename);
                $image = new RoomPicture();
                $image->room_id = $room->id;
                $image->picture = $filename;
                $image->save();
            }

            return redirect()->back()->with('success', 'Successfully updated room');

        }catch(\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $room = Room::findOrFail($id);
            $room->delete();

            return redirect()->back()->with('success', 'Successfully deleted room');

        }catch(\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
