<?php

namespace App\Service;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\Exception\NoFileException;

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
            if(in_array(null,array_values($fileData))){
                throw new NoFileException();
            } else {
                return $fileData;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }

    public function deleteFile($file)
    {
        if(Storage::exists($file)){
            if(Storage::delete($file)){
                return true;
            } 
        }
        return false; 
    }
}