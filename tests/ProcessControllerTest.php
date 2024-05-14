<?php

declare(strict_types=1);

namespace Tests;

use App\Controller\ProcessController;
use PHPUnit\Framework\TestCase;

class ProcessControllerTest extends TestCase
{
    public function testStore(): void
    {
        $response = (new ProcessController())->store(['name' => 'Test']);

        $this->assertNotEquals(false, $response);
        $this->assertEquals('Success', $response['message']);
        $this->assertIsArray($response['data']);
    }

    public function testIndex(): void
    {
        $response = (new ProcessController())->index();

        $this->assertNotEquals(false, $response);
        $this->assertEquals('Success', $response['message']);
        $this->assertIsArray($response['data']);
    }

    public function testShow(): void
    {
        $response = (new ProcessController())->show(1);

        $this->assertNotEquals(false, $response);
        $this->assertEquals('Success', $response['message']);
        $this->assertIsArray($response['data']);
    }

    public function testShowNotFound(): void
    {
        $response = (new ProcessController())->show(0);

        $this->assertNotEquals(false, $response);
        $this->assertEquals('Not found', $response['message']);
    }

    public function testAddFields(): void
    {
        $response = (new ProcessController())->addFields(1, [
            ['name' => 'Test', 'type' => 'number', 'value' => 1],
        ]);

        $this->assertNotEquals(false, $response);
        $this->assertEquals('Success', $response['message']);
        $this->assertIsArray($response['data']);
    }

    public function testAddFieldsInvalidType(): void
    {
        $response = (new ProcessController())->addFields(1, [
            ['name' => 'Test', 'type' => 'invalid', 'value' => 1],
        ]);

        $this->assertNotEquals(false, $response);
        $this->assertEquals('Error', $response['message']);
        $this->assertNull($response['data']);
    }
}
