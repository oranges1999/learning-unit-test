<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Service\TestMethodService;

class SumTest extends TestCase
{
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new TestMethodService;
    }

    public function test_add_integer(): void
    {
        // Arrange
        $x = 1;
        $y = 2;
        $expect = 3;
        $notExpect = 4;

        // Act
        $sum = $this->service->sum($x, $y);

        //Assert
        $this->assertEquals($expect, $sum);
        $this->assertNotEquals($notExpect, $sum);
    }

    public function test_add_decimal(): void
    {
        // Arrange
        $x = 0.1;
        $y = 0.2;
        $expect = 0.3;
        $notExpect = 3;

        // Act
        $sum = $this->service->sum($x, $y);

        //Assert
        $this->assertEquals($expect, $sum);
        $this->assertNotEquals($notExpect, $sum);
    }

    protected function tearDown(): void
    {
        $this->service = null;
        parent::tearDown();
    }
}
