<?php
if($hesap->id != "" AND $hesap->tipi != 0){

if ($_FILES['file']['name']) {
            if (!$_FILES['file']['error']) {
                $name = strtolower(substr(md5(uniqid(rand())), 0,13));
                $ext = explode('.', $_FILES['file']['name']);
                $filename = $name . '.' . end($ext);
                $destination = '../uploads/editor/' . $filename; //change this directory
                $location = $_FILES["file"]["tmp_name"];
                move_uploaded_file($location, $destination);
                echo SITE_URL.'uploads/editor/'.$filename;//change this URL
            }
            else
            {
              echo  $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
            }
        }



}