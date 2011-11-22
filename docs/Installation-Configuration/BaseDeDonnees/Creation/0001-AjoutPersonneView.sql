CREATE VIEW `INSSET_Airlines`.`PersonneView` AS
SELECT p.noPersonne AS noPersonne,
pt.labelTelephone AS labelTelephone,
pt.noTelephone AS noTelephone,
t.numTelephone AS numTelephone
FROM Personne AS p
INNER JOIN Personne_has_Telephone AS pt
ON p.noPersonne = pt.noPersonne
INNER JOIN Telephone AS t
ON pt.noTelephone = t.noTelephone
