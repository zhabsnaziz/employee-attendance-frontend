<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class AttendanceLogController extends Controller
{
    protected $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index(Request $request)
    {
        $departments = $this->api->get('/departments');

        $params = $request->only(['start_date', 'end_date', 'department_id']);
        $logs = $this->api->get('/attendance/logs', $params);
        
        return view('attendance.logs', compact('logs', 'departments', 'params'));
    }
}
