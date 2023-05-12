<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../database/class_user.php');
    require_once(__DIR__ . '/../database/class_department.php');
    require_once(__DIR__ . '/../database/class_priority.php');
    require_once(__DIR__ . '/../database/class_status.php');
    require_once(__DIR__ . '/../database/class_faq.php');
    require_once(__DIR__ . '/../database/class_tag.php');

    class Ticket {
        private int $id;
        private User $client;
        private string $title;
        private string $description;
        private string $dateOpened;
        private ?string $dateClosed;
        private ?User $agent;
        private ?Department $department;
        private ?Priority $priority;
        private ?Status $status;
        private ?FAQ $faq;

        public function __construct(int $id, User $client, string $title, string $description, string $dateOpened, ?string $dateClosed, ?User $agent, ?Department $department, ?Priority $priority, ?Status $status, ?FAQ $faq) {
            $this->id = $id;
            $this->client = $client;
            $this->title = $title;
            $this->description = $description;
            $this->dateOpened = $dateOpened;
            $this->dateClosed = $dateClosed;
            $this->agent = $agent;
            $this->department = $department;
            $this->priority = $priority;
            $this->status = $status;
            $this->faq = $faq;
        }

        public function getId() : int {
            return $this->id;
        }

        public function getClient() : User {
            return $this->client;
        }

        public function getTitle() : string {
            return $this->title;
        }

        public function getDescription() : string {
            return $this->description;
        }

        public function getDateOpened() : string {
            return $this->dateOpened;
        }

        public function getDateClosed() : ?string {
            return $this->dateClosed;
        }

        public function getAgent() : ?User {
            return $this->agent;
        }

        public function getDepartment() : ?Department {
            return $this->department;
        }

        public function getPriority() : ?Priority {
            return $this->priority;
        }

        public function getStatus() : ?Status {
            return $this->status;
        }

        public function getFAQ() : ?FAQ {
            return $this->faq;
        }

        public static function getTicket(PDO $db, int $id) : ?Ticket {
            $stmt = $db->prepare('
                SELECT idTicket, idClient, title, description, dateOpened, dateClosed, idAgent, idDepartment, idPriority, idStatus, idFAQ
                FROM Ticket
                WHERE idTicket = ?
            ');

            $stmt->execute(array($id));
            $ticket = $stmt->fetch();

            if (!$ticket) return null;

            return new Ticket(
                (int) $ticket['idTicket'],
                User::getUser($db, (int) $ticket['idClient']),
                $ticket['title'],
                $ticket['description'],
                $ticket['dateOpened'],
                $ticket['dateClosed'],
                User::getUser($db, (int) $ticket['idAgent']),
                Department::getDepartment($db, (int) $ticket['idDepartment']),
                Priority::getPriority($db, (int) $ticket['idPriority']),
                Status::getStatus($db, (int) $ticket['idStatus']),
                FAQ::getFAQ($db, (int) $ticket['idFAQ'])
            );
        }

        public static function getTicketsClient(PDO $db, int $id, string $after, string $before, int $department, int $priority, int $status) : array {
            $stmt = $db->prepare("
                SELECT idTicket, idClient, title, description, dateOpened, dateClosed, idAgent, idDepartment, idPriority, idStatus, idFAQ
                FROM Ticket
                WHERE (idClient = ?) 
                AND (? = '' OR dateOpened > ?) 
                AND (? = '' OR dateOpened < ?)
                AND (? = '0' OR idDepartment = ?) 
                AND (? = '0' OR idPriority = ?) 
                AND (? = '0' OR idStatus = ?) 
                ORDER BY 5 DESC, 9 DESC, 3
            ");

            $stmt->execute(array($id, $after, $after, $before, $before, $department, $department, $priority, $priority, $status, $status));
            $result = $stmt->fetchAll();

            $tickets = array();

            foreach ($result as $row)
                $tickets[] = new Ticket(
                    (int) $row['idTicket'],
                    User::getUser($db, (int) $row['idClient']),
                    $row['title'],
                    $row['description'],
                    $row['dateOpened'],
                    $row['dateClosed'],
                    User::getUser($db, (int) $row['idAgent']),
                    Department::getDepartment($db, (int) $row['idDepartment']),
                    Priority::getPriority($db, (int) $row['idPriority']),
                    Status::getStatus($db, (int) $row['idStatus']),
                    FAQ::getFAQ($db, (int) $row['idFAQ'])
                );
            
            return $tickets;
        }

        public static function getTicketsAgent(PDO $db, int $id, string $after, string $before, int $department, int $priority, int $status) : array {
            $stmt = $db->prepare("
                SELECT idTicket, idClient, title, description, dateOpened, dateClosed, idAgent, idDepartment, idPriority, idStatus, idFAQ
                FROM Ticket
                WHERE (idClient = ? OR idAgent = ? OR idDepartment IS NULL OR idDepartment IN (SELECT idDepartment FROM AgentDepartment WHERE idAgent = ?))
                AND (? = '' OR dateOpened > ?) 
                AND (? = '' OR dateOpened < ?)
                AND (? = '0' OR idDepartment = ?) 
                AND (? = '0' OR idPriority = ?) 
                AND (? = '0' OR idStatus = ?) 
                ORDER BY 5 DESC, 9 DESC, 3
            ");

            $stmt->execute(array($id, $id, $id, $after, $after, $before, $before, $department, $department, $priority, $priority, $status, $status));
            $result = $stmt->fetchAll();

            $tickets = array();

            foreach ($result as $row)
                $tickets[] = new Ticket(
                    (int) $row['idTicket'],
                    User::getUser($db, (int) $row['idClient']),
                    $row['title'],
                    $row['description'],
                    $row['dateOpened'],
                    $row['dateClosed'],
                    User::getUser($db, (int) $row['idAgent']),
                    Department::getDepartment($db, (int) $row['idDepartment']),
                    Priority::getPriority($db, (int) $row['idPriority']),
                    Status::getStatus($db, (int) $row['idStatus']),
                    FAQ::getFAQ($db, (int) $row['idFAQ'])
                );

            return $tickets;
        }

        public static function getTicketsCountByStatus(PDO $db, int $id, int $status) : int {
            $stmt = $db->prepare('
                SELECT idTicket
                FROM Ticket
                WHERE idClient = ? AND idStatus = ?
            ');

            $stmt->execute(array($id, $status));
            $result = $stmt->fetchAll();

            return count($result);
        }

        public static function addTicket(PDO $db, int $idClient, string $title, string $description, string $dateOpened, int $departmentId, array $tags) : bool {
            if ($departmentId !== 0) {
                $stmt = $db->prepare('
                    INSERT INTO Ticket (idClient, title, description, dateOpened, idDepartment)
                    VALUES (?, ?, ?, ?, ?)
                ');
                try {
                    $stmt->execute(array($idClient, $title, $description, $dateOpened, $departmentId));
                } catch (PDOException $e) {
                    return false;
                }
            } else {
                $stmt = $db->prepare('
                    INSERT INTO Ticket (idClient, title, description, dateOpened)
                    VALUES (?, ?, ?, ?)
                ');
                try {
                    $stmt->execute(array($idClient, $title, $description, $dateOpened));
                } catch (PDOException $e) {
                    return false;
                }
            }
            /* esta função parece demasiado complexa (desnecessariamente?) */
            $stmt = $db->prepare('
                SELECT max(idTicket)
                FROM Ticket
            ');
            $stmt->execute();
            $result = $stmt->fetch();
            $id = (int) $result['max(idTicket)'];

            foreach ($tags as $tag) {
                $stmt = $db->prepare('
                    INSERT INTO TicketTag (idTicket, idTag)
                    VALUES (?, ?)
                ');
                try {
                    $stmt->execute(array($id, $tag->getId()));
                } catch (PDOException $e) {
                    return false;
                }
            }

            return true;
        }

        public function edit(PDO $db, string $title, string $description) : bool {
            $stmt = $db->prepare('
                UPDATE Ticket
                SET title = ?, description = ?
                WHERE idTicket = ?
            ');

            try {
                $stmt->execute(array($title, $description, $this->id));
            } catch (PDOException $e) {
                return false;
            }
            
            $this->title = $title;
            $this->description = $description;
            return true;
        }

        public function editProperties(PDO $db, int $status, int $priority, int $department, int $agent) : bool {
            $stmt = $db->prepare('
                UPDATE Ticket
                SET idStatus = ?, idPriority = ?, idDepartment = ?, idAgent = ?
                WHERE idTicket = ?
            ');

            try {
                $stmt->execute(array($status, $priority, $department, $agent, $this->id));
            } catch (PDOException $e) {
                return false;
            }
            
            $this->status = Status::getStatus($db, $status);
            $this->priority = Priority::getPriority($db, $priority);
            $this->department = Department::getDepartment($db, $department);
            $this->agent = User::getUser($db, $agent);
            return true;
        }

        public function getTags(PDO $db) : ?array {
            $stmt = $db->prepare('
                SELECT idTag, name
                FROM TicketTag NATURAL JOIN Tag
                WHERE idTicket = ?
            ');

            $stmt->execute(array($this->id));

            $result = $stmt->fetchAll();

            $tags = array();

            foreach ($result as $row)
                $tags[] = new Tag(
                    (int) $row['idTag'],
                    $row['name'],
                );

            return $tags;
        }
    }
?>
