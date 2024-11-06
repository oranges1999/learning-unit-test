<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;

class LoginRequestTest extends TestCase
{
    protected $rules;

    protected function setUp(): void
    {
        parent::setUp();
        $request = new LoginRequest();
        $this->rules = $request->rules();
    }
    /**
     * A basic unit test example.
     */
    #[DataProvider('provider_test_form_request_return_true')]
    public function test_form_request_return_true(array $data)
    {
        $validator = Validator::make($data, $this->rules);
        $this->assertTrue($validator->passes());
    }

    public static function provider_test_form_request_return_true()
    {
        return [
            [[
                'email' => 'test@test.com',
                'password' => '123'
            ]],
        ];
    }

    #[DataProvider('provider_test_form_request_return_false')]
    public function test_form_request_return_false(array $data)
    {
        $validator = Validator::make($data,$this->rules);
        $this->assertFalse($validator->passes());
    }

    public static function provider_test_form_request_return_false()
    {
        return [
            "email is not in right format" => [[
                'email' => 'test',
                'password' => 'password'
            ]],
            "email is an empty string" => [[
                'email' => '',
                'password' => 'password'
            ]],
            "password is an empty string" => [[
                'email' => 'test',
                'password' => ''
            ]],
            "password is null" => [[
                'email' => 'test',
                'password' => null
            ]],
            "email is null" => [[
                'email' => null,
                'password' => 'password'
            ]]
        ];
    }
}
