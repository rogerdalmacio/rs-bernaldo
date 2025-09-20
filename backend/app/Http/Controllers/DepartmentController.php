<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    //
    public function index(): JsonResponse
    {
        $departments = Department::query()->orderBy('department')->get();

        return ApiResponse::success('Success', DepartmentResource::collection($departments));
    }
}
