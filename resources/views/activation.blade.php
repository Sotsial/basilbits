<!-- resources/views/emails/activation.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Активация аккаунта</title>
</head>

<body>
    <h1>Здравствуйте, {{ $user->name }}!</h1>
    <p>Спасибо за регистрацию в BasilBits.</p>
    <p>Для активации вашего аккаунта, пожалуйста, перейдите по следующей ссылке:</p>
    <p><a href="{{ $activationLink }}">Активировать аккаунт</a></p>
    <p>Если вы не регистрировались на нашем сайте, просто игнорируйте это письмо.</p>
</body>

</html>
<p>С уважением,<br>
    Команда BasilBits</p>