		</div> 
		<div id="footer">
			<div class="container">
				<p class="text-muted credit">Site courtesy Fabio Poloni & Florian Siffer</p>
			</div>
		</div>
		<script src="js/blueimp-gallery.min.js"></script>
        <script>
        document.getElementById('links').onclick = function (event) {
            event = event || window.event;
            var target = event.target || event.srcElement,
                link = target.src ? target.parentNode : target,
                options = {index: link, event: event},
                links = this.getElementsByTagName('a');
            blueimp.Gallery(links, options);
        };
        </script>
	</body>
</html>