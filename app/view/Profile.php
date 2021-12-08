
    <div id="content">
      <form id="editing" method="POST" action="<?= BASE_URL ?>/EditProfile-<?= $user->username ?>">
        <h2><?= $pageTitle ?></h2>
        <p>Username: <?= $user->username ?></p>

        <p>First name: <?= $user->first ?></p>
        <p>Last name: <?= $user->last ?></p>
        <p>E-mail: <?= $user->email ?></p>
        <p>Experince: <?= $user->experience ?></p>

        <?php if($user->username == User::loadById($_SESSION['loggedInUserID'])->username): ?>
          <input class="editBtn" type="submit" value="Change info">
        <?php endif;?>
      </form>




    </div><!-- #content -->
