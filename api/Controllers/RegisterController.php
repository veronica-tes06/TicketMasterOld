<?php
class RegisterController {
    //email and password will later be received from a request
    public function register($email, $password) {

        //finish this verification
        if (empty($email) || empty($password)) {
            echo "Invalid input";
            return;
        }
        else{

        $user = new User($email, $password);
        //will later add to database I think
        
        echo "[send to next page]" 
        }
    }
}
?>
