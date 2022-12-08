CREATE VIEW appointmentView
AS 
SELECT DISTINCT 
    person1.personFName AS ownerFName, 
    person1.personLName AS ownerLName, 
    person1.email AS ownerEmail, 
    person2.personFName AS sitterFName, 
    person2.personLName AS sitterLName, 
    person2.email AS sitterEmail, 
    appointment.startTime, 
    appointment.duration, 
    appointment.appointmentID,
    review.reviewText
 FROM 
    (((appointment
 INNER JOIN 
    person AS person1 ON appointment.petOwner = person1.personID)
 LEFT JOIN 
    person AS person2 ON appointment.petSitter = person2.personID) 
 LEFT JOIN 
    review ON appointment.appointmentID = review.appointmentID)