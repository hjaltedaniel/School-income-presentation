<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
		<script>
			var iFrameResizer = {
					messageCallback: function(message){
						alert(message,parentIFrame.getId());
					}
				}
		</script>

		<script type="text/javascript" src="assets/js/iframeResizer.contentWindow.min.js" defer></script>
<script>
    $(function() {
        var skoleListe = <?php autoComplete (); ?>;
        $("#skoleNavn").autocomplete({
            source: skoleListe,
            select: function(event, ui) {
                $("#skoleNavn").val(ui.item.value);
                $("form").submit();
            }
        });
    });

</script>

</body>

</html>
