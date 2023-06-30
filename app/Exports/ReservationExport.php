<?php

namespace App\Exports;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReservationExport implements FromView, ShouldAutoSize
{
    protected $reservations;

    public function __construct($reservations){
        $this->reservations = $reservations;
    }
    public function view():View
    {
           return view('exports.reservation-export',[
               'reservations'=>$this->reservations,
           ]);
    }
}
