<?php  
	if ( ! isset($_COOKIE['accepte-cookie'])){
?>
<div class="banniere">
<div class="text-danniere">
<p>Notre site utilise des cookies pour une meilleure expérience.</p>
</div>
<img src="/upload/cookie.jpg" alt="" style="width: 100px; height:100px">
<div class="button-banniere">
<a href="?accepte-cookie">OK, J'accepte</a>
</div>
</div>
<?php 
}
?>