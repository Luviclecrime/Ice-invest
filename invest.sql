CREATE DATABASE ice_invst;

USE ice_invst;

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(25),
    mots_de_pass VARCHAR(277),
    numero VARCHAR(9),
    solde DECIMAL(10, 2)
);

CREATE TABLE accounts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_utilisateur INT,
    solde DECIMAL(10, 2),
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES users(id)
);

CREATE TABLE depots (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_compte INT,
    montant DECIMAL(10, 2),
    date_depots TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_compte) REFERENCES accounts(id)
);

CREATE TABLE retraits (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_compte INT,
    montant DECIMAL(10, 2),
    date_retrait TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_compte) REFERENCES accounts(id)
);

CREATE TABLE projets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(244),
    description TEXT,
    montant_necessaire DECIMAL(10, 2),
    date_debut TIMESTAMP,
    date_fin TIMESTAMP
);

CREATE TABLE investissement (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_projet INT,
    id_compte INT,
    montant_investi DECIMAL(10, 2),
    date_investissement TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_projet) REFERENCES projets(id),
    FOREIGN KEY (id_compte) REFERENCES accounts(id)
);

CREATE TABLE transaction_log (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_compte INT,
    type_transaction VARCHAR(20),
    montant DECIMAL(10, 2),
    date_transaction TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_compte) REFERENCES accounts(id)
);
