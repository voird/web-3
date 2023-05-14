
<?php
echo "<link rel='stylesheet' href='style3.css'>";
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
  if (!empty($_GET['save'])) {
    // Если есть параметр save, то выводим сообщение пользователю.
      print('Спасибо, результаты сохранены. ');
  }
  // Включаем содержимое файла form.php.
  include('form.php');
  // Завершаем работу скрипта.
  exit();
}

$s = array($_POST['superpower']);
$sup = array('t','b','c', 'p');
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.

// Проверяем ошибки.
$errors = FALSE;
if (!preg_match("/^\w+[\w\s-]*$/", $_POST['fio']) || empty($_POST['fio'])) {
  print('Заполните имя.<br/>');
  $errors = TRUE;
}

if (empty($_POST['year']) || !is_numeric($_POST['year']) || !preg_match('/^\d+$/', $_POST['year'])) {
  print('Заполните год.<br/>');
  $errors = TRUE;
}

if (!preg_match("/^[\w\.-]+@([\w-]+\.)+[\w-]{2,4}$/", $_POST['email']) || empty($_POST['email'])) {
  print('Заполните email.<br/>');
  $errors = TRUE;
}

if($_POST['gender'] !== 'm' && $_POST['gender'] !== 'j'){
    print_r('Неверный формат пола.');
    exit();
}
if (empty($_POST['limbs']) || !is_numeric($_POST['limbs']) || !preg_match('/^\d+$/', $_POST['limbs'])) {
    print('нет конечностей.');
    $errors = TRUE;
}

foreach($_POST['superpower'] as $check){
    if(array_search($check,$sup)=== false){
        print_r('Неверный формат суперсил');
        exit();
    }
}

if(!preg_match("/^[\w\.-]+@([\w-]+\.)+[\w-]{2,4}$/", $_POST['formWheelchair']) || isset($_POST['formWheelchair']) &&
    $_POST['formWheelchair'] == 'Yes')
{
}
else
{
    print_r('Нажмите галочку.');
    exit();
}

//foreach($s as $checking){
//    if(array_search($checking,$sup)=== false){
//     print_r('Заполните суперсилы.');
        //       exit();
//   }
//}
if ($errors) {
  // При наличии ошибок завершаем работу скрипта.
  exit();
}


// Сохранение в базу данных.

$user = 'u52813';
$pass = '9339974';
$db = new PDO('mysql:host=localhost;dbname=u52813', $user, $pass, [PDO::ATTR_PERSISTENT => true]);

try{
    $stmt = $db->prepare("REPLACE INTO abilities (id,name_of_ability) VALUES (10, 'Бессмертие'), (20, 'Прохождение сквозь стены'), (30, 'Левитация')");
    $stmt-> execute();
}
catch (PDOException $e) {
    print('Error : ' . $e->getMessage());
    exit();
}
// Подготовленный запрос. Не именованные метки.
try {
  $stmt = $db->prepare("INSERT INTO form SET name = ?, year = ?, email = ?, pol = ?, limbs = ?, bio = ?");
  $stmt -> execute([$_POST['fio'], $_POST['year'], $_POST['email'],$_POST['gender'], $_POST['limbs'], $_POST['TextBox']]);
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}

$id = $db->lastInsertId();

try{
    $stmt = $db->prepare("REPLACE INTO Super (id_s,name) VALUES (10, 'God'), (20, 'fly'), (30, 'idclip'), (40, 'fireball')");
    $stmt-> execute();
}
catch (PDOException $e) {
    print('Error : ' . $e->getMessage());
    exit();
}

//print_r($_POST);
//print_r($id);
//exit();
try {
    $stmt = $db->prepare("INSERT INTO Sform SET id_per = ?, id_sup = ?");
    foreach ($_POST['superpower'] as $ability) {
        if ($ability=='t')
        {$stmt -> execute([$id, 10]);}
        else if ($ability=='b')
        {$stmt -> execute([$id, 20]);}
        else if ($ability=='c')
        {$stmt -> execute([$id, 30]);}
        else if ($ability=='p')
        {$stmt -> execute([$id, 30]);}
    }
}
catch(PDOException $e) {
    print('Error : ' . $e->getMessage());
    exit();
}

/*$id = $db->lastInsertId();
$sppe= $db->prepare("INSERT INTO form2 SET name=:name, per_id=:person");
$sppe->bindParam(':person', $id);
foreach($s as $inserting){
    $sppe->bindParam(':name', $inserting);
    if($sppe->execute()==false){
        print_r($sppe->errorCode());
        print_r($sppe->errorInfo());
        exit();
    }
}
*/
/*//  stmt - это "дескриптор состояния".
 
//  Именованные метки.
//$stmt = $db->prepare("INSERT INTO test (label,color) VALUES (:label,:color)");
//$stmt -> execute(['label'=>'perfect', 'color'=>'green']);
 
//Еще вариант
/*$stmt = $db->prepare("INSERT INTO users (firstname, lastname, email) VALUES (:firstname, :lastname, :email)");
$stmt->bindParam(':firstname', $firstname);
$stmt->bindParam(':lastname', $lastname);
$stmt->bindParam(':email', $email);
$firstname = "John";
$lastname = "Smith";
$email = "john@test.com";
$stmt->execute();
*/

// Делаем перенаправление.
// Если запись не сохраняется, но ошибок не видно, то можно закомментировать эту строку чтобы увидеть ошибку.
// Если ошибок при этом не видно, то необходимо настроить параметр display_errors для PHP.
header('Location: ?save=1');
?>

<!DOCTYPE html>
<head>
<meta charset="utf-8" />
<title>Web-3</title>
<link rel="stylesheet" href="style3.css" type="text/css"/>
</head>
</html>
