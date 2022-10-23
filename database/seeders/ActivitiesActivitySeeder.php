<?php

namespace Database\Seeders;


use App\Models\ActivitiesActivity;
use Illuminate\Database\Seeder;

class ActivitiesActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $activities =[
            [
                "activity_parent_id"=>"12",
                "activity_id"=>"1",
            ],
            [
                "activity_parent_id"=>"12",
                "activity_id"=>"2",
            ],
            [
                "activity_parent_id"=>"1",
                "activity_id"=>"2",
            ],
            [
                "activity_parent_id"=>"1",
                "activity_id"=>"3",
            ]
        ];
        foreach ($activities as $activity){
            ActivitiesActivity::firstOrCreate($activity);
        }
    }
}
