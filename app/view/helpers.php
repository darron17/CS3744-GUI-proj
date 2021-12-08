<?php

function calcVizSize($stories) {
  $height = count($stories) * 400;
  return $height;
}

function checkLiked($likedStories, $news_id) {
  foreach($likedStories as $storyID) {
    //echo $news_id;
    //echo $storyID;
    if ($news_id == $storyID) {
      return true;
    }
  }
  return false;
}

// Given a userID this creates a link to that user's page
function createUsernameLink($userID) {
  $user = User::loadByID($userID);
  $formatted = '<a href="'.BASE_URL.'/User-'.$user->username.'">'.$user->username.'</a>';
  return $formatted;
}

// Formats a given event depending on the action
function formatEvent($e) {
  switch($e->event_type) {
    case Event::EVENT_TYPE['add_story']:
      $story = NewsStory::loadByID($e->post_1_id);
      $formatted = createUsernameLink($e->user_1_id).' added the story, "'.$story->title.'." '.$e->date;
      break;

    case Event::EVENT_TYPE['view_profile']:
      $formatted = createUsernameLink($e->user_1_id).' viewed profile of '.createUsernameLink($e->user_2_id).'.';
      break;

    case Event::EVENT_TYPE['edit_story']:
      $story = NewsStory::loadByID($e->post_1_id);
      $formatted = createUsernameLink($e->user_1_id).' edited the story, "'.$story->title.'." '.$e->date;
      break;

    case Event::EVENT_TYPE['edit_profile']:
      $formatted = createUsernameLink($e->user_1_id).' edited his/her profile.'.$e->date;
      break;

    case Event::EVENT_TYPE['changed_role']:
      $formatted = createUsernameLink($e->user_1_id).' changed the role of '.createUsernameLink($e->user_2_id).' to '.findRole(User::loadByID($e->user_2_id)).'. '.$e->date;
      break;


    default:
      $formatted = 'Unrecognized event type.';
      break;
  }
  return $formatted;
}

// Gets the role of a given user
function findRole($u) {
  $roleNum = $u->role;
  $role = 'Undefined';
  if ($roleNum == 0) {
    $role = 'Admin';
  }
  elseif ($roleNum == 1) {
    $role = 'Passive User';
  }
  elseif($roleNum == 2) {
    $role = 'Active User';
  }
  return $role;
}
