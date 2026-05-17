<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentLog;

class DocumentLogController extends Controller
{
     public function index()
    {
        $logs = DocumentLog::latest()->get();

        return view(
            'document_logs.index',
            compact('logs')
        );
    }
}
