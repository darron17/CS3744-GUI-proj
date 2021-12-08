<?php include_once SYSTEM_PATH.'/view/helpers.php'; ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>What's Popping? | <?= $pageTitle ?></title>
    <link rel="stylesheet" href="public/css/styles.css">
    <?php if(isset($stylesheet)): ?>
      <link rel="stylesheet" href="public/css/<?= $stylesheet ?>.css">
    <?php endif; ?>
    <!-- Pages might use more than 1 style sheets -->
    <?php if(isset($stylesheet2)): ?>
      <link rel="stylesheet" href="public/css/<?= $stylesheet2 ?>.css">
    <?php endif; ?>
    <script>
      var base_url = '<?= BASE_URL ?>';
    </script>
    <script src="public/js/jquery-3.4.1.min.js"></script>
    <script src="http://d3js.org/d3.v3.min.js"></script>
    <script src="public/js/scripts.js"></script>
    <?php if(isset($script)): ?>
		    <script src="public/js/<?= $script ?>.js"></script>
	  <?php endif; ?>
    <!-- Pages might use more than 1 javascript sheets -->
    <?php if(isset($script2)): ?>
		    <script src="public/js/<?= $script2 ?>.js"></script>
	  <?php endif; ?>
  </head>

  <body>

    <div id="header">

      <div id="header-left">
        <h1>What's Popping?</h1>
        <ul id="primary-nav">
          <li><a href="Home"<?php if($pageTitle == 'Home') { echo ' class="selected"'; } ?>>Home</a></li>
          <li><a href="News"<?php if($pageTitle == 'News') { echo ' class="selected"'; }?>>News</a></li>
          <?php if(isset($_SESSION['loggedInUserID'])): ?>
            <li><a href="My_Page"<?php if($pageTitle == 'My_Page') { echo ' class="selected"'; }?>>My Page</a></li>
          <?php endif; ?>
        </ul>
      </div><!-- #header left -->

      <div id="header-right">
        <?php if(isset($_SESSION['loggedInUserID'])): ?>
          <img src="<?= IMG_URL ?>/Music_icon.png" alt="User's profile picture" width=50>
          <!-- source:https://pngtree.com/freepng/music-icon_3581507.html -->
          <p>
            Welcome <strong><?= createUsernameLink($_SESSION['loggedInUserID'])?></strong>! |
            <?php if($_SESSION['loggedInUserRole'] == User::ROLE['admin']): ?>
              <a href="Admin">Admin Page</a> |
            <?php endif; ?>
              <a href="Logout">Log out</a>
          </p>
        <?php elseif($pageTitle != 'Login'): ?>
          <p class="alt_user"><a href="Signup">Sign up</a> | <a href="Login">Log in</a></p>

        <?php endif; ?>


      </div><!-- header-right -->
    </div><!-- #header -->

    <?php if(isset($_SESSION['msg'])): ?>
			<div class="success">
				<?= $_SESSION['msg'] ?>
			</div>
		<?php unset($_SESSION['msg']); ?>
		<?php endif; ?>
