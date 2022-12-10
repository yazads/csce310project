-- change delimiter to $$ sql can tell between start & end of BEGIN END block vs the lines of code in it
DELIMITER $$
CREATE 
    TRIGGER IF NOT EXISTS beforeDeleteAppointment
    BEFORE DELETE
    ON appointment FOR EACH ROW
    BEGIN
        DELETE FROM review WHERE appointmentID = old.appointmentID;
        DELETE FROM petAppointment WHERE appointmentID = old.appointmentID;
    END$$
-- change delimiter back to normal
DELIMITER ;