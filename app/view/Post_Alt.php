
    <div id="content">
      <div id="content-upper">
        <div id="content-upper-left">

          <div class="post">
            <h2><?= $story->title ?></h2>
            <h3>By <?= createUsernameLink($story->author_id) ?> - <?= $story->date ?></h3>
            <p><?= $story->body ?></p>

            <h3><a href=<?= $story->url ?>><?= $story->url_header ?></a></h3>
            <div class="like_button">
							<button disabled class="like">Like</button>
						</div><!-- like_button -->
            <h3 class= "likes"><?= $story->likes ?></h3>
            <h3 class="liked_post_question"><a href="Signup">Sign up to like this post</a></h3>
          </div><!-- .post -->
        </div><!-- #content-upper-left -->

        <div id="content-upper-right">

          <img src="<?= $story->img ?>" width="300" onerror="this.style.display='none'"/>
          <!-- source: https://www.cheatsheet.com/entertainment/superm-releases-a-group-trailer-and-announces-first-concert.html/ -->

        </div><!-- #content-upper-right -->
      </div><!-- #content-upper -->

      <div id="content-lower">
        <div id="content-lower-left">

          <div id="storyID-<?= $story->id ?>" class="comment-section">

            <h2>Comments</h2>
            <h3><a href="Signup">Sign up to comment</a></h3>

            <?php foreach($comments as $comment): ?>

              <?php if($comment->storyID == $story->id): ?>
                <div class="comment">
                  <img src="public/img/User_icon.jpg" alt="User icon" width=50>
                  <!-- source: https://www.vectorstock.com/royalty-free-vector/user-icon-male-person-symbol-profile-avatar-vector-20787339 -->
                  <p>By <?= createUsernameLink($comment->author_id) ?> - <?= $comment->date ?></p>
                  <p><?= $comment->comment ?></p>
                </div><!-- comment -->
              <?php endif; ?>

            <?php endforeach; ?>
          </div><!-- #comment-section -->


        </div><!-- #content-lower-left -->

        <div id="content-lower-right">

          <h2>Top Posts</h2>

          <div id="storyID-<?= $top_story1->id ?>" class="story">
            <div class="like_button">
              <?php if(isset($_SESSION['loggedInUserID'])): ?>
                <button class="like">Like</button>
              <?php else: ?>
                <button disabled class="like">Like</button>
              <?php endif; ?>
            </div><!-- like_button -->
            <h3 class= "likes"><?= $top_story1->likes ?></h3>
            <?php if(isset($_SESSION['loggedInUserID'])): ?>
              <h3 class= "title"><a href="<?= $top_story1->url ?><?= $top_story1->id ?>"><?= $top_story1->title ?></a></h3>
            <?php else: ?>
              <h3 class= "title"><a href="<?= BASE_URL ?>/Post_Alt<?= $top_story1->id ?>"><?= $top_story1->title ?></a></h3>
            <?php endif; ?>
            <p class= "author">By <a href=""><?= $top_story1->author ?></a> - <?= $top_story1->date ?></p>
            <p class= "desc"><?= $top_story1->description ?></p>
          </div><!-- story -->

          <div id="storyID-<?= $top_story2->id ?>" class="story">
            <div class="like_button">
              <?php if(isset($_SESSION['loggedInUserID'])): ?>
                <button class="like">Like</button>
              <?php else: ?>
                <button disabled class="like">Like</button>
              <?php endif; ?>
            </div><!-- like_button -->
            <h3 class= "likes"><?= $top_story2->likes ?></h3>
            <?php if(isset($_SESSION['loggedInUserID'])): ?>
              <h3 class= "title"><a href="<?= $top_story2->url ?><?= $top_story2->id ?>"><?= $top_story2->title ?></a></h3>
            <?php else: ?>
              <h3 class= "title"><a href="<?= BASE_URL ?>/Post_Alt<?= $top_story2->id ?>"><?= $top_story2->title ?></a></h3>
            <?php endif; ?>
            <p class= "author">By <a href=""><?= $top_story2->author ?></a> - <?= $top_story2->date ?></p>
            <p class= "desc"><?= $top_story2->description ?></p>
          </div><!-- story -->

        </div><!-- #content-lower-right -->

      </div><!-- #content-lower -->
    </div><!-- #content -->
