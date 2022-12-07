CREATE VIEW petAndOwner
AS 
SELECT 
    person.email, 
    pet.petName, 
    pet.species, 
    pet.requirements,
    pet.petID
FROM
    pet
INNER JOIN
    person ON pet.personID = person.personID;