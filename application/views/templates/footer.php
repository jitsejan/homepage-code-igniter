		<footer>
            <div id="inner-footer" class="vertical-nav">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <p>
                            	<center>
									<a href="mailto:mail@jitsejan.nl"><i class="fa fa-envelope"></i></a>
									<a href="http://www.facebook.com/jitsejan" target="blank"><i class="fa fa-facebook"></i></a>
									<a href="http://www.flickr.com/photos/jitsejan/" target="blank"><i class="fa fa-flickr"></i></a>
									<a href="http://youtube.com/JQadrad" target="blank"><i class="fa fa-youtube"></i></a>
									<a href="https://play.spotify.com/user/jitsejan" target="blank"><i class="fa fa-spotify"></i></a>
									<a href="https://www.linkedin.com/in/jitsejan" target="blank"><i class="fa fa-linkedin"></i></a>
								</center>
							</p>
							<p>Copyright &copy; Jitse-Jan van Waterschoot | 2008 - 2016</p>
						</div>
                    </div>
                </div>
            </div>
        </footer>
		<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/js/jquery-2.2.0.min.js');?>"></script>
		<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/js/jquery-ui.js');?>"></script>
		<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/js/jquery.mobile.custom.min.js');?>"></script>
		<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/js/jquery.swipebox.js');?>"></script>
		<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/js/toc.js');?>"></script>
		<script type="text/javascript" language="javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			$( document ).ready(function() {
				$( '.swipebox' ).swipebox();
				$('#subnav').affix({
					offset: {
					top: $('#subnav').offset().top,
					bottom: $('footer').outerHeight(true) + $('.application').outerHeight(true) + 40
					}
				});
			});
		</script>
                <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-9074661-8', 'auto');
  ga('send', 'pageview');

              </script>
	</body>
</html>
