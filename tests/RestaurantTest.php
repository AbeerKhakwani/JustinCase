<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Restaurant.php";

    $DB = new PDO('pgsql:host=localhost;dbname=epifoodus_test');

    Class RestaurantTest extends PHPUnit_Framework_TestCase
    {
        function tearDown()
        {
            Restaurant::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Little Big Burger";
            $price_id = 1;
            $vegie = 0;
            $opentime = 0900;
            $closetime = 2100;
            $id = 1;
            $test_restaurant = new Restaurant($name, $price_id, $vegie, $opentime, $closetime, $id);

            //Act
            $result = $test_restaurant->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getPriceId()
        {
            //Arrange
            $name = "Little Big Burger";
            $price_id = 1;
            $vegie = 0;
            $opentime = 0900;
            $closetime = 2100;
            $id = 1;
            $test_restaurant = new Restaurant($name, $price_id, $vegie, $opentime, $closetime, $id);

            //Act
            $result = $test_restaurant->getPrice_id();

            //Assert
            $this->assertEquals($price_id, $result);
        }

        function test_getVegie()
        {
            //Arrange
            $name = "Little Big Burger";
            $price_id = 1;
            $vegie = 0;
            $opentime = 0900;
            $closetime = 2100;
            $id = 1;
            $test_restaurant = new Restaurant($name, $price_id, $vegie, $opentime, $closetime, $id);

            //Act
            $result = $test_restaurant->getVegie();

            //Assert
            $this->assertEquals($vegie, $result);
        }

        function test_getOpentime()
        {
            //Arrange
            $name = "Little Big Burger";
            $price_id = 1;
            $vegie = 0;
            $opentime = 0900;
            $closetime = 2100;
            $id = 1;
            $test_restaurant = new Restaurant($name, $price_id, $vegie, $opentime, $closetime, $id);

            //Act
            $result = $test_restaurant->getOpentime();

            //Assert
            $this->assertEquals($opentime, $result);
        }

        function test_getClosetime()
        {
            //Arrange
            $name = "Little Big Burger";
            $price_id = 1;
            $vegie = 0;
            $opentime = 0900;
            $closetime = 2100;
            $id = 1;
            $test_restaurant = new Restaurant($name, $price_id, $vegie, $opentime, $closetime, $id);

            //Act
            $result = $test_restaurant->getClosetime();

            //Assert
            $this->assertEquals($closetime, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Little Big Burger";
            $price_id = 1;
            $vegie = 0;
            $opentime = 0900;
            $closetime = 2100;
            $id = 1;
            $test_restaurant = new Restaurant($name, $price_id, $vegie, $opentime, $closetime, $id);

            //Act
            $result = $test_restaurant->getId();

            //Assert
            $this->assertEquals($id, $result);
        }

        function test_setId()
        {
            //Arrange
            $name = "Little Big Burger";
            $price_id = 1;
            $vegie = 0;
            $opentime = 0900;
            $closetime = 2100;
            $id = 1;
            $test_restaurant = new Restaurant($name, $price_id, $vegie, $opentime, $closetime, $id);

            //Act
            $test_restaurant->setId(2);
            $result = $test_restaurant->getId();

            //Assert
            $this->assertEquals(2, $result);
        }

        function test_save()
        {
            //Arrange
            $name = "Little Big Burger";
            $price_id = 1;
            $vegie = 0;
            $opentime = 0900;
            $closetime = 2100;
            $id = 1;
            $test_restaurant = new Restaurant($name, $price_id, $vegie, $opentime, $closetime, $id);
            $test_restaurant->save();

            //Act
            $result = Restaurant::getAll();

            //Assert
            $this->assertEquals($test_restaurant, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Little Big Burger";
            $price_id = 1;
            $vegie = 0;
            $opentime = 0900;
            $closetime = 2100;
            $id = 1;
            $test_restaurant = new Restaurant($name, $price_id, $vegie, $opentime, $closetime, $id);
            $test_restaurant->save();

            $name2 = "Kingsland";
            $price_id2 = 2;
            $vegie2 = 0;
            $opentime2 = 0800;
            $closetime2 = 2200;
            $id2 = 2;
            $test_restaurant2 = new Restaurant($name2, $price_id2, $vegie2, $opentime2, $closetime2, $id2);
            $test_restaurant2->save();

            //Act
            $result = Restaurant::getAll();

            //Assert
            $this->assertEquals([$test_restaurant, $test_restaurant2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Little Big Burger";
            $price_id = 1;
            $vegie = 0;
            $opentime = 0900;
            $closetime = 2100;
            $id = 1;
            $test_restaurant = new Restaurant($name, $price_id, $vegie, $opentime, $closetime, $id);
            $test_restaurant->save();

            $name2 = "Kingsland";
            $price_id2 = 2;
            $vegie2 = 0;
            $opentime2 = 0800;
            $closetime2 = 2200;
            $id2 = 2;
            $test_restaurant2 = new Restaurant($name2, $price_id2, $vegie2, $opentime2, $closetime2, $id2);
            $test_restaurant2->save();

            //Act
            Restaurant::deleteAll();
            $result = Restaurant::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Little Big Burger";
            $price_id = 1;
            $vegie = 0;
            $opentime = 0900;
            $closetime = 2100;
            $id = 1;
            $test_restaurant = new Restaurant($name, $price_id, $vegie, $opentime, $closetime, $id);
            $test_restaurant->save();

            $name2 = "Kingsland";
            $price_id2 = 2;
            $vegie2 = 0;
            $opentime2 = 0800;
            $closetime2 = 2200;
            $id2 = 2;
            $test_restaurant2 = new Restaurant($name2, $price_id2, $vegie2, $opentime2, $closetime2, $id2);
            $test_restaurant2->save();

            //Act
            $result = Restaurant::find($test_restaurant->getId());

            //Assert
            $this->assertEquals($test_restaurant, $result);
        }

        function test_updateName()
        {
            //Arrange
            $name = "Little Big Burger";
            $price_id = 1;
            $vegie = 0;
            $opentime = 0900;
            $closetime = 2100;
            $id = 1;
            $test_restaurant = new Restaurant($name, $price_id, $vegie, $opentime, $closetime, $id);
            $test_restaurant->save();

            $new_name = "Phat Phood";

            //Act
            $test_restaurant->updateName($new_name);

            //Assert
            $this->assertEquals($new_name, $test_restaurant->getName());
        }

        function test_updatePriceId()
        {
            //Arrange
            $name = "Little Big Burger";
            $price_id = 1;
            $vegie = 0;
            $opentime = 0900;
            $closetime = 2100;
            $id = 1;
            $test_restaurant = new Restaurant($name, $price_id, $vegie, $opentime, $closetime, $id);
            $test_restaurant->save();

            $new_price_id = 2;

            //Act
            $test_restaurant->updatePrice($new_price_id);

            //Assert
            $this->assertEquals($new_price_id, $test_restaurant->getPrice_id());
        }

        function test_updateVegie()
        {
            //Arrange
            $name = "Little Big Burger";
            $price_id = 1;
            $vegie = 0;
            $opentime = 0900;
            $closetime = 2100;
            $id = 1;
            $test_restaurant = new Restaurant($name, $price_id, $vegie, $opentime, $closetime, $id);
            $test_restaurant->save();

            $new_vegie = 1;

            //Act
            $test_restaurant->updateVegie($new_vegie);

            //Assert
            $this->assertEquals($new_vegie, $test_restaurant->getVegie());
        }

        function test_updateOpentime()
        {
            //Arrange
            $name = "Little Big Burger";
            $price_id = 1;
            $vegie = 0;
            $opentime = 0900;
            $closetime = 2100;
            $id = 1;
            $test_restaurant = new Restaurant($name, $price_id, $vegie, $opentime, $closetime, $id);
            $test_restaurant->save();

            $new_opentime = 0930;

            //Act
            $test_restaurant->updateOpentime($new_opentime);

            //Assert
            $this->assertEquals($new_opentime, $test_restaurant->getOpentime());
        }

        function test_updateClosetime()
        {
            //Arrange
            $name = "Little Big Burger";
            $price_id = 1;
            $vegie = 0;
            $opentime = 0900;
            $closetime = 2100;
            $id = 1;
            $test_restaurant = new Restaurant($name, $price_id, $vegie, $opentime, $closetime, $id);
            $test_restaurant->save();

            $new_closetime = 2200;

            //Act
            $test_restaurant->updateClosetime($new_closetime);

            //Assert
            $this->assertEquals($new_closetime, $test_restaurant->getClosetime());
        }
    }
?>
