<?php
class userController {
 private $userManager;
 private $user;
 public function __construct($db1) {
 require('./Model/User.class.php');
 require_once('./Model/UserManager.class.php');
 $this->userManager = new UserManager($db1);
 $this->db = $db1 ;
 }
 public function login() {
 $page = 'login';
 require('./View/main.php');
 }
 public function doLogin() {
 $this->user = new User();
 // Cette action teste l'existence d'un utilisateur de email $_POST['email'] et de password $_POST['password']
 // Le user extrait par le UserManager est renvoyé dans $result
 // A vous d'écrire les 3 lignes correspondantes 
 
 $result =  ;

 if ( $result ) :
 $info = "Connexion reussie";
 $_SESSION['user'] = $result;
 $page = 'home';
 else :
 $info = "Identifiants incorrects.";
 endif;
 require('./View/main.php');
 }

 public
function doCreate()
{
 if (
 isset($_POST['email']) &&
 isset($_POST['password']) &&
 isset($_POST['lastName']) &&
 isset($_POST['firstName']) &&
 isset($_POST['address']) &&
 isset($_POST['postalCode']) &&
 isset($_POST['city'])
 ) {
 $alreadyExist = $this->userManager->findByEmail($_POST['email']);
 if (!$alreadyExist) {
 $newUser = new User($_POST);
 $this->userManager->create($newUser);
 $page = 'login';
 } else {
 $error = "ERROR : This email (" . $_POST['email'] . ") is used by another user";
 $page = 'create';
 }
 }
 require('./View/default.php');
}
}