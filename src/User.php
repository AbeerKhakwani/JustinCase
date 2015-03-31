<?php

class User
{
	private $username;
	private $password;
	private $id;
  private $vegie;
  private $admin; 


	function __construct($new_username,$new_password,$new_vegie,$new_admin, $new_id =null){
           $this->id = $new_id;
           $this->password=$new_password;
           $this->username=$new_username;
           $this->vegie=$new_vegie; 
           $this->admin= $new_admin;
	}

	function getUsername()
	{
	return $this->username;
	}
	function setUsername($new_username)
	{
	$this->username =  $new_username;
	}
	function getId()
	{
	return $this->id;
	}
	function setId($new_id)
	{
	$this->id = (int) $new_id;
	}
  function getPassword()
  {
  return $this->password;
  }
  function setPassword($new_password)
  {
   $this->password = $new_password;
  }

  function getVegie(){

    return $this->vegie;
  }
  function setVegie($new_vegie){
       $this->vegie= $new_vegie;
  }
  function getAdmin(){

    return $this->admin;
  }
  function setAdmin($new_admin){
       $this->admin= $new_admin;
  }

    function save(){  $statemnt= $GLOBALS['DB']->query("INSERT INTO users (username, password,vegie,admin) VALUES
    ('{$this->getUsername()}', '{$this->getPassword()}',{$this->getVegie()},{$this->getAdmin()}) RETURNING id;");
    $result= $statemnt->fetch(PDO::FETCH_ASSOC);
    $this->setId($result['id']);
    }
    
    static function getAll(){
       $returned_users =$GLOBALS['DB']->query("SELECT * FROM users ;");
       $users=  array();
       foreach($returned_users as $user){
       	$username=$user['username'];
       	$password=$user['password'];
        $admin=$user['admin'];
        $vegie=$user['vegie'];
       	$id=$user['id'];
       	$new_user= new User($username,$password,$vegie,$admin, $id);
       	array_push($users, $new_user);

       }

      return $users;
    }

    static function deleteAll()
    {
    	
       $GLOBALS['DB']->exec("DELETE FROM users *;");
    
    }

    static function find($search_id){
    	$returned_user =null;
    	$all_users= User::getAll();
    	foreach ($all_users as $user) {
          $user_id=$user->getId();
          if ($user_id==$search_id){
               $returned_user= $user;
          }
    	}

  return $returned_user;
    }

   function updateUsername($user_name){

	$GLOBALS['DB']->exec("UPDATE users SET username={$user_name} WHERE id={$this->getId()};");
    $this->setUsername($user_name);
   }

   function updatePassword($new_password){

	$GLOBALS['DB']->exec("UPDATE users SET password={$new_password} WHERE id={$this->getId()};");
    $this->setPassword($new_password);
   }
    function delete(){

	$GLOBALS['DB']->exec("DELETE FROM users * WHERE id={$this->getId()};");
    
   }

   function addAnswer($user_id, $res_id, $answer)
   {
   	$GLOBALS['DB']->exec(" INSERT INTO likes (answer,user_id,
   restaurant_id)  VALUES ($answer,{$this->getId()},$res_id)");

   }

   function getLikes(){
       $user_likes= $GLOBALS['DB']->exec("SELECT restaurants.*
       	FROM users JOIN likes ON  (users.id = likes.user_id)
       	JOIN restaurants ON (likes.restaurant_id = restaurants.id)
       	WHERE answer = 2 &&  user_id = {$this->getId()};");

       $likes= array();
       foreach ($user_likes as $restaurant){
         $restaurant_id=$restaurant['id'];
         $restaurant_name= $restaurant['name'];
         $restaurant_price=$restaurant['price_id'];
         $restaurant_vegetarian=$restaurant['vegie'];
         $restaurant_hours=$restaurant['hours'];

         $new_restaurant= new Restaurant();
         $array_push($likes, $new_restaurant);

       }

	return $likes;
   }



}

?>