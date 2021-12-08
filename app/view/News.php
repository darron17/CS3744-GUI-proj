

    <div id="content">

      <div id="content-left">

        <h2>News</h2>

        <ul id="sortType">
          <li><input class="trending active" type="button" value="Trending"></li>
          <li><input class="most_recent" type="button" value="Most Recent"></li>
        </ul>

        <form id="search_bar_area">
          <input class="search_btn" type="button" value="Search">
          <input class="search_bar" name="search_bar" type="text" placeholder="Search">
        </form>

        <?php foreach($stories as $story): ?>

        <div id="storyID-<?= $story->id ?>" class="story">
          <div class="like_button">
            <?php if(isset($_SESSION['loggedInUserID'])): ?>
              <?php if(checkLiked($likedStories, $story->id)): ?>
                <button class="like" style="background-color: red; color: white;">Liked</button>
              <?php else: ?>
                <button class="like">Like</button>
              <?php endif; ?>
            <?php else: ?>
              <button disabled class="like">Like</button>
            <?php endif; ?>
          </div><!-- like_button -->
          <h3 class= "likes"><?= $story->likes ?></h3>
        <?php if(isset($_SESSION['loggedInUserID'])): ?>
          <h3 class= "title"><a href="<?= BASE_URL ?>/Post<?= $story->id ?>"><?= $story->title ?></a></h3>
        <?php else: ?>
          <h3 class= "title"><a href="<?= BASE_URL ?>/Post_Alt<?= $story->id ?>"><?= $story->title ?></a></h3>
        <?php endif; ?>
          <p class= "author">By <?= createUsernameLink($story->author_id) ?> - <?= $story->date ?></p>
          <p class= "desc"><?= $story->description ?></p>
        </div>

        <?php endforeach; ?>

        <div class="endStories"></div>

      </div><!-- #content-left -->

      <div id="content-right">


      </div><!-- #content-right -->

    </div><!-- #content -->
