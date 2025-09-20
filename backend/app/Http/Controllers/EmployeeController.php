<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //
    public function index(Request $request): JsonResponse
    {
        $department = $request->input('department_id');
        $sort = $request->input('sort');

        $employees = Employee::with(['projects', 'department'])
            ->when($department, function (Builder $query) use ($department) {
                $query->whereHas('department', function (Builder $query) use ($department) {
                    $query->where('id', $department);
                });
            })
            ->when($sort, function (Builder $query) use ($sort) {
                $query->orderBy('name', $sort);
            })
            ->paginate()
            ->withQueryString();

        return ApiResponse::success('Success', EmployeeResource::collection($employees)->resource);
    }
}
