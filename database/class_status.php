<?php
    declare(strict_types = 1);

    class Status {
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

        public static function getStatuses(PDO $db) : ?array {
            $stmt = $db->prepare('
                SELECT idStatus, name
                FROM Status
            ');

            $stmt->execute();
            $result = $stmt->fetchAll();

            if (!$result) return null;

            $statuses = array();

            foreach ($result as $row)
                $statuses[] = new Status(
                    (int) $row['idStatus'],
                    $row['name']
                );

            return $statuses;
        }
        
        public static function getStatus(PDO $db, int $id) : ?Status {
            $stmt = $db->prepare('
                SELECT idStatus, name
                FROM Status
                Where idStatus = ?
            ');

            $stmt->execute(array($id));
            $status = $stmt->fetch();

            if (!$status) return null;

            return new Status(
                (int) $status['idStatus'],
                $status['name']
            );
        }
    }
?>
