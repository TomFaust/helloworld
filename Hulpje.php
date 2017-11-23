<!DOCTYPE PHP>
<html>
<head>
<link rel="stylesheet" type="text/css" href="hulpje.css">
</head>



<body>

<div id="banner">

<h1>Hulpje</h1>

</div>



<?php

//verbind met de local database of de server database afhankelijk van wat werkt
include 'connect.php';
?>

<div id="opties">


<p>Selecteer een tabel:</p>
<form action="" name="form1" id="form1" method="get">

<!--select box voor welke tabel gebruikt word, submit onchange-->
<select name="Dbselect" onchange="this.form.submit()">
<!--blanko optie-->
<option value="">-select-</option>
<?php

//variabel voor de geselecteerde tabel
$Dbuse = $_GET['Dbselect'];

//query laat alle tafels in de database zien
$queryshow= "show tables;";

//fetch row neemt de naam van een tabel en zet die in een option op een loop
$DBfetchproductshow = mysqli_query($conn,$queryshow);
while($productshow = mysqli_fetch_row($DBfetchproductshow)){
$show = $productshow[0];

echo '<option value="'.$show.'">'.$show.'</option>';

};


?>
</select><br>

</form>








<!--form voor de checkboxen-->
<form action="" name="form2" id="form2" method="get">

<!--deze hidden input neemt de geselecteerde tabel en plaats hem in dit form, hierdoor word deze nog een keer
gesubmit samen met de checkboxen-->
<input type="hidden" name="Dbselect" value="<?php echo $Dbuse?>" />

<?php
//laat zien welke tabel er is geselecteerd
echo "<p>Tabel: ". $Dbuse . "</p>";

//geeft de namen van alle kolomen in een tabel
$query = "SELECT `COLUMN_NAME` 
FROM `INFORMATION_SCHEMA`.`COLUMNS` 
WHERE `TABLE_SCHEMA`='".$database."' 
AND `TABLE_NAME`='".$Dbuse."';";

//telt het aantal kolomen in een tabel
$sql='SELECT count(*) FROM information_schema.`COLUMNS` C
WHERE table_name = "'.$Dbuse.'"
AND TABLE_SCHEMA = "'.$database.'"';

//maakt een variabel aan voor het aantal kolomen
$DBfetchproductC = mysqli_query($conn,$sql);
while($productC = mysqli_fetch_row($DBfetchproductC)){
$DBstop = $productC[0];
};

//geeft aan hoevaak een tabel is gegenereerd
$act = 0;	


//genereert  de checkboxen, act gaat omhoog totdat hij bij DBstop komt
$DBfetchproduct = mysqli_query($conn,$query);

while($act<$DBstop){

$product = mysqli_fetch_row($DBfetchproduct);
$name = $product[0];
echo '<p><input type="checkbox" name="'.$name.'" value="'.$name.'">'.$name.'</p>' ;
$act++;

};

?>

<!--submit voor de checkboxen-->
<input type="submit" id="form2" value="submit">

</form>




<!--form voor het bepalen van het bereik-->
<form action="" method="post">


<select name="kolomn">
<!--blanko optie-->
<option value="nothing">-kolom-</option>
<?php

//variabel voor de geselecteerde tabel
$Dbuse = $_GET['Dbselect'];

//query laat alle tafels in de database zien
$queryshow= "SELECT `COLUMN_NAME` 
FROM `INFORMATION_SCHEMA`.`COLUMNS` 
WHERE `TABLE_SCHEMA`='".$database."' 
AND `TABLE_NAME`='".$Dbuse."';";

//fetch row neemt de naam van een tabel en zet die in een option op een loop
$DBfetchproductshow = mysqli_query($conn,$queryshow);
while($productshow = mysqli_fetch_row($DBfetchproductshow)){
$show = $productshow[0];

echo '<option value="'.$show.'">'.$show.'</option>';

};


?>
</select><br>


<input placeholder=" -like-" type="text" name="like"><br>

<!--naam limit2 word onthouden door een volgend stuk code-->
<input type="submit" name="limit2" id="form" value="submit"><br>
</form>
</div>






<div id="content">

<!--genereert de uitput van de gekozen opties-->
<?php

//geeft aan welk nummer kolom is gegenereet
$act = 0;
//zet de teller het aantal records op nul	
$records = 0; 

$count = 0;
	
//neemt een vorige query om de kolomnamen van de gekozen tabel een voor een te vinden	
$DBfetchproduct = mysqli_query($conn,$query);
while($product = mysqli_fetch_row($DBfetchproduct)){
$name = $product[0];

//als de naam die de query pakt verzonden is..
if(isset($_GET[$name])){
$count++;

//echoed de start van een tabel
echo '<table cellspacing="0" cellpadding="0" id="table"><tr bgcolor="gray" ><th>'.$name.'</th></tr>';


//kijkt of het berijk is aangegeven
if($_POST['limit2']=="submit"){
$kolomn = $_POST['kolomn'];
$like = $_POST['like'];
$query1 = "SELECT * FROM ".$Dbuse." WHERE ".$kolomn." LIKE '".$like."%'";
}else{
$query1 = "SELECT * FROM ".$Dbuse;
}


//variabel nodig voor de roterende kleur van de tabel
$color = 0;

//genereert een kolom van een tabel
	$DBfetchproduct1 = mysqli_query($conn,$query1);
while($product1 = mysqli_fetch_row($DBfetchproduct1)){

//$act geeft aan welke kolom gepakt word
$output = $product1[$act];

echo '<tr bgcolor="' ;

//bepaald de kleur
if ($color % 2 == 0) {
	echo 'white';}
else{
	echo '#C7C5B6';
};

	$color++;

echo '" height="30px"><td>'.$output.'</td></tr>';

//tels het aantal opgehaalde records per tabel
$records++;

};
//einde kolom
echo '</table>';

};

//naar volgende kolom
$act++;

};

?>
</div>

<div id="opgehaald">

<?php
//deelt het aantal records door het aantal tabellen
$end = $records / $count;

if($end == '' OR $end == NAN){
echo "<p>Er zijn geen records opgehaald.</p>";}else{
echo "<p>Er zijn ".$end." records opgehaald.</p>";}

?>
</div>

</body>
</html>