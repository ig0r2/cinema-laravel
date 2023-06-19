<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class LogsController extends Controller
{
    private static $logFile = 'logs/users.log';
    /**
     * Get all the logs for all users.
     */
    public static function getAll(): Collection
    {
        $content = file_get_contents(storage_path(self::$logFile));
        $lines = explode("\n", $content);
        $logs = [];
        foreach ($lines as $line) {
            $json = json_decode(trim($line), true);
            if ($json) {
                $logs[] = [
                    'timestamp' => $json['datetime'],
                    'level' => $json['level'],
                    'level_name' => $json['level_name'],
                    'channel' => $json['channel'],
                    'user_id' => $json['extra']['user_id'],
                    'message' => $json['message'],
                ];
            }
        }

        return Collection::make($logs)->sortByDesc('timestamp');
    }

    /**
     * Get all the logs for a specific user.
     */
    public static function get(User $user): Collection
    {
        $logs = self::getAll();
        $logs = $logs->filter(function ($log) use ($user) {
            return $log['user_id'] == $user->id;
        });

        return $logs;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $logs = self::getAll();
        $total = $logs->count();
        $per_paage = 10;
        $page = $request->get('page', 1);
        $offset = ($page - 1) * $per_paage;
        $logs = $logs->slice($offset, $per_paage);

        $logs = new LengthAwarePaginator($logs, $total, $per_paage, $page, [
            'path' => route('admin.logs.index'),
            'query' => $request->query(),
        ]);

        return view('admin.logs.index', compact('logs'));
    }
}
