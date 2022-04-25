<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\Item;


class EquipmentTest extends TestCase
{
    public function test_can_get_all_equipment()
    {
        $this->get('/api/equipment');
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

    public function test_can_get_an_equipment()
    {
        $equipment = Item::factory()->create([
            'name' => 'TestBase equipment',
            'item_type_id' => 2,
        ]);
        $this->get('/api/equipment?id=' . $equipment->id)
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

    public function test_can_update_an_equipment()
    {
        $equipment = Item::factory()->create([
            'item_type_id' => 2,
        ]);
        $payload = [
            'item_type_id' => 2,
            "name" => 'we global now'
        ];
        $this->patch('/api/equipment/' . $equipment->id, $payload)
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

    public function test_can_delete_an_equipment()
    {
        $equipment = Item::factory()->create([
            'item_type_id' => 2,
        ]);
        $this->delete('/api/equipment/' . $equipment->id)
            ->seeStatusCode(200)
            ->seeJsonStructure([
                'data'
            ]);
    }
}
