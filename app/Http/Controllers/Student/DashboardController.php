<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\House;
use App\Models\HousePicture;
use App\Models\Room;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $houses = House::paginate(10);
        $search = $request->search;
        if(isset($search))
        {
            $houses = House::where('name', 'like', '%'.$search.'%')->paginate(10);
        }

        return view('student.dashboard', [
            'houses' => $houses
        ]);
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
        //
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

            return view('student.house', [
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
