<?php 
 
 function encryption($data,$key)
  {
      $cipher = "AES-256-CBC";
      $plaintext =$data;
      $ivlen = openssl_cipher_iv_length($cipher);
      $iv ='c1aeB65F17A1c7f3';
      $tag="";
      return openssl_encrypt($plaintext, $cipher, $key, $options=0, $iv, $tag);
  }


  ?>