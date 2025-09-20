<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\AssignProjectsRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class EmployeeProjectController extends Controller
{
    public function index(): JsonResponse
    {
        $employees = Employee::with(['projects' => function ($query) {
            $query->whereNull('employee_project.end_date');
        }])->get();

        return ApiResponse::success('Success', EmployeeResource::collection($employees));
    }

    public function store(AssignProjectsRequest $request, Employee $employee): JsonResponse
    {
        try {
            DB::beginTransaction();

            $validatedProjects = $request->validated()['projects'];
            $projectsArr = [];

            foreach ($validatedProjects as $project) {
                $alreadyAssigned = $employee->projects()
                    ->where('projects.id', $project['project_id'])
                    ->exists();

                if ($alreadyAssigned) {
                    return ApiResponse::error(
                        "Employee is already assigned to project {$project['project_id']}",
                        null,
                        422
                    );
                }

                $projectsArr[$project['project_id']] = [
                    'role' => $project['role'],
                    'start_date' => $project['start_date'],
                    'end_date' => $project['end_date'] ?? null,
                    'updated_at' => now(),
                ];
            }

            $employee->projects()->attach($projectsArr);

            DB::commit();

            return ApiResponse::success('Success');
        } catch (Throwable $e) {
            DB::rollBack();

            return ApiResponse::error('Failed to assign projects', $e->getMessage(), 500);
        }
    }
}
