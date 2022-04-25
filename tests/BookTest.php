<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\Item;


class BookTest extends TestCase
{
    public function test_can_get_all_books()
    {
        $this->get('/api/books');
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => [
                [
                    'id',
                    'name',
                    'item_type_id',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
    }

    public function test_can_get_a_book()
    {
        $book = Item::factory()->create([
            'name' => 'TestBase Book',
            'item_type_id' => 1,
        ]);
        $this->get('/api/books?id=' . $book->id)
            ->seeStatusCode(200)
            ->seeJsonStructure([
                'data' => [
                    [
                        'id',
                        'name',
                        'item_type_id',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }

    public function test_can_update_a_book()
    {
        $book = Item::factory()->create([
            'item_type_id' => 1,
        ]);
        $payload = [
            'item_type_id' => 1,
            "name" => 'we global now'
        ];
        $this->patch('/api/books/' . $book->id, $payload)
            ->seeStatusCode(200)
            ->seeJsonStructure([
                'data' => [

                    'id',
                    'name',
                    'item_type_id',
                    'created_at',
                    'updated_at'

                ]
            ]);
    }

    public function test_can_delete_a_book()
    {
        $book = Item::factory()->create([
            'item_type_id' => 1,
        ]);
        $this->delete('/api/books/' . $book->id)
            ->seeStatusCode(200)
            ->seeJsonStructure([
                'data'
            ]);
    }
}
