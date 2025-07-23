<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class DepartmentController extends Controller
{
    protected $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $departments = $this->api->get('/departments');
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.form');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            
            if (isset($data['max_clock_in_time'])) {
                $data['max_clock_in_time'] = date('H:i:s', strtotime($data['max_clock_in_time']));
            }
    
            if (isset($data['max_clock_out_time'])) {
                $data['max_clock_out_time'] = date('H:i:s', strtotime($data['max_clock_out_time']));
            }
    
            $response = Http::post(config('services.api.base_url') . '/departments', $data);
    
            if ($request->ajax()) {
                return response()->json($response->json(), $response->status());
            }
    
            return redirect()
                ->route('departments.index')
                ->with('success', $response->json('message') ?? 'Department created successfully.');
    
        } catch (\Illuminate\Http\Client\RequestException $e) {
            if ($request->ajax() && $e->response && $e->response->status() === 422) {
                return response()->json([
                    'message' => $e->response->json('message') ?? 'Validation error',
                    'errors'  => $e->response->json('errors') ?? [],
                ], 422);
            }
    
            return redirect()
                ->route('departments.index')
                ->with('error', 'Something went wrong while creating the department.');
        }
    }

    public function edit($id)
    {
        $department = $this->api->get("/departments/{$id}");
        return view('departments.form', compact('department'));
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            
            if (isset($data['max_clock_in_time'])) {
                $data['max_clock_in_time'] = date('H:i:s', strtotime($data['max_clock_in_time']));
            }
    
            if (isset($data['max_clock_out_time'])) {
                $data['max_clock_out_time'] = date('H:i:s', strtotime($data['max_clock_out_time']));
            }
    
            $response = Http::put(config('services.api.base_url') . "/departments/{$id}", $data);
    
            if ($request->ajax()) {
                return response()->json($response->json(), $response->status());
            }
    
            return redirect()
                ->route('departments.index')
                ->with('success', $response->json('message') ?? 'Department updated successfully.');
    
        } catch (\Illuminate\Http\Client\RequestException $e) {
            if ($request->ajax() && $e->response && $e->response->status() === 422) {
                return response()->json([
                    'message' => $e->response->json('message') ?? 'Validation error',
                    'errors'  => $e->response->json('errors') ?? [],
                ], 422);
            }
    
            return redirect()
                ->route('departments.index')
                ->with('error', 'Something went wrong while updating the department.');
        }
    }

    public function destroy($id)
    {
        try {
            $response = Http::delete(config('services.api.base_url') . "/departments/{$id}");
    
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'message' => $response->json('message') ?? 'Department deleted successfully.',
                ], $response->status());
            }
    
            return redirect()
                ->route('departments.index')
                ->with('success', $response->json('message') ?? 'Department deleted successfully.');
                
        } catch (\Illuminate\Http\Client\RequestException $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'message' => 'Failed to delete department',
                    'errors'  => $e->response?->json('errors') ?? [],
                ], $e->response?->status() ?? 500);
            }
    
            return redirect()
                ->route('departments.index')
                ->with('error', 'Something went wrong while deleting the department.');
        }
    }
}
