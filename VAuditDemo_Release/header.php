<!DOCTYPE html>
<html lang="en">
  <head>
    <title>VAuditDemo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="/css/bootswatch.min.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../bower_components/html5shiv/dist/html5shiv.js"></script>
      <script src="../bower_components/respond/dest/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <script src="/js/bsa.js"></script>

    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="/" class="navbar-brand">VAuditDemo</a>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav">
            <li>
              <a href="/message.php">留言</a>
            </li>
            <li>
              <a href="/index.php?module=about">關於<span></a>
            </li>
          </ul>
          <form class="navbar-form navbar-left" action="/search.php" method="get">
            <input type="text" name="search" class="form-control col-lg-8" placeholder="搜索留言">
          </form>
          <ul class="nav navbar-nav navbar-right">
      <?php if ( isset( $_SESSION['username'] ) ) {?>
            <li><a href="/user/user.php"><?php echo $_SESSION['username'];?></a></li>
            <li><a href="/user/logout.php">退出</a></li>
      <?php } else if ( isset( $_SESSION['admin'] ) ) {?>
        <li><a href="/admin/manage.php"><?php echo $_SESSION['admin'];?></a></li>
            <li><a href="/user/logout.php">退出</a></li>
      <?php } else {?>
      <li><a href="/user/login.php">登录</a></li>
            <li><a href="/user/reg.php">注册</a></li>
      <?php }?>
          </ul>

        </div>
      </div>
    </div>

<br />
    <div class="container">
