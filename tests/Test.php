<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    /** @test */
    public function sum()
    {
        // Arrange

        // Act
        $result = 3 + 5;

        // Assert
        $this->assertEquals(8, $result);
        $this->assertNotEquals(10, $result);
    }
}
