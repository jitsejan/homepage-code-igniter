<div class="container">
    <div class="row" id="social-block">
    	<center>
    		<a href="http://www.facebook.com/jitsejan" target="blank"><i class="fa fa-facebook fa-3x"></i></a>
    		<a href="http://www.flickr.com/photos/jitsejan/" target="blank"><i class="fa fa-flickr fa-3x"></i></a>
    		<a href="http://youtube.com/JQadrad" target="blank"><i class="fa fa-youtube fa-3x"></i></a>
    		<a href="https://play.spotify.com/user/jitsejan" target="blank"><i class="fa fa-spotify fa-3x"></i></a>
    		<a href="http://nl.linkedin.com/pub/jitsejan" target="blank"><i class="fa fa-linkedin fa-3x"></i></a>
    	</center>
    </div>
</div><!-- /container !-->
<div class="container">
    <div class="row" id="projects">
        <hr/>
        <h1>Projects</h1>
        <h2 class='subtitle'>Some of the projects from my past</h2>
        <hr/>
        <?php if(isset($projects)): ?>
        <?php foreach($projects as $index => $project): ?>
        <article>
            <div class="row">
                <?php if($index % 2 == 0): ?>
		        <div class="thumbnail col-lg-4 col-md-4 col-sm-4">
	                <img src="<?php echo $project['image'];?>" class="img-responsive" alt="" >
                </div>
                <?php endif; ?>
		        <div class="col-md-8 col-lg-8 col-sm-8">
		            <h3 class="entry-title"><?php echo $project['title']; ?></h3>
                    <p><?php echo $project['description']; ?></p>
                </div>
                <?php if($index % 2 == 1): ?>
		        <div class="thumbnail col-lg-4 col-md-4 col-sm-4">
	                <img src="<?php echo $project['image'];?>" class="img-responsive" alt="" >
                </div>
                <?php endif; ?>
		    </div>
	    </article>
        <?php endforeach; ?>
        <?php endif; ?>
    </div><!-- /projects !-->
</div><!-- /container !-->
<div class="container">
    <div class="row" id="websites">
        <hr/>
        <h1>Websites</h1>
        <h2 class="subtitle">A history of the websites I have created</h2>
        <hr/>
        <?php if(isset($websites)): ?>
        <?php foreach($websites as $index => $website): ?>
        <?php if($index % 2 == 0): ?>
        <div class="row row-eq-height webrow">
	    <?php endif; ?>
            <article>
            	<div class="col-sm-6 col-xs-12 col-md-6">
            		<h4 class="entry-title"><?php echo $website['title'];?></h4>
		            <img class="web-img" src="<?php echo $website['image'];?>" width="200">
		            <p><?php echo $website['description'];?></p>
            	</div>
    	    </article>
    	<?php if($index % 2 == 1): ?>
        </div><!-- /row !-->
	    <?php endif; ?>
        <?php endforeach; ?>
        </div><!-- /row !-->
        <?php endif; ?>
    </div><!-- /websites !-->
</div><!-- /container !-->		</div><!-- container !-->