<?php namespace common\tests;

use common\models\Orders;

class OrderTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    public function testDateDate_InvalidDateWithFalseMonths_False()
    {
        $order = new Orders();
        $order->date = "2020-13-19 23:59";
        $this->assertFalse($order->validate(['date']));
    }

    public function testDateDate_ValidDate_True()
    {
        $order = new Orders();
        $order->date = "2020-12-30 23:59";
        $this->assertTrue($order->validate(['date']));
    }

    public function testUserId_isUserIdString_False()
    {
        $order = new Orders();
        $order->userId = "Nome de Pessoa";
        $this->assertFalse($order->validate(['userId']));
    }

    public function testUserId_isUserIdInt_True()
    {
        $order = new Orders();
        $order->userId = 1;
        $this->assertTrue($order->validate(['userId']));
    }
}