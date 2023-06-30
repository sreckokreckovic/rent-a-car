@php(
   $style='border: 1px solid black;border-collapse:collapse; background-color: #ADD8E6; border-style:solid;border-width:5px; text-align: center; font-weight: bold;'
)
@php(
   $borders='border: 1px solid black;border-collapse:collapse; border-style:solid;border-width:5px;'
)
<table style="{{$borders}}">

    <thead >
    <tr>
        <td style="{{$style}}">Customer</td>
        <td style="{{$style}}">Car</td>
        <td style="{{$style}}">Taking date</td>
        <td style="{{$style}}">Return date</td>
        <td style="{{$style}}">Total price</td>


    </tr>
    </thead>
    <tbody >
@foreach($reservations as $reservation)

    <tr style="{{$borders}}">
      <td style="{{$borders}}">{{$reservation->user->name}}</td>
        <td style="{{$borders}}">{{$reservation->auto->brand}} {{$reservation->auto->model}}</td>
        <td style="{{$borders}}">{{$reservation->taking_date}}</td>
        <td style="{{$borders}}">{{$reservation->return_date}}</td>
        <td style="{{$borders}}">{{$reservation->price}}</td>


    </tr>
@endforeach

    </tbody>


</table>
