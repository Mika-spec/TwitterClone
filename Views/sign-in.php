<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="\TwitterClone\Views\img\logo-twitterblue.svg">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <link href="\TwitterClone\Views\CSS\style.css" rel="stylesheet">
  <title>ログイン画面/Twitterクローン</title>
  <meta name="description" content="ログイン画面です">
</head>

<body class="signup text-center">
  <main class="form-signup">
    <form action="sign-in.php" method="post">
      <img src="\TwitterClone\Views\img\logo-white.svg" alt="" class="logo-white">
      <h1>Twitterクローンにログインする</h1>
      <input type="text" class="form-control" name="email" placeholder="メールアドレス" required autofocus>
      <input type="text" class="form-control" name="password" placeholder="パスワード" required>
      <button class="w-100 btn btn-lg" type="submit">ログイン</button>
      <p class="mt-3 mb-2"><a href="sign-up.php">会員登録する</a></p>
      <p class="mt-2 mb-3 text-muted">&copy; 2021</p>
    </form>
  </main>
</body>
</html>