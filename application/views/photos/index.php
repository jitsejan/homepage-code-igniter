<div class="container">
  <section>
    <div class="row page-header">
        <h1><?php echo $title; ?></h1>
    </div>
      <hr/>
    <div id="photos" class="row page-content">
      <?php if(isset($photosets)): ?>
      <ul>
      <?php foreach($photosets as $index => $photoset): ?>
        <li class="li-photoset">
  				<div class="div-photoset"><?php echo $photoset['title']; ?></div>
  			</li>
  			<?php if(isset($photoset['photos'])): ?>
  			<?php foreach($photoset['photos'] as $pindex => $photo): ?>
  			  <a class="swipebox" href="<?php echo $photo['url_o']; ?>" title="<?php echo $photo['title']; ?>">
      			<li>
      				<p>
      					<b><?php echo $photo['title'];?></b>
      					<br/><br/><br/>
      					[<?php echo $photo['datetaken'];?>]
      				</p>
      				<div style="background-image: url('<?php echo $photo['url_s'];?>');">
      				</div>
      			</li>
    			</a>
  			<?php endforeach; ?>
  			<?php else: ?>
  			<li>
  			  <p>
  					<b>No pictures found!</b>
  				</p>
  			</li>
  			<?php endif; ?>
      <?php endforeach; ?>
      </ul>
      <?php endif; ?>
    </div>
  </section>
</div>