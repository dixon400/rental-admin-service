<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Rentals;
use App\Traits\ApiResponse;
use Illuminate\Http\Response;

class EquipmentController extends Controller
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

    public function viewEquipment()
    {
        $equipment_id = request('id') ?? "";
        $equipment = $equipment_id == ""?
                 Item::where('item_type_id', 2)->get() 
                 :Item::where('item_type_id', 2)->where('id', $equipment_id)->get();
        return $this->successResponse($equipment);
    }

    public function createEquipment()
    {
        $this->validate(request(), [
            'name' => 'required | min:3',
            'item_type_id' => 'required',
        ]);

        return Item::create(request()->all());
    }

    public function updateEquipment()
    {
        $this->validate(request(), [
            'name' => 'required | min:3',
            'item_type_id' => 'required',
        ]);
        try {
            $equipment = Item::findOrFail(request()->id);
            $equipment->fill(request()->all());
            if ($equipment->isClean()) {
                return $this->errorResponse(
                    'At least one value must change',
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }
             $equipment->save();
             return $this->successResponse($equipment);
        } catch (\Throwable $th) {
            return $this->errorResponse(
                'Not found',
                Response::HTTP_NOT_FOUND
            );
        }
    }

    public function deleteEquipment($id)
    {
        try {
            $equipment = Item::findOrFail($id);
           if($equipment->item_type_id == 2){
            $rented = Rentals::where('item_id',$equipment->id)->orderBy('created_at', 'DESC')->get();
            if($rented[0]['status_id'] == 1){
                $equipment->delete();
                return $this->successResponse('Deleted Successfully');
            }
            else{
                return $this->successResponse('You can\'t delete a rented item');
            }
           }
           else {
            return $this->errorResponse(
                'Please pass a equipment id',
                Response::HTTP_NOT_FOUND
            );
           }
        } catch (\Throwable $th) {
            return $this->errorResponse(
                'Not found',
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
