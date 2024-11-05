<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Service\TestMethodService;
use ArgumentCountError;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;
use Throwable;

class UploadTest extends TestCase
{
    protected $service;

    protected $folder;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake();
        $this->service = new TestMethodService;
        $this->folder = 'avatars';
    }
    /**
     * A basic feature test example.
     */
    public function test_upload_using_assertTrue(): void
    {
        // Arrange 
        $file = UploadedFile::fake()->image('avatars.jpg');
        
        // Act
        $file = $this->service->upload($this->folder, $file);

        // Assert
        $this->assertTrue(Storage::exists($file));
    }

    public function test_upload_using_assertExists(): void
    {
        // Arrange 
        $file = UploadedFile::fake()->image('avatars.jpg');

        // Act
        $this->service->upload($this->folder ,$file);
        $fileHashName = $file->hashName();

        // Assert
        Storage::assertExists("$this->folder/$fileHashName");
    }

    public function test_upload_fail(): void
    {
        // Arrange 
        $file = 'dsadsadsa';

        // Act
        $throw = $this->service->upload($this->folder, $file);

        // Assert
        $this->assertInstanceOf(Throwable::class,$throw);
    }

    public function test_expect_missing_arguments(): void
    {
        // Assert
        $this->expectException(ArgumentCountError::class);
        
        // Arrange

        // Act
        $this->service->upload();
    }

    protected function tearDown(): void
    {
        $this->folder = null;
        $this->service = null;    
        parent::tearDown();
    }
}
