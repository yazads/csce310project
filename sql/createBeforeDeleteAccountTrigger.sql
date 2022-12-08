-- refs:
-- https://www.mysqltutorial.org/mysql-triggers/mysql-before-delete-trigger/#:~:text=MySQL%20BEFORE%20DELETE%20triggers%20are%20fired%20automatically%20before,SQL%20%28Structured%20Query%20Language%29%20%28sql%29%20In%20this%20syntax%3A
-- https://thispointer.com/trigger-with-if-condition-in-mysql/#:~:text=Triggers%20are%20named%20database%20objects%20linked%20with%20a,we%20will%20create%20sample%20tables%20employee_details%20and%20special_bonus_employees.

-- help w/ annoying syntax problems:
-- https://stackoverflow.com/questions/1102109/mysql-delimiter-syntax-errors

-- change delimiter to $$ sql can tell between start & end of BEGIN END block vs the lines of code in it
DELIMITER $$
CREATE 
    TRIGGER IF NOT EXISTS beforeDeleteAccount
    BEFORE DELETE
    ON person FOR EACH ROW
    BEGIN
        IF(old.personType = '1')
        -- case 1: the person being deleted is a pet owner
        THEN
            -- delete their reviews, pets, and appts
            DELETE FROM review WHERE personID = old.personID;
            DELETE FROM pet WHERE personID = old.personID;
            DELETE FROM appointment WHERE petOwner = old.personID;
        END IF;
        IF(old.personType = '2')
        -- case 2: the person being deleted is a pet sitter
        THEN
            -- update all the rows in appt with this pet sitter to be null
            UPDATE appointment SET petSitter = NULL WHERE petSitter = old.personID;
        END IF;
    END$$
-- change delimiter back to normal
DELIMITER ;
