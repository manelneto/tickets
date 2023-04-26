<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../database/class_user.php');

    class Ticket {
        private int $id;
        private User $client;
        private string $title;
        private string $content;
        private string $dateOpened;
        private string $dateDue;
        private string $dateClosed;
        private User $agent;
        private Department $department;
        private Priority $priority;
        private Status $status;
        private FAQ $faq;

        public function __construct(int $id, User $client, string $title, string $content, string $dateOpened, string $dateDue, string $dateClosed, User $agent, Department $department, Priority $priority, Status $status, FAQ $faq) {
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
    }
?>
