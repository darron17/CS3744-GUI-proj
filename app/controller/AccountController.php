<?php
// Controller for pages that have to do with logging in and user accounts

include_once '../global.php';

// Gets the route from "".htaccess"
$route = $_GET['route'];

// Account controller object
$ac = new AccountController();

// Check if route is login, loginProcess, or logout and calls the respective
// function
if ($route == 'signup') {
  $ac->signup();
}
elseif ($route == 'addUser') {
  $ac->addUser();
}
elseif ($route == 'login') {
  $ac->login();
}
elseif ($route == 'loginProcess') {
  $ac->loginProcess();
}
elseif ($route == 'logout') {
  $ac->logout();
}
elseif ($route == 'profile') {
  $ac->profile();
}
elseif ($route == 'edit') {
  $ac->edit();
}
elseif ($route == 'change') {
  $ac->change();
}
elseif ($route == 'roleChange') {
  $ac->roleChange();
}

// Account controller class
class AccountController {

  // Sets up and loads all CSS and JS files for the "Sign up" page
  public function signup() {
    $pageTitle = 'Sign Up';
    $stylesheet = 'new_profile';
    $script = 'dropdown';

    include_once SYSTEM_PATH.'/view/header.php';
    include_once SYSTEM_PATH.'/view/Signup.php';
    include_once SYSTEM_PATH.'/view/footer.php';
  }

  // Process page used to add a new "User" and stores their information that
  // they input.
  public function addUser() {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 1;
    $first = $_POST['first'];
    $last = $_POST['last'];
    $email = $_POST['email'];
    $experience = $_POST['experience'];

    $user = new User();
    $user->username = $username;
    $user->password = $password;
    $user->role = $role;
    $user->first = $first;
    $user->last = $last;
    $user->email = $email;
    $user->experience = $experience;
    $user = User::newUser($user);
    //echo $user->id;
    $_SESSION['loggedInUserID'] = $user->id;
    $_SESSION['loggedInUserRole'] = $user->role;
    $_SESSION['msg'] = 'Signup successful!';
    // $e = new Event();
    // $e->event_type = Event::EVENT_TYPE['edit_profile'];
    // $e->user_1_id = $_SESSION['loggedInUserID'];
    // $e = Event::insertEvent($e);


    header('Location: '.BASE_URL.'/Home');
    //exit();
  }

  // Sets the page title to "Login" and loads the header, content for login page,
  // and the footer
  public function login() {
    $pageTitle = 'Login';
    $stylesheet = 'login';

    include_once SYSTEM_PATH.'/view/header.php';
    include_once SYSTEM_PATH.'/view/Login.php';
    include_once SYSTEM_PATH.'/view/footer.php';
  }

  // Used to check if the input from the user matches the admin username and password.
  // If so then the username is stored in the session, a success message is printed,
  // and the user is directed to the "Home" page.
  // If incorrect then the Login page is reloaded and an message prints saying
  // user was incorrect.
  public function loginProcess() {
    $username = $_POST['un'];
    $password = $_POST['pw'];

    $user = User::loadByUsername($username);
    if ($user == null) {
      $_SESSION['msg'] = 'Login failed. Your username or password is incorrect.';
      header('Location: '.BASE_URL.'/Login');
      exit();
    }
    elseif ($user->password != $password) {
      $_SESSION['msg'] = 'Login failed. Your password or password is incorrect.';
      header('Location: '.BASE_URL.'/Login');
      exit();
    }
    else {
      //$_SESSION['username'] = $username;
      $_SESSION['loggedInUserID'] = $user->id;
      $_SESSION['loggedInUserRole'] = $user->role;
      $_SESSION['msg'] = 'Login successful!';
      header('Location: '.BASE_URL.'/Home');
      exit();
    }
  }

  // Used to logout and end the current session, also directs the user to the
  // "Home" page
  public function logout() {
    unset($_SESSION['loggedInUserID']);
    session_destroy();
    header('Location: '.BASE_URL.'/Home');
    exit();
  }

  // Sets up and loads the "Profile" page.
  public function profile() {
    $username = $_GET['un'];

    $user = User::loadByUsername($username);
    if ($user == null) {
      $_SESSION['msg'] = 'User page does not exist';
      header('Location: '.BASE_URL.'/Home');
      exit();
    }
    else {
      $pageTitle = $username."'s Profile";

      $stylesheet = 'profile';


      $e = new Event();
      $e->event_type = Event::EVENT_TYPE['view_profile'];
      $e->user_1_id = $_SESSION['loggedInUserID'];
      $e->user_2_id = $user->id;
      $e = Event::insertEvent($e);

      include_once SYSTEM_PATH.'/view/header.php';
      include_once SYSTEM_PATH.'/view/Profile.php';
      include_once SYSTEM_PATH.'/view/footer.php';
    }
  }

  // Sets up the page for editing a "Profile" page.
  public function edit() {
    $pageTitle = 'Edit';
    $stylesheet = 'new_profile';
    $script = 'dropdown';

    include_once SYSTEM_PATH.'/view/header.php';
    include_once SYSTEM_PATH.'/view/Edit_Profile.php';
    include_once SYSTEM_PATH.'/view/footer.php';
  }

  // Used to change a user's information on their profile page
  public function change() {
    $user = User::loadById($_SESSION['loggedInUserID']);

    $password = $_POST['password'];
    $first = $_POST['first'];
    $last = $_POST['last'];
    $email = $_POST['email'];
    $experience = $_POST['experience'];


    $user = User::updateUser($password, $first, $last, $email, $experience, $_SESSION['loggedInUserID']);

    $e = new Event();
    $e->event_type = Event::EVENT_TYPE['edit_profile'];
    $e->user_1_id = $_SESSION['loggedInUserID'];
    $e = Event::insertEvent($e);

    header('Location: '.BASE_URL.'/Home');
    exit();

  }

  // Page for changing a user's role
  public function roleChange() {
    $id = $_GET['userID'];
    $roleWord = $_GET['role'];
    $roleNum = User::ROLE[$roleWord];
    $user = User::loadById($id);
    $username = $user->username;


    $user = User::updateRole($user, $roleNum, $id);

    $e = new Event();
    $e->event_type = Event::EVENT_TYPE['changed_role'];
    $e->user_1_id = $_SESSION['loggedInUserID'];
    $e->user_2_id = $id;
    $e = Event::insertEvent($e);

    header('Location: '.BASE_URL.'/Home');
    exit();
  }
}
