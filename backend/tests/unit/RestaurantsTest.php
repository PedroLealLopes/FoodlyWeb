<?php

namespace backend\tests;

use common\models\Restaurant;
use Faker\Factory;
use Yii;

class RestaurantsTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    //LOCATION TESTS
    public function testLocationSize_LocationGreaterThan255_False()
    {
        $restaurant = new Restaurant();

        $restaurant->location =  str_repeat('a', 256);
        $this->assertFalse($restaurant->validate(['location']));
    }

    public function testLocationSize_LocationLesserThan255_True()
    {
        $restaurant = new Restaurant();

        $restaurant->location =  str_repeat('a', 245);
        $this->assertTrue($restaurant->validate(['location']));
    }

    public function testLocationString_IsLocationString_True()
    {
        $restaurant = new Restaurant();

        $restaurant->location =  'Foo';
        $this->assertTrue($restaurant->validate(['location']));
    }

    public function testLocationString_IsLocationInteger_False()
    {
        $restaurant = new Restaurant();

        $restaurant->location =  2;
        $this->assertFalse($restaurant->validate(['location']));
    }

    public function testLocationRequired_CanSaveWithoutLocation_False()
    {
        $faker = Factory::create();
        $restaurant = new Restaurant();

        // $restaurant->location = $faker->address;
        $restaurant->name = $faker->company;
        $restaurant->maxPeople = 20;
        $restaurant->currentPeople = 12;
        $restaurant->openingHour = $faker->time();
        $restaurant->closingHour = $faker->time();
        $restaurant->allowsPets = 1;
        $restaurant->hasVegan = 1;
        $restaurant->description = $faker->text;
        $restaurant->wifiPassword = $faker->password();

        $this->assertFalse($restaurant->save());
    }

    //NAME TESTS
    public function testNameSize_NameGreaterThan255_False()
    {
        $restaurant = new Restaurant();

        $restaurant->name =  str_repeat('a', 256);
        $this->assertFalse($restaurant->validate(['name']));
    }

    public function testNameSize_NameLesserThan255_True()
    {
        $restaurant = new Restaurant();

        $restaurant->name =  str_repeat('a', 240);
        $this->assertTrue($restaurant->validate(['name']));
    }

    public function testNameString_IsNameString_True()
    {
        $restaurant = new Restaurant();

        $restaurant->name =  'Foo';
        $this->assertTrue($restaurant->validate(['name']));
    }

    public function testNameString_IsNameInteger_False()
    {
        $restaurant = new Restaurant();

        $restaurant->name =  2;
        $this->assertFalse($restaurant->validate(['name']));
    }

    public function testNameRequired_CanSaveWithoutName_False()
    {
        $faker = Factory::create();
        $restaurant = new Restaurant();

        $restaurant->location = $faker->address;
        // $restaurant->name = $faker->company;
        $restaurant->maxPeople = 20;
        $restaurant->currentPeople = 12;
        $restaurant->openingHour = $faker->time();
        $restaurant->closingHour = $faker->time();
        $restaurant->allowsPets = 1;
        $restaurant->hasVegan = 1;
        $restaurant->description = $faker->text;
        $restaurant->wifiPassword = $faker->password();
        
        $this->assertFalse($restaurant->save());
    }

    //MAXPEOPLE TESTS
    public function testMaxPeopleInteger_isMaxPeopleInteger_True()
    {
        $restaurant = new Restaurant();

        $restaurant->maxPeople =  2;
        $this->assertTrue($restaurant->validate(['maxPeople']));
    }

    public function testMaxPeopleInteger_isMaxPeopleString_False()
    {
        $restaurant = new Restaurant();

        $restaurant->maxPeople =  "Foo";
        $this->assertFalse($restaurant->validate(['maxPeople']));
    }

    public function testMaxPeopleRule_isMaxPeopleGreaterThanCurrentPeople_True()
    {
        $restaurant = new Restaurant();

        $restaurant->maxPeople =  20;
        $restaurant->currentPeople =  10;
        $this->assertTrue($restaurant->validate(['maxPeople']));
    }


    public function testMaxPeopleRule_isMaxPeopleLesserThanCurrentPeople_False()
    {
        $restaurant = new Restaurant();

        $restaurant->maxPeople =  5;
        $restaurant->currentPeople =  10;
        $this->assertFalse($restaurant->validate(['maxPeople']));
    }

    public function testMaxPeopleRequired_CanSaveWithoutMaxPeople_False()
    {
        $faker = Factory::create();
        $restaurant = new Restaurant();

        $restaurant->location = $faker->address;
        $restaurant->name = $faker->company;
        // $restaurant->maxPeople = 20;
        $restaurant->currentPeople = 12;
        $restaurant->openingHour = $faker->time();
        $restaurant->closingHour = $faker->time();
        $restaurant->allowsPets = 1;
        $restaurant->hasVegan = 1;
        $restaurant->description = $faker->text;
        $restaurant->wifiPassword = $faker->password();

        $this->assertFalse($restaurant->save());
    }

    //CurrentPeople TESTS
    public function testCurrentPeopleInteger_isCurrentPeopleInteger_True()
    {
        $restaurant = new Restaurant();

        $restaurant->currentPeople = 10;
        //Not sure why It requires max people, but on the max people test It did not require currentPeople
        $restaurant->maxPeople = 20;
        $this->assertTrue($restaurant->validate(['currentPeople']));
    }

    public function testCurrentPeopleInteger_isCurrentPeopleString_False()
    {
        $restaurant = new Restaurant();

        $restaurant->currentPeople =  "Foo";
        $this->assertFalse($restaurant->validate(['currentPeople']));
    }

    public function testCurrentPeopleRequired_CanSaveWithoutCurrentPeople_False()
    {
        $faker = Factory::create();
        $restaurant = new Restaurant();

        $restaurant->location = $faker->address;
        $restaurant->name = $faker->company;
        $restaurant->maxPeople = 20;
        // $restaurant->currentPeople = 12;
        $restaurant->openingHour = $faker->time();
        $restaurant->closingHour = $faker->time();
        $restaurant->allowsPets = 1;
        $restaurant->hasVegan = 1;
        $restaurant->description = $faker->text;
        $restaurant->wifiPassword = $faker->password();

        $this->assertFalse($restaurant->save());
    }

    //allowsPets TESTS
    public function testAllowPets_isAllowPetsInteger_False()
    {
        $restaurant = new Restaurant();

        $restaurant->allowsPets = 3;
        $this->assertFalse($restaurant->validate(['allowsPets']));
    }

    public function testAllowPets_isAllowPetsBoolean0_True()
    {
        $restaurant = new Restaurant();

        $restaurant->allowsPets = 0;
        $this->assertTrue($restaurant->validate(['allowsPets']));
    }

    public function testAllowPets_isAllowPetsBoolean1_True()
    {
        $restaurant = new Restaurant();

        $restaurant->allowsPets = 1;
        $this->assertTrue($restaurant->validate(['allowsPets']));
    }


    public function testAllowPetsRequired_CanSaveWithoutAllowPets_False()
    {
        $faker = Factory::create();
        $restaurant = new Restaurant();

        $restaurant->location = $faker->address;
        $restaurant->name = $faker->company;
        $restaurant->maxPeople = 20;
        $restaurant->currentPeople = 12;
        $restaurant->openingHour = $faker->time();
        $restaurant->closingHour = $faker->time();
        // $restaurant->allowsPets = 1;
        $restaurant->hasVegan = 1;
        $restaurant->description = $faker->text;
        $restaurant->wifiPassword = $faker->password();

        $this->assertFalse($restaurant->save());
    }

    //HasVegan TESTS
    public function testHasVegan_isHasVeganInteger_False()
    {
        $restaurant = new Restaurant();

        $restaurant->hasVegan = 3;
        $this->assertFalse($restaurant->validate(['hasVegan']));
    }

    public function testHasVegan_isHasVeganBoolean0_True()
    {
        $restaurant = new Restaurant();

        $restaurant->hasVegan = 0;
        $this->assertTrue($restaurant->validate(['hasVegan']));
    }

    public function testHasVegan_isHasVeganBoolean1_True()
    {
        $restaurant = new Restaurant();

        $restaurant->hasVegan = 1;
        $this->assertTrue($restaurant->validate(['hasVegan']));
    }


    public function testHasVeganRequired_CanSaveWithoutHasVegan_False()
    {
        $faker = Factory::create();
        $restaurant = new Restaurant();

        $restaurant->location = $faker->address;
        $restaurant->name = $faker->company;
        $restaurant->maxPeople = 20;
        $restaurant->currentPeople = 12;
        $restaurant->openingHour = $faker->time();
        $restaurant->closingHour = $faker->time();
        $restaurant->allowsPets = 1;
        // $restaurant->hasVegan = 1;
        $restaurant->description = $faker->text;
        $restaurant->wifiPassword = $faker->password();

        $this->assertFalse($restaurant->save());
    }

    //description TESTS
    public function testDescriptionString_IsDescriptionString_True()
    {
        $restaurant = new Restaurant();

        $restaurant->description =  'Foo';
        $this->assertTrue($restaurant->validate(['description']));
    }

    public function testDescriptionString_IsDescriptionInteger_False()
    {
        $restaurant = new Restaurant();

        $restaurant->description =  2;
        $this->assertFalse($restaurant->validate(['description']));
    }

    public function testDescriptionRequired_CanSaveWithoutDescription_False()
    {
        $faker = Factory::create();
        $restaurant = new Restaurant();

        $restaurant->location = $faker->address;
        $restaurant->name = $faker->company;
        $restaurant->maxPeople = 20;
        $restaurant->currentPeople = 12;
        $restaurant->openingHour = $faker->time();
        $restaurant->closingHour = $faker->time();
        $restaurant->allowsPets = 1;
        $restaurant->hasVegan = 1;
        // $restaurant->description = $faker->text;
        $restaurant->wifiPassword = $faker->password();

        $this->assertFalse($restaurant->save());
    }

    //wifiPassword TESTS
    public function testWifiPassword_WifiPasswordGreaterThan255_False()
    {
        $restaurant = new Restaurant();

        $restaurant->wifiPassword =  str_repeat('a', 256);
        $this->assertFalse($restaurant->validate(['wifiPassword']));
    }

    public function testWifiPasswordSize_WifiPasswordLesserThan255_True()
    {
        $restaurant = new Restaurant();

        $restaurant->wifiPassword =  str_repeat('a', 240);
        $this->assertTrue($restaurant->validate(['wifiPassword']));
    }

    public function testWifiPasswordString_IsWifiPasswordString_True()
    {
        $restaurant = new Restaurant();

        $restaurant->wifiPassword =  'Foo';
        $this->assertTrue($restaurant->validate(['wifiPassword']));
    }

    public function testWifiPasswordString_IsWifiPasswordInteger_False()
    {
        $restaurant = new Restaurant();

        $restaurant->wifiPassword =  2;
        $this->assertFalse($restaurant->validate(['wifiPassword']));
    }

    public function testWifiPasswordRequired_CanSaveWithoutWifiPassword_False()
    {
        $faker = Factory::create();
        $restaurant = new Restaurant();

        $restaurant->location = $faker->address;
        $restaurant->name = $faker->company;
        $restaurant->maxPeople = 20;
        $restaurant->currentPeople = 12;
        $restaurant->openingHour = $faker->time();
        $restaurant->closingHour = $faker->time();
        $restaurant->allowsPets = 1;
        $restaurant->hasVegan = 1;
        $restaurant->description = $faker->text;
        // $restaurant->wifiPassword = $faker->password();
        
        $this->assertFalse($restaurant->save());
    }

    //criar, editar e eliminar na DB
    function testSavingRestaurant()
    {
        $restaurant = new Restaurant();

        $restaurant->location = 'Leiria';
        $restaurant->name = 'Foo';
        $restaurant->maxPeople = 20;
        $restaurant->currentPeople = 12;
        $restaurant->openingHour = '10:00:00';
        $restaurant->closingHour = '20:00:00';
        $restaurant->allowsPets = 1;
        $restaurant->hasVegan = 1;
        $restaurant->description = 'descricaooo';
        $restaurant->wifiPassword = 'awdd234//424';
        $restaurant->save();
        $this->tester->seeInDatabase('restaurant', ['name' => 'Foo']);
    }

    function testEditRestaurant()
    {
        $id = $this->tester->grabRecord('common\models\Restaurant', ['name' => 'Foo']);

        $restaurant = Restaurant::findOne($id);
        $restaurant->name = 'pizza';
        $restaurant->save();

        $this->tester->seeRecord('common\models\Restaurant', ['name' => 'pizza']);
        $this->tester->dontSeeInDatabase('restaurant', ['name' => 'Foo']);
    }

    function testDeleteRestaurant()
    {
        $id = $this->tester->grabRecord('common\models\Restaurant', ['name' => 'pizza']);

        $restaurant = Restaurant::findOne($id);
        $restaurant->delete();

        $this->tester->dontSeeRecord('common\models\Restaurant', ['name' => 'pizza']);
    }
}
