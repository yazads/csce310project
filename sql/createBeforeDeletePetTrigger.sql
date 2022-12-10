CREATE 
    TRIGGER IF NOT EXISTS beforeDeletePet
    BEFORE DELETE
    ON pet FOR EACH ROW
        DELETE FROM petAppointment WHERE petID = old.petID;