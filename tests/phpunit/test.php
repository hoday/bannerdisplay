<?php

require '../../vendor/autoload.php';

class ExampleTest extends PHPUnit_Framework_TestCase
{
  /**
   * @test
   * @return [type] [description]
   */
  public function testPassesTrue()
  {
    $this->assertTrue(true);
  }

  /**
   * @test
   * @return [type] [description]
   */
  public function testPassesFalse()
  {
    $this->assertFalse(false);
  }

}
