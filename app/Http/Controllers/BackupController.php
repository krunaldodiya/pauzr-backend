<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class BackupController extends Controller
{
    public function backupList(Request $request)
    {
        $disk = Storage::disk('backup');

        $backups = $disk->allFiles();

        return view('backup', ['backups' => $backups]);
    }

    public function backupRun(Request $request)
    {
        $output = Artisan::call('backup:run', []);

        return redirect("/backup/list?status=$output");
    }

    public function backupClean(Request $request)
    {
        $output = Artisan::call('backup:clean', []);

        return redirect("/backup/list?status=$output");
    }

    public function backupDownload(Request $request)
    {
        $file = $request->file;

        $headers = array('Content-Type' => 'application/octet-stream');

        return response()->download(storage_path("app/backup/$file"), $file, $headers);
    }
}
