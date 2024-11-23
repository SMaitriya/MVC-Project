<?php
class User {
    private ?int $id = NULL;
    private ?string $password;
    private ?string $email;
    private ?string $firstName;
    private ?string $lastName;
    private ?string $address;
    private ?string $postalCode;
    private ?string $city;
    private ?bool $admin = false;  


    public function __construct(array $data) {
        $this->email = $data['email'] ?? null;
        $this->password = $data['password'] ?? null;
        $this->firstName = $data['firstName'] ?? null;
        $this->lastName = $data['lastName'] ?? null;
        $this->address = $data['address'] ?? null;
        $this->postalCode = $data['postalCode'] ?? null;
        $this->city = $data['city'] ?? null;
        $this->admin = $data['admin'] ?? false;  

    }



    // Getters
    public function getId(){
        return $this->id;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getFirstName(){
        return $this->firstName;
    }

    public function getLastName(){
        return $this->lastName;
    }

    public function getAddress(){
        return $this->address;
    }

    public function getPostalCode(){
        return $this->postalCode;
    }

    public function getCity(){
        return $this->city;
    }

    public function getAdmin(){
        return $this->admin;
    }

    // Setters
    public function setId($id){
        $this->id = $id;
        return $this;
    }

    public function setEmail($email){
        $this->email = $email;
        return $this;
    }

    public function setPassword($password){
        $this->password = $password;
        return $this;
    }

    public function setFirstName($firstName){
        $this->firstName = $firstName;
        return $this;
    }

    public function setLastName($lastName){
        $this->lastName = $lastName;
        return $this;
    }

    public function setAddress($address){
        $this->address = $address;
        return $this;
    }

    public function setPostalCode($postalCode){
        $this->postalCode = $postalCode;
        return $this;
    }

    public function setCity($city){
        $this->city = $city;
        return $this;
    }

    public function setAdmin($admin){
        $this->admin = $admin;
        return $this;
    }

    public function hydrate(array $data) 
    {
        foreach ($data as $key => $donnee) 
        {
            // Convertir la clé de $data en camelCase pour correspondre au nom des setters
            $method = 'set' . ucfirst(str_replace('_', '', ucwords($key, '_')));
    
            // Si la méthode setter existe, l'appeler
            if (method_exists($this, $method))
            {
                $this->$method($donnee);
            }
        }
    }
    
}
