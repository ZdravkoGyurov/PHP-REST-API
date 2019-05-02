<?php
    class User {
        private $connection;
        private $table = 'users';

        public $email;
        public $name;
        public $surname;
        public $password;
        public $roleId;
        public $type;

        public function __construct($connection) {
            $this->connection = $connection;
        }

        public function createUser() {
            $query = "INSERT INTO ". $this->table ." SET email=:email, name=:name, surname=:surname, password=:password, roleId=:roleId";

            $statement = $this->connection->prepare($query);

            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->surname = htmlspecialchars(strip_tags($this->surname));
            $this->password = htmlspecialchars(strip_tags($this->password));
            $this->roleId = htmlspecialchars(strip_tags($this->roleId));
            $this->type = htmlspecialchars(strip_tags($this->type));
                                    
            $statement->bindParam(":email", $this->email);
            $statement->bindParam(":name", $this->name);
            $statement->bindParam(":surname", $this->surname);
            $statement->bindParam(":password", $this->password);
            $statement->bindParam(":roleId", $this->roleId);
            
            try {
                $statement->execute();
                return true;
            } catch(PDOException $e) {
                return false;
            }
        }

        public function findUserByEmail() {
            $query = 'SELECT u.email, u.name, u.surname, u.password, u.roleId, r.type
            FROM roles r JOIN ' . $this->table . ' u ON r.role_id = u.roleId WHERE u.email =:email';

            $statement = $this->connection->prepare($query);

            $statement->bindParam(":email", $this->email);

            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            $this->email = $row['email'];
            $this->name = $row['name'];
            $this->surname = $row['surname'];
            $this->password = $row['password'];
            $this->roleId = $row['roleId'];
            $this->type = $row['type'];
            
            return $this;
        }

        public function findAllUsers() {
            $query = 'SELECT u.email, u.name, u.surname, u.password, u.roleId, r.type
            FROM roles r JOIN ' . $this->table . ' u ON r.role_id = u.roleId';

            $statement = $this->connection->prepare($query);

            $statement->execute();

            return $statement;
        }

        public function removeUser() {
            $query = "DELETE FROM ". $this->table ." WHERE email=:email";

            $statement = $this->connection->prepare($query);

            $this->email = htmlspecialchars(strip_tags($this->email));

            $statement->bindParam(":email", $this->email);

            try {
                $statement->execute();
                return true;
            } catch(PDOException $e) {
                return false;
            }
        }
    }
