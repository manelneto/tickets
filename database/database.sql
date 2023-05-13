PRAGMA foreign_keys = ON;


/* DROP */


DROP TABLE IF EXISTS TicketTag;
DROP TABLE IF EXISTS AgentDepartment;
DROP TABLE IF EXISTS Message;
DROP TABLE IF EXISTS Change;
DROP TABLE IF EXISTS Ticket;
DROP TABLE IF EXISTS FAQ;
DROP TABLE IF EXISTS Status;
DROP TABLE IF EXISTS Tag;
DROP TABLE IF EXISTS Priority;
DROP TABLE IF EXISTS Department;
DROP TABLE IF EXISTS Admin;
DROP TABLE IF EXISTS Agent;
DROP TABLE IF EXISTS User;


/* CREATE */


CREATE TABLE User (
    idUser INTEGER NOT NULL,
    firstName TEXT NOT NULL,
    lastName TEXT NOT NULL,
    username TEXT NOT NULL,
    email TEXT NOT NULL,
    password TEXT NOT NULL,
    CONSTRAINT UserPK PRIMARY KEY (idUser),
    CONSTRAINT UserUsernameCK UNIQUE (username),
    CONSTRAINT UserEmailCK UNIQUE (email)
);

CREATE TABLE Agent (
    idAgent INTEGER NOT NULL,
    CONSTRAINT AgentPK PRIMARY KEY (idAgent),
    CONSTRAINT AgentUserFK FOREIGN KEY (idAgent) REFERENCES User (idUser) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE Admin (
    idAdmin INTEGER NOT NULL,
    CONSTRAINT AdminPK PRIMARY KEY (idAdmin),
    CONSTRAINT AdminAgentFK FOREIGN KEY (idAdmin) REFERENCES Agent (idAgent) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE Department (
    idDepartment INTEGER NOT NULL,
    name TEXT NOT NULL,
    CONSTRAINT DepartmentPK PRIMARY KEY (idDepartment),
    CONSTRAINT DepartmentNameCK UNIQUE (name)
);

CREATE TABLE Priority (
    idPriority INTEGER NOT NULL,
    name TEXT NOT NULL,
    CONSTRAINT PriorityPK PRIMARY KEY (idPriority),
    CONSTRAINT PriorityNameCK UNIQUE (name)
);

CREATE TABLE Tag (
    idTag INTEGER NOT NULL,
    name TEXT NOT NULL,
    CONSTRAINT TagPK PRIMARY KEY (idTag),
    CONSTRAINT TagNameCK UNIQUE (name)
);

CREATE TABLE Status (
    idStatus INTEGER NOT NULL,
    name TEXT NOT NULL,
    CONSTRAINT StatusPK PRIMARY KEY (idStatus),
    CONSTRAINT StatusNameCK UNIQUE (name)
);

CREATE TABLE FAQ (
    idFAQ INTEGER NOT NULL,
    question TEXT NOT NULL,
    answer TEXT NOT NULL,
    CONSTRAINT FAQPK PRIMARY KEY (idFAQ),
    CONSTRAINT FAQQuestionCK UNIQUE (question)
);

CREATE TABLE Ticket (
    idTicket INTEGER NOT NULL,
    idUser INTEGER NOT NULL,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    dateOpened DATE NOT NULL,
    dateClosed DATE,
    idAgent INTEGER,
    idDepartment INTEGER,
    idPriority INTEGER,
    idStatus INTEGER DEFAULT 1,
    idFAQ INTEGER,
    CONSTRAINT TicketPK PRIMARY KEY (idTicket),
    CONSTRAINT TicketUserFK FOREIGN KEY (idUser) REFERENCES User (idUser) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT TicketAgentFK FOREIGN KEY (idAgent) REFERENCES Agent (idAgent) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT TicketDepartmentFK FOREIGN KEY (idDepartment) REFERENCES Department (idDepartment) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT TicketPriorityFK FOREIGN KEY (idPriority) REFERENCES Priority (idPriority) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT TicketStatusFK FOREIGN KEY (idStatus) REFERENCES Status (idStatus) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT TicketFAQFK FOREIGN KEY (idFAQ) REFERENCES FAQ (idFAQ) ON UPDATE CASCADE,
    CONSTRAINT TicketCheckDateClosed CHECK (dateClosed IS NULL OR dateClosed >= dateOpened)
);

CREATE TABLE Change (
    idChange INTEGER NOT NULL,
    date DATE NOT NULL,
    description TEXT NOT NULL,
    idTicket INTEGER NOT NULL,
    CONSTRAINT ChangePK PRIMARY KEY (idChange),
    CONSTRAINT ChangeTicketFK FOREIGN KEY (idTicket) REFERENCES Ticket (idTicket) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE Message (
    idMessage INTEGER NOT NULL,
    date DATE NOT NULL,
    content TEXT NOT NULL,
    idTicket INTEGER NOT NULL,
    idUser INTEGER NOT NULL,
    CONSTRAINT MessagePK PRIMARY KEY (idMessage),
    CONSTRAINT MessageTicketFK FOREIGN KEY (idTicket) REFERENCES Ticket (idTicket) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT MessageUserFK FOREIGN KEY (idUser) REFERENCES User (idUser) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE AgentDepartment (
    idAgent INTEGER NOT NULL,
    idDepartment INTEGER NOT NULL,
    CONSTRAINT AgentDepartmentPK PRIMARY KEY (idAgent, idDepartment),
    CONSTRAINT AgentDepartmentAgentFK FOREIGN KEY (idAgent) REFERENCES Agent (idAgent) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT AgentDepartmentDepartmentFK FOREIGN KEY (idDepartment) REFERENCES Department (idDepartment) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE TicketTag (
    idTicket INTEGER NOT NULL,
    idTag INTEGER NOT NULL,
    CONSTRAINT TicketTagPK PRIMARY KEY (idTag, idTicket),
    CONSTRAINT TicketTagTicketFK FOREIGN KEY (idTicket) REFERENCES Ticket (idTicket) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT TicketTagTagFK FOREIGN KEY (idTag) REFERENCES Tag (idTag) ON UPDATE CASCADE ON DELETE CASCADE
);


/* TRIGGERS */


DROP TRIGGER IF EXISTS AdminAgent;
CREATE TRIGGER AdminAgent
    AFTER INSERT ON Admin
    WHEN NOT EXISTS (SELECT * FROM Agent WHERE idAgent = New.idAdmin)
BEGIN
    INSERT INTO Agent (idAgent) VALUES (New.idAdmin);
END;

DROP TRIGGER IF EXISTS TicketTitle;
CREATE TRIGGER TicketTitle
    AFTER UPDATE OF title ON Ticket
BEGIN
    INSERT INTO Change (date, description, idTicket) VALUES (date(), 'Title edited', New.idTicket);
END;

DROP TRIGGER IF EXISTS TicketDescription;
CREATE TRIGGER TicketDescription
    AFTER UPDATE OF description ON Ticket
BEGIN
    INSERT INTO Change (date, description, idTicket) VALUES (date(), 'Description edited', New.idTicket);
END;

DROP TRIGGER IF EXISTS TicketAgent;
CREATE TRIGGER TicketAgent
    AFTER UPDATE OF idAgent ON Ticket
BEGIN
    INSERT INTO Change (date, description, idTicket) VALUES (date(), 'Agent: ' || IFNULL((SELECT firstName || ' ' || lastName FROM Agent, User WHERE idAgent = idUser AND idAgent = Old.idAgent), 'None') || ' --> ' || (SELECT firstName || ' ' || lastName FROM Agent, User WHERE idAgent = idUser AND idAgent = New.idAgent), New.idTicket);
END;

DROP TRIGGER IF EXISTS TicketDepartment;
CREATE TRIGGER TicketDepartment
    AFTER UPDATE OF idDepartment ON Ticket
BEGIN
    INSERT INTO Change (date, description, idTicket) VALUES (date(), 'Department: ' || IFNULL((SELECT name FROM Department WHERE idDepartment = Old.idDepartment), 'None') || ' --> ' || (SELECT name FROM Department WHERE idDepartment = New.idDepartment), New.idTicket);
END;

DROP TRIGGER IF EXISTS TicketPriority;
CREATE TRIGGER TicketPriority
    AFTER UPDATE OF idPriority ON Ticket
BEGIN
    INSERT INTO Change (date, description, idTicket) VALUES (date(), 'Priority: ' || IFNULL((SELECT name FROM Priority WHERE idPriority = Old.idPriority), 'None') || ' --> ' || (SELECT name FROM Priority WHERE idPriority = New.idPriority), New.idTicket);
END;

DROP TRIGGER IF EXISTS TicketStatus;
CREATE TRIGGER TicketStatus
    AFTER UPDATE OF idStatus ON Ticket
BEGIN
    INSERT INTO Change (date, description, idTicket) VALUES (date(), 'Status: ' || IFNULL((SELECT name FROM Status WHERE idStatus = Old.idStatus), 'None') || ' --> ' || (SELECT name FROM Status WHERE idStatus = New.idStatus), New.idTicket);
END;

DROP TRIGGER IF EXISTS TicketTagDelete;
CREATE TRIGGER TicketTagInsert
    AFTER DELETE ON TicketTag
BEGIN
    INSERT INTO Change (date, description, idTicket) VALUES (date(), 'Tag: - ' || (SELECT name FROM Tag NATURAL JOIN TicketTag WHERE idTicket = Old.idTicket AND idTag = Old.idTag), Old.idTicket);
END;

DROP TRIGGER IF EXISTS TicketTagInsert;
CREATE TRIGGER TicketTagInsert
    AFTER INSERT ON TicketTag
BEGIN
    INSERT INTO Change (date, description, idTicket) VALUES (date(), 'Tag: + ' || (SELECT name FROM Tag NATURAL JOIN TicketTag WHERE idTicket = New.idTicket AND idTag = New.idTag), New.idTicket);
END;

/* INSERT */


INSERT INTO User VALUES(1, 'Joana', 'Marques', 'joanamarques', 'joanamarques@gmail.com', '$2y$12$DFNpOjKTVVMhs5DNj54mZOpSsXohNXNaQG4M0nGI/AOa.a4PS84Vy');
INSERT INTO User VALUES(2, 'Matilde', 'Simões', 'matildesimoes', 'matildesimoes@gmail.com', '$2y$12$OeWSWAOPBapajMhswVhjDerSaOpGNC9iUo6v94uRvg/r.V4xjc.MW');
INSERT INTO User VALUES(3, 'Manel', 'Neto', 'manelneto', 'manelneto@gmail.com', '$2y$12$nfwMTXK25lqUeUdtSSWDze1ruvRv2igiQMdhrJrmNLxp7XvOhBziW');
INSERT INTO User VALUES(4, 'Client', 'Test', 'client', 'client@test.com', '$2y$12$zlEzCwPtpRRXdS12ob9ypeajSLmW94dUo5kOmItV791QMOe5Mf5x6');
INSERT INTO User VALUES(5, 'Agent', 'Test', 'agent', 'agent@test.com', '$2y$12$5TuVO22AK1v3fXUPFuAKVueYh7/lqB9eWm8xgftXVQvtLRMLTRmoC');
INSERT INTO User VALUES(6, 'Admin', 'Test', 'admin', 'admin@test.com', '$2y$12$MVxJYNX6egxRIQOm6LyGXuscEoF/SOCX7uwmnIGP8inDFncQap6jq');

INSERT INTO Agent VALUES(5);
INSERT INTO Agent VALUES(2);

INSERT INTO Admin VALUES(6);
INSERT INTO Admin VALUES(1);

INSERT INTO Department VALUES(1, 'IT');
INSERT INTO Department VALUES(2, 'Human Resources');
INSERT INTO Department VALUES(3, 'Finances');
INSERT INTO Department VALUES(4, 'Marketing');

INSERT INTO Priority VALUES(1, 'Low');
INSERT INTO Priority VALUES(2, 'Medium');
INSERT INTO Priority VALUES(3, 'High');
INSERT INTO Priority VALUES(4, 'Critical');

INSERT INTO Tag VALUES(1, 'website');
INSERT INTO Tag VALUES(2, 'password');
INSERT INTO Tag VALUES(3, 'general');
INSERT INTO Tag VALUES(4, 'other');

INSERT INTO Status VALUES(1, 'Open');
INSERT INTO Status VALUES(2, 'Assigned');
INSERT INTO Status VALUES(3, 'Closed');

INSERT INTO FAQ VALUES(1, 'How long do I have to wait for an answer?', 'It depends on the question. On average, one week.');
INSERT INTO FAQ VALUES(2, 'Where can I see the current status of my ticket?', 'The client can check the ticket status in the Dashboard.');
INSERT INTO FAQ VALUES(3, 'Where can I submit a new ticket?', 'On the tickets section.');
INSERT INTO FAQ VALUES(4, 'Where can I change my email address?', 'On your profile section.');

INSERT INTO Ticket VALUES(1, 1, 'Received a broken TV', 'The television I ordered from your site was delivered with a cracked screen. I need some replacement.', '2023-04-07', NULL, NULL, NULL, NULL, 1, NULL);
INSERT INTO Ticket VALUES(2, 2, 'Payment failed', 'The payment of my purchase failed. What can I do?', '2023-04-06', '2023-04-13', 5, 3, 3, 3, NULL);
INSERT INTO Ticket VALUES(3, 3, 'Email address change', 'Where can I change my email address?', '2023-04-05', '2023-04-10', 6, 1, 1, 3, 4);

INSERT INTO Message VALUES(1, '2023-04-17', 'Forget it. I fixed the screen myself!', 1, 1);
INSERT INTO Message VALUES(2, '2023-04-10', 'What is the number of your purchase?', 2, 5);
INSERT INTO Message VALUES(3, '2023-04-11', 'Purchase Number 123', 2, 2);

INSERT INTO AgentDepartment VALUES(5, 2);
INSERT INTO AgentDepartment VALUES(5, 4);
INSERT INTO AgentDepartment VALUES(2, 2);
INSERT INTO AgentDepartment VALUES(6, 1);
INSERT INTO AgentDepartment VALUES(6, 3);
INSERT INTO AgentDepartment VALUES(1, 1);

INSERT INTO TicketTag VALUES(1, 4);
INSERT INTO TicketTag VALUES(2, 4);
INSERT INTO TicketTag VALUES(3, 1);
INSERT INTO TicketTag VALUES(3, 3);
