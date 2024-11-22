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

 public function home() {
    $page = 'home';  // Définit la page d'accueil
    require('./View/main.php');  // Charge la vue correspondante
}



 public function login() {
 $page = 'login';
 require('./View/main.php');
 }
 public function doLogin() {
    $this->user = new User();
    
    // On vérifie les identifiants de l'utilisateur
    $result = $this->userManager->findByEmailAndPassword($_POST['email'], $_POST['password']);
    
    if ($result) {
        $info = "Connexion réussie";
        $_SESSION['user'] = $result; // On stocke l'utilisateur dans la session
        $page = 'home';  // On redirige vers la page d'accueil
    } else {
        $info = "Identifiants incorrects.";
    }
    
    require('./View/main.php');
}


public function doCreate()
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
 $page = 'CeateAccount';
 } else {
 $error = "ERROR : This email (" . $_POST['email'] . ") is used by another user";
 $page = 'CreateAccount';
 }
 }
 $page = 'CreateAccount';
 require('./View/main.php');
}
}