<?php

namespace App\Http\Controllers\api;

use App\Exports\ReservationExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminFilterRequest;
use App\Http\Requests\FilterExcelRequest;
use App\Http\Requests\ReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Requests\UserFilterRequest;
use App\Http\Resources\ReservationResource;
use App\Http\Services\ReservationService;
use App\Models\Reservation;
use App\Models\User;
use Maatwebsite\Excel\Excel;


class ReservationController extends Controller
{
    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(AdminFilterRequest $request)
    {
        return ReservationResource::collection($this->reservationService->index($request->validated()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservationRequest $request)
    {
        return ReservationResource::make($this->reservationService->store($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, UserFilterRequest $request)
    {
        return ReservationResource::collection($this->reservationService->show($user, $request->validated()));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        return ReservationResource::make($this->reservationService->update($request->validated(), $reservation));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $this->reservationService->destroy($reservation);
        return response(['message' => 'Deleted'], 402);
    }

    public function export(FilterExcelRequest $request)
    {
        return $reservations = $this->reservationService->export($request->validated());

    }
}
