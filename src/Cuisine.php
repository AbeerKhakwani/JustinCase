<?php

    class Cuisine
    {
        private $type;
        private $id;

        function __construct($type, $id = null)
        {
            $this->type = $type;
            $this->id = $id;
        }

        function getType()
        {
            return $this->type;
        }

        function setType($new_type)
        {
            $this->type = (string) $new_type;
        }

        function getid()
        {
            return $this->id;
        }

        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO cuisines (type)
                                                VALUES ('{$this->getType()}')
                                                RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        static function getAll() //READ ALL
        {
            $returned_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisines;");
            $cuisines = [];
            foreach($returned_cuisines as $element) {
                $type = $element['type'];
                $id = $element['id'];
                $new_cuisine = new Cuisine($type, $id);
                array_push($cuisines, $new_cuisine);
            }
            return $cuisines;
        }

        static function deleteAll() //DESTROY ALL
        {
            $GLOBALS['DB']->exec("DELETE FROM cuisines *;");
        }
    }
?>
