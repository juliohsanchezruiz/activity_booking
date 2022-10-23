<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityReservationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_number_people()
    {
        $params = [
            "number_people" => "2022-12-11",
        ];
        $response = $this->post(route('activity_reservation.store',0), $params);

        $response->assertStatus(302);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_not_exist_activity()
    {
        $params = [
            "number_people" => "1",
        ];
        $response = $this->post(route('activity_reservation.store',0), $params);

        $result=["message"=>"No se pudo guardar el registro"];
        $response->assertJson($result)->assertStatus(400);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_success()
    {
        $params = [
            "number_people" => "1",
        ];
        $response = $this->post(route('activity_reservation.store',1), $params);

        $result=["message"=>"Seguardo el registro correctamente"];
        $response->assertJson($result)->assertStatus(201);
    }
}
