<?php
    include_once 'mvc/view/header.php';
?>
<div class="container">
	<a href="index">Powrót do Strony Głównej</a>
	<table class="table">
        <tbody>
            <td><strong>LP.</strong></td>
            <td><strong>Nazwa produktu:</strong></td>
		    <td><strong>Kod Kreskowy:</strong></td>
		    <td><strong>Comman ID</strong></td>
		    <td><strong>STATUS</strong></td>
<?php
for ($i = 1; $i <= 10; $i++) {
	echo "<tr>"
        . "<td>{$i}</td>"
        . "<td>Nazwa</td>"
        . "<td>EAN</td>"
        . "<td>Command ID</td>"
        . '<td>Synchronizacja udana</td>'
        . "</tr>";
}
?>
    </tbody>
</table>
<?php
include_once 'mvc/view/footer.php';
