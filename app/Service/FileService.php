<?php

namespace App\Service;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function storeFile(UploadedFile $file, $folder)
    {
        try {
            $fileUrl = Storage::putFile($folder,$file);
            $originalFileName = $file->getClientOriginalName();
            $originalFileExt = $file->getClientOriginalExtension();
            $fileData = [
                'file_url' => $fileUrl,
                'file_name' => $originalFileName,
                'file_extension' => $originalFileExt,
            ];
            return $fileData;
        } catch (\Throwable $th) {
            dd($th);
            throw $th;
        }
        
    }

    public function deleteFile($file)
    {
        if(Storage::exists($file)){
            Storage::delete($file);
            return true;
        } else {
            return false;
        }
    }
}