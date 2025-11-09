<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BookingController extends BaseController
{
    /**
     * List available events with pagination and optional search
     */
    public function listEvents(Request $request)
    {
        $query = Event::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Only future events
        $query->where('start_time', '>', Carbon::now());

        return response()->json($query->paginate(10));
    }

    /**
     * Book seats for an event
     */
    public function bookEvent(Request $request)
    {
        $data = $request->only('event_id', 'seats_booked');

        // Step 1: Validate input
        $validator = Validator::make($data, [
            'event_id' => 'required|exists:events,id',
            'seats_booked' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422); // Use 422 for validation errors
        }

        // Step 2: Fetch Event
        $event = Event::find($data['event_id']);

        if (!$event || $event->start_time < now()) {
            return response()->json([
                'message' => 'Cannot book a past or unavailable event.'
            ], 400);
        }

        // Step 3: Check seat availability
        if ($data['seats_booked'] > $event->available_seats) {
            return response()->json([
                'message' => 'Not enough available seats.'
            ], 400);
        }

        // Step 4: Perform booking
        try {
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'event_id' => $event->id,
                'seats_booked' => $data['seats_booked']
            ]);

            // Step 5: Decrease available seats
            $event->decrement('available_seats', $data['seats_booked']);

            $response = [
                'message' => 'Booking successful.',
                'booking' => $booking
            ];

            // Optional log
            $this->logStore($request, $response);

            return response()->json($response, 201);

        } catch (\Exception $e) {
            // Step 6: Handle errors gracefully
            return response()->json([
                'message' => 'Something went wrong while booking.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show current user's bookings (including soft-deleted if needed)
     */
    public function myBookings(Request $request)
    {
        // Columns shown in frontend UI filter
        $filter_column_name = ['Date', 'Total Seat Booked', 'Event Title', 'Event Location'];
        $filter_column_key = ['bookings.created_at', 'bookings.seats_booked', 'events.title', 'events.location'];
        $column_name = ['Date', 'Total Seat Booked', 'Event Title', 'Event Location'];

        $perPage = $request->input('per_page', 10);
        $page = $request->input('page_no', 1);
        $searchColumn = $request->input('search_column');
        $searchKeyword = $request->input('search_keyword');
        $from = $request->input('from_date');
        $to = $request->input('to_date');

        $query = Booking::with('event')
            ->where('bookings.user_id', Auth::id())
            ->orderByDesc('bookings.id');

        // Optional Search Filter (on event fields)
        if (!empty($searchColumn) && !empty($searchKeyword)) {
            if (in_array($searchColumn, ['title', 'location'])) {
                $query->whereHas('event', function ($q) use ($searchColumn, $searchKeyword) {
                    $q->where($searchColumn, 'like', '%' . $searchKeyword . '%');
                });
            } else {
                $query->where($searchColumn, 'like', '%' . $searchKeyword . '%');
            }
        }

        // Optional Date Filters
        if (!empty($from)) {
            $query->whereDate('bookings.created_at', '>=', Carbon::parse($from)->format('Y-m-d'));
        }

        if (!empty($to)) {
            $query->whereDate('bookings.created_at', '<=', Carbon::parse($to)->format('Y-m-d'));
        }

        $total = $query->count();

        $bookings = $query->skip($perPage * ($page - 1))->take($perPage)->get();

        return response()->json([
            'status' => true,
            'per_page' => $perPage,
            'page_no' => $page,
            'total' => $total,
            'filter_column_name' => $filter_column_name,
            'filter_column_key' => $filter_column_key,
            'column' => $column_name,
            'data' => $bookings->map(function ($booking) {
                return [
                    'date' => $booking->created_at->format('d-m-Y H:i'),
                    'seats_booked' => $booking->seats_booked,
                    'event_title' => $booking->event->title ?? null,
                    'event_location' => $booking->event->location ?? null,
                    'event_description' => $booking->event->description ?? null,
                    'start_time' => $booking->event->start_time ?? null,
                    'end_time' => $booking->event->end_time ?? null,
                ];
            }),
        ]);
    }

}
