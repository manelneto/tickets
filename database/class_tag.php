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

        public static function getTagById(PDO $db, int $id) : ?Tag {
            $stmt = $db->prepare('
                SELECT idTag, name
                FROM Tag
                WHERE idTag = ?
            ');

            $stmt->execute(array($id));
            $tag = $stmt->fetch();

            if (!$tag) return null;

            return new Tag(
                (int) $tag['idTag'],
                $tag['name']
            );
        }

        public static function getTagByName(PDO $db, string $name) : ?Tag {
            $stmt = $db->prepare('
                SELECT idTag, name
                FROM Tag
                WHERE name = ?
            ');

            $stmt->execute(array($name));
            $tag = $stmt->fetch();

            if (!$tag) return null;

            return new Tag(
                (int) $tag['idTag'],
                $tag['name']
            );
        }

        public static function addTag(PDO $db, string $name) : bool {
            $stmt = $db->prepare('
                INSERT INTO Tag (name)
                VALUES (?)
            ');

            try {
                $stmt->execute(array($name));
            } catch (PDOException) {
                return false;
            }
            
            return true;
        }
    }
?>
