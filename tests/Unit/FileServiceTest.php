<?php

namespace Tests\Unit;

use App\Service\FileService;
use ArgumentCountError;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;
use Throwable;
use TypeError;

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
    public function test_store_file_return_full_data_and_file_exist($folder, $file): void
    {
        $arrayKeys=['file_url','file_name','file_extension'];

        $fileData = $this->fileService->storeFile($file, $folder);

        foreach ($arrayKeys as $arrayKey) {
            $this->assertTrue($fileData[$arrayKey] != null);
        }
        $this->assertTrue(Storage::exists($fileData['file_url']));
    }

    public static function provider_store_file()
    {
        return [
            "image" => ['avatars',UploadedFile::fake()->create('avatars.jpg')],
            "document" => ['documents',UploadedFile::fake()->create('document.pdf')],
            "null folder" => ['',UploadedFile::fake()->create('file.docx')]
        ];
    }

    public function test_expect_type_error(): void
    {
        $this->expectException(TypeError::class);
        $folder = '';
        $file = null;

        $fileData = $this->fileService->storeFile($file, $folder);
    }

    public function test_expect_arguments_count_error(): void
    {
        $this->expectException(TypeError::class);
        // $folder = '';
        $file = UploadedFile::fake()->create('document.pdf');

        $fileData = $this->fileService->storeFile($file);
    }

    #[DataProvider('provider_delete_file')]
    public function test_delete_existing_file($folder, $file)
    {
        $fileData = $this->fileService->storeFile($file, $folder);
        
        $this->assertTrue($this->fileService->deleteFile($fileData['file_url']));
    }

    #[DataProvider('provider_delete_file')]
    public function test_delete_non_existing_file($folder, $file)
    {
        $fileData = $this->fileService->storeFile($file, $folder);
        $this->fileService->deleteFile($fileData['file_url']);

        $this->assertFalse($this->fileService->deleteFile($fileData['file_url']));
    }

    public static function provider_delete_file()
    {
        return [
            "valid data set 1" => ['avatars',UploadedFile::fake()->create('avatars.jpg')],
            "valid data set 2" => ['documents',UploadedFile::fake()->create('document.pdf')],
        ];
    }

    protected function tearDown(): void
    {
        $this->fileService = null;
        parent::tearDown();
    }
}
