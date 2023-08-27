<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
use Illuminate\Http\Request;

class LogActivityController extends Controller
{
    public function index() {
        // dd(LogActivity::orderBy('created_at', 'desc')->first());
        LogActivity::storeLogActivity('Membuka halaman Log Activities.', 'admin');
        $logsData = LogActivity::orderBy('created_at', 'desc')->get();
        $latestLog = $logsData->first();

        return view('admin.log_activities.index', [
            'title' => 'Log Activities',
            'logs_data' => $logsData,
            'latest_log' => $latestLog,
        ]);
    }

    public function store(Request $request) {
        LogActivity::create([
            'user_id' => null,
            'role' => $request->role,
            'activity' => $request->role == 'enabled' ? 'Mengaktifkan fitur Logging.' : 'Menonaktifkan fitur logging.',
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'ip' => $request->ip(),
            'agent' => $request->header('user-agent'), 
        ]);

        return back()->with('success', $request->role == 'enabled' ? 'Logging feature has been enabled.' : 'Logging feature has been disabled.');
    }

    public function destroy(LogActivity $logActivity) {
        LogActivity::destroy($logActivity->id);
        LogActivity::storeLogActivity('Menghapus Log Activity: #' . $logActivity->id . '.', 'admin');

        return back()->with('success', 'Log Activity: <strong>#' . $logActivity->id . '</strong> has been deleted.');
    }
}
