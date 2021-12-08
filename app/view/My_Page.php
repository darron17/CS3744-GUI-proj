
    <div id="content">

      <div id="content-left">

        <h2>My Page</h2>
        <h3 class="section_headers">Liked Posts</h3>

        <?php foreach($stories as $story): ?>
          <?php if(checkLiked($likedStories, $story->id)): ?>

            <div id="storyID-<?= $story->id ?>" class="story">
              <div class="like_button">
                <button class="like" style="background-color: red; color: white;">Liked</button>
              </div><!-- like_button -->
              <h3 class= "likes"><?= $story->likes ?></h3>
              <h3 class= "title"><a href="<?= BASE_URL ?>/Post<?= $story->id ?>"><?= $story->title ?></a></h3>
              <p class= "author">By <?= createUsernameLink($story->author_id) ?> - <?= $story->date ?></p>
              <p class= "desc"><?= $story->description ?></p>
            </div><!-- story -->
          <?php endif; ?>
        <?php endforeach; ?>

        <?php if($_SESSION['loggedInUserRole'] == User::ROLE['admin'] || $_SESSION['loggedInUserRole'] == User::ROLE['active']): ?>

          <h3 class="section_headers">My Posts</h3>

          <?php foreach($stories as $story): ?>

            <?php if($story->author_id == $_SESSION['loggedInUserID']): ?>
              <div id="storyID-<?= $story->id ?>" class="story">
                <div class="like_button">
                  <?php if(checkLiked($likedStories, $story->id)): ?>
                    <button class="like" style="background-color: red; color: white;">Liked</button>
                  <?php else: ?>
                    <button class="like">Like</button>
                  <?php endif; ?>
                </div><!-- like_button -->
                  <h3 class= "likes"><?= $story->likes ?></h3>
                  <h3 class= "title"><a href="<?= BASE_URL ?>/Post<?= $story->id ?>"><?= $story->title ?></a></h3>
                  <form id="editing" method="POST" action="<?= BASE_URL ?>/Edit<?= $story->id ?>">
                    <input class="edit" type="submit" value="Edit" name="edit">
                  </form>
                  <form id="deleting" method="POST" action="<?= BASE_URL ?>/My_Page/process">
                    <input class="delete" type="submit" value="Delete <?= $story->id ?>" name="delete">
                  </form>
                  <p class= "author">By <?= createUsernameLink($story->author_id) ?> - <?= $story->date ?></p>
                  <p class= "desc"><?= $story->description ?></p>

              </div><!-- story -->
            <?php endif; ?>
          <?php endforeach; ?>


          <div class="newPostBtn">
            <a class="plus" href="New_Post"><img src="<?= IMG_URL ?>/Plus_icon.jpg" alt="Plus icon" width=30></a>
            <!-- https://www.freepik.com/ -->
            <h3>Add new post</h3>


          </div><!-- Add new post -->

        <?php endif;?>

        <h3 class="section_headers">Visualization of My Posts</h3>

        <div id="panel" style="display: none;">
          <p>Title: </p>
          <input type="text" id="txtEditTitle" name="txtEditTitle" />
          <input type="button" class="panelBtns" id="btnEdit" name="btnEdit" value="Edit" />
          <input type="button" class="panelBtns" id="btnDelete" name="btnDelete" value="Delete" />
        </div>

          <div id="mainBubble" style="height: 1000;">
            <svg class="mainBubbleSVG" width="969.0000000000001" height="679">
              <text id="bubbleItemNote" x="10" y="469.50000000000006" font-size="12" dominant-baseline="middle" alignment-baseline="middle" style="fill: rgb(136, 136, 136);">
              </text>
            </svg>
          </div>


      </div><!-- #content-left -->

      <div id="content-right">





      </div><!-- #content-right -->

    </div><!-- #content -->
