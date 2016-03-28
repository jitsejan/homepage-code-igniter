<div class="row">
	<a href="<?php echo base_url('items/add'); ?>"><i class="fa fa-plus fa-4x"></i></a>
</div>
<div class="row">
<?php if(isset($items)){ ?>
<h2><?php echo $title; ?></h2>
<?php foreach ($items as $item): ?>
	<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2 item-col">
		<?php if(isset($item['images']) && sizeof($item['images'],2) > 1){ ?>
		<div class="product-slider">
			<div id="carousel<?php echo $item['id']; ?>" class="carousel slide" data-ride="carousel" data-interval="false">
				<center><div class="carousel-inner" role="listbox">
				<?php foreach($item['images'] as $index => $image){?>
					<div class="item<?php echo ($index == 0 ? ' active' : ''); ?>">
						<center><a href="<?php echo site_url('items/'.$item['uuid']); ?>">
							<img src="<?php echo $image['imageurl']; ?>" class="img-responsive detail-view"/>
						</a></center>
					</div> <!-- item !-->
				<?php } ?>
				</div> <!-- carousel-inner !-->
				</center>
				<a class="left carousel-control" href="#carousel<?php echo $item['id'];?>" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#carousel<?php echo $item['id'];?>" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div><!-- carousel !-->
			<div style="clear: both;"></div>
		</div><!-- product-slider !-->
		<?php }elseif(isset($item['images']) && sizeof($item['images'],2) == 1){ ?>
		<div class="product-image">
			<a href="<?php echo site_url('/items/'.$item['uuid']);?>">
				<center><img src="<?php echo $item['images'][0]['imageurl']; ?>" title="'<?php echo $item['title']; ?>" class="img-responsive img-prod"/></center>
			</a><!-- product-image !-->
		</div>
		<?php }else{ ?>
		<div class="product-image">
			Oops! No images found.
		</div>
		<div style="clear: both;"></div>
		<?php } ?>
		<div class="product-description">
			<div class="product-title">
				<p><b><?php echo (isset($item['brand']) ? $item['brand'] : "No brand found"); ?></b></p>
				<p><?php echo (isset($item['title']) ? $item['title'] : "No title found"); ?></p>
			</div>
			<div class="product-price"> <?php echo ( (isset($item['prices']) && ($item['prices'][0]['price'] != "0.00") ) ? $item['prices'][0]['price']: 'Not available');?></div>
			<div class="product-store"><a href="<?php echo (isset($item['link']) ? $item['link'] : "");?>">
				<?php // echo (isset($item['store']) ? $item['store'] : "No store found"); ?>
				<center><img class="img-responsive" src="<?php echo $this->config->item(strtolower($item['store']), 'brandimages'); ?>"/></center>
			</div>
			<a href="<?php echo site_url('/items/'.$item['uuid']);?>"><i title="View details" class=" fa fa-info-circle fa-2x" value=""></i></a>
			<i title="Remove item" class="deleteitembtn fa fa-times fa-2x" data-toggle="modal" data-target="#deleteItemModal" value="<?php echo $item['uuid'];?>"></i>
			<i title="Favorite item" class="favoriteitembtn fa fa-star-o fa-2x" data-toggle="modal" data-target="#favoriteItemModal" value="<?php echo $item['uuid'];?>"></i>
		</div><!-- product-description !-->
	</div> <!-- item-col !-->
	<?php endforeach; ?>
	<?php }else{ ?>
		<div class="col-md-2 col-md-offset-5"><center>No items yet!</center></div>
	<?php } ?>
	
</div><!-- row !-->
<script>
	$(function() {
	
		$(".favoriteitembtn").click(function(){
		    var productuuid = $(this).attr('value');
			var html = '<input type="hidden" name="productuuid" value="' + productuuid + '" />';
			$("#form-add-wishlist").append(html); 
		    
			$.ajax({
				url: 'http://ci.jitsejan.nl/wishlists/get_wishlists_ajax',
				type: "post",
				dataType: "json",
				success: function(results) {
					var numResults = Object.keys(results).length;
					var htmlStr = '';
					if(numResults > 0)
					{
						$.each(results, function(k, v){
							htmlStr += '<option value="'+k+'">'+v+'</option>';
						});
					}
					if(numResults > 1){
						// $('input#wishlist').attr('disabled','disabled'); 
					}		
					$("#wishlistid").html(htmlStr);
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert(textStatus + ': ' + errorThrown + '(' + jqXHR + ')');
					console.log('Cannot retrieve data.');
				}
			});
		});
		
	
		
		$("input#submit-wishlist").click(function(){
			var wid = $("select[name=wishlistid]").val();
			var wname = $("input#wishlist").val();
			if((wname == "" ) && (wid == 0)){
				 $("input#wishlist").focus();
				alert("Please fill in a wishlist name");
			}else{
				$("form#form-add-wishlist").submit();
			}
		});
		
		
		 $('select[name="wishlistid"]').on('change',function(){
			var wval = $(this).val();
			if(wval == "0"){           
		    	$('input#wishlist').removeAttr('disabled');          
		    }else{
	    		$('input#wishlist').attr('disabled','disabled'); 
	    	}  
	    });
	    
		
		$(".deleteitembtn").click(function(){
		    var productuuid = $(this).attr('value');
		    var formData = {productuuid: productuuid};
		    $.ajax({
				url: 'http://ci.jitsejan.nl/items/getoutfits',
				type: "post",
				data: formData,
				dataType: "json",
				success: function(results) {
					var numResults = Object.keys(results).length;
					var htmlStr = 'Are you sure?';
					if(numResults > 0)
					{
						htmlStr += '<br/><br/>The following outfits will be affected<br/><ul>';
						$.each(results, function(k, v){
							htmlStr += '<li>' + v + '</li>';
						});
						htmlStr += '</ul>';
					}
					$("#deleteItemModal .modal-dialog .modal-content .modal-body").html(htmlStr);
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert(textStatus + ': ' + errorThrown);
					console.log('Cannot retrieve data.');
				}
			});
            var html = '<input type="hidden" name="productuuid" value="' + productuuid + '" />';
		    $("#form-delete-item").append(html); 
		});
	});
</script>

<form action="items/delete" method="post" id="form-delete-item">
<div id="deleteItemModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
	<div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Confirm delete</h4>
      </div>
      <div class="modal-body">
      Do you want to delete this item?
      </div>
      <div class="modal-footer">
		<button class="btn btn-lg btn-primary" id="submit-delete" type="submit">Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
<input type="hidden" name="action" value="deleteconfirmed" />
</form>

<form action="items/addtowishlist" method="post" id="form-add-wishlist">
	<div id="favoriteItemModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
		<!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Add this item to your wishlist</h4>
	      </div>
	      <div class="modal-body">
	        <div class="form-group">
	          <label for="sel1">Select wishlist:</label>
	          <select name="wishlistid" class="form-control" id="wishlistid">
              </select>
              <input id="wishlist" name="wishlist" type="text" placeholder="Name of wishlist" class="form-control input-md" />
            </div>
	      </div>
	      <div class="modal-footer">
			<input class="btn btn-lg btn-primary" type="submit" id="submit-wishlist" value="Add"></input>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	      </div>
	    </div>
	  </div>
	</div>
</form>