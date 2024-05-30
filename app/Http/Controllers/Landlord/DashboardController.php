<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $search = $request->search;
            $bookings = Booking::join('users', 'users.id', '=', 'bookings.user_id')
            ->join('rooms', 'rooms.id', '=', 'bookings.room_id')
            ->join('houses', 'houses.id', '=', 'rooms.house_id')
            ->select('bookings.id', 'bookings.start_date', 'bookings.end_date', 'bookings.status', 'bookings.created_at', 'users.name as student', 'rooms.name as room', 'houses.name as house')
            ->where('houses.user_id', Auth::id())
            ->orderBy('bookings.created_at', 'DESC')
            ->paginate(10);

            $revenue = Booking::join('users', 'users.id', '=', 'bookings.user_id')
            ->join('rooms', 'rooms.id', '=', 'bookings.room_id')
            ->join('houses', 'houses.id', '=', 'rooms.house_id')
            ->join('transactions', 'transactions.booking_id', '=', 'bookings.id')
            ->where('houses.user_id', Auth::id())
            ->sum('transactions.amount');

            if(isset($search))
            {
                $bookings = Booking::join('users', 'users.id', '=', 'bookings.user_id')
                ->join('rooms', 'rooms.id', '=', 'bookings.room_id')
                ->join('houses', 'houses.id', '=', 'rooms.house_id')
                ->select('bookings.id', 'bookings.start_date', 'bookings.end_date', 'bookings.status', 'bookings.created_at', 'users.name as student', 'rooms.name as room', 'houses.name as house')
                ->whereDate('bookings.created_at', $search)
                ->where('houses.user_id', Auth::id())
                ->orderBy('bookings.created_at', 'DESC')
                ->paginate(10);
            }

            return view('landlord.dashboard', [
                'bookings' => $bookings,
                'revenue' => $revenue
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
