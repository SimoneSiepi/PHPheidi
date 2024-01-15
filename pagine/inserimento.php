<?php
include "../Connesione.php";
$conn = new mysqli($host, $username, $password, $dbName);
if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}

//Inserimento dati autore
$autore_nome = $_POST['autore_nome'];
$autore_cognome = $_POST['autore_cognome'];
$autore_data = $_POST['autore_data'];

$sql_autore = "INSERT INTO Autori (nome_autore, cognome_autore, data_di_nascita) VALUES ('$autore_nome', '$autore_cognome', '$autore_data')";

if ($conn->query($sql_autore) === TRUE) {
    $id_autore = $conn->insert_id;
} else {
    echo "Errore nell'inserimento dell'autore: " . $conn->error;
}

//Inserimento dati casa editrice
$editore_nome = $_POST['editore'];
$editore_sede = $_POST['editore_sede'];

$sql_editore = "INSERT INTO Case_Editrici (nome_casa_editrice, sede_casa_editrice) VALUES ('$editore_nome', '$editore_sede')";

if ($conn->query($sql_editore) === TRUE) {
    $id_casa_editrice = $conn->insert_id;
} else {
    echo "Errore nell'inserimento della casa editrice: " . $conn->error;
}

//inserimento genere
$categoria = $_POST['genere'];
$sql_genere="INSERT INTO generi(nome_genere) VALUES ('$categoria')";
//Inserimento dati libro
$titolo_libro = $_POST['libro'];
$prezzo = $_POST['libro_prezzo'];
$giacenza_minima = $_POST['libro_giacenza'];

$sql_libro = "INSERT INTO Libri (titolo_libro, id_autore, categoria, id_casa_editrice, prezzo, giacenza_minima) VALUES ('$titolo_libro', $id_autore, '$categoria', $id_casa_editrice, $prezzo, $giacenza_minima)";

if ($conn->query($sql_libro) === TRUE) {
    $ultimo_id_inserito = $conn->insert_id;
    echo "Dati inseriti con successo. ID dell'ultimo libro inserito: " . $ultimo_id_inserito;
} else {
    echo "Errore nell'inserimento dei dati del libro: " . $conn->error;
}

$conn->close($conn);
?>
