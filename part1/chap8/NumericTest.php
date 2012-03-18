<?php
require_once 'Numeric.php';

class NumericTest extends PHPUnit_Framework_TestCase {
    protected $object;

    protected function setUp() {
        $this->object = new Numeric;
    }

    protected function tearDown() {}

    public function testAdd() {
        $this->assertEquals(3, $this->object->add(1,2));
    }

    public function testDiv() {
        $this->assertEquals(2, $this->object->div(4,2));
    }

    /**
     * @expectedException RuntimeException
     */
    public function testDiv2()
    {
        $this->object->div(6,0);
    }
}
?>