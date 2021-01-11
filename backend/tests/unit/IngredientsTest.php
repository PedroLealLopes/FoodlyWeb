<?php namespace backend\tests;

use common\models\Ingredients;

class IngredientsTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    
    public function testStock_isFloat_true()
    {
        $ingredient = new Ingredients();
        $ingredient->stock = 13.3;
        $this->assertTrue($ingredient->validate(['stock']));
    }
    
    public function testStock_isString_false()
    {
        $ingredient = new Ingredients();
        $ingredient->stock = "13.3";
        $this->assertTrue($ingredient->validate(['stock']));
    }

    
    public function testName_isString_true()
    {
        $ingredient = new Ingredients();
        $ingredient->name = "foo";
        $this->assertTrue($ingredient->validate(['name']));
    }

    
    public function testName_isNum_false()
    {
        $ingredient = new Ingredients();
        $ingredient->name = 13.3;
        $this->assertFalse($ingredient->validate(['name']));
    }

     
     public function testName_Has255Chars_false()
     {
         $ingredient = new Ingredients();
         $ingredient->name = "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Consectetur fugit ullam in maxime fuga libero ipsam ipsum molestias ex totam. Perspiciatis unde, ex sapiente ut accusantium deserunt quasi! Voluptatibus, ut.";
         $this->assertFalse($ingredient->validate(['name']));
     }

     
     public function testName_Limit45Chars_true()
     {
         $ingredient = new Ingredients();
         $ingredient->name = "";
         for($i = 0; $i < 45; $i++){
             $ingredient->name .= "l";
         }
         $this->assertTrue($ingredient->validate(['name']));
     }

     //criar, editar e eliminar na DB
    function testSavingIngredient()
    {
        $ingrediente = new Ingredients();
        $ingrediente->name = 'alho';
        $ingrediente->stock = 20;
        $ingrediente->save();
        $this->tester->seeInDatabase('ingredients', ['name' => 'alho']);
    }

    function testEditIngredien()
    {
        $id = $this->tester->grabRecord('common\models\Ingredients', ['name' => 'alho']);

        $ingrediente = Ingredients::findOne($id);
        $ingrediente->name = 'cebola';
        $ingrediente->save();

        $this->tester->seeRecord('common\models\Ingredients', ['name' => 'cebola']);
        $this->tester->dontSeeRecord('common\models\Ingredients', ['name' => 'alho']);
    }

    function testDeleteIngredien()
    {
        $id = $this->tester->grabRecord('common\models\Ingredients', ['name' => 'cebola']);

        $ingrediente = Ingredients::findOne($id);
        $ingrediente->delete();

        $this->tester->dontSeeRecord('common\models\Ingredients', ['name' => 'cebola']);
    }
}