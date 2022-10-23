<?php

namespace Database\Factories;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $current = Carbon::now();
        $sumDay = rand(2,50);
        $decimal = rand(0,99);
        $price = rand(0,5000);
        return [
            //
            'title' => $this->faker->name(),
            'description' => $this->faker->paragraph(),
            'start_at' => $current->addDay($sumDay)->format('Y-m-d'),
            'end_at' => $current->addDay($sumDay + 2)->format('Y-m-d'),
            'price_person' => $price . "." . $decimal,
            'popularity' => rand(0,500),
        ];
    }
}
