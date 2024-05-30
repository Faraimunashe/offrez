<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $search = $request->search;
            $transactions = Booking::join('rooms', 'rooms.id', '=', 'bookings.room_id')
            ->join('houses', 'houses.id', '=', 'rooms.house_id')
            ->join('transactions', 'transactions.booking_id', '=', 'bookings.id')
            ->select('transactions.id', 'transactions.amount', 'transactions.method', 'transactions.status', 'transactions.created_at', 'rooms.name as room', 'houses.name as house')
            ->where('bookings.user_id', Auth::id())
            ->orderBy('transactions.created_at', 'DESC')
            ->paginate(10);

            return view('student.transactions', [
                'transactions' => $transactions
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
