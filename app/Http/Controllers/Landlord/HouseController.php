<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\House;
use App\Models\HousePicture;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $houses = House::where('user_id', Auth::id())->paginate(10);
            $search = $request->search;
            if (isset($search)) {
                $houses = House::where('user_id', Auth::id())
                    ->where(function($query) use ($search) {
                        $query->orWhere('name', 'LIKE', '%'.$search.'%')
                              ->orWhere('address', 'LIKE', '%'.$search.'%');
                    })
                    ->paginate(10);
            }

            return view('landlord.houses', [
                'houses' => $houses
            ]);

        }catch(\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
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
            'name' => ['required', 'string'],
            'address' => ['required', 'string'],
            'description' => ['required', 'string'],
            'picture' => ['required','mimes:jpg,jpeg,png,','max:2048']
        ]);

        try{
            $house = new House();
            $house->user_id = Auth::id();
            $house->name = $request->name;
            $house->address = $request->address;
            $house->description = $request->description;
            $house->save();

            $file = $request->file('picture');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $request->picture->move(public_path('images/houses'), $filename);
            $image = new HousePicture();
            $image->house_id = $house->id;
            $image->picture = $filename;
            $image->save();


            return redirect()->back()->with('success', 'Successfully added new house');

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
            $house = House::findOrFail($id);
            $hp = HousePicture::where('house_id', $id)->orderBy('created_at','DESC')->first();
            $rooms = Room::where('house_id', $id)->get();

            return view('landlord.house', [
                'house' => $house,
                'rooms' => $rooms,
                'hp' => $hp
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
            'address' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        if($request->hasFile('picture'))
        {
            $request->validate([
                'picture' => ['required', 'mimes:jpg,jpeg,png,','max:2048']
            ]);
        }

        try{
            $house = House::findOrFail($id);
            $house->name = $request->name;
            $house->address = $request->address;
            $house->description = $request->description;
            $house->save();

            if ($request->hasfile('picture')) {
                House::where('house_id', $id)->delete();
                $file = $request->file('picture');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $request->picture->move(public_path('images/houses'), $filename);
                $image = new HousePicture();
                $image->house_id = $house->id;
                $image->picture = $filename;
                $image->save();
            }

            return redirect()->back()->with('success', 'Successfully updated house');

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
            $house = House::findOrFail($id);
            $house->delete();

            return redirect()->back()->with('success', 'Successfully deleted house');

        }catch(\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
