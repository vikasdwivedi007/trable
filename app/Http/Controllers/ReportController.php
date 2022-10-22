<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Report;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    private $prefix = 'reports.';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', Report::class);
        $hotels = Hotel::all();
        return view($this->prefix . 'index', compact('hotels'));
    }

    public function getReport($report_type)
    {
        $this->authorize('viewAny', Report::class);
        $year = null;
        if (request('year')) {
            $year = request('year');
        }
        switch ($report_type) {
            case 'files-report':
                $data = Report::getJobFilesReport($year);
                return response()->json(['success' => true, 'data' => $data]);
                break;
            case 'clients':
                $data = Report::getClientsReport($year);
                return response()->json(['success' => true, 'data' => $data]);
                break;
            case 'rooms':
                $data = Report::getRoomsReport(request('hotel_id'), $year);
                return response()->json(['success' => true, 'data' => $data]);
                break;
            default:
                return response()->json(['success' => false, 'message' => 'Invalid report type']);
                break;
        }
    }
}
