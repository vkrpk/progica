CREATE VIEW view_equipement_gite AS
SELECT eg.gite_id , eg.equipement_id, e.nom as 'nom_equipement', gs.service_id, s.nom as 'nom_service'
FROM gite g
INNER JOIN gite_service gs ON g.id = gs.gite_id
INNER JOIN service s ON s.id = gs.service_id
INNER JOIN equipement_gite eg ON g.id = eg.gite_id
INNER JOIN equipement e ON eg.equipement_id = e.id
ORDER BY eg.gite_id;