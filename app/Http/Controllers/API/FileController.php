<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFile;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function store(StoreFile $request)
    {
        $testId = Test::select('id')->get()->max()->id;
        return $request->file('file')->store('test_' . $testId,'public');
    }

    public function destroy(Request $request)
    {
        foreach ($request->json()->all() as $file)
            if(Storage::disk('public')->exists($file))
                Storage::disk('public')->delete($file);
    }
}
