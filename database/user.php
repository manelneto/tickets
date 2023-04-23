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

        public function getId() {
            return $this->id;
        }

        public function getFirstName() {
            return $this->firstName;
        }

        public function getLastName() {
            return $this->lastName;
        }

        public function getUsername() {
            return $this->username;
        }

        public function getEmail() {
            return $this->email;
        }

        public function getName() {
            return $this->firstName . ' ' . $this->lastName;
        }

        public static function loginUser(PDO $db, string $username, string $password) : ?User {
            $stmt = $db->prepare('
                SELECT idUser, firstName, lastName, username, email
                FROM User
                WHERE lower(username) = ? AND password = ?
            ');

            $stmt->execute(array(strtolower($username), $password));

            if ($user = $stmt->fetch()) {
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
            $stmt = $db->prepare('
                INSERT INTO User (firstName, lastName, username, email, password)
                VALUES (?, ?, ?, ?, ?)
            ');

            try {
                $stmt->execute(array($firstName, $lastName, $username, $email, $password));
            } catch (PDOException $e) {
                return null;
            }

            return User::loginUser($db, $username, $password);
        }
    }
?>
