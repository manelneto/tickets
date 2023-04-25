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

        public function getId() {
            return $this->id;
        }

        public function getQuestion() {
            return $this->question;
        }

        public function getAnswer() {
            return $this->answer;
        }

        public function setQuestion(string $question) {
            $this->question = $question;
        }

        public function setAnswer(string $answer) {
            $this->answer = $answer;
        }

        public static function getFAQ(PDO $db) {
            $stmt = $db->prepare('
                SELECT idFAQ, question, answer
                FROM FAQ
            ');

            $stmt->execute();
            $result = $stmt->fetchAll();

            if (!$result) return null;

            $faq = array();

            foreach ($result as $row)
                $faq[] = new FAQ((int) $row['idFAQ'], $row['question'], $row['answer']);

            return $faq;
        }
    }
?>
