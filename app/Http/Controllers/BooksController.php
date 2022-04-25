<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Rentals;
use App\Traits\ApiResponse;
use Illuminate\Http\Response;

class BooksController extends Controller
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

    public function viewBooks()
    {
        $book_id = request('id') ?? "";
        $books = $book_id == ""?
                 Item::where('item_type_id', 1)->get() 
                 :Item::where('item_type_id', 1)->where('id', $book_id)->get();
        return $this->successResponse($books);
    }


    public function createBook()
    {
        $this->validate(request(), [
            'name' => 'required | min:3',
            'item_type_id' => 'required',
        ]);

        return $this->successResponse(Item::create(request()->all()));
    }

    public function updateBook()
    {
        $this->validate(request(), [
            'name' => 'required | min:3',
            'item_type_id' => 'required',
        ]);
        try {
            $book = Item::findOrFail(request()->id);
            $book->fill(request()->all());
            if ($book->isClean()) {
                return $this->errorResponse(
                    'At least one value must change',
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }
             $book->save();
             return $this->successResponse($book);
        } catch (\Throwable $th) {
            return $this->errorResponse(
                'Not found',
                Response::HTTP_NOT_FOUND
            );
        }
    }

    public function deleteBook($id)
    {
        try {
            $book = Item::findOrFail($id);
            if($book->item_type_id == 1){
                $rented = Rentals::where('item_id',$book->id)->orderBy('created_at', 'DESC')->get();
                if(count($rented) == 0 || $rented[0]['status_id'] == 1 ){
                $book->delete();
                return $this->successResponse('Deleted Successfully');
            }
            else{
                return $this->successResponse('You can\'t delete a rented item');
            }
           }
           else {
            return $this->errorResponse(
                'Please pass a book id',
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
