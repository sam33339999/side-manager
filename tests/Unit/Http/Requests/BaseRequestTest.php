<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\BaseRequest;
use PHPUnit\Framework\TestCase;

class BaseRequestTest extends TestCase
{
    public function test_no_error(): void
    {
        /** @var BaseRequest $baseRequest */
        $baseRequest = app(BaseRequest::class);

        $this->assertTrue(empty($baseRequest->getErrors()));
    }

    public function test_has_error(): void
    {
        /** @var BaseRequest $baseRequest */
        $baseRequest = app(BaseRequest::class);
        $this::setProperty($baseRequest, 'errors', ['test_error' => 'show my test error']);
        $this->assertFalse(empty($baseRequest->getErrors()));
    }


    public static function getProperty(&$object, $property): mixed
    {
        $reflectedClass = new \ReflectionClass($object);
        $reflection = $reflectedClass->getProperty($property);
        $reflection->setAccessible(true);
        return $reflection->getValue($object);
    }

    public static function setProperty(&$object, $property, $value): void
    {
        $reflectedClass = new \ReflectionClass($object);
        $reflectedClass->getProperty($property)->setValue($object, $value);
    }

}
