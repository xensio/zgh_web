<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // pobranie danych z wpisania
    $numPasswords = intval($_POST['numPasswords']);
    $passwordLength = intval($_POST['passwordLength']);
    $includeLowercase = isset($_POST['lowercase']);
    $includeUppercase = isset($_POST['uppercase']);
    $includeNumbers = isset($_POST['numbers']);
    $includeSpecial = isset($_POST['specialChars']);
    $fileFormat = $_POST['fileFormat'];

    $lowercase = "abcdefghijklmnopqrstuvwxyz";
    $uppercase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $numbers = "0123456789";
    $specialChars = "!@#$%^&*()-_+=<>?/";

    $characterSet = "";
    if ($includeLowercase) $characterSet .= $lowercase;
    if ($includeUppercase) $characterSet .= $uppercase;
    if ($includeNumbers) $characterSet .= $numbers;
    if ($includeSpecial) $characterSet .= $specialChars;

    // generowanie haseł (jak ktos to czyta to przepraszam ze jest tak niechlujnie xd)
    $passwords = [];
    for ($i = 0; $i < $numPasswords; $i++) {
        $password = "";
        for ($j = 0; $j < $passwordLength; $j++) {
            $password .= $characterSet[rand(0, strlen($characterSet) - 1)];
        }
        $passwords[] = $password;
    }

    // formatowanie do odpowiedniego rodzaju pliku
    if ($fileFormat === 'txt') {
        $content = implode("\n", $passwords);
        $fileName = "losoweznaki.txt";
    } elseif ($fileFormat === 'csv') {
        $content = implode(",", $passwords);
        $fileName = "losoweznaki.csv";
    } elseif ($fileFormat === 'json') {
        $content = json_encode($passwords, JSON_PRETTY_PRINT);
        $fileName = "losowenzaki.json";
    }

    // pullowanie pliku do wysłania do uzytkownika
    header('Content-Type: application/octet-stream');
    header("Content-Disposition: attachment; filename=$fileName");
    echo $content;
    exit();
}
?>
