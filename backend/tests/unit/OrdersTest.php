<?php namespace backend\tests;

use common\models\Orders;

class OrdersTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
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

    //criar, editar e eliminar na DB
    function testSavingOrder()
    {
        $order = new Orders();
        $order->userId = 1;
        $order->date = '2020-02-02 20:20';
        $order->save();
        $this->tester->seeInDatabase('orders', ['date' => '2020-02-02 20:20']);
    }

    function testEditOrder()
    {
        $id = $this->tester->grabRecord('common\models\Orders', ['date' => '2020-02-02 20:20']);

        $order = Orders::findOne($id);
        $order->date = ('2020-10-10 10:10');
        $order->save();

        $this->tester->seeRecord('common\models\Orders', ['date' => '2020-10-10 10:10']);
        $this->tester->dontSeeRecord('common\models\Orders', ['date' => '2020-02-02 20:20']);
    }

    function testDeleteOrder()
    {
        $id = $this->tester->grabRecord('common\models\Orders', ['date' => '2020-10-10 10:10']);

        $order = Orders::findOne($id);
        $order->delete();

        $this->tester->dontSeeRecord('common\models\Orders', ['date' => '2020-10-10 10:10']);
    }
}