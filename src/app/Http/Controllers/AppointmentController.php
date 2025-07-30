<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Appointment\BookAppointmentRequest;

class AppointmentController extends Controller
{
    public function allAppointments(Request $request)
    {
        $limit = $_GET['limit'] ?? 10;
        $appointments = Appointment::with('professional')
            ->orderBy('appointment_start_time')
            ->latest()->paginate($limit);

        return $this->successResponseWithPagination($appointments);
    }
    
    public function userAppointments(Request $request)
    {
        $limit = $_GET['limit'] ?? 10;
        $appointments = Appointment::with('professional')
            ->where('user_id', Auth::id())
            ->orderBy('appointment_start_time')
            ->latest()->paginate($limit);

        return $this->successResponseWithPagination($appointments);
    }


    public function book(BookAppointmentRequest $request)
    {
        $start = Carbon::parse($request->appointment_start_time);
        $end = Carbon::parse($request->appointment_end_time);
        $professionalId = $request->healthcare_professional_id;


        $conflict = Appointment::where('healthcare_professional_id', $professionalId)
            ->where('status', 'booked')
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('appointment_start_time', [$start, $end])
                      ->orWhereBetween('appointment_end_time', [$start, $end])
                      ->orWhere(function ($q) use ($start, $end) {
                          $q->where('appointment_start_time', '<=', $start)
                            ->where('appointment_end_time', '>=', $end);
                      });
            })
            ->exists();

        if ($conflict) {
            return $this->errorResponse('Appointment is already booked during this time.', 409);
        }

        $appointment = Appointment::create([
            'user_id' => Auth::id(),
            'healthcare_professional_id' => $professionalId,
            'appointment_start_time' => $start,
            'appointment_end_time' => $end,
            'status' => 'booked',
        ]);
        return $this->successResponse($appointment, 'Appointment booked successfully');
    }


    public function cancel($id)
    {
        $appointment = Appointment::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$appointment) {

            return $this->errorResponse('Appointment not found or access denied.', 404);
        }

        $now = Carbon::now();
        if ($now->diffInHours(Carbon::parse($appointment->appointment_start_time), false) < 24) {

            return $this->errorResponse('Cannot cancel appointment within 24 hours.', 400);
        }

        if ($appointment->status !== 'booked') {
            return $this->errorResponse('Only booked appointments can be cancelled.', 400);
        }

        $appointment->status = 'cancelled';
        $appointment->save();

        return $this->successResponse($appointment, 'Appointment cancelled successfully');
    }


    public function markComplete($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment || $appointment->user_id !== Auth::id()) {
            return $this->errorResponse('Appointment not found or access denied.', 404);
        }

        if ($appointment->status !== 'booked') {
            return $this->errorResponse('Only booked appointments can be marked completed.', 400);
        }

        $appointment->status = 'completed';
        $appointment->save();

        return $this->successResponse($appointment, 'Appointment marked as completed.');
    }

}
