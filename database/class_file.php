<?php
    declare(strict_types = 1);

    class File {
        private int $id;
        private string $name;

        public function __construct(int $id, string $name) {
            $this->id = $id;
            $this->name = $name;
        }

        public function __toString() {
            return $this->name;
        }

        public function getId() : int {
            return $this->id;
        }

        public function getName() : string {
            return $this->name;
        }

        /*public static function getFiles(PDO $db) : array {
            $stmt = $db->prepare('
                SELECT idFile, filename, idTicketFile
                FROM File
                WHERE id =...
                ORDER BY 2
            ');

            $stmt->execute();
            $result = $stmt->fetchAll();

            $files = array();

            foreach ($result as $row)
                $files[] = new File(
                    (int) $row['idFile'],
                    $row['filename']
                );

            return $files;
        }*/
    }
?>
