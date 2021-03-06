// <?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */


    $DB = new PDO('pgsql:host=localhost;dbname=epifoodus');

	require_once "src/response.php";

	class ResponseTest extends PHPUnit_Framework_TestCase
	{
		protected function tearDown()
		{
			Response::deleteAll();
		}

	private $answer;
	private $restaurant_id;
	private $user_id;
	private $id;

		 function test_getAnswer()
        {
            //Arrange
            $answer = 1;
            $restaurant_id = 1;
            $user_id = 1;
            $id = 1;
            $test_response = new Response($answer, $restaurant_id, $user_id, $id);

            //Act
            $result = $test_response->getAnswer();

            //Assert
            $this->assertEquals($answer, $result);
        }

        function test_getRestaurantId()
        {
            //Arrange
            $answer = 1;
            $restaurant_id = 1;
            $user_id = 1;
            $id = 1;
            $test_response = new Response($answer, $restaurant_id, $user_id, $id);

            //Act
            $result = $test_response->getRestaurantId();

            //Assert
            $this->assertEquals($restaurant_id, $result);
        }

		function test_getUserId()
        {
            //Arrange
            $answer = 1;
            $restaurant_id = 1;
            $user_id = 1;
            $id = 1;
            $test_response = new Response($answer, $restaurant_id, $user_id, $id);

            //Act
            $result = $test_response->getUserId();

            //Assert
            $this->assertEquals($user_id, $result);
        }

		function test_getId()
        {
            //Arrange
            $answer = 1;
            $restaurant_id = 1;
            $user_id = 1;
            $id = 1;
            $test_response = new Response($answer, $restaurant_id, $user_id, $id);

            //Act
            $result = $test_response->getId();

            //Assert
            $this->assertEquals($id, $result);
        }

        function test_setAnswerDisike()
        {
            //Arrange
            $answer = 1;
            $restaurant_id = 1;
            $user_id = 1;
            $id = 1;
            $test_response = new Response($answer, $restaurant_id, $user_id, $id);

            //Act
            $new_answer = 0;
            $test_response->setAnswer($new_answer);
            $result = $test_response->getAnswer();

            //Assert
            $this->assertEquals($new_answer, $result);
        }

		// function test_setAnswerLike()
        // {
        //     //Arrange
        //     $answer = 1;
        //     $restaurant_id = 1;
        //     $user_id = 1;
        //     $id = 1;
        //     $test_response = new Response($answer, $restaurant_id, $user_id, $id);
        //
        //     //Act
        //     $new_answer = 2;
        //     $test_response->setAnswer($new_answer);
        //     $result = $test_response->getAnswer();
        //
        //     //Assert
        //     $this->assertEquals($new_answer, $result);
        // }

		function test_setRestaurantId()
        {
            //Arrange
            $answer = 1;
            $restaurant_id = 1;
            $user_id = 1;
            $id = 1;
            $test_response = new Response($answer, $restaurant_id, $user_id, $id);

            //Act
            $new_restaurant_id = 2;
            $test_response->setRestaurantId($new_restaurant_id);
            $result = $test_response->getRestaurantId();

            //Assert
            $this->assertEquals($new_restaurant_id, $result);
        }

		function test_setUserId()
        {
            //Arrange
            $answer = 1;
            $restaurant_id = 1;
            $user_id = 1;
            $id = 1;
            $test_response = new Response($answer, $restaurant_id, $user_id, $id);

            //Act
            $new_user_id = 2;
            $test_response->setUserId($new_user_id);
            $result = $test_response->getUserId();

            //Assert
            $this->assertEquals($new_user_id, $result);
        }

		function test_setId()
        {
            //Arrange
            $answer = 1;
            $restaurant_id = 1;
            $user_id = 1;
            $id = 1;
            $test_response = new Response($answer, $restaurant_id, $user_id, $id);

            //Act
            $new_id = 2;
            $test_response->setId($new_id);
            $result = $test_response->getId();

            //Assert
            $this->assertEquals($new_id, $result);
        }

		function test_save()
        {
            //Arrange
            $answer = 1;
            $restaurant_id = 1;
            $user_id = 1;
            $id = 1;
            $test_response = new Response($answer, $restaurant_id, $user_id, $id);
            $test_response->save();

            //Act
            $result = Response::getAll();

            //Assert
            $this->assertEquals([$test_response], $result);
        }

        function test_getAll()
        {
            //Arrange
            $answer = 1;
            $restaurant_id = 1;
            $user_id = 1;
            $id = 1;
            $test_response = new Response($answer, $restaurant_id, $user_id, $id);
            $test_response->save();

            $answer2 = 2;
            $restaurant_id2 = 2;
            $user_id2 = 2;
            $id2 = 2;
            $test_response2 = new Response($answer2, $restaurant_id2, $user_id2, $id2);
            $test_response2->save();

            //Act
            $result = Response::getAll();

            //Assert
            $this->assertEquals([$test_response, $test_response2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $answer = 1;
            $restaurant_id = 1;
            $user_id = 1;
            $id = 1;
            $test_response = new Response($answer, $restaurant_id, $user_id, $id);
            $test_response->save();

            $answer2 = 2;
            $restaurant_id2 = 2;
            $user_id2 = 2;
            $id2 = 2;
            $test_response2 = new Response($answer2, $restaurant_id2, $user_id2, $id2);
            $test_response2->save();

            //Act
            Response::deleteAll();
            $result = Response::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_update()
        {
        	//Arrange
            $answer = 1;
            $restaurant_id = 1;
            $user_id = 1;
            $id = 1;
            $test_response = new Response($answer, $restaurant_id, $user_id, $id);
            $test_response->save();
            $new_answer = 2;

            //Act
            $test_response->update($new_answer);
            $result = $test_response->getAnswer();

			//Assert
            $this->assertEquals($new_answer, $result);
        }

		function test_delete()
        {
            //Arrange
			$answer = 1;
            $restaurant_id = 1;
            $user_id = 1;
            $id = 1;
            $test_response = new Response($answer, $restaurant_id, $user_id, $id);
            $test_response->save();

            $answer2 = 2;
            $restaurant_id2 = 2;
            $user_id2 = 2;
            $id2 = 2;
            $test_response2 = new Response($answer2, $restaurant_id2, $user_id2, $id2);
            $test_response2->save();

            //Act
            $test_response->delete();
            $result = Response::getAll();

            //Assert
            $this->assertEquals([$test_response2], $result);
        }




	}

?>
