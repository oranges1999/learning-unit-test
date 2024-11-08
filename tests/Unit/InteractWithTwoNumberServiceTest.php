<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use App\Service\InteractWithTwoNumber;

class InteractWithTwoNumberServiceTest extends TestCase
{
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new InteractWithTwoNumber;
    }

    #[DataProvider('provider_test_add')]
    public function test_add($x, $y, $expect): void
    {
        // Act
        $sum = $this->service->sum($x, $y);

        //Assert
        $this->assertEquals($expect, $sum);
    }

    public static function provider_test_add()
    {
        return [
            "integer" => [1,2,3],
            "float" => [0.1,0.2,0.3],
            "fraction" => [1/2,1/3,round(5/6,4)],
            "negative integer" => [-1,-2,-3]
        ];
    }

    #[DataProvider('provider_test_subtract')]
    public function test_subtract($x, $y, $expect): void
    {
        // Act
        $sum = $this->service->subtract($x, $y);

        //Assert
        $this->assertEquals($expect, $sum);
    }

    public static function provider_test_subtract()
    {
        return [
            'integer' => [1,2,-1],
            'float' => [0.1,0.2,-0.1],
            'fraction' => [1/2,1/3,round(1/6,4)],
            'negative integer' => [-1,-2,1]
        ];
    }

    protected function tearDown(): void
    {
        $this->service = null;
        parent::tearDown();
    }
}
