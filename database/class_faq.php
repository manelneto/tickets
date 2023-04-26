<?php
    declare(strict_types = 1);

    class FAQ {
        private int $id;
        private string $question;
        private string $answer;

        public function __construct(int $id, string $question, string $answer) {
            $this->id = $id;
            $this->question = $question;
            $this->answer = $answer;
        }

        public function getId() : int {
            return $this->id;
        }

        public function getQuestion() : string {
            return $this->question;
        }

        public function getAnswer() : string {
            return $this->answer;
        }

        public function setQuestion(string $question) {
            $this->question = $question;
        }

        public function setAnswer(string $answer) {
            $this->answer = $answer;
        }

        public static function getFAQs(PDO $db) : ?array {
            $stmt = $db->prepare('
                SELECT idFAQ, question, answer
                FROM FAQ
            ');

            $stmt->execute();
            $result = $stmt->fetchAll();

            if (!$result) return null;

            $faqs = array();

            foreach ($result as $row)
                $faqs[] = new FAQ((int) $row['idFAQ'], $row['question'], $row['answer']);

            return $faqs;
        }
    }
?>
