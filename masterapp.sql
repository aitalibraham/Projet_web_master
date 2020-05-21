
DROP TABLE IF EXISTS `stage`;
CREATE TABLE IF NOT EXISTS `stage` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `domaine` varchar(256) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `etudiant`;
CREATE TABLE IF NOT EXISTS `etudiant` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `adresse` varchar(256) NOT NULL,
  `date_naissance` date NOT NULL,
  `photo` varchar(256),
  `parcours` varchar(256) NOT NULL,
  `note_maths` double NOT NULL,
  `note_info` double NOT NULL,
  `note_anglais` double NOT NULL,
  `moyenne` double NOT NULL,
  `lettre_motivation` varchar(256) NOT NULL,
  `specialite` int(11),
  `statut` enum('Inscris','Candidat') NOT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`specialite`) REFERENCES stage(`ID`),
  CONSTRAINT `CHK_Unique_Nom_Prenom_Datenaissance` UNIQUE (`nom`, `prenom`, `date_naissance`),
  CONSTRAINT `CHK_Nom_Prenom_Len` CHECK (LENGTH(`nom`) >= 3 AND LENGTH(`prenom`)>=3),
  CONSTRAINT `CHK_Note_Maths` CHECK (`note_maths`>10),
  CONSTRAINT `CHK_Note_Info` CHECK (`note_info`>15),
  CONSTRAINT `CHK_Note_Anglais` CHECK (`note_anglais`>12),
  CONSTRAINT `CHK_Moyenne` CHECK (`moyenne`>14)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TRIGGER IF EXISTS before_billing_update;
DELIMITER $$

CREATE TRIGGER before_etudiant_insert
BEFORE INSERT
ON Etudiant FOR EACH ROW
BEGIN
	DECLARE age float;
	
    SELECT datediff(CURDATE(), `date_naissance`)/365.25 
    INTO age
    FROM etudiant WHERE ID=new.ID;
    
    IF age < 20 OR age > 35 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Age invalide.';
    END IF; 

END $$

DELIMITER ;

