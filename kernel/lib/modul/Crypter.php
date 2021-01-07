<?php

class Crypter{
    protected $key;
    protected $cipher;
    protected $initialVector;

    /**
     * Primary class constructor
     */
    public function __construct()
    {
        $this->key = "pute";
        $this->cipher = "aes-128-cbc";
        $this->initialVector = "merevendettapute";
    }

    /**
     * Method that allow the user to encrypt a data given trough a parameters.
     * 
     * @param string $data is the data you want to encrypt.
     * @return array $res contains a key value array with the encrypted message.
     */
    public function encrypt($data){
        $res = array(
            "success" => false,
            "message" => "This cipher method does not exists.",
            "data" => null
        );
        if(in_array($this->cipher, openssl_get_cipher_methods())){

            $res = array(
                "success" => true,
                "message" => "Data encrypted successfully",
                "data" => openssl_encrypt($data, $this->cipher, $this->key, 0, $this->initialVector)
            );
        }
        return($res);
    }

    /**
     * Method that allow the user to decrypt a data given through parameters.
     * 
     * @param string $data is the data you want to decrypt.
     * @return array $res contains a key value array with the decrypted message.
     */
    public function decrypt($data){
        $res = array(
            "success" => false,
            "message" => "This cipher method does not exists",
            "data" => null
        );
        if(in_array($this->cipher, openssl_get_cipher_methods())){
            $res = array(
                "success" => true,
                "message" => "Data decrypted successfully",
                "data" => openssl_decrypt($data, $this->cipher, $this->key, 0, $this->initialVector)
            );
        }
        return($res);
    }

    /**
     * Method that allow the user to set the current object decrypt key.
     * 
     * @param string $newKey is the new key to define.
     * @return null
     */
    public function setKey($newKey){
        $this->key = "$newKey";
    }

    /**
     * Method that allow the user to change the current object cipher.
     * 
     * @param string $newCipher is the new cipher to define.
     * @return null
     */
    public function setCipher($newCipher){
        $this->cipher = "$newCipher";
    }

    /**
     * Method that allow the user to change the current object initial vector.
     * 
     * @param string $newInitialVector is the new initial vector to define.
     * @param null
     */
    public function setInitialVector($newInitialVector){
        $this->initialVector = "$newInitialVector";
    }
}

?>