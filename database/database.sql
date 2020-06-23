
CREATE TABLE ADMIN (
                id_admin INT AUTO_INCREMENT NOT NULL,
                nom VARCHAR(255) NOT NULL,
                prenom VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                contact VARCHAR(255) NOT NULL,
                login VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                PRIMARY KEY (id_admin)
);


CREATE UNIQUE INDEX admin_idx
 ON ADMIN
 ( login );

CREATE TABLE SOCIETE (
                id_societe INT AUTO_INCREMENT NOT NULL,
                nom VARCHAR(255) NOT NULL,
                branch INT NOT NULL,
                id_admin INT NOT NULL,
                PRIMARY KEY (id_societe)
);


CREATE UNIQUE INDEX societe_idx
 ON SOCIETE
 ( nom );

CREATE UNIQUE INDEX societe_idx1
 ON SOCIETE
 ( nom );

CREATE TABLE UTILISATEUR (
                id_utilisateur INT AUTO_INCREMENT NOT NULL,
                login VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                nom_utilisateur VARCHAR(255) NOT NULL,
                prenom_utilisateur VARCHAR(255) NOT NULL,
                fonction VARCHAR(255) NOT NULL,
                id_societe INT NOT NULL,
                site VARCHAR(255) NOT NULL,
                PRIMARY KEY (id_utilisateur)
);


CREATE UNIQUE INDEX utilisateur_idx
 ON UTILISATEUR
 ( login );

CREATE TABLE CLOTURE_MT (
                id_cloture INT AUTO_INCREMENT NOT NULL,
                date DATE NOT NULL,
                solde_banque INT NOT NULL,
                espece_cloture INT NOT NULL,
                id_utilisateur INT NOT NULL,
                PRIMARY KEY (id_cloture)
);


CREATE TABLE CLOTURE_MM (
                id_cloture INT AUTO_INCREMENT NOT NULL,
                date DATE NOT NULL,
                solde_orange INT NOT NULL,
                solde_mtn INT NOT NULL,
                solde_moov INT NOT NULL,
                espece_cloture INT NOT NULL,
                id_utilisateur INT NOT NULL,
                PRIMARY KEY (id_cloture)
);


CREATE TABLE OUVERTURE_MM (
                id_ouverture_mm INT AUTO_INCREMENT NOT NULL,
                date DATE NOT NULL,
                solde_orange INT NOT NULL,
                solde_mtn INT NOT NULL,
                solde_moov INT NOT NULL,
                espece_ouverture INT NOT NULL,
                id_utilisateur INT NOT NULL,
                PRIMARY KEY (id_ouverture_mm)
);


CREATE TABLE OUVERTURE (
                id_ouverture INT AUTO_INCREMENT NOT NULL,
                date DATE NOT NULL,
                solde_ouverture INT DEFAULT 0 NOT NULL,
                espece_ouverture INT DEFAULT 0 NOT NULL,
                id_utilisateur INT NOT NULL,
                PRIMARY KEY (id_ouverture)
);


CREATE TABLE RAPPORT (
                id_raport INT AUTO_INCREMENT NOT NULL,
                date DATE NOT NULL,
                solde_ouverture INT NOT NULL,
                retrait_moneygram INT NOT NULL,
                retrait_western INT NOT NULL,
                retrait_ria INT NOT NULL,
                envoi_moneygram INT NOT NULL,
                envoi_western INT NOT NULL,
                envoi_ria INT NOT NULL,
                id_utilisateur INT NOT NULL,
                PRIMARY KEY (id_raport)
);


CREATE TABLE CREDIT (
                id_credit INT AUTO_INCREMENT NOT NULL,
                date DATE NOT NULL,
                montant INT NOT NULL,
                commentaire VARCHAR(255) NOT NULL,
                id_utilisateur INT NOT NULL,
                PRIMARY KEY (id_credit)
);


CREATE TABLE OPERATION (
                id_operation INT AUTO_INCREMENT NOT NULL,
                date DATE NOT NULL,
                type_operation VARCHAR(255) NOT NULL,
                montant INT NOT NULL,
                id_utilisateur INT NOT NULL,
                service VARCHAR(255) NOT NULL,
                nom_client VARCHAR(255) NOT NULL,
                prenom_client VARCHAR(255) NOT NULL,
                tel_client VARCHAR(255) NOT NULL,
                PRIMARY KEY (id_operation)
);


ALTER TABLE SOCIETE ADD CONSTRAINT admin_societe_fk
FOREIGN KEY (id_admin)
REFERENCES ADMIN (id_admin)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE UTILISATEUR ADD CONSTRAINT societe_utilisateur_fk
FOREIGN KEY (id_societe)
REFERENCES SOCIETE (id_societe)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE OPERATION ADD CONSTRAINT utilisateur_operation_fk
FOREIGN KEY (id_utilisateur)
REFERENCES UTILISATEUR (id_utilisateur)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE CREDIT ADD CONSTRAINT utilisateur_credit_fk
FOREIGN KEY (id_utilisateur)
REFERENCES UTILISATEUR (id_utilisateur)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE RAPPORT ADD CONSTRAINT utilisateur_rapport_fk
FOREIGN KEY (id_utilisateur)
REFERENCES UTILISATEUR (id_utilisateur)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE OUVERTURE ADD CONSTRAINT utilisateur_ouverture_fk
FOREIGN KEY (id_utilisateur)
REFERENCES UTILISATEUR (id_utilisateur)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE OUVERTURE_MM ADD CONSTRAINT utilisateur_ouverture_mm_fk
FOREIGN KEY (id_utilisateur)
REFERENCES UTILISATEUR (id_utilisateur)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE CLOTURE_MM ADD CONSTRAINT utilisateur_cloture_mm_fk
FOREIGN KEY (id_utilisateur)
REFERENCES UTILISATEUR (id_utilisateur)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE CLOTURE_MT ADD CONSTRAINT utilisateur_cloture_mt_fk
FOREIGN KEY (id_utilisateur)
REFERENCES UTILISATEUR (id_utilisateur)
ON DELETE NO ACTION
ON UPDATE NO ACTION;
