<?php
include 'connexion.php';

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
}
