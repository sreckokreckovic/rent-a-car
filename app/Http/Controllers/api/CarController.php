<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarFilterRequest;
use App\Http\Requests\StoreCarDocumentRequest;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Http\Resources\CarResource;
use App\Http\Resources\DocumentResource;
use App\Http\Services\CarService;
use App\Models\Car;
use App\Models\Document;
use Illuminate\Http\Request;

class CarController extends Controller
{
    protected $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(CarFilterRequest $request)
    {
        return CarResource::collection($this->carService->index($request->validated()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarRequest $request)
    {
        return CarResource::make($this->carService->store($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarRequest $request, Car $car)
    {
        return CarResource::make($this->carService->update($request->validated(), $car));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        $this->carService->destroy($car);
    }

    public function storeCarDocument(StoreCarDocumentRequest $request, Car $car)
    {
        $file = $request->file('file');
        return DocumentResource::make($this->carService->storeCarDocument($file, $car));

    }

    public function getCarDocuments(Car $car)
    {
        return DocumentResource::collection($this->carService->getCarDocuments($car));
    }

    public function destroyDocument(Document $document)
    {
        $this->carService->destroyDocument($document);
        return response(['message' => 'Deleted'], 402);

    }
}
