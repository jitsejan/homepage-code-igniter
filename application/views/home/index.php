<h1>Overview of changed items in the past 30 days</h1>
<?php foreach($dates as $index => $date): ?>
    <?php if($newitems[$date] !== FALSE || $decitems[$date] !== FALSE || $navitems[$date]!== FALSE || $incitems[$date] !== FALSE || $avaitems[$date] !== FALSE):?>
        <h2><?php echo $date; ?></h2>
        <div class="clearfix row">
        <?php if(isset($newitems[$date]) and $newitems[$date] !== FALSE): ?>
        <?php foreach($newitems[$date] as $item):?>
            <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1">
                New
                <a href="items/<?php echo $item['uuid'];?>"><img class="img-responsive" title="<?php echo $item['title']; ?>" src="<?php echo $item['images'][0]['imageurl'];?>"/></a>
                <?php echo $item['curprice'];?>
            </div>
        <?php endforeach;?>
        <?php endif; ?>
        
        <?php if(isset($decitems[$date]) and $decitems[$date] !== FALSE):?>
        <?php foreach($decitems[$date] as $item):?>
            <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1">
                <a href="items/<?php echo $item['uuid'];?>"><img class="img-responsive" title="<?php echo $item['title']; ?>" src="<?php echo $item['images'][0]['imageurl'];?>"/></a>
                <font color="lightgreen"><?php echo $item['curprice'];?><br/></font>
                <strike><?php echo $item['prevprice'];?></strike>
            </div>
        <?php endforeach;?>
        <?php endif; ?>
        
        <?php if(isset($incitems[$date]) and $incitems[$date] !== FALSE):?>
        <?php foreach($incitems[$date] as $item):?>
            <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1">
                <a href="items/<?php echo $item['uuid'];?>"><img class="img-responsive" title="<?php echo $item['title']; ?>" src="<?php echo $item['images'][0]['imageurl'];?>"/></a>
                <font color="red"><?php echo $item['curprice'];?><br/></font>
                <strike><?php echo $item['prevprice'];?></strike>
            </div>
        <?php endforeach;?>
        <?php endif; ?>
        
        <?php if(isset($navitems[$date]) and $navitems[$date] !== FALSE):?>
        <?php foreach($navitems[$date] as $item):?>
            <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1">
                Not available
                <a href="items/<?php echo $item['uuid'];?>"><img class="img-responsive" title="<?php echo $item['title']; ?>" src="<?php echo $item['images'][0]['imageurl'];?>"/></a>
                <strike><?php echo $item['prevprice'];?></strike>
            </div>
        <?php endforeach;?>
        <?php endif; ?>
        
        <?php if(isset($avaitems[$date]) and $avaitems[$date] !== FALSE):?>
        <?php foreach($avaitems[$date] as $item):?>
            <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1">
                Back available
                <a href="items/<?php echo $item['uuid'];?>"><img class="img-responsive" title="<?php echo $item['title']; ?>" src="<?php echo $item['images'][0]['imageurl'];?>"/></a>
                <?php echo $item['curprice'];?>
            </div>
        <?php endforeach;?>
        <?php endif; ?>
        
        <div class="clearfix"></div>
        </div><!-- row !-->
    <?php else: ?>
        <!-- No items for this date-->
    <?php endif; ?>    
<?php endforeach; ?>