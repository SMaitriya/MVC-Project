<?php
require_once('./Model/Connection.class.php');

class UserManager
{
    private PDO $db;
    private string $table = 'users'; // Déclare la propriété $table

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Méthode pour créer un utilisateur
    public function create(User $user): void
    {
        $req = $this->db->prepare("INSERT INTO {$this->table} (password, email, firstName, lastName,
            address, postalCode, city, admin) VALUES(:password, :email, :firstName, :lastName, :address,
            :postalCode, :city, :admin)");

        // Lier les valeurs
        $req->bindValue(':password', hash("sha256", $user->getPassword()));
        $req->bindValue(':email', $user->getEmail());
        $req->bindValue(':firstName', $user->getFirstName());
        $req->bindValue(':lastName', $user->getLastName());
        $req->bindValue(':address', $user->getAddress());
        $req->bindValue(':postalCode', $user->getPostalCode());
        $req->bindValue(':city', $user->getCity());
        $req->bindValue(':admin', 0);

        // Exécuter la requête
        $req->execute();
    }

    // Méthode pour récupérer tous les utilisateurs
    public function findAll(): array
    {
        $users = [];
        $req = $this->db->query("SELECT * FROM {$this->table} ORDER BY id");
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            $user = new User();
            $user->hydrate($donnees); // Utilisation de la méthode hydrate
            $users[] = $user;
        }
        return $users;
    }

    // Méthode pour récupérer un utilisateur par son ID
    public function findOne(int $id): ?User
    {
        $req = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();

        $donnees = $req->fetch(PDO::FETCH_ASSOC);
        if ($donnees) {
            $user = new User();
            $user->hydrate($donnees); // Utilisation de la méthode hydrate
            return $user;
        }
        return null;
    }

    // Méthode pour mettre à jour un utilisateur
    public function update(User $user): void
    {
        try {
            $req = $this->db->prepare("UPDATE {$this->table} SET 
                password = :password, 
                email = :email, 
                firstName = :firstName, 
                lastName = :lastName, 
                address = :address, 
                postalCode = :postalCode, 
                city = :city 
                WHERE id = :id");

            $req->bindValue(':password', hash("sha256", $user->getPassword()));
            $req->bindValue(':email', $user->getEmail());
            $req->bindValue(':firstName', $user->getFirstName());
            $req->bindValue(':lastName', $user->getLastName());
            $req->bindValue(':address', $user->getAddress());
            $req->bindValue(':postalCode', $user->getPostalCode());
            $req->bindValue(':city', $user->getCity());
            $req->bindValue(':id', $user->getId(), PDO::PARAM_INT);

            $req->execute();
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour: " . $e->getMessage();
        }
    }

    // Méthode pour supprimer un utilisateur
    public function delete(User $user): void
    {
        $req = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $req->bindValue(':id', $user->getId(), PDO::PARAM_INT); // Correction de l'erreur
        $req->execute();
    }

    public function findByEmailAndPassword(string $email, string $password): ?User
{
    // Hachage du mot de passe pour la comparaison
    $hashedPassword = hash("sha256", $password);
    
    $req = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email AND password = :password");
    $req->bindValue(':email', $email);
    $req->bindValue(':password', $hashedPassword);
    $req->execute();

    $donnees = $req->fetch(PDO::FETCH_ASSOC);
    if ($donnees) {
        $user = new User($donnees);
        $user->hydrate($donnees); // Utilisation de la méthode hydrate pour peupler l'objet User
        return $user;
    }
    return null; // Retourne null si aucun utilisateur trouvé
}


public function findByEmail(string $email): ?User
{
    // Prépare la requête pour récupérer l'utilisateur par email
    $req = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email");
    $req->bindValue(':email', $email);
    $req->execute();

    // Récupère les données de l'utilisateur
    $donnees = $req->fetch(PDO::FETCH_ASSOC);
    
    // Si l'utilisateur est trouvé
    if ($donnees) {
        // On passe les données au constructeur de User
        $user = new User($donnees);  // Le constructeur prendra en charge l'hydratation des données
        return $user;
    }
    return null;  // Si l'email n'existe pas dans la base de données
}

}
