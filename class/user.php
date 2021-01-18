<?php
class user
{
    protected $login = '';
    protected $password = '';
    protected $id = '';
    protected $email = '';
    protected $status = '';

    public function __construct()
    {
        $this->pdo = new PDO('mysql:dbname=forum;host=localhost', "root", "");
        $this->errors = array();
        $this->user_info = array();
    }

    public function register($login, $password, $email)
    {
        $login = htmlspecialchars($login);
        $password = htmlspecialchars($password);
        $email = htmlspecialchars($email);
        $status = 'membre';

        if (empty(trim($login)) || empty(trim($password)) || empty(trim($email))) {
            //Vérifie si l'un des champs est vide

            $this->errors[] = "Merci de remplir le formulaire";
            //Si c'est le login => message erreur

        }
        $count_erreur_saisie = count($this->errors);
        // Si le tableau est vide cela signifie que nous pouvons commencer à vérifier les données et les insérer
        if ($count_erreur_saisie == 0) {
            $requete = $this->pdo->prepare("SELECT id FROM utilisateurs WHERE login = :login");
            $requete->execute(['login' => $login]);
            $result_login = $requete->fetchColumn();
            if ($result_login != false) {
                $this->errors[] = "Le login existe déjà";
            }
            $requete = $this->pdo->prepare("SELECT id FROM utilisateurs WHERE email = :email");
            $requete->execute(['email' => $email]);
            $result_email = $requete->fetchColumn();
            if ($result_email != false) {
                $this->errors[] = "Il existe déjà un compte associé à cet email";
            }
            $count_doublons = (count($this->errors));
            if ($count_doublons == 0) {
                $requete = $this->pdo->prepare("INSERT INTO `utilisateurs`(`login`, `password`, `email`,`status`) VALUES (:login,:password, :email, :status)");
                $password = password_hash($password, PASSWORD_BCRYPT);
                $requete->execute(['login' => $login, 'password' => $password, 'email' => $email, 'status' => $status]);
                $this->login = $login;
                $this->password = $password;
                $this->email = $email;
                $this->status = $status;
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }

    }

    public function connect($login, $password)
    {
        $login = htmlspecialchars($login);
        $password = htmlspecialchars($password);

        if (empty(trim($login)) || empty(trim($password))) {
            //Vérifie si l'un des champs est vide
            if (empty(trim($login))) {
                $this->errors[] = "Merci de compléter le login";
                //Si c'est le login => message erreur
            }
            if (empty(trim($password))) {
                $this->errors[] = "Merci de compléter le password";
                //Si c'est le login => message erreur
            }
        }
        $count_erreur_saisie = count($this->errors);
        if ($count_erreur_saisie == 0) {
            $requete = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE login=:login");
            $requete->execute(['login' => $login]);
            $allresult = $requete->fetch(PDO::FETCH_ASSOC);
            if (!empty($allresult)) {
                if (password_verify($password, $allresult['password'])) {
                    $this->login = $allresult['login'];
                    $this->id = $allresult['id'];
                    $this->password = $allresult['password'];
                    $this->email = $allresult['email'];
                    $this->status = $allresult['status'];
                    return true;
                } else {
                    $this->errors[] = "le mots de passe est incorrect";
                }

                return false;
            } else {
                $this->errors[] = "Le login n'existe pas";
            }

            return false;
        } else {
            return false;
        }

    }

    public function login($login, $password)
    {
        $login = htmlspecialchars($login);
        $password = htmlspecialchars($password);

        if (empty(trim($login)) || empty(trim($password))) {
            //Vérifie si l'un des champs est vide
            if (empty(trim($login))) {
                $this->errors[] = "Merci de compléter le login";
                //Si c'est le login => message erreur
            }
            if (empty(trim($password))) {
                $this->errors[] = "Merci de compléter le password";
                //Si c'est le login => message erreur
            }
        }
        $count_erreur_saisie = count($this->errors);
        if ($count_erreur_saisie == 0) {
            $query = $this->pdo->prepare("SELECT password FROM utilisateurs WHERE id=:id");
            $query->execute(['id' => $this->id]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $cpassword = $result['password'];
            var_dump($this->id);
            var_dump($cpassword);
            var_dump($this->login);
            //Recherche du mot de passe pour comparaison//
            if (password_verify($password, $cpassword) == false) {
                $this->errors[] = "Le mot de passe est incorrect";
                return false;
            }
            $query = $this->pdo->prepare("SELECT login FROM utilisateurs WHERE login=:login");
            $query->execute(['login' => $login]);
            $result = $query->fetchColumn();
            var_dump($result);
            if (count($this->errors) == 0) {
                //Recherche si le login proposé est déjà dans la base
                if ($result == false) {
                    $update = $this->pdo->prepare("UPDATE utilisateurs SET login = :login WHERE id=:id ");
                    $update->bindParam("login", $login);
                    $update->bindParam("id", $this->id);
                    $update->execute();
                    $this->login = $login;
                    return true;
                }$this->errors[] = "Le login existe déjà";
                return false;
            }return false;
        }return false;
    }

    public function password($password, $cpassword1, $cpassword2)
    {
        $password = htmlspecialchars($password);
        $cpassword1 = htmlspecialchars($cpassword1);
        $cpassword2 = htmlspecialchars($cpassword2);
        if (empty(trim($password)) || empty(trim($cpassword1)) || empty(trim($cpassword2))) {
            //Vérifie si l'un des champs est vide => Car nécessité d'entrer mdp, nouveau mdp et conf nouveau mdp
            if (empty(trim($password))) {
                $this->errors[] = "Merci de compléter votre mot de passe actuel";
            }
            if (empty(trim($cpassword1))) {
                $this->errors[] = "Merci de compléter votre nouveau mot de passe";
            }
            if (empty(trim($cpassword2))) {
                $this->errors[] = "Merci de confirmer votre nouveau mot de passe";
            }
        }

        $count = count($this->errors);
        if ($count == 0) {
            $query = $this->pdo->prepare("SELECT password FROM utilisateurs WHERE id=:id");
            $query->execute(['id' => $this->id]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $bdd_password = $result['password'];

            if (password_verify($password, $bdd_password)) {
                if ($cpassword1 == $cpassword2) {
                    $cpassword1 = password_hash($cpassword1, PASSWORD_BCRYPT);
                    $update = $this->pdo->prepare("UPDATE utilisateurs SET password = :password WHERE id = :id");
                    $update->bindParam("password", $cpassword1);
                    $update->bindParam("id", $this->id);
                    $update->execute();
                    $this->password = $password;
                    return true;
                } else {
                    $this->errors[] = "Les deux nouveaux mots de passe ne sont pas identiques";
                }

                return false;
            } else {
                $this->errors[] = "Le mot de passe est incorrect";
            }

            return false;
        }return false;
    }

    public function afficherProfil($id)
    {
        if (isset($id)) {
            $query = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE id=:id");
            $query->execute(['id' => $id]);
            $allresult = $query->fetch(PDO::FETCH_ASSOC);
            $this->user_info[] = $allresult;
            var_dump($this->user_info);
            return true;
        } else {
            return false;
        }

    }

    public function setId($id)
    {
        $this->id = $id;
        return $this->id;
    }

    public function setLogin($login)
    {
        $this->login = $login;
        return $this->login;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this->status;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function delete()
    {
        global $pdo;
        $requete = $pdo->prepare("DELETE FROM utilisateurs WHERE login=':login'");
        $requete->execute(['login' => $this->login]);
        session_destroy();
        echo "Votre compte à bien été supprimé";
    }
}
