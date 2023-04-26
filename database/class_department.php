<?php
    declare(strict_types = 1);

    class Department {
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

        public static function getDepartments(PDO $db) : ?array {
            $stmt = $db->prepare('
                SELECT idDepartment, name
                FROM Department
            ');

            $stmt->execute();
            $result = $stmt->fetchAll();

            if (!$result) return null;

            $departments = array();

            foreach ($result as $row)
                $departments[] = new Department(
                    (int) $row['idDepartment'],
                    $row['name']
                );

            return $departments;
        }

        public static function getDepartment(PDO $db, int $id) : ?Department {
            $stmt = $db->prepare('
                SELECT idDepartment, name
                FROM Department
                Where idDepartment = ?
            ');

            $stmt->execute(array($id));
            $department = $stmt->fetch();

            if (!$department) return null;

            return new Department(
                (int) $department['idDepartment'],
                $department['name']
            );
        }
    }
?>
