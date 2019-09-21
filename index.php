<?php

include('simple_html_dom.php');

$connection = new PDO("mysql:host=localhost;dbname=scraping_test", 'root', '');

$html = file_get_html('https://amplitudo.me/blog');

$no_of_links = 0;
$no_of_data = 0;

foreach($html->find('div.div_novost') as $e){

    foreach($e->find('a') as $a){
        $no_of_links++;
        // echo $a->attr['href'] . "<br>";
        $html_inside = file_get_html('https://amplitudo.me/' . $a->attr['href']);
        foreach($html_inside->find('div.tekst_u_boji') as $u){
            $no_of_data++;
            //echo $no_of_links . " - " . "-" . $a->attr['href'] . $no_of_data . " - " . $u->innertext . "<br>"; 
            $statement = $connection->prepare("Insert into blog values (null, :intro_text)");
            $statement->bindValue('intro_text', $u->innertext);
            echo ($statement->execute() ? 'Success!' : 'Fail!' . $a->attr['href']);
        }
    }

}

// $arr = ['div.bijeladiv2', 'div.div_novost'];

// insertPDO($connection, 'https://amplitudo.me/blog', $arr);

// function insertPDO($link, $search){

//     $no = 0;
//     level($search, $no);

// }

// function level($deptArray, $lvl){
//     $elements = file_get_html('https://amplitudo.me/blog');

//     foreach($elements->find($deptArray[$lvl]) as $element){
//         if($lvl == count($deptArray) - 1){
//             echo $element->innertext;
//         }else{
//             $lvl++;
//             level($deptArray, $lvl);
//         }
//     }
// }