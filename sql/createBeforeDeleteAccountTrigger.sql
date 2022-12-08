DELIMITER $$

CREATE TRIGGER IF NOT EXISTS beforeDeleteAccount
    BEFORE DELETE
    ON person FOR EACH ROW
BEGIN
    DELETE FROM review WHERE personID = old.personID;
    IF($personType = 1)
        DELETE FROM appointment WHERE petOwner = old.personID;
    IF($personType = 2)
        DELETE FROM appointment WHERE petSitter = old.personID;
END$$

DELIMITER ;