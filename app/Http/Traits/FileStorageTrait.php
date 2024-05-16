<?php

namespace App\Http\Traits;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use League\Flysystem\Visibility;
use Illuminate\Support\Facades\Storage;

trait FileStorageTrait
{
    public function storeFile($file)
    {
        // $file = $request->file;
        $originalName = $file->getClientOriginalName();

        // Check for double extensions in the file name
        if (preg_match('/\.[^.]+\./', $originalName)) {
            throw new Exception(trans('general.notAllowedAction'), 403);
        }

        $fileName = Str::random(32);
        $mime_type = $file->getClientMimeType();
        $type = explode('/', $mime_type);

        // Save the file and get the path within the storage disk
        $storagePath = Storage::disk('public')->put('files', $file, [
            'visibility' => Visibility::PUBLIC,
        ]);

        // Generate the URL to access the stored file
        // $url = Storage::disk('public')->url($storagePath);

        return $storagePath;
    }
}
