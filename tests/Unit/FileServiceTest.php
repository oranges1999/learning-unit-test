<?php

namespace Tests\Unit;

use App\Service\FileService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\File\Exception\NoFileException;
use Tests\TestCase;
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

    #[DataProvider('provider_store_file')]
    public function test_returned_array_contains_necessary_keys($folder, $file)
    {
         // Arrange
         $arrayKeys=['file_url','file_name','file_extension'];

         // Act
         $fileData = $this->fileService->storeFile($file, $folder);
 
         // Assert
         $this->assertSame($arrayKeys, array_keys($fileData));
    }

    #[DataProvider('provider_store_file')]
    public function test_returned_array_not_have_null_value($folder, $file)
    {
        // Act
        $fileData = $this->fileService->storeFile($file, $folder);

        // Assert
        $this->assertFalse(in_array(null,array_values($fileData)));
    }

    #[DataProvider('provider_store_file')]
    public function test_stored_file_exist($folder, $file): void
    {
        // Act
        $fileData = $this->fileService->storeFile($file, $folder);

        // Assert
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

    public function test_expect_no_file_exception()
    {
        $this->expectException(NoFileException::class);
        $folder = '';
        $file = UploadedFile::fake()->create('');

        $this->fileService->storeFile($file,$folder);
    }

    public function test_expect_type_error(): void
    {
        $this->expectException(TypeError::class);
        $folder = '';
        $file = null;

        $this->fileService->storeFile($file, $folder);
    }

    public function test_expect_arguments_count_error(): void
    {
        $this->expectException(TypeError::class);

        $file = UploadedFile::fake()->create('document.pdf');

        $this->fileService->storeFile($file);
    }
    
    public function test_delete_existing_file()
    {
        Storage::shouldReceive('exists')->once()->andReturnTrue();
        Storage::shouldReceive('delete')->once()->with('file.jpg')->andReturnTrue();
        $this->assertTrue($this->fileService->deleteFile('file.jpg'));
    }

    public function test_delete_non_existing_file()
    {
        $this->assertFalse($this->fileService->deleteFile('file.jpg'));
    }

    protected function tearDown(): void
    {
        $this->fileService = null;
        parent::tearDown();
    }
}
