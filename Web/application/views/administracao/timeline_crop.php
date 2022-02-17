<div id="cropWidget" style="float: left;">
	<img id="cropbox" src="<?=$foto?>" />
</div>
<div style="width: 135px; height: 115px; float: left; overflow: hidden; margin-left: 5px;">
	<img id="preview" src="<?=$foto?>" />
</div>
<script type="text/javascript">
	$(function(){
		var cropWidget;

		function initCoords() {
			$('#x, input[name=x]').val(0);
			$('#y, input[name=y]').val(0);
			$('#w, input[name=w]').val(layer[id].width);
			$('#h, input[name=h]').val(layer[id].height);
			$('#refW, input[name=refW]').val(layer[id].width);
			$('#refH, input[name=refH]').val(layer[id].height);
		}

		function updateCoords(c) {
			$('#x, input[name=x]').val(c.x);
			$('#y, input[name=y]').val(c.y);
			$('#w, input[name=w]').val(c.w);
			$('#h, input[name=h]').val(c.h);
		};

		function showPreview(coords)
		{
			var rx = 135 / coords.w;
			var ry = 115 / coords.h;

			$('#preview').css({
				width: Math.round(rx * $("#cropbox").width()) + 'px',
				height: Math.round(ry * $("#cropbox").height()) + 'px',
				marginLeft: '-' + Math.round(rx * coords.x) + 'px',
				marginTop: '-' + Math.round(ry * coords.y) + 'px'
			});
		};

		$("#cropbox").onImagesLoad({
				selectorCallback: function(){
					if (typeof(cropWidget) != 'undefined' && typeof(cropWidget.destroy == 'function')) {
						cropWidget.destroy();
					} else {
						cropWidget = $.Jcrop("#cropbox",{
							aspectRatio: 135 / 115,
							minSize: [135 , 115],
							setSelect: [0, 0, 135 , 115],
							onSelect: showPreview,
							onChange: showPreview
						});
					}
				}
		});

	});
</script>