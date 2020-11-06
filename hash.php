<?php
$resp = "err";

if (empty($_REQUEST["action"])){
    echo $resp;
    exit;
}

$action = $_REQUEST["action"];

switch ($action) {
    case 'getFunctions':
        switch ($_REQUEST["language"]) {
            case 'PHP':
                $resp = implode(",", array("password_hash", "hash", "crypt"));
                break;
            default:
                $resp = "-";
                break;
        }
        break;

    case 'getOptions':
        switch ($_REQUEST["function"]) {
            case 'password_hash':
                $resp = implode(",", array("PASSWORD_DEFAULT","PASSWORD_BCRYPT","PASSWORD_ARGON2I","PASSWORD_ARGON2ID"));
                break;
            case 'hash':
                $resp = implode(",", array("sha1", "sha224", "sha384", "sha256", "sha512", "md5", "ripemd128", "ripemd256", "whirlpool", "crc32", "crc32b", "crc32c"));
                break;
            case 'crypt':
                $resp = implode(",", array("CRYPT_SHA512", "CRYPT_SHA256", "CRYPT_BLOWFISH", "CRYPT_MD5", "CRYPT_EXT_DES", "CRYPT_STD_DES"));
                break;
            default:
                $resp = "-";
                break;
        }
        break;

    case 'getPwd':
        $language = $_REQUEST["language"];
        $function = $_REQUEST["function"];
        $password = $_REQUEST["password"];
        $option = $_REQUEST["option"];

        if($language == "PHP"){

            $optionPWD = PASSWORD_DEFAULT;
            switch ($option) {
                case 'PASSWORD_DEFAULT':
                    $optionPWD = PASSWORD_DEFAULT;
                    break;
                case 'PASSWORD_BCRYPT':
                    $optionPWD = PASSWORD_BCRYPT;
                    break;
                case 'PASSWORD_ARGON2I':
                    $optionPWD = PASSWORD_ARGON2I;
                    break;
                case 'PASSWORD_ARGON2ID':
                    $optionPWD = PASSWORD_ARGON2ID;
                    break;
            }

            switch ($function) {
                case 'password_hash':
                    $resp = password_hash($password, $optionPWD);
                    break;
                case 'hash':
                    $resp = hash($option, $password);
                    break;
                case 'crypt':
                    $resp = crypt($password, $option);
                    break;
            }
        }
        break;
}
echo $resp;
?>