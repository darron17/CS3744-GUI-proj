
    <div id="content">

      <div id="content-left">

        <h2>About us</h2>
        <p>"What's Popping?" is a social news site made to help spread news and build a community
          all around K-pop. K-pop, or Korean pop, is a type of music that started in South Korea in the '90s
          and has been on the rise ever since. The K-pop industry consists of companies forming groups of talented
          boy and/or girl groups to make and perform music. Some of the most famous groups of today include the girl groups
          Twice and Blackpink as well as boy groups such as EXO and BTS.
        </p>
        <img src="public/img/BTS_pic.jpg" alt="BTS pic" width="300">
        <!-- source: https://medium.com/@lukewaltham/why-btss-performance-at-the-amas-is-so-important-78861ae35a02 -->

        <img src="public/img/Blackpink_pic.jpg" alt="Blackpink pic" width="350">
        <!-- source: https://ygdreamers.com/2018/10/22/show-181021-blackpink-performs-ddu-du-ddu-du-on-japanese-talk-show-love-music/ -->


      </div><!-- #content-left -->

      <div id="content-right">

        <img src="<?= IMG_URL ?>/Bell_icon.png" alt="Notification Bell" width=50>
        <!-- source:https://www.iconfinder.com/icons/211694/bell_icon -->

        <h3>Recent Activity</h3>
        <?php if(count($events) > 0): ?>
          <ul id="recent_activity">
          <?php foreach($events as $e): ?>
            <?php if($e->$user_1_id == $_SESSION['loggedInUserID']): ?>
              <li><?= formatEvent($e) ?></li>
            <?php endif; ?>
          <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <p>No recent activity.</p>
        <?php endif; ?>

      </div><!-- #content-right -->

    </div><!-- #content -->
