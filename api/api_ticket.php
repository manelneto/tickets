<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if (!$session->isLoggedIn()) {
        header('Location: ../pages/index.php');
        die();
    }

    require_once(__DIR__ . '/../database/connection.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/class_ticket.php');

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if (isset($_GET['id']))
                echo json_encode(Ticket::getTicket($db, (int) ($_GET['id'])));
            else {
                $id = $session->getId();
                $after = $_GET['after'] ?? '';
                $before = $_GET['before'] ?? '';
                $department = (int) $_GET['department'] ?? 0;
                $priority = (int) $_GET['priority'] ?? 0;
                $status = (int) $_GET['status'] ?? 0;
                $agent = (int) $_GET['agent'] ?? 0;
                $tag = (int) $_GET['tag'] ?? 0;

                if ($session->isAdmin())
                    echo json_encode(Ticket::getTickets($db, $after, $before, $department, $priority, $status, $agent, $tag));
                else if ($session->isAgent())
                    echo json_encode(Ticket::getTicketsAgent($db, $session->getId(), $after, $before, $department, $priority, $status, $agent, $tag));
                else
                    echo json_encode(Ticket::getTicketsClient($db, $session->getId(), $after, $before, $department, $priority, $status, $agent, $tag));
            }
            break;
        case 'POST':
            $title = trim($_POST['title']);
            $description = trim($_POST['description']);
            if ($title === '' || $description === '') {
                echo json_encode('Ticket title/description cannot be empty');
                die();
            }
            $dateOpened =  date('Y-m-d');
            $department = (int) $_POST['department'];
            $names = (strpos($_POST['tags'], ',') !== false) ? explode(',', $_POST['tags']) : array(trim($_POST['tags']));
            $tags = array();
            foreach ($names as $name) {
                $tag = Tag::getTagId($db, $name);
                if ($tag) $tags[] = $tag;
            }
            echo json_encode(Ticket::addTicket($db, $session->getId(), $title, $description, $dateOpened, $department, $tags));
            break;
        case 'PUT':
            $id = (int) $_GET['id'];
            $ticket = Ticket::getTicket($db, $id);
            if (isset($_GET['title']) && isset($_GET['description'])) {
                $title = $_GET['title'];
                $description = $_GET['description'];
                echo json_encode($ticket->edit($db, $title, $description));
            }
            if (isset($_GET['status']) && isset($_POST['tags'])) {
                $status = (int) $_GET['status'];
                $priority = (int) $_GET['priority'];
                $department = (int) $_GET['department'];
                $agent = (int) $_GET['agent'];
                $tags = json_decode($_POST['tags']); //???????
                echo json_encode($ticket->editProperties($db, $status, $priority, $department, $agent, $tags));
            }
            break;
    }
?>
