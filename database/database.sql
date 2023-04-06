/* APAGAR */



DROP TABLE IF EXISTS HashtagTicket;
DROP TABLE IF EXISTS AgenteDepartamento;
DROP TABLE IF EXISTS Mensagem;
DROP TABLE IF EXISTS Ticket;
DROP TABLE IF EXISTS Prioridade;
DROP TABLE IF EXISTS Hashtag;
DROP TABLE IF EXISTS Estado;
DROP TABLE IF EXISTS Departamento;
DROP TABLE IF EXISTS FAQ;
DROP TABLE IF EXISTS Administrador;
DROP TABLE IF EXISTS Agente;
DROP TABLE IF EXISTS Cliente;
DROP TABLE IF EXISTS Utilizador;



/* CRIAR */



CREATE TABLE Utilizador (
    idUtilizador INTEGER NOT NULL,
    nome TEXT NOT NULL,
    apelido TEXT NOT NULL,
    email TEXT NOT NULL,
    username TEXT NOT NULL,
    password TEXT NOT NULL,
    CONSTRAINT UtilizadorPK PRIMARY KEY (idUtilizador),
    CONSTRAINT UtilizadorEmailCK UNIQUE (email),
    CONSTRAINT UtilizadorUsernameCK UNIQUE (username)
);


CREATE TABLE Cliente (
    idCliente INTEGER NOT NULL,
    CONSTRAINT ClientePK PRIMARY KEY (idCliente),
    CONSTRAINT ClienteUtilizadorFK FOREIGN KEY (idCliente) REFERENCES Utilizador (idUtilizador) ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE Agente (
    idAgente INTEGER NOT NULL,
    CONSTRAINT AgentePK PRIMARY KEY (idAgente),
    CONSTRAINT AgenteClienteFK FOREIGN KEY (idAgente) REFERENCES Cliente (idCliente) ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE Administrador (
    idAdministrador INTEGER NOT NULL,
    CONSTRAINT AdministradorPK PRIMARY KEY (idAdministrador),
    CONSTRAINT AdministradorAgenteFK FOREIGN KEY (idAdministrador) REFERENCES Agente (idAgente) ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE FAQ (
    idFAQ INTEGER NOT NULL,
    pergunta TEXT NOT NULL,
    resposta TEXT NOT NULL,
    CONSTRAINT FAQPK PRIMARY KEY (idFAQ),
    CONSTRAINT FAQPerguntaCK UNIQUE (pergunta)
);


CREATE TABLE Departamento (
    idDepartamento INTEGER NOT NULL,
    nome TEXT NOT NULL,
    CONSTRAINT DepartamentoPK PRIMARY KEY (idDepartamento),
    CONSTRAINT DepartamentoNomeCK UNIQUE (nome)
);


CREATE TABLE Estado (
    idEstado INTEGER NOT NULL,
    nome TEXT NOT NULL,
    CONSTRAINT EstadoPK PRIMARY KEY (idEstado),
    CONSTRAINT EstadoNomeCK UNIQUE (nome)
);


CREATE TABLE Hashtag (
    idHashtag INTEGER NOT NULL,
    hashtag TEXT NOT NULL,
    CONSTRAINT HashtagPK PRIMARY KEY (idHashtag),
    CONSTRAINT HashtagHashtagCK UNIQUE (hashtag)
);


CREATE TABLE Prioridade (
    idPrioridade INTEGER NOT NULL,
    nome TEXT NOT NULL,
    CONSTRAINT PrioridadePK PRIMARY KEY (idPrioridade),
    CONSTRAINT PrioridadeNomeCK UNIQUE (nome)
);


CREATE TABLE Ticket (
    idTicket INTEGER NOT NULL,
    idCliente INTEGER NOT NULL,
    titulo TEXT NOT NULL,
    conteudo TEXT NOT NULL,
    dataAbertura DATE NOT NULL,
    idEstado INTEGER NOT NULL,
    idDepartamento INTEGER,
    idAgente INTEGER,
    idPrioridade INTEGER,
    dataFecho DATE,
    idFAQ INTEGER,
    CONSTRAINT TicketPK PRIMARY KEY (idTicket),
    CONSTRAINT TicketClienteFK FOREIGN KEY (idCliente) REFERENCES Cliente (idCliente) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT TicketEstadoFK FOREIGN KEY (idEstado) REFERENCES Estado (idEstado) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT TicketDepartamentoFK FOREIGN KEY (idDepartamento) REFERENCES Departamento (idDepartamento) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT TicketAgenteFK FOREIGN KEY (idAgente) REFERENCES Agente (idAgente) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT TicketPrioridadeFK FOREIGN KEY (idPrioridade) REFERENCES Prioridade (idPrioridade) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT TicketFAQFK FOREIGN KEY (idFAQ) REFERENCES FAQ (idFAQ) ON UPDATE CASCADE
);


CREATE TABLE Mensagem (
    idMensagem INTEGER NOT NULL,
    data DATE NOT NULL,
    conteudo TEXT NOT NULL,
    idUtilizador INTEGER NOT NULL,
    idTicket INTEGER NOT NULL,
    CONSTRAINT MensagemPK PRIMARY KEY (idMensagem),
    CONSTRAINT MensagemUtilizadorFK FOREIGN KEY (idUtilizador) REFERENCES Utilizador (idUtilizador) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT MensagemTicketFK FOREIGN KEY (idTicket) REFERENCES Ticket (idTicket) ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE AgenteDepartamento (
    idAgente INTEGER NOT NULL,
    idDepartamento INTEGER NOT NULL,
    CONSTRAINT AgenteDepartamentoPK PRIMARY KEY (idAgente, idDepartamento),
    CONSTRAINT AgenteDepartamentoAgenteFK FOREIGN KEY (idAgente) REFERENCES Agente (idAgente) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT AgenteDepartamentoDepartamentoFK FOREIGN KEY (idDepartamento) REFERENCES Departamento (idDepartamento) ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE HashtagTicket (
    idHashtag INTEGER NOT NULL,
    idTicket INTEGER NOT NULL,
    CONSTRAINT HashtagTicketPK PRIMARY KEY (idHashtag, idTicket),
    CONSTRAINT HashtagTicketHashtagFK FOREIGN KEY (idHashtag) REFERENCES Hashtag (idHashtag) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT HashtagTicketTicketFK FOREIGN KEY (idTicket) REFERENCES Ticket (idTicket) ON UPDATE CASCADE ON DELETE CASCADE
);



/* TRIGGERS */


CREATE TRIGGER AgenteCliente
AFTER INSERT ON Agente
FOR EACH ROW
BEGIN
    INSERT INTO Cliente VALUES(New.idAgente);
END;


CREATE TRIGGER AdministradorAgente
AFTER INSERT ON Administrador
FOR EACH ROW
BEGIN
    INSERT INTO Agente VALUES(New.idAdministrador);
END;


/* POVOAR */



PRAGMA foreign_keys = ON;

INSERT INTO Utilizador VALUES(1, 'Joana', 'Marques', 'joanamarques@gmail.com', 'joanamarques', 'marquesjoana');
INSERT INTO Utilizador VALUES(2, 'Matilde', 'Simões', 'matildesimoes@gmail.com', 'matildesimoes', 'simoesmatilde');
INSERT INTO Utilizador VALUES(3, 'Manel', 'Neto', 'manelneto@gmail.com', 'manelneto', 'netomanel');
INSERT INTO Utilizador VALUES(4, 'Benedita', 'Braga', 'beneditabraga@gmail.com', 'beneditabraga', 'bragabenedita');
INSERT INTO Utilizador VALUES(5, 'Isabel', 'Cabral', 'isabelcabral@gmail.com', 'isabelcabral', 'cabralisabel');
INSERT INTO Utilizador VALUES(6, 'João', 'Melo', 'joaomelo@gmail.com', 'joaomelo', 'melojoao');

INSERT INTO Cliente VALUES(6);
INSERT INTO Cliente VALUES(5);

INSERT INTO Agente VALUES(4);
INSERT INTO Agente VALUES(3);

INSERT INTO Administrador VALUES(2);
INSERT INTO Administrador VALUES(1);

INSERT INTO FAQ VALUES(1, 'Como usar o site?', 'Usar o menu');
INSERT INTO FAQ VALUES(2, 'Como recuperar a palavra-passe?', 'Não sei');
INSERT INTO FAQ VALUES(3, 'Que nota vamos ter no projeto?', '20');
INSERT INTO FAQ VALUES(4, 'Porto ou Benfica?', 'Porto');

INSERT INTO Departamento VALUES(1, 'Recursos Humanos');
INSERT INTO Departamento VALUES(2, 'Finanças');
INSERT INTO Departamento VALUES(3, 'IT');
INSERT INTO Departamento VALUES(4, 'Marketing');

INSERT INTO Estado VALUES(1, 'Aberto');
INSERT INTO Estado VALUES(2, 'À espera');
INSERT INTO Estado VALUES(3, 'Atribuído');
INSERT INTO Estado VALUES(4, 'Fechado');

INSERT INTO Hashtag VALUES(1, 'site');
INSERT INTO Hashtag VALUES(2, 'password');
INSERT INTO Hashtag VALUES(3, 'geral');
INSERT INTO Hashtag VALUES(4, 'outro');

INSERT INTO Prioridade VALUES(1, 'Crítico');
INSERT INTO Prioridade VALUES(2, 'Urgente');
INSERT INTO Prioridade VALUES(3, 'Normal');
INSERT INTO Prioridade VALUES(4, 'Não Prioritário');

INSERT INTO Ticket VALUES(1, 6, 'Candeeiro', 'Preciso de um candeeiro novo.', '2023-04-06', 1, NULL, NULL, NULL, NULL, NULL);
INSERT INTO Ticket VALUES(2, 5, 'Bilhete', 'Onde comprar bilhetes para os Coldplay?', '2023-04-06', 2, 4, NULL, NULL, NULL, NULL);
INSERT INTO Ticket VALUES(3, 4, 'Computador', 'O meu computador deixou de funcionar!', '2023-06-04', 3, 3, 3, 1, NULL, NULL);
INSERT INTO Ticket VALUES(4, 3, 'Palavra-Passe', 'Perdi a minha palavra-passe. O que devo fazer?', '2023-01-01', 4, 3, 2, 2, '2023-01-02', 2);
INSERT INTO Ticket VALUES(5, 2, 'Salário', 'Quero um aumento salarial.', '2023-01-01', 4, 2, 1, 3, '2023-01-10', NULL);
INSERT INTO Ticket VALUES(6, 1, 'Post-Its', 'Alguém tirou os post-its da minha secretária.', '2022-10-10', 4, 1, 2, 4, '2022-12-25', NULL);

INSERT INTO Mensagem VALUES(1, '2023-01-02', 'Não sabes ler o FAQ?', 2, 4);
INSERT INTO Mensagem VALUES(2, '2023-01-02', 'Qual é o aumento que queres?', 1, 5);
INSERT INTO Mensagem VALUES(3, '2023-01-02', '10.000 € no mínimo', 2, 5);
INSERT INTO Mensagem VALUES(4, '2023-01-02', 'Feliz Natal!', 2, 6);


INSERT INTO AgenteDepartamento VALUES(1, 2);
INSERT INTO AgenteDepartamento VALUES(1, 3);
INSERT INTO AgenteDepartamento VALUES(2, 1);
INSERT INTO AgenteDepartamento VALUES(2, 3);
INSERT INTO AgenteDepartamento VALUES(3, 3);
INSERT INTO AgenteDepartamento VALUES(4, 4);

INSERT INTO HashtagTicket VALUES(1, 2);
INSERT INTO HashtagTicket VALUES(1, 4);
INSERT INTO HashtagTicket VALUES(2, 4);
INSERT INTO HashtagTicket VALUES(3, 3);
INSERT INTO HashtagTicket VALUES(3, 5);
INSERT INTO HashtagTicket VALUES(4, 6);
