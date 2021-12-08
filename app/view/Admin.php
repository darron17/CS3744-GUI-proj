
    <div id="content">
      <?php foreach($users as $user): ?>
        <p>Account: <?= createUsernameLink($user->id) ?></p>
        <p>Role: <?= findRole($user) ?></p>

        <?php if(findRole($user) == 'Admin' || findRole($user) == 'Passive User'): ?>

          <form id="active" method="POST" action="<?= BASE_URL ?>/ChangeRole/process-<?= $user->id ?>-active">
            <input class="active" type="submit" value="Change to Active User" name="active">
          </form>

        <?php endif; ?>

        <?php if(findRole($user) == 'Admin' || findRole($user) == 'Active User'): ?>

          <form id="passive" method="POST" action="<?= BASE_URL ?>/ChangeRole/process-<?= $user->id ?>-passive">
            <input class="passive" type="submit" value="Change to Passive User" name="passive">
          </form>

        <?php endif; ?>

        <?php if(findRole($user) == 'Passive User' || findRole($user) == 'Active User'): ?>

          <form id="admin" method="POST" action="<?= BASE_URL ?>/ChangeRole/process-<?= $user->id ?>-admin">
            <input class="admin" type="submit" value="Change to Admin" name="admin">
          </form>

        <?php endif; ?>
      <?php endforeach; ?>




    </div><!-- #content -->
