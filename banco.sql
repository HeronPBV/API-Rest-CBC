CREATE TABLE recurso (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    recurso varchar(255) NOT NULL,
    saldo_disponivel decimal(15,2) NOT NULL
);  



CREATE TABLE clube (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    clube varchar(255) NOT NULL,
    saldo_disponivel decimal(15,2) NOT NULL
);  



INSERT INTO recurso
    (recurso, saldo_disponivel)
VALUES
    ('Recurso para passagens', 10000.00),
    ('Recurso para hospedagens', 10000.00);
