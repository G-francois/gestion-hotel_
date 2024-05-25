<?php

$url = $_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER["HTTP_HOST"] . PATH_PROJECT . 'client/modification_mot_passe/index/{id_utilisateur}/{token}';

$url = str_replace('{id_utilisateur}', $id_utilisateur, $url);

$url = str_replace('{token}', $token, $url);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email de gestion d'hotel</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #F5F5F5;
            text-align: center;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #FFFFFF;
            border: 1px solid #DDDDDD;
            border-radius: 5px;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            margin: 0;
            color: #fff;
        }

        img {
            width: auto;
            height: 80px;
        }

        p {
            font-size: 16px;
            margin-top: 10px;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        a {
            display: flex;
            justify-content: center;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #1E90FF;
            color: #012970;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .button:hover {
            background-color: #f6f9ff;
            color: #1E90FF;
            border: 1px solid #1E90FF;
        }
    </style>
</head>

<body>
<div class="container" style="background-color: black; display: flex; justify-content: center; align-items: center;">
    <div style="margin-right: 40px; margin-left: 70px;">
        <img src="https://celebrason.com/media/1473737489_palmier-courbe-543556a76ac15.png" alt="">
    </div>
    <div>
        <h1> SOUS LES COCOTIERS <br>Vérification de l'adresse email</h1>
    </div>

</div>
<div class="container" style="text-align: center; align-items: center; flex-direction: column;">
    <p>Nous avons reçu votre demande de réinitialisation de mot de passe. Afin de pouvoir modifier le mot de passe de
        votre compte,
        veuillez cliquer sur le bouton ci-dessous pour modifier votre mot de passe :</p>

    <a href="<?= $url ?>" target="_blank" class="d-flex flex-wrap"
       style="display: list-item; justify-content: center; background-color: #1a73e8; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 5px;">Modifier
        mot de passe</a>

    <p>Une fois que vous aurez cliqué sur le bouton, vous pourrez créer un nouveau mot de passe afin de pouvoir accéder
        à votre compte.</p>
    <p>Si vous rencontrez des difficultés pour modifier votre mot de passe ou si vous avez des questions, n'hésitez pas
        à nous écrire.</p>
    <p>Cordialement, l'équipe de l'hôtel "SOUS LES COCOTIERS"</p>
</div>
</body>

</html>