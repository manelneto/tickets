<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../database/class_user.php');

    class Message {
        public int $id;
        public string $date;
        public string $content;
        public User $author;

        public function __construct(int $id, string $date, string $content, User $author) {
            $this->id = $id;
            $this->date = $date;
            $this->content = $content;
            $this->author = $author;
        }

        public function getId() : int {
            return $this->id;
        }

        public function getDate() : string {
            return $this->date;
        }

        public function getContent() : string {
            return $this->content;
        }

        public function getAuthor() : User {
            return $this->author;
        }
    }
?>

