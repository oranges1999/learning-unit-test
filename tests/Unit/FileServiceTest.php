<?php

namespace Tests\Unit;

use App\Service\FileService;
use ArgumentCountError;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;
use Throwable;

class FileServiceTest extends TestCase
{
    protected $fileService;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake();
        $this->fileService = new FileService();
    }
    /**
     * A basic unit test example.
     */
    #[DataProvider('provider_store_file')]
    public function test_store_file_return_full_data_and_file_exist($folder, $fileName): void
    {
        $file = UploadedFile::fake()->create($fileName);
        $arrayKeys=['file_url','file_name','file_extension'];

        $fileData = $this->fileService->storeFile($file, $folder);

        foreach ($arrayKeys as $arrayKey) {
            $this->assertTrue(array_key_exists($arrayKey,$fileData) && $fileData[$arrayKey] != null);
        }
        $this->assertTrue(Storage::exists($fileData['file_url']));
    }

    public static function provider_store_file()
    {
        return [
            "image" => ['avatars','avatars.jpg'],
            "document" => ['documents','document.pdf'],
            "without folder" => ['','file.docx']
        ];
    }

    #[DataProvider('provider_delete_file')]
    public function test_delete_existing_file($folder, $fileName)
    {
        $file = UploadedFile::fake()->create($fileName);
        $fileData = $this->fileService->storeFile($file, $folder);
        
        $this->assertTrue($this->fileService->deleteFile($fileData['file_url']));
    }

    #[DataProvider('provider_delete_file')]
    public function test_delete_non_existing_file($folder, $fileName)
    {
        $file = UploadedFile::fake()->create($fileName);
        $fileData = $this->fileService->storeFile($file, $folder);
        $this->fileService->deleteFile($fileData['file_url']);

        $this->assertFalse($this->fileService->deleteFile($fileData['file_url']));
    }

    public static function provider_delete_file()
    {
        return [
            ['avatars','avatars.jpg'],
            ['documents','document.pdf'],
        ];
    }

    protected function tearDown(): void
    {
        $this->fileService = null;
        parent::tearDown();
    }
}
