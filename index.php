<?php
session_start();

if(isset($_GET["unos_naslova"])){
    $a = $_GET["unos_naslova"];
}else{
    $a = 0;
}

require_once('config/db.php');
$query = "SELECT estate_ad.id_ad, estate_ad.ad_title, city_languages.name AS \"cityn\", hood.name AS \"hoodn\", estate_ad.street, estate_ad.price, estate_ad.surface, estate_type_languages.name AS \"typen\" FROM estate_ad LEFT JOIN city_languages ON estate_ad.id_city = city_languages.id_city LEFT JOIN hood ON estate_ad.id_hood = hood.id_hood LEFT JOIN estate_type_languages ON estate_ad.id_type = estate_type_languages.id_type WHERE ad_title = \"".$a."\" AND estate_ad.deleted = 0;";
$result = mysqli_query($con, $query);

$query2 = "SELECT DISTINCT ad_title FROM estate_ad";
$result2 = mysqli_query($con, $query2);
$autoList = [];

while($row = mysqli_fetch_assoc($result2)){
    array_push($autoList, $row['ad_title']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src=validation.js></script>
</head>
<body>
    <main>

        <form action="index.php" method="GET" autocomplete="off">
            <div class="container">
                <div class="wrapper show">
                    <label for="unos_naslova">Uneti naslov: </label>
                    <input id="unos_naslova" name="unos_naslova" type="text" placeholder="Naslov...">
                    <ul class="results">
                    </ul><br>
                </div>
            </div>
            <button type="submit">Submit</button>
        </form>

        <script>

        let lista = <?php echo json_encode($autoList) ?>;
        for(i=0; i<lista.length; i++){
            let holder1 = lista[i];
            let holder2 = holder1.trimStart();
            lista[i] = holder2;
        }
        lista = lista.sort();

        let searchInput = document.getElementById("unos_naslova");
        let resultWrapper = document.querySelector(".results");

        searchInput.onkeyup = function(){
            let result = [];
            let input = searchInput.value;
            if(input.length){
                result = lista.filter((keyword) => {
                    return keyword.toLowerCase().startsWith(input.toLowerCase());
                })
                console.log(result);
            }
            display(result);
        }

        function display(result){
            $cnt = 1;
            
            let content = result.map((list) => {
                if($cnt<=10){
                    $cnt++;
                    return "<li onclick=selectInput(this)>" + list + "</li>";
                }
                
            });

            resultWrapper.innerHTML = "<ul>" + content.join('') + "</ul>";
        }

        function selectInput(list){
            searchInput.value = list.innerHTML;
            resultWrapper.innerHTML = "";

        }
    </script>

        <br>

        <table border="solid">
            <tr>
                <th>Naslov oglasa</th>
                <th>Grad</th>
                <th>Deo grada</th>
                <th>Ulica</th>
                <th>Cena</th>
                <th>Kvadratura</th>
                <th>Tip nekretnine</th>
            </tr>
            <tr>
                <?php

                $naslov = [];
                $grad = [];
                $naselje = [];
                $ulica = [];
                $cena = [];
                $kvadratura = [];
                $tip = [];
                $id = "";

                while($row = mysqli_fetch_assoc($result)){
                    $id = $row['id_ad'];
                ?>

                    <td> <?php echo $row['ad_title']; array_push($naslov, $row['ad_title'])?> </td>
                    <td> <?php echo $row['cityn']; array_push($grad, $row['cityn']) ?></td>
                    <td> <?php echo $row['hoodn']; array_push($naselje, $row['hoodn']) ?> </td>
                    <td> <?php echo $row['street']; array_push($ulica, $row['street']) ?> </td>
                    <td> <?php echo $row['price']; array_push($cena, $row['price']) ?> </td>
                    <td> <?php echo $row['surface']; array_push($kvadratura, $row['surface']) ?> </td>
                    <td> <?php echo $row['typen']; array_push($tip, $row['typen']) ?> </td>
                    </tr>
                <?php
                    
                    }
                    $_SESSION["l0"] = $id;

                    $_SESSION["l1"] = $naslov;
                    $_SESSION["l2"] = $grad;
                    $_SESSION["l3"] = $naselje;
                    $_SESSION["l4"] = $ulica;
                    $_SESSION["l5"] = $cena;
                    $_SESSION["l6"] = $kvadratura;
                    $_SESSION["l7"] = $tip;
                ?>
            
        </table>

        <br>
        <hr>

        <form action="send.php" method="POST" autocomplete="off">
            <label for="poruka">Poruka: </label>
            <input type="text" name="poruka" id="poruka" placeholder="Poruka..."><br><br>
            <label for="email">E-mail: </label>
            <input type="email" name="email" id="email" placeholder="E-mail...">

            <button type="submit" onclick="isValid(email.value)" name="send">Send</button>
        </form>

    </main>

            
</body>
</html>