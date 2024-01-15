<?php
include "../Connesione.php";


$conn = new mysqli($host, $username, $password, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$queryLibri = "SELECT 
libri.id AS id_libro, autori.nome_autore, libri.titolo_libro AS libro,case_editrici.nome_casa_editrice AS casa_editrice, generi.nome_genere AS genere,libri.prezzo, libri.giacenza_minima
FROM 
libri
INNER JOIN autori ON libri.id_autore=autori.id
INNER JOIN case_editrici ON libri.id_casa_editrice= case_editrici.id
INNER JOIN generi ON libri.categoria=generi.nome_genere;";

$risultato= $conn->query($queryLibri);
$arrayLibri=array();
if ($risultato->num_rows>0) {
    while ($row= $risultato->fetch_array()) {
        $arrayLibri[]=$row;
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>cerca libri belli</title>
</head>

<body>
    <div class="boxEsterno">
        <header><h1>Ricerca</h1></header>
        <div class="boxForm">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <!-- autore  -->
                <label for="autore">Autore</label><br>
                <input type="text" name="autore" id="autore" class="filtroInput"><br>

                <!-- libro -->
                <label for="Titolo">Titolo del libro</label><br>
                <input type="text" name="Titolo" id="Titolo" class="filtroInput"><br>

                <!-- editore -->
                <select name="editore" id="editore">
                    <option value="">scegli una casa editrice</option>
                    <?php
                    $arrayControllo = [];
                    foreach ($arrayLibri as $libro) {
                        if (!in_array($libro['casa_editrice'], $arrayControllo)) {
                            $selected = (isset($_POST['editore']) && $_POST['editore'] == $libro['casa_editrice']) ? 'selected' : '';
                            echo "<option value='{$libro['casa_editrice']}' " . $selected . ">{$libro['casa_editrice']}</option>";

                            $arrayControllo[] = $libro['casa_editrice'];
                        }
                    }
                    ?>
                </select>

                <!-- categoria -->
                <select name="categoria" id="categoria">
                    <option value="">scegli una categoria</option>
                    <?php
                    $arrayControllo = [];
                    foreach ($arrayLibri as $libro) {
                        if (!in_array($libro['genere'], $arrayControllo)) {
                            $selected = (isset($_POST['categoria']) && $_POST['categoria'] == $libro['genere']) ? 'selected' : '';
                            echo "<option value='{$libro['genere']}' " . $selected . ">{$libro['genere']}</option>";

                            $arrayControllo[] = $libro['genere'];
                        }
                    }
                    ?>
                </select>

                <input type="submit" value="filtra">
            </form>

            <table id="outputTable">
            <?php


            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $filtroAutore = isset($_POST['autore']) ? trim($_POST['autore']) : '';
                $filtroTitolo = isset($_POST['Titolo']) ? trim($_POST['Titolo']) : '';
                $filtroEditore = isset($_POST['editore']) ? trim($_POST['editore']) : '';
                $filtroCategoria = isset($_POST['categoria']) ? trim($_POST['categoria']) : '';

                // Eseguo la ricerca anche se è presente un solo parametro
                if (!empty($filtroAutore) || !empty($filtroTitolo) || !empty($filtroEditore) || !empty($filtroCategoria)) {

                    echo "<h3>Risultati</h3>";
                    echo '<tr><th>Titolo</th>
                          <th>Autore</th>
                          <th>Editore</th>
                          <th>Genere</th>
                          <th>Prezzo</th>
                          <th>Giacenza</th>
                          </tr>';

                    foreach ($arrayLibri as $libro) {
                        $confrontoAutore = empty($filtroAutore) || stripos($libro['nome_autore'], $filtroAutore) !== false;
                        $confrontoTitolo = empty($filtroTitolo) || stripos($libro['libro'], $filtroTitolo) !== false;
                        $confrontoEditore = empty($filtroEditore) || stripos($libro['casa_editrice'], $filtroEditore) !== false;
                        $confrontoMateria = empty($filtroCategoria) || strpos($libro['genere'], $filtroCategoria) !== false;

                        if ($confrontoAutore && $confrontoTitolo && $confrontoEditore && $confrontoMateria) {
                            echo "<tr><td>".$libro['libro']."</td>
                            <td>".$libro['nome_autore']."</td>
                            <td>".$libro['casa_editrice']."</td>
                            <td>".$libro['genere']."</td>
                            <td>".$libro['prezzo']."</td>
                            <td>".$libro['giacenza_minima']."</td>
                            </tr>";
                        }
                    }

                    echo "</table>";
                }

                else{
                    echo "<p>Nessun filtro inserito. Inserisci almeno un criterio di ricerca</p>";
                }
            }

            ?>
        </div>
    </div>
    <footer>
        <p class="footer_text">creato da simone Fernandez IV</p>
    </footer>

</body>

</html>