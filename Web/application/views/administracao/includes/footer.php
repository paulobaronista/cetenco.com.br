		</div><!-- NÃO APAGAR!!! Fecha o div 'content' -->
	</div><!-- NÃO APAGAR!!! Fecha o div 'wrapper'-->
	<script type="text/javascript" charset="utf-8">
		$(function(){
			// This is required for the PNG fix to work.
			if (window.DD_belatedPNG)
			DD_belatedPNG.fix('.pngimg');

			// This is some javascript to stop IE from displaying the img alt attributes
			// when you mouse over imagess.  If you would like IE to display the alt attributes,
			// just comment out the following 4 lines.  Don't worry, if you leave this in
			// place, your ALT attributes are still readable by the search engines.
			var tmpalt;
			$("img").hover(
				function(){ tmpalt = $(this).attr( "alt" ); $(this).attr( "alt", "" ); },
				function(){ $(this).attr( "alt", tmpalt );}
			);



			$("button, input:submit, a.button").button();
			$("a").bind('click', function(){
				if ($.cookie('ci_session') == null){
					$.colorbox.remove();
					location.replace('<?=site_url('administracao/access')?>');
				}
			});

			$("select[name=idioma]").change(function(){
				$("#idioma").submit();
			});

		});
	</script>
</body>
</html>