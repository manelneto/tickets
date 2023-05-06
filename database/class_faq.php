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

        public static function getFAQs(PDO $db) : array {
            $stmt = $db->prepare('
                SELECT idFAQ, question, answer
                FROM FAQ
            ');

            $stmt->execute();
            $result = $stmt->fetchAll();

            $faqs = array();

            foreach ($result as $row)
                $faqs[] = new FAQ(
                    (int) $row['idFAQ'],
                    $row['question'],
                    $row['answer']
                );

            return $faqs;
        }

        public static function getFAQ(PDO $db, int $id) : ?FAQ {
            $stmt = $db->prepare('
                SELECT idFAQ, question, answer
                FROM FAQ
                Where idFAQ = ?
            ');

            $stmt->execute(array($id));
            $faq = $stmt->fetch();

            if (!$faq) return null;

            return new FAQ(
                (int) $faq['idFAQ'],
                $faq['question'],
                $faq['answer']
            );
        }

        public static function addFAQ(PDO $db, string $question, string $answer) : bool {
            $stmt = $db->prepare('
                INSERT INTO FAQ (question, answer)
                VALUES (?, ?)
            ');

            try {
                $stmt->execute(array($question, $answer));
            } catch (PDOException $e) {
                return false;
            }
            
            return true;
        }

        public function delete(PDO $db) : bool {
            $stmt = $db->prepare('
                DELETE
                FROM FAQ
                WHERE idFAQ = ?
            ');

            try {
                $stmt->execute(array($this->id));
            } catch (PDOException $e) {
                return false;
            }
            
            return true;
        }

        public function edit(PDO $db, string $question, string $answer) : bool {
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
    }
?>
