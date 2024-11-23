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

    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $this->userManager->findByEmailAndPassword($email, $password);

    if ($result) {
        $_SESSION['user'] = $result;  
        $page = 'home';
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
            
            $page = 'Login'; 
            header('Location: index.php?ctrl=user&action=login');
            exit(); 
        } else {
            // Si l'email est déjà utilisé, afficher la page d'erreur
            $page = 'Error';
        }
    } else {
        $page = 'createAccount';
    }

    // Afficher la vue principale avec la page à afficher
    require('./View/main.php');
}



public function logout() {
    session_start();
    
    session_unset();

    // Détruire la session
    session_destroy();

    header('Location: index.php?ctrl=user&action=login');
    exit();
}

public function userList() {
    if (isset($_SESSION['user'])) {
        $users = $this->userManager->getAllUsers();

        $page = 'userList'; 
        require('./View/main.php'); 
    } else {
       
        $page = 'unauthorized';
        require('./View/main.php');
    }
}






}


