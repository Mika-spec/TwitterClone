<?php
//エラー表示あり
ini_set('display_errors', 1);

//日本時間にする
date_default_timezone_set('Asia/Tokyo');

//URL/ディレクトリ設定
define('HOME_URL', '/TwitterClone/');

////////////////////////////////////////////////////////////
//  ツイート一覧
////////////////////////////////////////////////////////////
$view_tweets = [
  [
    'user_id' => 1,
    'user_name' => 'taro',
    'user_nickname' => '太郎',
    'user_image_name' => 'sample-person.jpg',
    'tweet_body' => '今プログラミングをしています。',
    'tweet_image_name' => null,
    'tweet_created_at' => '2021-3-15 14:00:00',
    'like_id' => null,
    'like_count' => 0,
  ],
  [
    'user_id' => 2,
    'user_name' => 'jiro',
    'user_nickname' => '次郎',
    'user_image_name' => null,
    'tweet_body' => 'コワーキングスペースをオープンしました！',
    'tweet_image_name' => 'sample-post.jpg',
    'tweet_created_at' => '2021-3-14 14:00:00',
    'like_id' => 1,
    'like_count' => 1,
  ],
];

////////////////////////////////////////////////////////////
//  便利な関数
////////////////////////////////////////////////////////////

/**
 * 画像ファイル名から画像のURLを生成
 * 
 * @param string $name 画像ファイル名 //第一引数
 * @param string $type ユーザー画像かアップロード画像か //第二引数
 * @return string 
 */
function buildImagePath(string $name = null, string $type) //第一引数=>nullの許容(画像が無くてもエラーにならない)
{
  if ($type === 'user' && !isset($name)) {
    return HOME_URL . 'Views/img/icon-default-user.svg'; //デフォルトのアイコン画像表示
  }

  return HOME_URL . 'Views/img_uploaded/' . $type . '/' . htmlspecialchars($name);
  // 例）/TwitterClone/Views/img_uploaded/user/sample-person.jpg
}


/**
 * 指定した日からどれだけ経過したかを取得
 * 
 * @param string $datetime 日時 //引数の説明
 * @return string //戻り値の説明
 */
function convertToDayTimeAgo(string $datetime) 
{
  $unix = strtotime($datetime); //1970年1月1日0時から、現在までの経過秒数
  $now = time(); //投稿した時間
  $diff_sec = $now - $unix; //投稿した時間からどれだけ経過したか

  if ($diff_sec < 60) { //経過時間が60秒(1分)未満の場合
    $time = $diff_sec;
    $unit = '秒前';
  } elseif ($diff_sec < 3600){ // 60秒*60秒=3600秒=1h => 1h未満の場合
    $time = $diff_sec / 60;
    $unit = '分前';
  } elseif ($diff_sec < 86400){ //3600秒(1h)*24 => 1day未満の場合
    $time = $diff_sec / 3600;
    $unit = '時間前';
  } elseif ($diff_sec < 2764800){ //86400秒(1day)*32 => 32day未満の場合
    $time = $diff_sec / 86400;
    $unit = '日前';
  } else {
    if (date('Y') != date('Y', $unix)) { //投稿した年と現在の年が一緒か否か
      $time = date('Y年n月j日', $unix);
    } else {
      $time = date('n月j日', $unix);
    }  
    return $time;
  }
  return (int)$time . $unit;
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="ホーム画面です">
  <link rel="icon" href="<?php echo HOME_URL; ?>Views\img\logo-twitterblue.svg">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <link href="<?php echo HOME_URL; ?>Views\CSS\style.css" rel="stylesheet">
  <title>ホーム画面/Twitterクローン</title>
</head>

<body class="home">
  <div class="container">
    <!-- メイン画面左サイドのアイコン表示 -->
    <div class="side">
      <div class="side-inner">
        <ul class="nav flex-column">
          <li class="nav-item"><a href="home.php" class="nav-link"><img src="<?php echo HOME_URL; ?>Views\img\logo-twitterblue.svg" alt="" class="icon"></a></li>
          <li class="nav-item"><a href="home.php" class="nav-link"><img src="<?php echo HOME_URL; ?>Views\img\icon-home.svg" alt=""></a></li>
          <li class="nav-item"><a href="search.php" class="nav-link"><img src="<?php echo HOME_URL; ?>Views\img\icon-search.svg" alt=""></a></li>
          <li class="nav-item"><a href="notification.php" class="nav-link"><img src="<?php echo HOME_URL; ?>Views\img\icon-notification.svg" alt=""></a></li>
          <li class="nav-item"><a href="profile.php" class="nav-link"><img src="<?php echo HOME_URL; ?>Views\img\icon-profile.svg" alt=""></a></li>
          <li class="nav-item"><a href="post.php" class="nav-link"><img src="<?php echo HOME_URL; ?>Views\img\icon-post-tweet-twitterblue.svg" alt="" class="post-tweet"></a></li>
          <li class="nav-item my-icon"><img src="<?php echo HOME_URL; ?>Views\img_uploaded\user\sample-person.jpg" alt=""></li>
        </ul>
      </div>
    </div>

    <div class="main">
      <!-- ツイート投稿欄 -->
      <div class="main-header">         
        <h1>ホーム</h1>
      </div>
      <div class="tweet-post">
        <!-- ユーザーアイコン表示 -->
        <div class="my-icon">
          <img src="<?php echo HOME_URL; ?>Views\img_uploaded\user\sample-person.jpg" alt="">
        </div>
        <!-- 文章入力欄 -->
        <div class="input-area">
          <form action="post.php" method="post" enctype="multipart/form-data">
            <textarea name="body" placeholder="いまどうしてる？" maxlength="140"></textarea>
            <div class="bottom-area">
              <div class="mb-0">
                <!-- ファイルを選択するボタン -->
                <input type="file" name="image" class="form-control form-control-sm">
              </div>
              <!-- 投稿するボタン -->
              <button class="btn" type="submit">つぶやく</button> 
            </div>
          </form>
        </div>
      </div>
      <!-- 投稿欄と投稿済み欄の境目ライン -->
      <div class="ditch"></div>

      <!-- 投稿済みの欄/ツイートがない場合 -->
      <?php if(empty($view_tweets)): ?>
        <!-- p-3＝＞1eｍスペース空ける -->
        <p class="p-3">ツイートがまだありません。</p>

      <?php else: ?>
      <!-- ツイートがある場合 -->
      <div class="tweet-list">
        <?php foreach($view_tweets as $view_tweet): ?>
          <div class="tweet">
            <!-- ユーザーアイコン表示 -->
            <div class="user">
              <a href="profile.php?user_id=1">
                <img src="<?php echo buildImagePath($view_tweet['user_image_name'] , 'user'); ?>" alt="">
              </a>
            </div>

            <!-- ツイートの中身 -->
            <div class="content">
              <!-- ユーザー情報(ID、名前、時間) -->
              <div class="name">
                <a href="profile.php?user_id=<?php echo htmlspecialchars($view_tweet['user_id']); ?>">
                  <span class="nickname"><?php echo htmlspecialchars($view_tweet['user_nickname']); ?></span> 
                  <span class="user-name">＠<?php echo htmlspecialchars($view_tweet['user_name']); ?> ・<?php echo convertToDayTimeAgo($view_tweet['tweet_created_at']); ?></span> 
                </a>
              </div>
              <!-- ツイートした文章 -->
              <p><?php echo htmlspecialchars($view_tweet['tweet_body']); ?></p>
              <!-- 画像があれば表示 -->
              <?php if (isset($view_tweet['tweet_image_name'])): ?>
                <img src="<?php echo buildImagePath($view_tweet['tweet_image_name'] , 'tweet'); ?>" alt="" class="post-image">
              <?php endif; ?>

              <!-- いいね！がある時ない時 -->
              <div class="icon-list">
                <div class="like">
                  <?php 
                  if (isset($view_tweet['like_id'])) {
                    // いいね！している場合
                    echo '<img src="' . HOME_URL . 'Views\img\icon-heart-twitterblue.svg" alt="">';
                  } else {
                    echo '<img src="' . HOME_URL . 'Views\img\icon-heart.svg" alt="">';
                  }
                  ?>
                </div>
                <!-- いいね！の数 -->
                <div class="like-count"><?php echo htmlspecialchars($view_tweet['like_count']); ?></div>
              </div>
            </div><!-- /.content -->
          </div><!-- /.tweet -->
        <?php endforeach; ?>
      </div><!-- /.tweet-list -->
      <?php endif; ?>
    </div><!-- /.main -->
  </div><!-- /.container -->
</body>
</html>