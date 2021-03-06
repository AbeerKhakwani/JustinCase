<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Cuisine.php";
    require_once __DIR__."/../src/Restaurant.php";
    require_once __DIR__."/../src/User.php";
    //ADD OTHER CLASSES ONCE COMPLETE [users, likes, ??]


    $app = new Silex\Application();
    $app['debug'] = true;

    //do we need session info here for users who don't sign in ?

    $DB = new PDO('pgsql:host=localhost;dbname=epifoodus');

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    /*  get routes for all user-interacted pages:
    *   main, options, choice, cuisine, all cuisines, create_user, user info
    */

    session_start();
    if (empty($_SESSION['user_id'])) {
        $_SESSION['user_id'] = null;
    };
    if (empty($_SESSION['is_admin'])) {
        $_SESSION['is_admin'] = null;
    };

    //main
    //if user is already logged in,
    $app->get("/", function() use ($app) {
        $user = User::find($_SESSION['user_id']);
        return $app['twig']->render('main.twig', array('user_id' => $_SESSION['user_id'], 'user' => $user));
    });

    //options -- randomly shows 2 restaurant options out of all restaurants
    $app->get("/options", function() use($app) {

        $restaurant_list = Restaurant::getAll();

        $two_choices = [];

        $picks = array_rand($restaurant_list, 2);

        array_push($two_choices, $restaurant_list[$picks[0]]);
        array_push($two_choices, $restaurant_list[$picks[1]]);

        $restaurant1 = $two_choices[0];
        $restaurant2 = $two_choices[1];

        return $app['twig']->render('options.twig', array('restaurant_list' => $restaurant_list, 'restaurant1' => $restaurant1, 'restaurant2' => $restaurant2));
    });

    //choice
    $app->get("/choice/{id}", function($id) use($app) {
      $current_restaurant = Restaurant::find($id);
      $cuisine = $current_restaurant->getCuisines();
      $user = User::find($_SESSION['user_id']);
      return $app['twig']->render('choice.twig', array('restaurant' => $current_restaurant, 'cuisine' => $cuisine[0], 'user' => $user));
    });

    //cuisine
    $app->get("/cuisines/{id}", function($id) use($app) {
      $current_cuisine = Cuisine::find($id);
      return $app['twig']->render('cuisine.twig', array('cuisine' => $current_cuisine, 'restaurants' => $current_cuisine->getRestaurants()));
    });

    //all cuisines
    $app->get("/cuisines", function() use($app) {
      return $app['twig']->render('cuisines.twig', array('cuisines' => Cuisine::getAll()));
    });

////////////////////////////////////////////////////////////////

/*
* ALL OF THESE ROUTES ARE HIDDEN FOR THE USER, ONLY ADMINS CAN ADD/ALTER RESTAURANTS
*/


    $app->get("/restaurant_form", function() use($app) {
        return $app['twig']->render('restaurant_form.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->post("/add_restaurant", function() use($app) {
      // needs all info for restaurant class & form. twig page currently blank
        $new_restaurant = new Restaurant(
            $_POST['name'],
            $_POST['address'],
            $_POST['phone'],
            $_POST['price'],
            $_POST['vegie'],
            $_POST['opentime'],
            $_POST['closetime']);

        $new_restaurant->save();

        //for now, do the check for dupes later bra
        $new_cuisine = $_POST['cuisine'];
        $new_restaurant->addCuisine($new_cuisine);

        return $app['twig']->render('add_restaurant.twig', array('restaurant' => $new_restaurant, 'cuisine' => $new_cuisine, 'restaurants' => Restaurant::getAll()));
    });

    //view a single restaurant
    $app->get("/restaurants/{id}", function($id) use ($app) {
      $restaurant = Restaurant::find($id);
      return $app['twig']->render('restaurant.twig', array('restaurant' => $restaurant, 'restaurants' => Restaurant::getAll()));
    });

    //all restaurants
    $app->get("/restaurants", function() use ($app) {
      return $app['twig']->render('restaurants.twig', array('restaurants' => Restaurant::getAll()));
    });

    //EDIT a restaurant
    $app->get("/restaurants/{id}/edit", function($id) use ($app) {
      $restaurant = Restaurant::find($id);
      return $app['twig']->render('restaurant_edit.twig', array('restaurant' => $restaurant));
    });

    //DELETE a restaurant
    $app->delete("/restaurants/{id}", function($id) use ($app) {
      $restaurant = Restaurant::find($id);
      $restaurant->delete();
      return $app['twig']->render('restaurants.twig', array('restaurants' => Restaurant::getAll()));
    });

    //UPDATE a restaurant
    $app->patch("/restaurants/{id}", function($id) use ($app) {
      $name = $_POST['name'];
      $address = $_POST['address'];
      $phone = $_POST['phone'];
      $opentime = $_POST['opentime'];
      $closetime = $_POST['closetime'];
      $restaurant = Restaurant::find($id);
      $restaurant->updateName($name);
      $restaurant->updateAddress($address);
      $restaurant->updatePhone($phone);
      // $price = $_POST['price'];
      // $vegie = $_POST['vegie'];
      // $restaurant->updatePrice($price);
    //   $restaurant->updateVegie($vegie);
      $restaurant->updateOpentime($opentime);
      $restaurant->updateClosetime($closetime);
      return $app['twig']->render('restaurants.twig', array('restaurant' => $restaurant, 'restaurants' => Restaurant::getAll()));
    });

/////////////////////////////////////////////////////////////
    //create user
    $app->get("/create_user", function() use($app) {
      return $app['twig']->render('create_user.twig', array('user_id' => $_SESSION['user_id'], 'exists' => 0));
    });

    //create user post route, will render profile page if user doesn't already exist, will render "create user" page with error msg if user exists already
    $app->post("/create_user", function() use($app) {
        $user = null;
        $exists = User::checkIfExists($_POST['username']);

        if ($exists == 0){
            $user = new User($_POST['username'], $_POST['password'],0,0);
            $user->save();
            $new_user_id = $user->getId();
            $_SESSION['user_id'] = $new_user_id;
            $new_user_is_admin = $user->getAdmin();
            $_SESSION['is_admin'] = $new_user_is_admin;
        }
        else {
            return $app['twig']->render('create_user.twig', array('user_exist' => $user, 'user_id' => $_SESSION['user_id'],'exists' => $exists));
        }
        return $app['twig']->render('user.twig', array('user'=>$user, 'user_id' => $_SESSION['user_id'], 'exists' => $exists));
    });

    $app->post("/logout", function() use($app) {
        $_SESSION['user_id'] = null;
        return $app['twig']->render('main.twig', array('user_id' => $_SESSION['user_id']));
    });

    $app->post("/login", function() use($app) {
        $username = $_POST['signin_username'];
        $password = $_POST['user_password'];
        $user = User::authenticatePassword($username, $password);
        if ($user) {
            $user_id= $user->getId();
            $_SESSION['user_id']=$user_id;
            $new_user_is_admin = $user->getAdmin();
            $_SESSION['is_admin'] = $new_user_is_admin;
            return $app['twig']->render('user.twig', array('user'=> $user, 'user_id' => $_SESSION['user_id'], 'is_admin' => $_SESSION['is_admin']));
        }
        else {
            return $app['twig']->render('main.twig',array('user_id' => $_SESSION['user_id']));

        }
    });
    /////////////////////////////////////////////////////////////



    //user info
    $app->get("/user/{id}", function($id) use($app) {
      $current_user = User::find($id);
      return $app['twig']->render('user.twig', array('user' => $current_user));
    });


////// FUTURE WISHLIST CODE
    // /* a route for keeping option 1 / option 2 but re-randoming the other
    // * if we keep option 1, we use array_pop to drop restaurant2 from $choices
    // * if we keep option 2, we use array_shift to drop restuarant1 from $choices
    // */
    // $app->get("/keep1", function() use($app) {
    //   array_pop($choices);
    //
    //   $restaurants = Restaurant::getAll();
    //
    //   $new_choices = array_rand($restaurants, 2);
    //
    //   $restaurant3 = $new_choices[0];
    //   $restaurant4 = $new_choices[1];
    //
    //   return $app['twig']->render('options.twig', array('restaurants' => Restaurant::getAll(), 'restaurant1' => $choices[0], 'restaurant2' => $restaurant3));
    // });
    //
    // $app->get("/keep2", function() use($app) {
    //   array_shift($choices);
    //
    //   $restaurants = Restaurant::getAll();
    //
    //   $new_choices = array_rand($restaurants, 2);
    //
    //   $restaurant3 = $new_choices[0];
    //   $restaurant4 = $new_choices[1];
    //
    //   return $app['twig']->render('options.twig', array('restaurants' => Restaurant::getAll(), 'restaurant2' => $choices[0], 'restaurant1' => $restaurant3));
    // });

    return $app;
?>
