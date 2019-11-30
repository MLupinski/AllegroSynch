	<footer>
		<div class="page-footer white">
			<div class="footer-copyright white grey-text">
            	<div class="container">
            		COPYRIGHT © Michał Łupiński 2019
            	</div>
          	</div>
		</div>	
	</footer>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	<script type="text/javascript">
		var elem = document.querySelector('.sidenav');
		var instance = M.Sidenav.init(elem, {
			inDuration: 350,
			outDuration: 350,
			edge: 'left' //or right
	});
	document.addEventListener('DOMContentLoaded', function() {
		var elems = document.querySelectorAll('select');
	    var instances = M.FormSelect.init(elems);
	});
	</script>
</body>
</html>