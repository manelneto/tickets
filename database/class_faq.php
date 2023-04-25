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

        public function setQuestion($question) {
            $this->question = $question;
        }

        public function setAnswer($answer) {
            $this->answer = $answer;
        }

        function update($db, string $question, string $answer) : bool {
            $stmt = $db->prepare('
                UPDATE FAQ
                SET question = ?, answer = ?
                WHERE idFAQ = ?
            ');

            try {
                $stmt->execute(array($question, $answer, $this->id));
            } catch (PDOException $e) {
                return false;
            }
            
            $this->question = $question;
            $this->answer = $answer;
            return true;
        }

        public static function getFAQs(PDO $db) {
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
