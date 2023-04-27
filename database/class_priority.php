<?php
    declare(strict_types = 1);

    class Priority {
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

        public static function getPriorities(PDO $db) : array {
            $stmt = $db->prepare('
                SELECT idPriority, name
                FROM Priority
            ');

            $stmt->execute();
            $result = $stmt->fetchAll();

            $priorities = array();

            foreach ($result as $row)
                $priorities[] = new Priority(
                    (int) $row['idPriority'],
                    $row['name']
                );

            return $priorities;
        }

        public static function getPriority(PDO $db, int $id) : ?Priority {
            $stmt = $db->prepare('
                SELECT idPriority, name
                FROM Priority
                Where idPriority = ?
            ');

            $stmt->execute(array($id));
            $priority = $stmt->fetch();

            if (!$priority) return null;

            return new Priority(
                (int) $priority['idPriority'],
                $priority['name']
            );
        }

        public static function addPriority(PDO $db, string $name) : bool {
            $stmt = $db->prepare('
                INSERT INTO Priority (name)
                VALUES (?)
            ');

            try {
                $stmt->execute(array($name));
            } catch (PDOException e) {
                return false;
            }
            
            return true;
        }
    }
?>
