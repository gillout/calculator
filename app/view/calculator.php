<?php
$inputs = isset($inputs) ? $inputs : '';
$result = isset($result) ? $result : '0';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>calculator</title>
    <link rel="stylesheet" href="/css/calculator.css">
</head>
<body>
<div class="calculator">
    <div class="screens">
        <div class="input">
            <!-- Affichage de l'historique des opérations effectuées -->
            <div class="inputs-screen">
                <span><?= $inputs ?></span>
            </div>
        </div>
        <!-- Affichage du résultat -->
        <div class="result-screen">
            <span><?= $result ?></span>
        </div>
    </div>
    <div class="buttons">
        <!--
        Les touches de la calculette sont représentées par un formulaire utilisant la méthode post.
        Il envoie le champ "action" dans le cas d'une opération ou le champ "value" dans le cas de la saisie d'un
        chiffre
        -->
        <form method="post" id="action">
            <div class="row">
                <button type="submit" name="action" value="clear">c</button>
                <button type="submit" name="action" value="plusmn">&plusmn;</button>
                <button type="submit" name="action" value="percnt">&percnt;</button>
                <button type="submit" name="action" value="divide">&divide;</button>
            </div>
            <div class="row">
                <button type="submit" name="value" value="7">7</button>
                <button type="submit" name="value" value="8">8</button>
                <button type="submit" name="value" value="9">9</button>
                <button type="submit" name="action" value="times">&times;</button>
            </div>
            <div class="row">
                <button type="submit" name="value" value="4">4</button>
                <button type="submit" name="value" value="5">5</button>
                <button type="submit" name="value" value="6">6</button>
                <button type="submit" name="action" value="minus">&minus;</button>
            </div>
            <div class="row">
                <button type="submit" name="value" value="1">1</button>
                <button type="submit" name="value" value="2">2</button>
                <button type="submit" name="value" value="3">3</button>
                <button type="submit" name="action" value="plus">&plus;</button>
            </div>
            <div class="row">
                <button type="submit" name="value" value="0">0</button>
                <button type="submit" name="action" value="middot">&middot;</button>
                <button type="submit" name="action" value="equals">&equals;</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
