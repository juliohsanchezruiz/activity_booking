<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_success()
    {
        $params = [
            "search_date" => "2022-12-11",
        ];

        $result = [
            "data" => [
                [
                    "id" => 19,
                    "title" => "Kane Funk",
                    "description" => "Tempora qui molestiae similique consequuntur neque nihil. Labore ut et saepe ipsum est. Doloribus molestias impedit cupiditate quia fuga minus enim quaerat. Excepturi itaque aspernatur perspiciatis quia sunt et accusamus enim.",
                    "start_at" => "2022-12-11",
                    "end_at" => "2023-02-01",
                    "price_person" => "1415.60",
                    "popularity" => 340
                ]
            ]
        ];
        $response = $this->post(route('activity.index'), $params);

        $response->assertJson($result)->assertStatus(200);

    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_empty()
    {
        $params = [
            "search_date" => "",
        ];

        $result = [];
        $response = $this->post(route('activity.index'), $params);

        $response->assertJson($result)->assertStatus(200);

    }

    public function test_not_search_date()
    {
        $params = [
            "search_date1" => "2022-12-11",
        ];

        $result = [];
        $response = $this->post(route('activity.index'), $params);

        $response->assertJson($result)->assertStatus(200);
    }
}
