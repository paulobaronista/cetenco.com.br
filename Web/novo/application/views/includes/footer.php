
            </div>

            <div id="footer">
            	<p id="copyright">R. Maria Paula 36 - 8º Andar - Bela Vista - 01319-000 - São Paulo - SP<br />
				Tel: 11 3320 7000 | Fax: 11 3107 7546 | 7547 | <a href="http://maps.google.com.br/maps?f=q&source=s_q&hl=pt-BR&geocode=&q=Rua+Maria+Paula+36+-+8%C2%BA+Andar+-+Bela+Vista&sll=-23.551669,-46.639042&sspn=0.001913,0.003484&ie=UTF8&hq=&hnear=R.+Maria+Paula,+36+-+Rep%C3%BAblica,+S%C3%A3o+Paulo,+01319-000&z=17" target="_blank"><?=lang('localize_no_gmaps')?></a></p>

<!--                <p id="nav"><a href="<?=site_url('certificacoes')?>"><?=mb_strtoupper(lang('menu_certificacoes'),'UTF-8')?></a> | <a href="<?=site_url('contato/trabalhe-conosco')?>"><?=mb_strtoupper(lang('menu_trabalhe_conosco'),'UTF-8')?></a> | <a href="<?=site_url('mapa-do-site')?>"><?=mb_strtoupper(lang('menu_sitemap'),'UTF-8')?></a></p>-->
				<div id="assinatura" style="float:right; margin: 40px 25px 0 0">
					<object width="150" height="11" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id="FlashID2">
						<param value="<?=base_url()?>includes/swf/assin_01.swf" name="movie">
						<param value="high" name="quality">
						<param value="transparent" name="wmode">
						<param value="9.0.45.0" name="swfversion">
						<!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you donâ€™t want users to see the prompt. -->
						<param value="Scripts/expressInstall.swf" name="expressinstall">
						<!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
						<!--[if !IE]>-->
						<object width="150" height="11" data="<?=base_url()?>includes/swf/assin_01.swf" type="application/x-shockwave-flash">
							<!--<![endif]-->
							<param value="high" name="quality">
							<param value="transparent" name="wmode">
							<param value="9.0.45.0" name="swfversion">
							<param value="<?=base_url()?>includes/swf/expressInstall.swf" name="expressinstall">
							<!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
							<div>
								<h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
								<p><a href="http://www.adobe.com/go/getflashplayer"><img width="112" height="33" alt="Get Adobe Flash player" src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif"></a></p>
							</div>
							<!--[if !IE]>-->
						</object>
						<!--<![endif]-->
					</object>
				</div>
                <p id="nav"><a href="<?=site_url('certificacoes')?>"><?=mb_strtoupper(lang('menu_certificacoes'),'UTF-8')?></a></p>
            </div>
        </div>

	</div>

    <script type="text/javascript">
		$(document).ready(function() {
			var current_slide = 1;

			$('#destaque-img').children('div').hide();
			$('#destaque-img').children('div').first().show();

//			function rotate_slides(container) {
//				var num_slides = $(container).children('div').size();
//
//				if (num_slides > 1) {
//					if (current_slide < num_slides) {
//						next_slide = current_slide + 1;
//					} else {
//						next_slide = 1;
//					}
//
//					$("#slide-"+current_slide).fadeOut(500, function(){
//						$("#slide-"+next_slide).fadeIn(500);
//					});
//
//					current_slide = next_slide;
//				}
//
//			}
//
//			var intervalo = window.setInterval(rotate_slides, 6000, '#destaque-img');
			
			$.doTimeout(6000,function(){
				var num_slides = $('#destaque-img').children('div').size();

				if (num_slides > 1) {
					if (current_slide < num_slides) {
						next_slide = current_slide + 1;
					} else {
						next_slide = 1;
					}

					$("#slide-"+current_slide).fadeOut(500, function(){
						$("#slide-"+next_slide).fadeIn(500);
					});

					current_slide = next_slide;
				}

				return true;
			});

			$("a.pop").fancybox({
				'padding' : 0,
				'margin' : 0,
				'overlayOpacity' : 0.6,
				'overlayColor' : '#a1b5d3',
				'titlePosition' : 'over'
			});

		});
		
		
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-20941850-1']);
		_gaq.push(['_trackPageview']);

		(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
</body>
</html>
