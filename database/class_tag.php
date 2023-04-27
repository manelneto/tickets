<?php
    declare(strict_types = 1);

    class Tag {
        private int $id;
        private string $name;

        public function __construct(int $id, string $name) {
            $this->id = $id;
            $this->name = $name;
        }

        public function getId() : int {
            return $this->id;
        }

        public function getName() : string {
            return $this->name;
        }

        public function setName(string $name) {
            $this->name = $name;
        }

        public static function getTags(PDO $db) : array {
            $stmt = $db->prepare('
                SELECT idTag, name
                FROM Tag
            ');

            $stmt->execute();
            $result = $stmt->fetchAll();

            $tags = array();

            foreach ($result as $row)
                $tags[] = new Tag(
                    (int) $row['idTag'],
                    $row['name']
                );

            return $tags;
        }
        
        public static function getTag(PDO $db, int $id) : ?Tag {
            $stmt = $db->prepare('
                SELECT idTag, name
                FROM Tag
                Where idTag = ?
            ');

            $stmt->execute(array($id));
            $tag = $stmt->fetch();

            if (!$tag) return null;

            return new Tag(
                (int) $tag['idTag'],
                $tag['name']
            );
        }
    }
?>
