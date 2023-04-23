<?php
    declare(strict_types = 1);

    class Session {
        private array $messages;

        public function __construct() {
            session_start();

            $this->messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
            unset($_SESSION['messages']);
        }

        public function isLoggedIn() : bool {
            return isset($_SESSION['id']);
        }

        public function logout() {
            session_destroy();
        }

        public function getId() : ?int {
            return $_SESSION['id'];
        }

        public function getUsername() : ?string {
            return $_SESSION['username'];
        }

        public function getName() : ?string {
            return $_SESSION['name'];
        }

        public function setId(int $id) {
            $_SESSION['id'] = $id;
        }

        public function setUsername(string $username) {
            $_SESSION['username'] = $username;
        }

        public function setName(string $name) {
            $_SESSION['name'] = $name;
        }

        public function addMessage(string $type, string $text) {
            $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
        }

        public function getMessages() {
            return $this->messages;
        }
    }
?>
