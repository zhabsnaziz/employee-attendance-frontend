<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class AttendanceController extends Controller
{
    protected $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function create()
    {
        $employees = $this->api->get('/employees');
        return view('attendance.form', compact('employees'));
    }

    public function clockIn(Request $request)
    {
        try {
            $response = Http::post(config('services.api.base_url') . '/attendance/clock-in', $request->all());
    
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json($response->json(), $response->status());
            }
    
            return back()->with('success', $response->json('message') ?? 'Clock In successful.');
    
        } catch (RequestException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'message' => $e->response?->json('message') ?? 'Failed to Clock In.',
                    'errors'  => $e->response?->json('errors') ?? [],
                ], $e->response?->status() ?? 500);
            }
    
            return back()->with('error', 'Something went wrong while trying to Clock In.');
        }
    }
    
    public function clockOut(Request $request)
    {
        try {
            $response = Http::put(config('services.api.base_url') . '/attendance/clock-out', $request->all());
    
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json($response->json(), $response->status());
            }
    
            return back()->with('success', $response->json('message') ?? 'Clock Out successful.');
    
        } catch (RequestException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'message' => $e->response?->json('message') ?? 'Failed to Clock Out.',
                    'errors'  => $e->response?->json('errors') ?? [],
                ], $e->response?->status() ?? 500);
            }
    
            return back()->with('error', 'Something went wrong while trying to Clock Out.');
        }
    }
}
