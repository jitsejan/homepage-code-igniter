<center><h2><?php echo $item['title'];?></h2></center>
<div class="row">
<div class="col-xs-8 col-xs-offset-2 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
	<?php if(sizeof($item['images'],2) > 1): ?>
	<div class="product-slider-detail">
		<div id="carousel" class="carousel slide" data-ride="carousel" data-interval="false">
			<center><div class="carousel-inner" role="listbox">
			<?php foreach($item['images'] as $index => $image){?>
				<div class="item <?php echo ($index == 0 ? 'active' : ''); ?>" data-slide-number="<?php echo $index;?>">
					<center><img src="<?php echo $image['imageurl']; ?>" class="img-responsive detail-view"/></center>
				</div> <!-- item !-->
			<?php } ?>
			</div> <!-- carousel-inner !-->
			</center>
			<a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#carousel" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div><!-- carousel !-->
		<div class="row hidden-xs" id="slider-thumbs">
			<ul class="hide-bullets">
	            <?php foreach($item['images'] as $index => $image):?>
	            <li class="col-md-2 col-lg-2 col-sm-2">
	                <a id="carousel-selector-<?php echo $index;?>"><img class="img-responsive" src="<?php echo $image['imageurl']; ?>"></a>
	            </li>
	            <?php endforeach; ?>
	        </ul>
		</div>
		<div style="clear: both;"></div>
	</div><!-- product-slider !-->
	<?php elseif(sizeof($item['images'],2) == 1): ?>
	<div class="product-image-detail">
			<center><img src="<?php echo $item['images'][0]['imageurl']; ?>" title="'<?php echo $item['title']; ?>" class="img-responsive img-prod"/></center>
	</div>
	<?php else: ?>
	<div class="product-image-detail">
		Oops! No images found.
	</div>
	<div style="clear: both;"></div>
	
	<?php endif; ?>
	</div> <!-- item-col !-->
	<div class="clearfix row">
		<div class="col-xs-12 col-xs-offset-0 col-sm-6 col-sm-offset-3 col-md-2 col-md-offset-5 col-lg-2 col-lg-offset-5">
			<center>
				<div class="product-price"> <?php echo ($item['prices'] ? $item['prices'][0]['price']: 'No price found!');?></div>
			</center>
		</div>
	</div>
	<!--<div class="clearfix row">-->
	<!--	<button value="<?php // echo $item['uuid'];?>" class="btn wishlistbtn btn-primary col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4" data-toggle="modal" data-target="#wishlistmodal">-->
	<!--		Add to wishlist-->
	<!--	</button>-->
	<!--	<button value="<?php // echo $item['uuid'];?>" class="btn deleteitembtn btn-primary col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-4	col-lg-offset-4" data-toggle="modal" data-target="#deleteItemModal">-->
	<!--		Remove from items-->
	<!--	</button>-->
	<!--	<a href="<?php // echo $item['link']; ?>">-->
	<!--		<button class="btn btn-primary col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">-->
	<!--			Go to <?php // echo $item['store'];?>-->
	<!--		</button>-->
	<!--	</a>-->
	<!--</div>-->
	<div class="clearfix row">
		<section>
			<h2>Prices</h2>
			<?php if(sizeof($item['prices'],2) > 1): ?>
				<div class="item-price-table">
					<table class="table" id="tb-price">
						<?php foreach($item['prices'] as $index => $price): ?>
						<tr class="tr-price"><td class="td-checkdate"><?php echo $price['checkdate'];?></td><td class="td-price"><?php echo $price['price'];?></td></td></tr>
						<?php endforeach; ?>
					</table>
				</div>
				<div class="item-price-graph"></div>
			<?php elseif(sizeof($item['prices'],2) == 1): ?>
				<center>No graph possible yet. Only one price stored in the database!</center>
			<?php else: ?>
				<center>Oops! No prices found.</center>
			<?php endif; ?>
		</section>
	</div>
</div>


<script type="text/javascript">
$(document).ready(function () {
	
	$('[id^=carousel-selector-]').click( function(){
        var id = this.id.substr(this.id.lastIndexOf("-") + 1);
        var id = parseInt(id);
        $('#carousel').carousel(id);
    });

    
	var d1 = [];
	var numm = $('#tb-price > tbody  > tr').length;
	$('#tb-price > tbody  > tr').each(function(index) {
		var tmpdate = $(this).find('.td-checkdate').html();
		var date = (new Date(tmpdate).getTime());
		var price = $(this).find('.td-price').html();
		d1.push([date, price]);
	});
	setGraph(d1);
	
	function setGraph(d1){
    	$.plot($(".item-price-graph"),
    		[{data :d1}],
    		{
	        xaxis: {
	            mode: "time",
    			timeformat: "%m/%d/%y",
	            axisLabel: 'Day',
	            axisLabelUseCanvas: true,
	            axisLabelFontSizePixels: 8,
	            axisLabelFontFamily: 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
	            axisLabelPadding: 5
	        },
	        yaxis: {
	            axisLabel: 'Price',
	            axisLabelUseCanvas: true,
	            axisLabelFontSizePixels: 12,
	            axisLabelFontFamily: 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
	            axisLabelPadding: 5
	        },
	        series: {
	            lines: { show: true },
	            points: {
	                radius: 3,
	                show: true,
	                fill: true
	            },
	        },
	        grid: {
	            hoverable: true,
	            borderWidth: 1
	        },
	        legend: {
	            labelBoxBorderColor: "none",
	                position: "right"
	        }
	    });
    }
    
    
});
</script>