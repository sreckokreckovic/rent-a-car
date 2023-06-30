<?php

namespace App\Http\Services;

use App\Http\Requests\StoreCarDocumentRequest;
use App\Models\Car;
use App\Models\Document;
use Tests\Fixtures\Model;

class CarService
{
    public function store($requestValidated)
    {
        return Car::query()->create($requestValidated);
    }

    public function update($requestValidated, $car)
    {
        Car::query()->where('id', $car->id)->update($requestValidated);

        return Car::query()->where('id',$car->id)->first() ;
    }

    public function destroy(Car $car)
    {
        $car->delete();
    }

    public function index($requestValidated)
    {

        return
            Car::query()
                ->when($requestValidated['brand'], function ($query, $brand) {
                    return $query->where('brand', $brand);
                })
                ->when($requestValidated['model'], function ($query, $model) {
                    return $query->where('model', $model);
                })
                ->when($requestValidated['year'], function ($query, $year) {
                    return $query->where('year', $year);
                })
                ->when($requestValidated['price_start'], function ($query, $priceStart) {
                    return $query->where('price', '>=', $priceStart);
                })
                ->when($requestValidated['price_end'], function ($query, $priceEnd) {
                    return $query->where('price', '<=', $priceEnd);
                })
                ->get();
    }

    public function storeCarDocument($file, $car)
    {

        $name = $file->getClientOriginalName();
        $path = "storage/" . $file->store('car-documents');
        return Document::query()->create([
            'name' => $name,
            'path' => $path,
            'documentable_type' => Car::class,
            'documentable_id' => $car->id
        ]);


    }

    public function getCarDocuments($car)
    {
        return Document::query()->where('documentable_type', Car::class)->where('documentable_id', $car->id)->get();
    }

    public function destroyDocument($document)
    {
        $document->delete();
    }

}

?>
