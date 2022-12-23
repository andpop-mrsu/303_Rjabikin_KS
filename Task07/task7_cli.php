<?php
function dataTransform($array)
{
    $amount_symbol_str = array();
    foreach ($array as $a) {
        $amount_symbol_str[] = iconv_strlen($a);
    }

    $max_str = max($amount_symbol_str);

    $temp = array();
    foreach ($array as $d) {
        $a = abs($max_str - iconv_strlen($d));
        $temp[] = str_repeat(" ", $a) . $d;
    }

    $temp[] = $max_str;

    return $temp;
}

$db = new PDO('sqlite:dental_clinic.db');

$sql ="SELECT doctors.id, surname, name, patronymic, date_end, procedure_name, price FROM doctors 
INNER JOIN report on doctors.id == report.id 
INNER JOIN procedures on procedures.id == report.procedure_id 
ORDER BY surname, date_end ASC;";

$statement = $db->query($sql);
$data = $statement->fetchAll();

$array_id = [];

foreach ($data as $d) {
    $array_id[] = $d['id'];
}

$array_id = array_unique($array_id);
sort($array_id);

print_r("╔═══════════════════════════" . str_repeat('═', $array_id[count($array_id) - 1] - 1) . "═╗\n");
print_r("║ Выберите номер доктора :   " . str_repeat(' ', $array_id[count($array_id) - 1] - 1) . "║\n");
print_r("╠════════════════════════════" . str_repeat('═', $array_id[count($array_id) - 1] - 1) . "╣\n");
for ($i = 0; $i < count($array_id) - 1; ++$i) {
    if($i < 9) {
        print_r("║      {$array_id[$i]}                               ║\n");
    }
    else{
        print_r("║      {$array_id[$i]}                              ║\n");
    }
}
print_r("╚════════════════════════════" . str_repeat('═', $array_id[count($array_id) - 1] - 1) . "╝\n");

print_r("Input : ");
$doctor_id = readline();

if (($doctor_id > max($array_id) || $doctor_id <= 0) && $doctor_id != "") {
    print_r("Доктора с номером {$doctor_id} в базе нету.\n");
    return -1;
}
else if ($doctor_id !== "") {
    $query = "SELECT doctors.id, surname, name, patronymic, date_end, procedure_name, price FROM doctors 
    INNER JOIN report on doctors.id == report.id 
    INNER JOIN procedures on procedures.id == report.procedure_id WHERE doctors.id == {$doctor_id} ORDER BY surname, date_end ASC;";
    $statement = $db->query($query);
    $data = $statement->fetchAll();
}
else{
    $statement = $db->query($sql);
    $data = $statement->fetchAll();
}

$array_full_name = array();
$array_id = array();
$array_date_end = array();
$array_procedure = array();
$array_prices = array();

foreach ($data as $d) {
    $array_full_name[] = $d['surname'] . " " . $d['name'] . " " . $d['patronymic'];
    $array_date_end[] = $d['date_end'];
    $array_id[] = $d['id'];
    $array_procedure[] = $d['procedure_name'];
    $array_prices[] = $d['price'];
}

$array_full_name = dataTransform($array_full_name);
$array_prices = dataTransform($array_prices);
$array_id = dataTransform($array_id);
$array_procedure = dataTransform($array_procedure);
$array_date_end = dataTransform($array_date_end);

if($doctor_id == "") {
    print_r("╔══" . str_repeat('═', ($array_id[count($array_id) - 1])) . "══╦═══" . str_repeat('═', $array_full_name[count($array_id) - 1]) . "═╦══" . str_repeat('═', $array_date_end[count($array_id) - 1]) . "═════╦══" . str_repeat('═', $array_procedure[count($array_id) - 1]) . "══╦══" . str_repeat('═', $array_prices[count($array_id) - 1]) . "═════════════╗\n"); //  ╚╔ ╩ ╦ ╠ ═ ╬ ╣ ║ ╗ ╝
    print_r("║ " . str_repeat(' ', $array_id[count($array_id) - 1] - 1) . "ID      ФИО" . str_repeat(' ', $array_full_name[count($array_id) - 1] - 2) . "  Дата проведения  " . str_repeat(' ', $array_date_end[count($array_id) - 1] - 2) . "Процедура" . str_repeat(' ', $array_procedure[count($array_id) - 1] - 4) . "Цена" . str_repeat(' ', $array_prices[count($array_id) - 1] - 2) . "     ║\n");
    print_r("╠══" . str_repeat('═', $array_id[count($array_id) - 1]) . "══╬═══" . str_repeat('═', $array_full_name[count($array_id) - 1]) . "═╬══" . str_repeat('═', $array_date_end[count($array_id) - 1]) . "═════╬══" . str_repeat('═', $array_procedure[count($array_id) - 1]) . "══╬══" . str_repeat('═', $array_prices[count($array_id) - 1]) . "═════════════╣\n");
    for ($i = 0; $i < count($array_prices) - 1; ++$i) {
        if ($i < 9) {
            $format = "║  %d   ║  %s  ║  %s     ║  %s  ║        %s       ║\n";
            echo sprintf($format, $array_id[$i], $array_full_name[$i], $array_date_end[$i], $array_procedure[$i], $array_prices[$i]);
        } else {
            $format = "║  %d  ║  %s  ║  %s     ║  %s  ║        %s       ║\n";
            echo sprintf($format, $array_id[$i], $array_full_name[$i], $array_date_end[$i], $array_procedure[$i], $array_prices[$i]);
        }
    }
    print_r("╚════" . str_repeat('═', $array_id[count($array_id) - 1]) . "╩═" . str_repeat('═', $array_full_name[count($array_id) - 1]) . "═══╩══" . str_repeat('═', $array_date_end[count($array_id) - 1]) . "═════╩══" . str_repeat('═', $array_procedure[count($array_id) - 1]) . "══╩══" . str_repeat('═', $array_prices[count($array_id) - 1]) . "═════════════╝\n");
}
else{
    print_r("╔══" . str_repeat('═', ($array_id[count($array_id) - 1])) . "══╦═══" . str_repeat('═', $array_full_name[count($array_id) - 1]) . "═╦══" . str_repeat('═', $array_date_end[count($array_id) - 1]) . "═════╦══" . str_repeat('═', $array_procedure[count($array_id) - 1]) . "══╦══" . str_repeat('═', $array_prices[count($array_id) - 1]) . "═════════════╗\n"); //  ╚╔ ╩ ╦ ╠ ═ ╬ ╣ ║ ╗ ╝
    print_r("║ " . str_repeat(' ', $array_id[count($array_id) - 1] - 1) . "ID      ФИО" . str_repeat(' ', $array_full_name[count($array_id) - 1] - 2) . "  Дата проведения  " . str_repeat(' ', $array_date_end[count($array_id) - 1] - 2) . "Процедура" . str_repeat(' ', $array_procedure[count($array_id) - 1] - 4) . "Цена" . str_repeat(' ', $array_prices[count($array_id) - 1] - 2) . "     ║\n");
    print_r("╠══" . str_repeat('═', $array_id[count($array_id) - 1]) . "══╬═══" . str_repeat('═', $array_full_name[count($array_id) - 1]) . "═╬══" . str_repeat('═', $array_date_end[count($array_id) - 1]) . "═════╬══" . str_repeat('═', $array_procedure[count($array_id) - 1]) . "══╬══" . str_repeat('═', $array_prices[count($array_id) - 1]) . "═════════════╣\n");
    for ($i = 0; $i < count($array_prices) - 1; ++$i) {
        if ($i < 9) {
            $format = "║  %d  ║ %s   ║  %s     ║  %s  ║        %s       ║\n";
            echo sprintf($format, $array_id[$i], $array_full_name[$i], $array_date_end[$i], $array_procedure[$i], $array_prices[$i]);
        } else {
            $format = "║  %d  ║  %s  ║  %s     ║  %s  ║        %s       ║\n";
            echo sprintf($format, $array_id[$i], $array_full_name[$i], $array_date_end[$i], $array_procedure[$i], $array_prices[$i]);
        }
    }
    print_r("╚════" . str_repeat('═', $array_id[count($array_id) - 1]) . "╩═" . str_repeat('═', $array_full_name[count($array_id) - 1]) . "═══╩══" . str_repeat('═', $array_date_end[count($array_id) - 1]) . "═════╩══" . str_repeat('═', $array_procedure[count($array_id) - 1]) . "══╩══" . str_repeat('═', $array_prices[count($array_id) - 1]) . "═════════════╝\n");

}


?>