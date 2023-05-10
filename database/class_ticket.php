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
        private string $content;
        private string $dateOpened;
        private string $dateDue;
        private ?string $dateClosed;
        private ?User $agent;
        private ?Department $department;
        private ?Priority $priority;
        private ?Status $status;
        private ?FAQ $faq;

        public function __construct(int $id, User $client, string $title, string $content, string $dateOpened, string $dateDue, ?string $dateClosed, ?User $agent, ?Department $department, ?Priority $priority, ?Status $status, ?FAQ $faq) {
            $this->id = $id;
            $this->client = $client;
            $this->title = $title;
            $this->content = $content;
            $this->dateOpened = $dateOpened;
            $this->dateDue = $dateDue;
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

        public function getContent() : string {
            return $this->content;
        }

        public function getDateOpened() : string {
            return $this->dateOpened;
        }

        public function getDateDue() : string {
            return $this->dateDue;
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

        public function setClient(User $client) {
            $this->client = $client;
        }

        public function setTitle(string $title) {
            $this->title = $title;
        }

        public function setContent(string $content) {
            $this->content = $content;
        }

        public function setDateOpened(string $dateOpened) {
            $this->dateOpened = $dateOpened;
        }

        public function setDateDue(string $dateDue) {
            $this->dateDue = $dateDue;
        }

        public function setDateClosed(string $dateClosed) {
            $this->dateClosed = $dateClosed;
        }

        public function setAgent(User $agent) {
            $this->agent = $agent;
        }

        public function setDepartment(Department $department) {
            $this->department = $department;
        }

        public function setPriority(Priority $priority) {
            $this->priority = $priority;
        }

        public function setStatus(Status $status) {
            $this->status = $status;
        }

        public function setFAQ(FAQ $faq) {
            $this->faq = $faq;
        }

        public static function getTicket(PDO $db, int $id) : ?Ticket {
            $stmt = $db->prepare('
                SELECT idTicket, idClient, title, content, dateOpened, dateDue, dateClosed, idAgent, idDepartment, idPriority, idStatus, idFAQ
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
                $ticket['content'],
                $ticket['dateOpened'],
                $ticket['dateDue'],
                $ticket['dateClosed'],
                User::getUser($db, (int) $ticket['idAgent']),
                Department::getDepartment($db, (int) $ticket['idDepartment']),
                Priority::getPriority($db, (int) $ticket['idPriority']),
                Status::getStatus($db, (int) $ticket['idStatus']),
                FAQ::getFAQ($db, (int) $ticket['idFAQ'])
            );
        }

        public static function getTickets(PDO $db, int $id, string $after, string $before, int $department, int $priority, int $status) : array {
            $stmt = $db->prepare("
                SELECT idTicket, idClient, title, content, dateOpened, dateDue, dateClosed, idAgent, idDepartment, idPriority, idStatus, idFAQ
                FROM Ticket
                WHERE (idClient = ? OR idAgent = ?) 
                AND (? = '' OR dateOpened > ?) 
                AND (? = '' OR dateOpened < ?)
                AND (? = '0' OR idDepartment = ?) 
                AND (? = '0' OR idPriority = ?) 
                AND (? = '0' OR idStatus = ?) 
            ");

            $stmt->execute(array($id, $id, $after, $after, $before, $before, $department, $department, $priority, $priority, $status, $status));
            $result = $stmt->fetchAll();

            $tickets = array();

            foreach ($result as $row)
                $tickets[] = new Ticket(
                    (int) $row['idTicket'],
                    User::getUser($db, (int) $row['idClient']),
                    $row['title'],
                    $row['content'],
                    $row['dateOpened'],
                    $row['dateDue'],
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

        public static function addTicket(PDO $db, int $idClient, string $title, string $content, string $dateOpened, string $dateDue, int $departmentId, array $tags) : bool {
            if ($departmentId !== 0) {
                $stmt = $db->prepare('
                    INSERT INTO Ticket (idClient, title, content, dateOpened, dateDue, idDepartment)
                    VALUES (?, ?, ?, ?, ?, ?)
                ');
                try {
                    $stmt->execute(array($idClient, $title, $content, $dateOpened, $dateDue, $departmentId));
                } catch (PDOException $e) {
                    return false;
                }
            } else {
                $stmt = $db->prepare('
                    INSERT INTO Ticket (idClient, title, content, dateOpened, dateDue)
                    VALUES (?, ?, ?, ?, ?)
                ');
                try {
                    $stmt->execute(array($idClient, $title, $content, $dateOpened, $dateDue));
                } catch (PDOException $e) {
                    return false;
                }
            }

            $stmt = $db->prepare('
                SELECT last_insert_rowid()
                FROM Ticket    
            ');
            $id = $stmt->execute();

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

        public function edit(PDO $db, string $title, string $content) : bool {
            $stmt = $db->prepare('
                UPDATE Ticket
                SET title = ?, content = ?
                WHERE idTicket = ?
            ');

            try {
                $stmt->execute(array($title, $content, $this->id));
            } catch (PDOException $e) {
                return false;
            }
            
            $this->title = $title;
            $this->content = $content;
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
    }
?>
