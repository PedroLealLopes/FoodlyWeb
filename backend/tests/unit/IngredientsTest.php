<?php namespace backend\tests;

use app\models\Ingredients;

class IngredientsTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    // tests
    public function testStock_isFloat_true()
    {
        $ingredient = new Ingredients();
        $ingredient->stock = 13.3;
        $this->assertTrue($ingredient->validate(['stock']));
    }
    // tests
    public function testStock_isString_false()
    {
        $ingredient = new Ingredients();
        $ingredient->stock = "13.3";
        $this->assertTrue($ingredient->validate(['stock']));
    }

    // tests
    public function testName_isString_true()
    {
        $ingredient = new Ingredients();
        $ingredient->name = "foo";
        $this->assertTrue($ingredient->validate(['name']));
    }

    // tests
    public function testName_isNum_false()
    {
        $ingredient = new Ingredients();
        $ingredient->name = 13.3;
        $this->assertFalse($ingredient->validate(['name']));
    }

     // tests
     public function testName_Has255Chars_false()
     {
         $ingredient = new Ingredients();
         $ingredient->name = "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Consectetur fugit ullam in maxime fuga libero ipsam ipsum molestias ex totam. Perspiciatis unde, ex sapiente ut accusantium deserunt quasi! Voluptatibus, ut.";
         $this->assertFalse($ingredient->validate(['name']));
     }

     // tests
     public function testName_Limit45Chars_true()
     {
         $ingredient = new Ingredients();
         $ingredient->name = "";
         for($i = 0; $i < 45; $i++){
             $ingredient->name .= "l";
         }
         $this->assertTrue($ingredient->validate(['name']));
     }
}