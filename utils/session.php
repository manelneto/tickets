<?php
    declare(strict_types = 1);

    class Session {
        public function __construct() {
            session_start();
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

        public function isAgent() : ?bool {
            return $_SESSION['agent'];
        }

        public function isAdmin() : ?bool {
            return $_SESSION['admin'];
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

        public function setAgent(bool $agent) {
            $_SESSION['agent'] = $agent;
        }

        public function setAdmin(bool $agent) {
            $_SESSION['admin'] = $agent;
        }
    }
?>
