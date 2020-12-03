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

    public function testDateDate_InvalidDateWithRealMonths_False()
    {
        $order = new Orders();
        $order->date = "2020-02-31 23:59";
        $this->assertTrue($order->validate(['date']), 'Motivo: O regex está a validar a data como se todos os meses tivessem 31 dias');
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