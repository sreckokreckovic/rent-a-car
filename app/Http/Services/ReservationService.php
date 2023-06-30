<?php
namespace App\Http\Services;

use App\Exports\ReservationExport;
use App\Mail\ReservationMail;
use App\Models\Car;
use App\Models\Document;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Excel;

class ReservationService
{
    public function index($requestValidated)
    {

        return Reservation::query()
            ->when($requestValidated['taking_date'], function ($query, $takingDate) {
                return $query->where('taking_date', '>=', $takingDate);
            })
            ->when($requestValidated['return_date'], function ($query, $returnDate) {
                return $query->where('return_date', '<=', $returnDate);
            })->get();


    }

    public function show($user, $requestValidated)
    {

        return Reservation::query()->where('customer', $user->id)
            ->when($requestValidated['taking_date'], function ($query, $takingDate) {
                return $query->where('taking_date', '>=', $takingDate);
            })
            ->when($requestValidated['return_date'], function ($query, $returnDate) {
                return $query->where('return_date', '<=', $returnDate);
            })->get();


    }

    public function destroy($reservation)
    {
        $reservation->delete();
    }

    public function store($requestValidated)
    {
        $id=$requestValidated['car'];
        $car= Car::query()->where('id','=',$id)->first();
        $date1=Carbon::parse($requestValidated['taking_date']);
        $date2=Carbon::parse($requestValidated['return_date']);
        $diff=$date1->diffInDays($date2);
        $price=$diff*$car->price;

        $user = \auth()->user()->email;

        Mail::to($user)->queue(new ReservationMail(\auth()->user()));

        return Reservation::query()->create(array_merge($requestValidated,['price'=>$price]));

    }

    public function update($requestValidated, $reservation)
    {
        Reservation::query()->where('id', $reservation->id)->update($requestValidated);
        return Reservation::query()->where('id',$reservation->id)->first() ;
    }

    public function export($requestValidated)
    {
        $reservations = Reservation::query()
            ->when($requestValidated['taking_date'], function ($query, $takingDate) {
                return $query->where('taking_date', '>=', $takingDate);
            })
            ->when($requestValidated['return_date'], function ($query, $returnDate) {
                return $query->where('return_date', '<=', $returnDate);
            })
            ->when($requestValidated['price_start'], function ($query, $priceStart) {
                return $query->where('price', '>=', $priceStart);
            })
            ->when($requestValidated['price_end'], function ($query, $priceEnd) {
                return $query->where('price', '<=', $priceEnd);
            })->get();

        return \Maatwebsite\Excel\Facades\Excel::download(new ReservationExport($reservations), 'reservation-export.xlsx');
    }


}

?>
