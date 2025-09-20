<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Department::factory(10)->create();

        // Create 10 employees with random addresses and projects
        \App\Models\Employee::factory(50)
            ->hasAttached(
                \App\Models\Address::factory()->count(2) // many-to-many
            )
            ->hasAttached(
                \App\Models\Project::factory()->count(3),
                function () {
                    $faker = fake();
                    $date = $faker->date();
                    return [
                        'role' => RoleEnum::random()->value,
                        'start_date' => $date,
                        'end_date' => $faker->boolean()
                            ? Carbon::parse($date)->addYear()
                            : null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            )
            ->create();
    }
}
