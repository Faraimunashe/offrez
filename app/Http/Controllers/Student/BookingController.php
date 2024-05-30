<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $bookings = Booking::join('users', 'users.id', '=', 'bookings.user_id')
            ->join('rooms', 'rooms.id', '=', 'bookings.room_id')
            ->join('houses', 'houses.id', '=', 'rooms.house_id')
            ->select('bookings.id', 'bookings.start_date', 'bookings.end_date', 'bookings.status', 'bookings.created_at', 'users.name as student', 'rooms.name as room', 'houses.name as house')
            ->where('bookings.user_id', Auth::id())
            ->orderBy('bookings.created_at', 'DESC')
            ->paginate(10);

            //dd($bookings);
            return view('student.bookings', [
                'bookings' => $bookings
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
            'amount' => ['required', 'numeric', 'min:1'],
            'phone' => ['required', 'digits:10', 'starts_with:07'],
            'room_id' => ['required', 'integer'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date']
        ]);

        $wallet = "ecocash";

        //get all data ready
        $email = "jimmymotofire@gmail.com";
        $phone = $request->phone;
        $amount = $request->amount;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $room = Room::find($request->room_id);
        if(is_null($room))
        {
            return redirect()->back()->with("error","Room not found!");
        }

        $overlappingBookings = Booking::where('room_id', $request->room_id)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<=', $startDate)
                                ->where('end_date', '>=', $endDate);
                    });
            })
            ->count();

        $i_booked = Booking::where('room_id', $request->room_id)
            ->where('user_id', Auth::id())
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<=', $startDate)
                                ->where('end_date', '>=', $endDate);
                    });
            })
            ->first();

        //dd($overlappingBookings);

        if ($overlappingBookings > $room->capacity) {
            return redirect()->back()->with('error', 'The room is already booked during the selected period.');
        }

        if (!is_null($i_booked)) {
            return redirect()->back()->with('error', 'You already booked this room.');
        }

        /*determine type of wallet*/
        if (strpos($phone, '071') === 0) {
            $wallet = "onemoney";
        }

        $paynow = new \Paynow\Payments\Paynow(
            "11336",
            "1f4b3900-70ee-4e4c-9df9-4a44490833b6",
            route('bookings.store'),
            route('bookings.store'),
        );

        // Create Payments
        $invoice_name = "MSU-OFFREZ" . time();
        $payment = $paynow->createPayment($invoice_name, $email);

        $payment->add("MSU OFFREZ ROOM", $amount);

        $response = $paynow->sendMobile($payment, $phone, $wallet);
        //dd($response);
        // Check transaction success
        if ($response->success()) {

            $timeout = 9;
            $count = 0;

            while (true) {
                sleep(3);
                // Get the status of the transaction
                // Get transaction poll URL
                $pollUrl = $response->pollUrl();
                $status = $paynow->pollTransaction($pollUrl);


                //Check if paid
                if ($status->paid()) {
                    // Yay! Transaction was paid for
                    // You can update transaction status here
                    // Then route to a payment successful
                    $info = $status->data();

                    if (($overlappingBookings + 1) == $room->capacity)
                    {
                        $room->status = "BOOKED";
                        $room->save();
                    }

                    $booking = new Booking();
                    $booking->user_id = Auth::id();
                    $booking->room_id = $request->room_id;
                    $booking->start_date = $request->start_date;
                    $booking->end_date = $request->end_date;
                    $booking->status = "SUCCESSFUL";
                    $booking->save();


                    //transaction update
                    $trans = new Transaction();
                    $trans->booking_id = $booking->id;
                    $trans->method = "paynow";
                    $trans->amount = $info['amount'];
                    $trans->status = 'SUCCESSFUL';
                    $trans->save();

                    return redirect()->back()->with('success', 'Succesfully paid room booking');
                }


                $count++;
                if ($count > $timeout) {
                    $info = $status->data();

                    return redirect()->back()->with('error', 'Taking too long wait a moment and refresh');
                } //endif
            } //endwhile
        } //endif

        //total fail
        return redirect()->back()->with('error', 'Cannot perform transaction at the moment');
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
