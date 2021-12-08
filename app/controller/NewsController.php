<?php

include_once '../global.php';

// Gets the route from ".htaccess"
$route = $_GET['route'];

// News controller object
$nc = new NewsController();

// Check the route and calls the corresponding function
if ($route == 'home') {
  $nc->home();
}
elseif ($route == 'news') {
  $nc->news();
}
elseif ($route == 'sort') {
  $nc->sort();
}
elseif ($route == 'my_page') {
  $nc->my_page();
}
elseif ($route == 'new_post') {
  $nc->new_post();
}
elseif ($route == 'post') {
  $nc->post();
}
elseif ($route == 'alt') {
  $nc->alt();
}
elseif ($route == 'add') {
  $nc->add();
}
elseif ($route == 'delete') {
  $nc->delete();
}
elseif ($route == 'deleteBubble') {
  $nc->deleteBubble();
}
elseif ($route == 'editBubble') {
  $nc->deleteBubble();
}
elseif ($route == 'edit') {
  $nc->edit();
}
elseif ($route == 'change') {
  $nc->change();
}
elseif ($route == 'admin') {
  $nc->admin();
}
elseif ($route == 'commentProcess') {
  $nc->commentProcess();
}
elseif ($route == 'likeProcess') {
  $nc->likeProcess();
}
elseif ($route == 'searchProcess') {
  $nc->searchProcess();
}
elseif ($route == 'viz') {
  $nc->viz();
}



// News controller class
class NewsController {

  // Sets the page title to "Home" and loads the header, content for the home page,
  // and the footer
  public function home() {
    $pageTitle = 'Home';

    $events = Event::loadAllEvents();

    include_once SYSTEM_PATH.'/view/header.php';
    include_once SYSTEM_PATH.'/view/Home.php';
    include_once SYSTEM_PATH.'/view/footer.php';
  }

  // Sets the page title to "News" and loads the header, content for the news page,
  // and the footer. Along with CSS and JS files
  public function news() {
    $stories = NewsStory::loadAllStoriesLikes();
    $likedStories = LikedPosts::loadLikedStoriesIDs($_SESSION['loggedInUserID']);

    $pageTitle = 'News';
    $stylesheet = 'stories';
    $script = 'stories';
    $script2 = 'news';

    include_once SYSTEM_PATH.'/view/header.php';
    include_once SYSTEM_PATH.'/view/News.php';
    include_once SYSTEM_PATH.'/view/footer.php';
  }

  // Used to process how the posts will be sorted when one of the sorting options
  // are clicked on the news page. Uses GET and loads the stories in order of
  // the corresponding way it was told to sort.
  // Then it creates arrays of the usernames of the story in the order of the stories
  // this is for printing the username links in the javascript file since we cannot
  // call createUsernameLink()
  // Lastly depending on the button that was pressed or the info in the url,
  // information will be sent back to the javascript file.
  public function sort() {
    $sortType = $_GET['sort_type'];

    $storiesT = NewsStory::loadAllStoriesLikes();
    $storiesMR = NewsStory::loadAllStoriesDate();
    $usernamesT = array();
    $usernamesMR = array();
    $loggedIn = false;
    if(isset($_SESSION['loggedInUserID'])) {
      $loggedIn = true;
    }

    $i = 1;
    while($storiesT[$i]->id != null) {
      $us = $storiesT[$i]->author;
      $usernamesT[$i] = $us;
      $i = $i + 1;
    }

    $j = 1;
    while($storiesMR[$j]->id != null) {
      $us = $storiesMR[$j]->author;
      $usernamesMR[$j] = $us;
      $j = $j + 1;
    }

    if ($sortType == null) {
      $json = array(
        'error' => 'Invalid sorting type'
      );
    }
    else {
      if ($sortType == 'trending') {
        $json = array(
          'success' => 'success',
          'stories' => $storiesT,
          'usernames' => $usernamesT,
          'loggedIn' => $loggedIn
        );
      }
      elseif($sortType == 'most_recent') {
        $json = array(
          'success' => 'success',
          'stories' => $storiesMR,
          'usernames' => $usernamesMR,
          'loggedIn' => $loggedIn
        );
      }
      else {
        $json = array(
          'error' => 'Invalid sorting type'
        );
      }
    }
    echo json_encode($json);
  }

  // Loads all the news stories from the SQL sorted by date from present to past.
  // Sets page title to "My_Page", stylesheet to stories.css, and javascript to
  // stories.js.
  // Loads the header, content for the my page page, and the footer.
  public function my_page() {
    $stories = NewsStory::loadAllStoriesDate();
    $likedStories = LikedPosts::loadLikedStoriesIDs($_SESSION['loggedInUserID']);

    $pageTitle = 'My_Page';
    $stylesheet = 'stories';
    $stylesheet2 = 'my_page';
    $script = 'stories';

    include_once SYSTEM_PATH.'/view/header.php';
    include_once SYSTEM_PATH.'/view/My_Page.php';
    include_once SYSTEM_PATH.'/view/footer.php';
  }

  // Sets the page title to "New_Post" and loads the header, content for the new post page,
  // and the footer
  public function new_post() {
    $pageTitle = 'New_Post';
    $stylesheet = 'new_post';
    $script = 'addNews';

    include_once SYSTEM_PATH.'/view/header.php';
    include_once SYSTEM_PATH.'/view/New_Post.php';
    include_once SYSTEM_PATH.'/view/footer.php';
  }

  // Gets the storyID and gets the story with the corresponding id.
  // Also loads stories with id 1 and 2 for the related stories on this page.
  // Sets page title to "Post", stylesheet to posts.css, stylesheet2 to stories.css,
  // and javascript to stories.js.
  // Loads the header, content for the post page, and the footer.
  public function post() {
    $storyID = $_GET['storyID'];
    $story = NewsStory::loadByID($storyID);
    $comments = Comments::loadAllComments();
    $topStories = NewsStory::loadAllStoriesLikes();
    $likedStories = LikedPosts::loadLikedStoriesIDs($_SESSION['loggedInUserID']);

    if ($storyID == 1 || $storyID == 2) {
      if ($storyID == 1) {
        $top_story1 = NewsStory::loadByID($topStories[2]->id);
        $top_story2 = NewsStory::loadByID($topStories[3]->id);
      }
      else {
        $top_story1 = NewsStory::loadByID($topStories[1]->id);
        $top_story2 = NewsStory::loadByID($topStories[3]->id);
      }
    }
    else {
      $top_story1 = NewsStory::loadByID($topStories[1]->id);
      $top_story2 = NewsStory::loadByID($topStories[2]->id);
    }

    $pageTitle = 'Post';
    $stylesheet = 'posts';
    $stylesheet2 = 'stories';
    $script = 'stories';
    $script2 = 'comments';

    include_once SYSTEM_PATH.'/view/header.php';
    include_once SYSTEM_PATH.'/view/Post.php';
    include_once SYSTEM_PATH.'/view/footer.php';
  }

  // Loads the stories with id 1 and 2 for the related stories on this page.
  // Sets page title to "Post_Alt", stylesheet to posts.css, stylesheet2 to stories.css,
  // and javascript to stories.js.
  // Loads the header, content for the alternate post page, and the footer.
  public function alt() {
    $storyID = $_GET['storyID'];
    $story = NewsStory::loadByID($storyID);
    $comments = Comments::loadAllComments();
    $topStories = NewsStory::loadAllStoriesLikes();

    if ($storyID == 1 || $storyID == 2) {
      if ($storyID == 1) {
        $top_story1 = NewsStory::loadByID($topStories[2]->id);
        $top_story2 = NewsStory::loadByID($topStories[3]->id);
      }
      else {
        $top_story1 = NewsStory::loadByID($topStories[1]->id);
        $top_story2 = NewsStory::loadByID($topStories[3]->id);
      }
    }
    else {
      $top_story1 = NewsStory::loadByID($topStories[1]->id);
      $top_story2 = NewsStory::loadByID($topStories[2]->id);
    }

    $pageTitle = 'Post_Alt';
    $stylesheet = 'posts';
    $stylesheet2 = 'stories';
    $script = 'stories';

    include_once SYSTEM_PATH.'/view/header.php';
    include_once SYSTEM_PATH.'/view/Post_Alt.php';
    include_once SYSTEM_PATH.'/view/footer.php';
  }

  // Gets the data the user inputs in the "New_Post" page and stores them in variables
  // to make a NewsStory object and then insert the story into the database.
  // Then redirect the user to that story page.
  public function add() {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $description = $_POST['description'];
    $url = $_POST['url'];
    $img = $_POST['img'];

    $story = new NewsStory();
    $story->title = $title;
    $story->body = $body;
    $story->description = $description;
    $story->url = $url;
    $story->img = $img;
    $story->author_id = $_SESSION['loggedInUserID'];
    $story = NewsStory::insertStory($story);

    $e = new Event();
    $e->event_type = Event::EVENT_TYPE['add_story'];
    $e->user_1_id = $story->author_id;
    $e->post_1_id = $story->id;
    $e = Event::insertEvent($e);

    header('Location: '.BASE_URL.'/Home');
    exit();

  }

  // Gets the id from the story that will be deleted then finds that story in the
  // database and deletes it. Then redirect to "My_Page"
  public function delete() {
    // get the id of the story that will be deleted
    $delete = $_POST['delete'];
    $parse = explode(' ', $delete);
    $id = array_pop($parse);
    $storyname = NewsStory::loadByID($id)->title;

    // delete the story from the SQLiteDatabase
    $id = NewsStory::deleteStory($id);

    header('Location: '.BASE_URL.'/Home');
    exit();

  }

  // Deletes the corresponding bubble in the Visualization part of "My Page" page
  public function deleteBubble() {
    $storyID = $_POST['story_id'];
    $story = NewsStory::loadByID($storyID);
    if ($story == null) {
      $json = array(
        'error' => 'Invalid story ID'
      );
    }
    else {
      $json = array(
        'success' => 'success'
      );
    }
    header('Content-Type: application/json');
    echo json_encode($json);

  }

  // Used to change the text of a story bubble in the Visualization part of "My Page" page
  public function editBubble() {
    $storyID = $_POST['story_id'];
    $newTitle = $_POST['new_title'];
    $story = NewsStory::loadByID($storyID);
    if ($story == null) {
      $json = array(
        'error' => 'Invalid story ID'
      );
    }
    else {
      $json = array(
        'success' => 'success',
        'new_title' => '$newTitle'
      );
    }
    header('Content-Type: application/json');
    echo json_encode($json);
  }

  // Sets the page title to "Edit" and loads the stylesheet "new_post".
  // Loads hte header, content for the edit page, and footer.
  public function edit() {
    $pageTitle = 'Edit';
    $stylesheet = 'new_post';

    include_once SYSTEM_PATH.'/view/header.php';
    include_once SYSTEM_PATH.'/view/Edit.php';
    include_once SYSTEM_PATH.'/view/footer.php';
  }

  // Gets the story id from the url and loads the story using that id.
  // Stores the  user input from the "Edit" page.
  // Then call updateStory with the new user input data which updates the story
  // data in the SQL database.
  // Then redirect the user to "My_Page"
  public function change() {
    $storyID = $_GET['storyID'];
    $story = NewsStory::loadByID($storyID);

    $title = $_POST['title'];
    $body = $_POST['body'];
    $description = $_POST['description'];
    $url = $_POST['url'];
    $img = $_POST['img'];

    $story = NewsStory::updateStory($story, $storyID, $title, $description, $url, $img);

    $e = new Event();
    $e->event_type = Event::EVENT_TYPE['edit_story'];
    $e->user_1_id = $story->author_id;
    $e->post_1_id = $story->id;
    $e = Event::insertEvent($e);

    header('Location: '.BASE_URL.'/Home');
    exit();

  }

  // Sets up the admin page
  public function admin() {
    $users = User::loadAllUsers();
    $pageTitle = 'Admin';
    $stylesheet = 'admin';

    include_once SYSTEM_PATH.'/view/header.php';
    include_once SYSTEM_PATH.'/view/Admin.php';
    include_once SYSTEM_PATH.'/view/footer.php';

  }

  // Used to process the new comment that was input by the user. So we use POST
  // to get the data and then check that data and sends new data back to the javascript
  // file.
  public function commentProcess() {
    $storyID = $_POST['story_id'];
    $commentTxt = $_POST['comment'];

    $story = NewsStory::loadByID($storyID);
    if ($story == null) {
      $json = array(
        'error' => 'Invalid story ID'
      );
    }
    else {
      $comment = new Comments();
      $comment->storyID = $storyID;
      $comment->author_id = $_SESSION['loggedInUserID'];
      $user = User::loadByID($comment->author_id);
      $comment->comment = $commentTxt;
      $newComment = Comments::insertComment($comment);
      $json = array(
        'success' => 'success',
        'newComment' => $newComment,
        'user' => $user
      );
    }
    echo json_encode($json);
  }

  public function likeProcess() {
    $storyID = intval($_POST['story_id']);
    $likeAction = $_POST['like_action'];
    $story = NewsStory::loadByID($storyID);

    if ($story == null) {
      $json = array(
        'error' => 'Invalid story ID'
      );
    }
    else {
      if ($likeAction == 'like') {
        $likedStory = LikedPosts::insertLikedStory($storyID, $_SESSION['loggedInUserID']);
        $story->likes += 1;
        $story->update();
        $json = array(
          'success' => 'success',
          'new_likes' => $story->likes,
          'story_id' => $story->id
        );
      }
      elseif ($likeAction == 'dislike') {
        $likedStory = LikedPosts::deleteLikedStory($storyID);
        $story->likes -= 1;
        $story->update();
        $json = array(
          'success' => 'success',
          'new_likes' => $story->likes,
          'story_id' => $story->id
        );
      }
      else {
        $json = array(
          'error' => 'Invalid like action'
        );
      }
    }
    echo json_encode($json);
  }

  // Sorts the stories on the "News" page using the word input in the search bar
  public function searchProcess() {
    $keyword = $_POST['keyword'];
    //echo $keyword;

    $stories = NewsStory::loadAllStoriesKeyword($keyword);
    //echo $stories[1]->title;

    $usernames = array();
    $loggedIn = false;
    if(isset($_SESSION['loggedInUserID'])) {
      $loggedIn = true;
    }

    $i = 1;
    while($stories[$i]->id != null) {
      $us = $stories[$i]->author;
      $usernames[$i] = $us;
      $i = $i + 1;
    }


    if ($keyword == null) {
      $json = array(
        'error' => 'Invalid search type'
      );
    }
    else {
      $json = array(
        'success' => 'success',
        'stories' => $stories,
        'usernames' => $usernames,
        'loggedIn' => $loggedIn
      );
    }
    echo json_encode($json);
  }

  // Sets up the information that goes in the Visualization section of the
  // "My Page" page
  public function viz() {

    $storyBubbles = array();

    $stories = NewsStory::loadAllStoriesDate();
    foreach($stories as $story) {

      $options = array(
        array(
          'name' => 'select',
          'address' => '',
          'story' => $story->title,
          'story_id' => $story->id
        )
      );

      if ($story->author_id == $_SESSION['loggedInUserID']) {
        $bubble = array(
          'name' => $story->title,
          'children' => $options,
          'story_id' => $story->id
        );
        $storyBubbles[] = $bubble;
      }
    }

    $json = array(
      'name' => 'bubble',
      'children' => $storyBubbles
    );

    header('Content-Type: application/json');
    echo json_encode($json);

  }

}
