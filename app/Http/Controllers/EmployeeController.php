<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class EmployeeController extends Controller
{
    protected $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $employees = $this->api->get('/employees');
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $departments = $this->api->get('/departments');
        return view('employees.form', compact('departments'));
    }

    public function store(Request $request)
    {
        try {
            $response = Http::post(config('services.api.base_url') . '/employees', $request->all());
            
            if ($request->ajax()) {
                return response()->json($response->json(), $response->status());
            }
            
            return redirect()->route('employees.index')->with('success', $response->json('message') ?? 'Employee created successfully.');
    
        } catch (\Illuminate\Http\Client\RequestException $e) {
            if ($request->ajax() && $e->response && $e->response->status() === 422) {
                return response()->json([
                    'message' => $e->response->json('message') ?? 'Validation error',
                    'errors'  => $e->response->json('errors') ?? [],
                ], 422);
            }
    
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }

    public function edit($id)
    {
        $employee = $this->api->get("/employees/{$id}");
        $departments = $this->api->get('/departments');
        return view('employees.form', compact('employee', 'departments'));
    }

    public function update(Request $request, $id)
    {
        try {
            $response = Http::put(config('services.api.base_url') . "/employees/{$id}", $request->all());
    
            if ($request->ajax()) {
                return response()->json($response->json(), $response->status());
            }
    
            return redirect()
                ->route('employees.index')
                ->with('success', $response->json('message') ?? 'Employee updated successfully.');
    
        } catch (RequestException $e) {
            if ($request->ajax() && $e->response && $e->response->status() === 422) {
                return response()->json([
                    'message' => $e->response->json('message') ?? 'Validation error',
                    'errors'  => $e->response->json('errors') ?? [],
                ], 422);
            }
    
            return redirect()
                ->route('employees.index')
                ->with('error', 'Something went wrong while updating the employee.');
        }
    }

    public function destroy($id)
    {
        try {
            $response = Http::delete(config('services.api.base_url') . "/employees/{$id}");
    
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'message' => $response->json('message') ?? 'Employee deleted successfully.',
                ], $response->status());
            }
    
            return redirect()
                ->route('employees.index')
                ->with('success', 'Employee deleted successfully.');
                
        } catch (\Illuminate\Http\Client\RequestException $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'message' => 'Failed to delete employee',
                    'errors'  => $e->response?->json('errors') ?? [],
                ], $e->response?->status() ?? 500);
            }
    
            return redirect()
                ->route('employees.index')
                ->with('error', 'Something went wrong while deleting the employee.');
        }
    }
}
