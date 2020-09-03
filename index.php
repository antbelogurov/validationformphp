<?php
session_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/cfg/data.php';
require_once __DIR__ . '/cfg/functions.php';



if (!empty($_POST)) {
    $examples = loading($examples);
    if ($errors = validate($examples)) {
        $res = ['answer' => 'error', 'errors' => $errors];
    } else {
        if (!sendMail($examples, $mailSettings)) {
            $res = ['answer' => 'error', 'errors' => "Ошибка отправки письма"];
        } else {
            $res = ['answer' => 'ok', 'capcha' => setCapcha()];
        } // mail$res = ['answer' => 'error', 'errors' => $errors];
    }
    exit(json_encode($res));
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validation form</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>

<body style="background-color:silver">
    <div class="container">
        <div class="col-md-6 offset-md-3">

            <form method="POST" id="form" class='p-4 m-5 bg-light d-flex flex-column rounded needs-validation' novalidate>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name">
                    <div class="invalid-feedback">
                        Вы не ввели Имя
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" required>
                    <div class="invalid-feedback">
                        Вы не ввели почту
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" required>
                    <div class="invalid-feedback">
                        Вы не ввели пароль
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="number" class="form-control" name="phone" required>
                    <div class="invalid-feedback">
                        Вы не ввели телефон
                    </div>
                </div>
                <div class="form-group">
                    <label for="adress">Adress</label>
                    <input type="text" class="form-control" name="adress">
                </div>
                <div class="form-group">
                    <label for="comment">Comment</label>
                    <textarea type="text" class="form-control" name="comment" rows='3'></textarea>
                </div>
                <div class="form-group form-check">
                    <input name="check" type="checkbox" class="form-check-input" id="check" required>
                    <label class="form-check-label" for="check">Соглашаюсь с обработкой персональных данных</label>
                    <div class="invalid-feedback">
                        Пожалуйста, согласитесь
                    </div>
                </div>
                <div class="form-group">
                    <label for="capcha" id="label-capcha"><?= setCapcha() ?> </label>
                    <input type="text" class="form-control" name="capcha" required>
                    <div class="invalid-feedback">
                        Вы неправильно ввели капчу
                    </div>
                </div>
                <button type="submit" class="btn btn-success text-center justify-content-center btn-lg">Submit</button>


                <div class="mt-3" id="answer"></div>

                <div class="load">
                    <img src="load.svg" alt="">
                </div>
            </form>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="main.js"></script>
</body>

</html>