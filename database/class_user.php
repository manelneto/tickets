<?php
    declare(strict_types = 1);

    class User {
        private int $id;
        private string $firstName;
        private string $lastName;
        private string $username;
        private string $email;

        public function __construct(int $id, string $firstName, string $lastName, string $username, string $email) {
            $this->id = $id;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->username = $username;
            $this->email = $email;
        }

        public function getId() : int {
            return $this->id;
        }

        public function getFirstName() : string {
            return $this->firstName;
        }

        public function getLastName() : string {
            return $this->lastName;
        }

        public function getUsername() : string {
            return $this->username;
        }

        public function getEmail() : string {
            return $this->email;
        }

        public function getName() : string {
            return $this->firstName . ' ' . $this->lastName;
        }

        public static function getClients(PDO $db) : array {
            $stmt = $db->prepare('
                SELECT idClient, firstName, lastName, username, email
                FROM User, Client
                WHERE idUser = idClient
            ');

            $stmt->execute();
            $result = $stmt->fetchAll();

            $clients = array();

            foreach ($result as $row)
                $clients[] = new User(
                    (int) $row['idClient'],
                    $row['firstName'],
                    $row['lastName'],
                    $row['username'],
                    $row['email'],  
                );

            return $clients;
        }

        public static function getAgents(PDO $db) : array {
            $stmt = $db->prepare('
                SELECT idAgent, firstName, lastName, username, email
                FROM User, Agent
                WHERE idUser = idAgent
            ');

            $stmt->execute();
            $result = $stmt->fetchAll();

            $agents = array();

            foreach ($result as $row)
                $agents[] = new User(
                    (int) $row['idAgent'],
                    $row['firstName'],
                    $row['lastName'],
                    $row['username'],
                    $row['email'],  
                );

            return $agents;
        }

        public function isAgent(PDO $db) : bool {
            $stmt = $db->prepare('
                SELECT *
                FROM Agent
                WHERE idAgent = ?
            ');

            $stmt->execute(array($this->id));

            return (bool) $stmt->fetch();
        }

        public function isAdmin(PDO $db) : bool {
            $stmt = $db->prepare('
                SELECT *
                FROM Admin
                WHERE idAdmin = ?
            ');

            $stmt->execute(array($this->id));

            return (bool) $stmt->fetch();
        }

        public function edit(PDO $db, string $firstName, string $lastName, string $username, string $email) : bool {
            $stmt = $db->prepare('
                UPDATE User
                SET firstName = ?, lastName = ?, username = ?, email = ?
                WHERE idUser = ?
            ');

            try {
                $stmt->execute(array($firstName, $lastName, $username, $email, $this->id));
            } catch (PDOException) {
                return false;
            }
            
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->username = $username;
            $this->email = $email;
            return true;
        }

        public function editPassword(PDO $db, string $current, string $new) : bool {
            $stmt = $db->prepare('
                SELECT password
                FROM User
                WHERE idUser = ?
            ');

            try {
                $stmt->execute(array($this->id));
            } catch (PDOException) {
                return false;
            }

            $password = $stmt->fetch();

            if (!password_verify($current, $password['password']))
                return false;
            
            $update = $db->prepare('
                UPDATE User
                SET password = ?
                WHERE idUser = ?
            ');
            
            try {
                $update->execute(array(password_hash($new, PASSWORD_DEFAULT, ['cost' => 12]), $this->id));
            } catch (PDOException) {
                return false;
            }

            return true;
        }

        public static function getUser(PDO $db, int $id) : ?User {
            $stmt = $db->prepare('
                SELECT idUser, firstName, lastName, username, email
                FROM User
                WHERE idUser = ?
            ');

            $stmt->execute(array($id));
            $user = $stmt->fetch();

            if (!$user) return null;

            return new User(
                (int) $user['idUser'],
                $user['firstName'],
                $user['lastName'],
                $user['username'],
                $user['email']
            );
        }

        public static function loginUser(PDO $db, string $username, string $password) : ?User {
            $stmt = $db->prepare('
                SELECT idUser, firstName, lastName, username, email, password
                FROM User
                WHERE lower(username) = ?
            ');

            $stmt->execute(array(strtolower($username)));
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                return new User(
                    (int) $user['idUser'],
                    $user['firstName'],
                    $user['lastName'],
                    $user['username'],
                    $user['email']
                );
            } else return null;
        }

        public static function registerUser(PDO $db, string $firstName, string $lastName, string $username, string $email, string $password) : ?User {
            $options = ['cost' => 12];
                        
            $stmt = $db->prepare('
                INSERT INTO User (firstName, lastName, username, email, password)
                VALUES (?, ?, ?, ?, ?)
            ');

            try {
                $stmt->execute(array($firstName, $lastName, $username, $email, password_hash($password, PASSWORD_DEFAULT, $options)));
            } catch (PDOException) {
                return null;
            }

            return User::loginUser($db, $username, $password);
        }

        public function assignToDepartment(PDO $db, int $department) : bool {
            $stmt = $db->prepare('
                INSERT INTO AgentDepartment (idAgent, idDepartment)
                VALUES (?, ?)
            ');

            try {
                $stmt->execute(array($this->id, $department));
            } catch (PDOException) {
                return false;
            }

            return true;
        }

        public function upgradeToAgent(PDO $db) : bool {
            $stmt = $db->prepare('
                INSERT INTO Agent (idAgent)
                VALUES (?)
            ');

            try {
                $stmt->execute(array($this->id));
            } catch (PDOException) {
                return false;
            }

            return true;
        }

        public function upgradeToAdmin(PDO $db) : bool {
            $stmt = $db->prepare('
                INSERT INTO Admin (idAdmin)
                VALUES (?)
            ');

            try {
                $stmt->execute(array($this->id));
            } catch (PDOException) {
                return false;
            }

            return true;
        }
    }
?>
