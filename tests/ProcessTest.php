<?php

namespace Tests;

use App\Model\Process;
use App\Model\ProcessField;
use PHPUnit\Framework\TestCase;

class ProcessTest extends TestCase
{
    public function testGetId()
    {
        $process = new Process(1, 'Test Process');

        $this->assertEquals(1, $process->getId());
    }

    public function testGetName()
    {
        $process = new Process(1, 'Test Process');

        $this->assertEquals('Test Process', $process->getName());
    }

    public function testSetName()
    {
        $process = new Process(1, 'Test Process');
        $process->create();

        $process->setName('New Process');
        $process->save();

        $this->assertEquals('New Process', $process->getName());
    }

    public function testGetFields()
    {
        $process = new Process(1, 'Test Process');

        // for (int $i; $i < 5; $i++) {
        //     $process->addField(new ProcessField("Field {$i}"));
        // }

        $process->create();
        $fields = $process->getFields();

        $this->assertIsArray($fields);
        $this->assertCount(0, $fields);
    }
}
