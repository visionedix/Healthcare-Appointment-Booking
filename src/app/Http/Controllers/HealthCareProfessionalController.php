<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HealthcareProfessional;

class HealthCareProfessionalController extends Controller
{
    public function index()
    {
        try {

            $limit = $_GET['limit'] ?? 10;
            $search = $_GET['search'] ?? null;

            $professionals = HealthcareProfessional::where('name', 'like', '%'.$search.'%')
                             ->orWhere('specialty', 'like', '%'.$search.'%')
                             ->latest()->paginate($limit);

            return $this->successResponseWithPagination($professionals);


        } catch (\Exception $ex) {
            return $this->errorResponse($ex, 404);
        }
    }

    public function show($id)
    {
        try {
            $professional = HealthcareProfessional::find($id);

            if (!$professional) {
                return $this->errorResponse('Healthcare Professional not found', 404);
            }

            return $this->successResponse($professional, 1, 'Healthcare Professional details retrieved successfully');

        } catch (\Exception $ex) {
            return $this->errorResponse($ex, 404);
        }

    }
}
