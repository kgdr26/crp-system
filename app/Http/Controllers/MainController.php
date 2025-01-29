<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use \Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Carbon;
use App\Models\user;
use Auth;
use Hash;
use Redirect;
use DB;

class MainController extends Controller
{
    function dasbor()
    {
        $data = array(
            'title' => 'Dashboard',
        );

        return view('Dashboard.list')->with($data);
    }

    function save_data(Request $request): object{
        try {
            // Validasi data
            $request->validate([
                'activity' => 'required|',
                'date' => 'required|',
                'value' => 'required|'
            ]);

            // Insert data ke database
            DB::table('trx_activity')->insert([
                'activity' => $request->activity,
                'date' => $request->date,
                'value' => $request->value,
            ]);

            return response()->json(['message' => 'Data berhasil disimpan!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    function show_data(Request $request): object{
        try {
            $year = now()->year;

            $monthlyData = DB::table('trx_activity as activity')
                ->selectRaw("
                    MONTH(activity.date) as month,
                    SUM(activity.value) as total_value,
                    target.value as target_value
                ")
                ->leftJoin('mst_target as target', DB::raw("DATE_FORMAT(activity.date, '%Y-%m')"), '=', 'target.bulan')
                ->whereYear('activity.date', $year)
                ->groupBy('month', 'target.value')
                ->orderBy('month', 'asc')
                ->get();

            // Daftar nama bulan
            $months = [
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ];

            // Susun data per bulan dengan nilai target
            $data = [];
            foreach ($months as $index => $monthName) {
                $monthData = $monthlyData->firstWhere('month', $index + 1);

                $data[] = [
                    'month' => $monthName,
                    'value' => $monthData ? (int) $monthData->total_value : null,
                    'target' => $monthData ? (int) $monthData->target_value : null,
                    'year' => $year
                ];
            }

            return response()->json([
                'year' => $year,
                'monthlyData' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    function test()
    {
        $reqbooking  = '["2024-04-27"]';
        $kategori  = 1;
        $date_start  = '2024-04-27 20:00:00';
        $date_end  = '2024-04-27 23:00:00';
        $arr = testhelper();
        echo '<pre>';
        print_r($arr);
        exit;
    }
}
