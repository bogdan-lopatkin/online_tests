<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFile;
use App\Models\Test;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

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

    public function storeAvatar(Request $request)
    {
        $url = Storage::disk('s3')->put('/storage/Avatars', $request->file('img'));

      //  $url = $request->file('img')->store('Avatars' ,'public');
        $user = User::find(auth()->id());
        $user->avatar_url  =  $url;
        $user->save();
        return redirect(URL::previous());
    }
}
