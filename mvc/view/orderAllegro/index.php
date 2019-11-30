<?php
    include_once 'mvc/view/header.php';
?>
<div class="container">
    <ul id="slide-out" class="sidenav">
        <li>
            <div class="user-view">
                <div class="background">
                    <img src="https://thumbs.dreamstime.com/b/b-kitny-technologia-okr-g-i-informatyki-abstrakcjonistyczny-t-o-z-kod-matryc-kitnego-binarnego-biznes-zwi-zek-futurystyczny-149819172.jpg">
                </div>
                <a href="index"><img class="circle" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRM2onTPJELE1lDi5Pq1WJl5-HT4Jeo_r81Ui15C__sci1gbbPU&s"></a>
                <a href="index"><span class="white-text name">Michał Łupiński</span></a>
                <a href="#email"><span class="white-text email">przykład@gmail.com</span></a>
            </div>
        </li>
        <li>
            <a href="systim" class="waves-effect md-list"><i class="material-icons">autorenew</i>Aktualizacja SYSTIM</a>
        </li>
        <li>
            <a href="https://allegro.pl.allegrosandbox.pl/auth/oauth/authorize?response_type=code&client_id=3617cce10485446b908ea021060544df&redirect_uri=http://mojaapka.pl/Allegro&prompt=confirm" class="waves-effect "><i class="material-icons">compare_arrows</i>Synchronizacja z Allegro</a>
        </li>
        <li><div class="divider"></div></li>
        <li>
            <a href="orderAllegro" class="waves-effect"><i class="material-icons">shopping_basket</i>Zamówienia Allegro</a>
        </li>
        <li>
            <a href="#" class="waves-effect"><i class="material-icons">local_shipping</i>Wysyłki Allegro</a>
        </li>
        <li>
            <a href="#" class="waves-effect"><i class="material-icons">timelapse</i>Licznik Synchronizacji</a>
        </li>
        <li>
        	<label>Wybierz konto Allegro</label>
            <select>
                <?php
                    $i = 0;
                    foreach ($account as $acc) {

                    	if($i == 0) {

                    		echo '<option value="account"'. $i .' selected>'. ' ' . $acc[1] .'</option>';
                    	} else {

                    		 echo '<option value="account"'. $i .'>'. ' ' . $acc[1] .'</option>';
                    	}
                        $i++;
                    }
                ?>
            </select>
        </li>
        <li>
            <a href="#!" class="waves-effect"><i class="material-icons">add</i>Dodaj konto Allegro</a>
        </li>
    </ul>
    <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    
    <table class="table">
        <tbody>
            <td><strong>LP.</strong></td>
			<td><strong>Kupujacy:</strong></td>
			<td><strong>Data:</strong></td>

<?php
    for ($i = 0; $i < count($data); $i += 3) {
    	
    	$badData = date_create($data['checkoutForms'][$i]['updatedAt']);
    	$normalData = date_format($badData,'Y-m-d H:i:s');

        echo '<tr>'
            . '<td>'.($i+1).'</td>'
            . '<td>'.$data['checkoutForms'][$i]['buyer']['login'].'</td>'
            . '<td>'.$normalData.'</td>'
        . '</tr>';
    }
?>
    </tbody>
</table>
<?php
include_once 'mvc/view/footer.php';