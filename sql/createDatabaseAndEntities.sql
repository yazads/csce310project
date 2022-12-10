CREATE DATABASE IF NOT EXISTS petSitting;

USE petSitting;

CREATE TABLE IF NOT EXISTS person( -- user is a reserved word :(
    personID int NOT NULL AUTO_INCREMENT,
    email varchar(65535),
    passphrase varchar(65535),
    phone int,
    personFName varchar(65535),
    personLName varchar(65535),
    streetAddress varchar(65535),
    city varchar(65535),
    USState varchar(65535),
    zipCode int,
    personType int,
    PRIMARY KEY (personID)
    );

CREATE TABLE IF NOT EXISTS pet(
    petID int NOT NULL AUTO_INCREMENT,
    personID int,
    petName varchar(65535), -- apparently Name is also a reserved word in SQL.  I found a list of them: https://dev.mysql.com/doc/refman/5.7/en/keywords.html
    species int,
    requirements varchar(65535),
    PRIMARY KEY (petID),
    FOREIGN KEY (personID) REFERENCES person(personID)
    );

CREATE TABLE IF NOT EXISTS appointment(
    appointmentID int NOT NULL AUTO_INCREMENT,
    petOwner int,
    petSitter int,
    startTime datetime,
    duration int,
    PRIMARY KEY (appointmentID),
    FOREIGN KEY (petOwner) REFERENCES person(personID), -- possibly add constraint Person type = owner
    FOREIGN KEY (petSitter) REFERENCES person(personID) -- possibly add constraint Person type = sitter
    );

CREATE TABLE IF NOT EXISTS review(
    reviewID int NOT NULL AUTO_INCREMENT,
    personID int,
    appointmentID int,
    reviewText varchar(65535),
    PRIMARY KEY (reviewID),
    FOREIGN KEY (personID) REFERENCES person(personID),
    FOREIGN KEY (appointmentID) REFERENCES appointment(appointmentID)
    );

-- for pet-appointment, we can either have a separate 
-- auto-incremented primary key or we can do a composite
-- primary key composed of pet_id and appointment_id 
-- I left the former implementation commented out

CREATE TABLE IF NOT EXISTS petAppointment(
--    petAppointmentID int NOT NULL AUTO_INCREMENT,
    petID int,
    appointmentID int,
--    PRIMARY KEY (petAppointmentID),
    PRIMARY KEY (petID, appointmentID),
    FOREIGN KEY (petID) REFERENCES pet(petID),
    FOREIGN KEY (appointmentID) REFERENCES appointment(appointmentID)
    );