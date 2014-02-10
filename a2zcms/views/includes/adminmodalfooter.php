 <script type="text/javascript">
			$(function() {
				$('form').submit(function(event) {
					var form = $(this);
					$.ajax({
						type : form.attr('method'),
						url : form.attr('action'),
						data : form.serialize(),
					}).complete(function() {
						// Optionally alert the user of success here...
						setTimeout(function() 
					        {
					            //parent.$.colorbox.close();
					            //window.parent.location.reload();
					        }, 10);
						
					}).fail(function() {
						// Optionally alert the user of an error here...
					});
					//event.preventDefault();
					// Prevent the form from submitting via the browser.
				});

				$('.close_popup').click(function() {
					//parent.$.colorbox.close()
					//window.parent.location.reload();
				});
				 $( "#sortable" ).sortable();
				$( "#sortable" ).disableSelection();
				$( "#finished" ).spinner({
						step: 0.01,
						numberFormat: "n"
					});
				$("select[id^='id'],select[id^='grid']").multiselect();
			});
		</script>
	</body>
</html>