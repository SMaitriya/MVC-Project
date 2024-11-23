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

    // Cherche l'utilisateur avec les identifiants fournis
    $result = $this->userManager->findByEmailAndPassword($email, $password);

    if ($result) {
        // Si l'utilisateur est trouvé, l'objet User est retourné et peut être utilisé
        $_SESSION['user'] = $result;  // On enregistre l'objet User dans la session
        $info = "Connexion réussie";
        $page = 'home';
    } else {
        // Si l'utilisateur n'est pas trouvé, afficher un message d'erreur
        $info = "Identifiants incorrects.";
    }

    // Affiche la vue principale avec le message d'info
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
    // Démarre la session si ce n'est pas déjà fait
    session_start();
    
    // Supprimer toutes les variables de session
    session_unset();

    // Détruire la session
    session_destroy();

    // Rediriger l'utilisateur vers la page d'accueil ou la page de connexion
    header('Location: index.php?ctrl=user&action=login');
    exit();
}

function userList() {
    // Vérifier si l'utilisateur est connecté
    if (isset($_SESSION['user'])) {
        // L'utilisateur est connecté, afficher la liste des utilisateurs
        $page = 'userList';  // Définir la page comme 'userList'
    } else {
        // L'utilisateur n'est pas connecté, afficher la page unauthorized
        $page = 'unauthorized';  // Définir la page comme 'unauthorized'
    }

    // Inclure la vue principale avec la variable $page
    require('./View/main.php');
}




}


