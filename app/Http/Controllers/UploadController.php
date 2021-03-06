<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UploadController extends Controller
{
    public function store(Request $req): JsonResponse {
        $image = $this->renameImage($req);
//        Storage::disk('local')->put($image['filenametostore'], fopen($req->file('file'), 'r+'), 'public');
//        $caminho = public_path('/imagens');
//        $req->file('file')->move($pathToFile, $image['filenametostore']);
        Storage::disk('public')->put($image['filenametostore'], fopen($req->file('file'), 'r+'), 'public');
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function renameImage(Request $req): array {
        $username = User::find($req->input('user_id'))->username;
        $return['filenametostore'] = $username.'.pdf';
        return $return;
    }

    public function destroy(Request $req): JsonResponse {
        $array =  $req->all();
        foreach ($array as $item) {
            Storage::delete($item . '.pdf');
        }
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function download(string $username) {
        $file = null;

        $file = storage_path("app\\public\\".$username.".pdf") ;

        $headers = [
            'Content-Type' => 'application/pdf',
        ];

        return response()->download($file, $username . '.pdf', $headers);
    }
}
