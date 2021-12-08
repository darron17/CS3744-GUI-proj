
    <div id="content">
      <div id="content-left">

        <form id="submitNews" method="POST" action="<?= BASE_URL ?>/New_Post/process">
          <h2>Post Title</h2>
          <input class="title" name="title" type="text" placeholder="Type title here">

          <h2>Body</h2>
          <textarea id="body" class="body" name="body" placeholder="Type content here"></textarea>

          <h2 class="description">Description</h2>
          <h2 class="links">Links</h2>
          <h2 class="image">Image</h2>

          <textarea id="desc" class="descBox" name="description" placeholder="Type short description here"></textarea>
          <textarea class="linksBox" name="url" placeholder="Type link urls here"></textarea>
          <textarea class="imageBox" name="img" placeholder="Type image url here"></textarea>

          <input class="submitBtn" type="submit" value="Finish post">
        </form>

      </div><!-- #content-left -->

      <div id="content-right">

      </div><!-- #content-right -->

    </div><!-- #content -->
