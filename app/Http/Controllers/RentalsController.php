<?php

namespace App\Http\Controllers;

use App\Models\Rentals;
use App\Traits\ApiResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class RentalsController extends Controller
{
    use ApiResponse;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getStat()
    {
        $month = request('month') ?? Carbon::now()->month;

        $rentedItems =  $this->rentedItems($month);
        $returnedItems = $this->returnedItems($month);

        $data['rentedItems']['books'] =  $rentedItems['books']['totalrented'];
        $data['rentedItems']['equipment'] = $rentedItems['equipment']['totalrented'];

        $data['returnedItems']['books']= $returnedItems['books']['totalreturned'];
        $data['returnedItems']['equipment'] = $returnedItems['equipment']['totalreturned'];
        return $this->successResponse($data);
    }

    protected function rentedItems($month)
    {

        try {
        $books =  Rentals::select('rentals.*', 'rental_statuses.name as status')
                        ->leftJoin('items', 'rentals.item_id', '=', 'items.id')
                        ->leftJoin('rental_statuses', 'rental_statuses.id', '=', 'rentals.status_id')
                        ->where('items.item_type_id', '=', 1)
                        ->where('status_id', '=', 1)
                        ->whereMonth('rentals.created_at', $month)->get();
        $equipment = Rentals::select('rentals.*', 'rental_statuses.name as status')
                        ->leftJoin('items', 'rentals.item_id', '=', 'items.id')
                        ->leftJoin('rental_statuses', 'rental_statuses.id', '=', 'rentals.status_id')
                        ->where('items.item_type_id', '=', 2)
                        ->where('status_id', '=', 1)
                        ->whereMonth('rentals.created_at', $month)->get();
        $rentedItems['books']['totalrented'] = count($books);
        $rentedItems['books']['data'] = $books;
        $rentedItems['equipment']['totalrented'] = count($equipment);
        $rentedItems['equipment']['data'] = $equipment;

        
        return ($rentedItems);
        } catch (\Throwable $th) {
            $this->errorResponse("Error Fetching Rented Data", Response::HTTP_NOT_FOUND);
        }
    }

    protected function returnedItems($month)
    {
        try {
        $books =  Rentals::select('rentals.*', 'rental_statuses.name as status')
                        ->leftJoin('items', 'rentals.item_id', '=', 'items.id')
                        ->leftJoin('rental_statuses', 'rental_statuses.id', '=', 'rentals.status_id')
                        ->where('items.item_type_id', '=', 1)
                        ->where('status_id', '=', 2)
                        ->whereMonth('rentals.created_at', $month)->get();
        
        $equipment = Rentals::select('rentals.*', 'rental_statuses.name as status')
                        ->leftJoin('items', 'rentals.item_id', '=', 'items.id')
                        ->leftJoin('rental_statuses', 'rental_statuses.id', '=', 'rentals.status_id')
                        ->where('items.item_type_id', '=', 2)
                        ->where('status_id', '=', 2)
                        ->whereMonth('rentals.created_at', $month)->get();
       
        $returnedItems['books']['totalreturned'] = count($books);
        $returnedItems['books']['data'] = $books;
        $returnedItems['equipment']['totalreturned'] = count($equipment);
        $returnedItems['equipment']['data'] = $equipment;
        
         return ($returnedItems);
        } catch (\Throwable $th) {
            $this->errorResponse("Error Fetching Returned Data", Response::HTTP_NOT_FOUND);
        }
    }
}
