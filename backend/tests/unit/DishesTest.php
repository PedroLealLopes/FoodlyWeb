<?php

namespace backend\tests;

use common\models\Dishes;
use common\models\Menus;
use Faker\Factory;

class DishesTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    //NAME TESTS
    public function testNameSize_NameGreaterThan255_False()
    {
        $dish = new Dishes();

        $dish->name =  str_repeat('a', 256);
        $this->assertFalse($dish->validate(['name']));
    }

    public function testNameSize_NameLesserThan255_True()
    {
        $dish = new Dishes();

        $dish->name =  str_repeat('a', 240);
        $this->assertTrue($dish->validate(['name']));
    }

    public function testNameString_IsNameString_True()
    {
        $dish = new Dishes();

        $dish->name =  'Foo';
        $this->assertTrue($dish->validate(['name']));
    }

    public function testNameString_IsNameInteger_False()
    {
        $dish = new Dishes();

        $dish->name =  2;
        $this->assertFalse($dish->validate(['name']));
    }

    public function testNameRequired_CanSaveWithoutName_False()
    {
        $faker = Factory::create();
        $dish = new Dishes();

        // $dish->name = $faker->name;
        $dish->description = $faker->text;
        $dish->type = 'STARTERS';
        $dish->price = $faker->randomNumber(2);
        $dish->menuId = 1;

        $this->assertFalse($dish->save());
    }

    //type TESTS
    public function testTypeString_IsTypeString_False()
    {
        $dish = new Dishes();

        $dish->type =  'foo';
        $this->assertFalse($dish->validate(['type']));
    }

    public function testTypeString_IsTypeInteger_False()
    {
        $dish = new Dishes();

        $dish->type =  2;
        $this->assertFalse($dish->validate(['type']));
    }

    public function testTypeString_IsTypeCorrectEnum_True()
    {
        $dish = new Dishes();

        $dish->type =  'STARTERS';
        $this->assertTrue($dish->validate(['type']));
    }

    public function testTypeString_IsTypeWrongEnum_False()
    {
        $dish = new Dishes();

        $dish->type =  'STARTERSSSS';
        $this->assertFalse($dish->validate(['type']));
    }

    public function testTypeRequired_CanSaveWithoutType_False()
    {
        $faker = Factory::create();
        $dish = new Dishes();

        $dish->name = $faker->name;
        $dish->description = $faker->text;
        // $dish->type = 'STARTERS';
        $dish->price = $faker->randomNumber(2);
        $dish->menuId = 1;

        $this->assertFalse($dish->save());
    }

    //price TESTS
    public function testPriceNumber_isPriceNumber_True()
    {
        $faker = Factory::create();
        $dish = new Dishes();

        $dish->price =  $faker->randomNumber(2);
        $this->assertTrue($dish->validate(['price']));
    }

    public function testPriceNumber_isPriceString_False()
    {
        $faker = Factory::create();
        $dish = new Dishes();

        $dish->price =  'foo';
        $this->assertFalse($dish->validate(['price']));
    }

    public function testPriceNumber_isPriceGreaterThan0_True()
    {
        $faker = Factory::create();
        $dish = new Dishes();

        $dish->price =  1;
        $this->assertTrue($dish->validate(['price']));
    }

    public function testPriceNumber_isPriceLowerThan0_False()
    {
        $faker = Factory::create();
        $dish = new Dishes();

        $dish->price =  -1;
        $this->assertFalse($dish->validate(['price']));
    }

    public function testPriceRequired_CanSaveWithoutPrice_False()
    {
        $faker = Factory::create();
        $dish = new Dishes();

        $dish->name = $faker->name;
        $dish->description = $faker->text;
        $dish->type = 'STARTERS';
        // $dish->price = $faker->randomNumber(2);
        $dish->menuId = 1;

        $this->assertFalse($dish->save());
    }

    //menu TESTS
    public function testMenuIdRequired_CanSaveWithoutMenuId_False()
    {
        $faker = Factory::create();
        $dish = new Dishes();

        $dish->name = $faker->name;
        $dish->description = $faker->text;
        $dish->type = 'STARTERS';
        $dish->price = $faker->randomNumber(2);
        // $dish->menuId = 1;

        $this->assertFalse($dish->save());
    }

    //criar, editar e eliminar na DB
    function testSavingDish()
    {
        $dish = new Dishes();
        $dish->type = 'STARTERS';
        $dish->price = '12.23';
        $dish->menuId = 2;
        $dish->name = 'prato principal';
        $dish->description = 'descriaoooo';
        $dish->save();
        $this->tester->seeRecord('common\models\Dishes', ['name' => 'prato principal']);
    }

    function testEditDish()
    {
        $id = $this->tester->grabRecord('common\models\Dishes', ['name' => 'prato principal']);

        $dish = Dishes::findOne($id);
        $dish->name = 'sobremesa';
        $dish->save();

        $this->tester->seeRecord('common\models\Dishes', ['name' => 'sobremesa']);
        $this->tester->dontSeeRecord('common\models\Dishes', ['name' => 'prato principal']);
    }

    function testDeleteDish()
    {
        $id = $this->tester->grabRecord('common\models\Dishes', ['name' => 'sobremesa']);

        $dish = Dishes::findOne($id);
        $dish->delete();

        $this->tester->dontSeeRecord('common\models\Dishes', ['name' => 'sobremesa']);
    }
}
