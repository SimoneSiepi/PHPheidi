USE libreria;
SELECT id, CONCAT(nome_autore, ' ', cognome_autore) AS nome_completo, data_di_nascita FROM autori;


SELECT 
	libri.id AS id_libro, autori.nome_autore, libri.titolo_libro AS libro,case_editrici.nome_casa_editrice AS casa_editrice, generi.nome_genere AS genere,libri.prezzo, libri.giacenza_minima
FROM 
	libri
INNER JOIN autori ON libri.id_autore=autori.id
INNER JOIN case_editrici ON libri.id_casa_editrice= case_editrici.id
INNER JOIN generi ON libri.categoria=generi.nome_genere;