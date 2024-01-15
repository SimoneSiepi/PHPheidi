<?php
include "Connesione.php";//parametri di connessione in caso di errore da un warning
//require "./Connesione.php";//  -- IN CASO DI ERRORE DA UN ERRORE è CHIUDE LA CONNESSIONE  

$conn=mysqli_connect($host,$username,$pasword,$dbName);
if (mysqli_connect_errno()) {
    echo 'connessione fallita: '. die(mysqli_connect_error());
}

$prodotti=[];

$fileName="prodotti.txt";
$testo=fopen($fileName,"r") or exit("impossibile caricare il file");
while (!feof($testo)) {
    $riga=explode(";",fgets($testo));
    $prodotti[] = [
        'nome' => $riga[0],
        'negozio' => $riga[1],
        'quantita' => $riga[2],
        'prezzo' => $riga[3],
        'tipologia'=> $riga[4]
    ];
}
fclose($testo);

$query="CREATE TABLE IF NOT EXISTS articolo(
    nome VARCHAR(50) NOT NULL,
    negozio VARCHAR(50) NOT NULL,
    quantita INT(255),
    prezzo INT(255) CHECK(prezzo>0),
    tipologia VARCHAR(50) NOT NULL
    )";
mysqli_query($conn,$query);
foreach($prodotti as $key => $articolo){
if($articolo['nome'] != "Nome"){
    $query="INSERT INTO articolo (nome,negozio,quantita,prezzo,tipologia)
    VALUES ('$articolo[nome]', '$articolo[negozio]','$articolo[quantita]','$articolo[prezzo]','$articolo[tipologia]')";
    mysqli_query($conn,$query);
}
}
mysqli_close($conn);

echo 'dati inseriti';
?>