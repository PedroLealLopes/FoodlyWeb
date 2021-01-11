<?php namespace backend\tests;

use common\models\Profiles;

class ProfilesTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    
    public function testUserId_isIntAndExists_True()
    {
        $profile = new Profiles();
        //it must exist a user id 1 in profiles table;
        $profile->userId = 1;
        $this->assertTrue($profile->validate(["userId"]));
    }
    
    public function testUserId_isIntAndNotExists_False()
    {
        $profile = new Profiles();
        //it must not exist a user id -1 in profiles table;
        $profile->userId = -1;
        $this->assertFalse($profile->validate(["userId"]));
    }
    
    public function testUserId_isString_False()
    {
        $profile = new Profiles();
        $profile->userId = "foo";
        $this->assertFalse($profile->validate(["userId"]));
    }
     
     public function testFullName_isString_True()
     {
         $profile = new Profiles();
         $profile->fullname = "foo";
         $this->assertTrue($profile->validate(["fullname"]));
     } 
     
     public function testFullName_isNum_False()
     {
         $profile = new Profiles();
         $profile->fullname = 13;
         $this->assertFalse($profile->validate(["fullname"]));
     }

     public function testFullName_isBoolean_False()
     {
         $profile = new Profiles();
         $profile->fullname = false;
         $this->assertFalse($profile->validate(["fullname"]));
     }

     public function testFullName_isNull_False()
     {
         $profile = new Profiles();
         $profile->fullname = null;
         $this->assertFalse($profile->validate(["fullname"]));
     }

     public function testAge_isNull_False()
     {
         $profile = new Profiles();
         $profile->age = null;
         $this->assertFalse($profile->validate(["age"]));
     }

     public function testAge_isInt_True()
     {
         $profile = new Profiles();
         $profile->age = 18;
         $this->assertTrue($profile->validate(["age"]));
     }

     public function testAge_isString_False()
     {
         $profile = new Profiles();
         $profile->age = "null";
         $this->assertFalse($profile->validate(["age"]));
     }

     public function testAge_isFloat_False()
     {
         $profile = new Profiles();
         $profile->age = 13.3;
         $this->assertFalse($profile->validate(["age"]));
     }

     public function testAlergias_isString_True()
     {
         $profile = new Profiles();
         $profile->alergias = "pickles";
         $this->assertTrue($profile->validate(["alergias"]));
     }

     public function testAlergias_isNum_False()
     {
         $profile = new Profiles();
         $profile->alergias = 18;
         $this->assertFalse($profile->validate(["alergias"]));
     }

     public function testAlergias_isNull_True()
     {
         $profile = new Profiles();
         $profile->alergias = null;
         $this->assertTrue($profile->validate(["alergias"]));
     }

     public function testGenero_isCharM_True()
     {
         $profile = new Profiles();
         $profile->genero = "M";
         $this->assertTrue($profile->validate(["genero"]));
     }

     public function testGenero_isCharF_True()
     {
         $profile = new Profiles();
         $profile->genero = "F";
         $this->assertTrue($profile->validate(["genero"]));
     }

     public function testGenero_isAnyChar_False()
     {
         $profile = new Profiles();
         $profile->genero = "P";
         $this->assertFalse($profile->validate(["genero"]));
     }

     public function testGenero_isNull_true()
     {
         $profile = new Profiles();
         $profile->genero = null;
         $this->assertTrue($profile->validate(["genero"]));
     }

    /* //criar, editar e eliminar na DB
    function testSavingProfile()
    {
        $profile = new Profiles();
        $profile->userId = 1;
        $profile->fullname = 'Nome Completo';
        $profile->age = 20;
        $profile->alergias = 'Nenhumas';
        $profile->genero = 'M';
        $profile->save();
        $this->tester->seeInDatabase('profiles', ['fullname' => 'Nome Completo']);
    }

    function testEditProfile()
    {
        $id = $this->tester->grabRecord('common\models\Profiles', ['fullname' => 'Nome Completo']);

        $profile = Profiles::findOne($id);
        $profile->fullname = ('Nome Completo Editado');
        $profile->save();

        $this->tester->seeRecord('common\models\Profiles', ['fullname' => 'Nome Completo Editado']);
        $this->tester->dontSeeRecord('common\models\Profiles', ['fullname' => 'Nome Completo']);
    }

    function testDeleteProfile()
    {
        $id = $this->tester->grabRecord('common\models\Profiles', ['fullname' => 'Nome Completo Editado']);

        $profile = Profiles::findOne($id);
        $profile->delete();

        $this->tester->dontSeeRecord('common\models\Profiles', ['fullname' => 'Nome Completo Editado']);
    }*/
}