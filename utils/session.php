<?php
    declare(strict_types = 1);

    class Session {
        private array $messages;

        public function __construct() {
            session_start();

            $this->messages = $_SESSION['messages'] ?? array();
            unset($_SESSION['messages']);
        }

        public function isLoggedIn() : bool {
            return isset($_SESSION['id']);
        }

        public function logout() : void {
            session_destroy();
        }

        public function getId() : ?int {
            return $_SESSION['id'] ?? null;
        }

        public function getName() : ?string {
            return $_SESSION['name'] ?? null;
        }

        public function isAgent() : ?bool {
            return $_SESSION['agent'] ?? null;
        }

        public function isAdmin() : ?bool {
            return $_SESSION['admin'] ?? null;
        }

        public function setId(int $id) : void {
            $_SESSION['id'] = $id;
        }

        public function setName(string $name) : void {
            $_SESSION['name'] = $name;
        }

        public function setAgent(bool $agent) : void {
            $_SESSION['agent'] = $agent;
        }

        public function setAdmin(bool $admin) : void {
            $_SESSION['admin'] = $admin;
        }

        public function getMessages() : array {
            return $this->messages;
        }

        public function addMessage(string $type, string $text) : void {
            $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
        }
    }
?>
