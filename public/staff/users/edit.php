<?php
require_once('../../../private/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to('index.php');
}

$users_result = find_user_by_id($_GET['id']);
$user = db_fetch_assoc($users_result);
if($user === NULL){
  redirect_to('index.php');
}

// Set default values for all variables the page needs.
$errors = array();
$user['orig_uname'] = $user["username"];

if(is_post_request()) {

  // Confirm that values are present before accessing them.
  if(isset($_POST['first_name'])) { $user['first_name'] = h($_POST['first_name']); }
  if(isset($_POST['last_name'])) { $user['last_name'] = h($_POST['last_name']); }
  if(isset($_POST['username'])) { $user['username'] = h($_POST['username']); }
  if(isset($_POST['email'])) { $user['email'] = h($_POST['email']); }


  $result = update_user($user);
  if($result === true) {
    redirect_to('show.php?id=' . $user['id']);
  } else {
    $errors = $result;
  }
}
?>
<?php $page_title = 'Staff: Edit User ' . $user['first_name'] . " " . $user['last_name']; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="index.php">Back to Users List</a><br />
  <a href="show.php?id=<?php echo $user['id'];?>">Cancel</a>


  <h1>Edit User: <?php echo $user['first_name'] . " " . $user['last_name']; ?></h1>

  <?php echo display_errors($errors); ?>

  <form action="edit.php?id=<?php echo $user['id']; ?>" method="post">
    First name:<br />
    <input type="text" name="first_name" value="<?php echo $user['first_name']; ?>" /><br />
    Last name:<br />
    <input type="text" name="last_name" value="<?php echo $user['last_name']; ?>" /><br />
    Username:<br />
    <input type="text" name="username" value="<?php echo $user['username']; ?>" /><br />
    Email:<br />
    <input type="text" name="email" value="<?php echo $user['email']; ?>" /><br />
    <br />
    <input type="submit" name="submit" value="Update"  />
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
