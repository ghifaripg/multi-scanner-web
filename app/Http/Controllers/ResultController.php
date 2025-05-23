<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function show($status)
    {
        if (!in_array($status, ['safe', 'not_safe'])) {
            abort(404);
        }

        return view('result.result', [
            'status' => $status,
        ]);
    }
}

