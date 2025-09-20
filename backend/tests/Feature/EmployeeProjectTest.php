<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeProjectTest extends TestCase
{
    use RefreshDatabase;

    public function it_validates_required_fields(): void
    {
        $employee = Employee::factory()->create();

        $response = $this->postJson("/api/employees/{$employee->id}/projects", [
            'projects' => [
                [
                    'project_id' => null,
                    'role' => '',
                    'start_date' => 'not-a-date'
                ]
            ]
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'projects.0.project_id',
                'projects.0.role',
                'projects.0.start_date',
            ]);
    }

    public function it_assigns_multiple_projects_successfully(): void
    {
        $employee = Employee::factory()->create();
        $projects = Project::factory()->count(2)->create();

        $payload = [
            'projects' => [
                [
                    'project_id' => $projects[0]->id,
                    'role' => 'Developer',
                    'start_date' => now()->toDateString(),
                    'end_date' => null,
                ],
                [
                    'project_id' => $projects[1]->id,
                    'role' => 'Tester',
                    'start_date' => now()->toDateString(),
                    'end_date' => now()->addMonths(3)->toDateString(),
                ],
            ]
        ];

        $response = $this->postJson("/api/employees/{$employee->id}/projects", $payload);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Projects assigned successfully',
            ]);

        $this->assertDatabaseHas('employee_project', [
            'employee_id' => $employee->id,
            'project_id' => $projects[0]->id,
            'role' => 'Developer',
        ]);

        $this->assertDatabaseHas('employee_project', [
            'employee_id' => $employee->id,
            'project_id' => $projects[1]->id,
            'role' => 'Tester',
        ]);
    }

    public function it_prevents_duplicate_project_assignment(): void
    {
        $employee = Employee::factory()->create();
        $project = Project::factory()->create();

        // First assignment
        $this->postJson("/api/employees/{$employee->id}/projects", [
            'projects' => [[
                'project_id' => $project->id,
                'role' => 'Developer',
                'start_date' => now()->toDateString(),
                'end_date' => null,
            ]]
        ])->assertStatus(201);

        // Second assignment
        $response = $this->postJson("/api/employees/{$employee->id}/projects", [
            'projects' => [[
                'project_id' => $project->id,
                'role' => 'Manager',
                'start_date' => now()->toDateString(),
                'end_date' => null,
            ]]
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => "Employee is already assigned to project {$project->id}",
            ]);
    }
}
