<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Данные о докторах</title>
</head>
<?php
$pdo = new PDO("sqlite:dental_clinic.db");

$sql =   "SELECT doctors.id, surname, name, patronymic, date_end, procedure_name, price FROM doctors 
INNER JOIN report on doctors.id == report.id 
INNER JOIN procedures on procedures.id == report.procedure_id 
ORDER BY surname, date_end ASC;";

$statement = $pdo->query($sql);
$data = $statement->fetchAll();
$statement->closeCursor();

$array_id = [];

foreach($data as $d){
    $array_id[] = $d['id'];
}

$array_id = array_unique($array_id);
sort($array_id);
?>

<body>

<h1 aligh="justify"><span style="font-size: 30px;font-family: Arial">Список оказанных процедур:</span></h1>
<p><span style="font-size: 15px;font-family: Arial">Выберите конкретного врача</span></p>

<style>
    .table {
        border-collapse: collapse;
        margin: 25px 0;
        font-size: 0.9em;
        font-family: fantasy;
        min-width: 400px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.24);
    }

    .table thead tr {
        background-color: rgba(85, 155, 74, 0.91);
        color: #000000;
        text-align: left;
    }

    .table th,
    .table td {
        padding: 12px 15px;
    }

    .table tbody tr {
        border-bottom: 1px solid #000000;
    }

    .table tbody tr:nth-of-type(even) {
        background-color: #e1d781;
    }
    .table tbody tr:nth-of-type(odd) {
        background-color: #ecefc4;
    }

    .table tbody tr:last-of-type {
        border-bottom: 2px solid #000000;
    }

    .table tbody tr.active-row {
        font-weight: bold;
        color: #000000;
    }
</style>




<form method="POST">
    <label>
        <select style="width: 150px;" name="id">
            <option value= <?= null ?>>
                Все
            </option>
            <?php foreach($array_id as $id) {?>
                <option value= <?= $id ?>>
                    <?= $id ?>
                </option>
            <?php }?>
        </select>
    </label>
    <button type="submit"> Поиск</button>
</form>

<br>

<?php
$doctor_id = 0;
if(isset($_POST["id"])){
    $doctor_id = (int)$_POST["id"];
}

if($doctor_id === 0){
    $sql =   "SELECT doctors.id, surname, name, patronymic, date_end, procedure_name, price FROM doctors 
    INNER JOIN report on doctors.id == report.id 
    INNER JOIN procedures on procedures.id == report.procedure_id ORDER BY surname, date_end ASC;";
}else{
    $sql =   "SELECT doctors.id, surname, name, patronymic, date_end, procedure_name, price FROM doctors 
    INNER JOIN report on doctors.id == report.id 
    INNER JOIN procedures on procedures.id == report.procedure_id WHERE doctors.id == {$doctor_id} ORDER BY surname, date_end ASC;";
}
$statement = $pdo->query($sql);
$data = $statement->fetchAll();
?>

<table border="1" width="100%" cellpadding="10" class="table">
    <thead>
    <th>ID</th>
    <th>ФИО</th>
    <th>Дата проведения</th>
    <th>Процедура</th>
    <th>Цена</th>
    </thead>
    <?php foreach($data as $d) { ?>
        <tr>
            <th><?= $d["id"] ?></th>
            <th><?= $d["surname"]," ",$d["name"]," ",$d["patronymic"]?></th>
            <th><?= $d["date_end"] ?></th>
            <th><?= $d["procedure_name"] ?></th>
            <th><?= $d["price"] ?></th>
        </tr>
    <?php }?>
</table>
</body>
</html>