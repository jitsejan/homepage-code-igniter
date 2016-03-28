<h2>Colors</h2>
<?php 
$attr = array("class" => "form-horizontal", "role" => "form", "id" => "admin-color", "name" => "admin-color");
echo form_open("admin/colors", $attr);?>
<table class="table admin-table">
    <!--<tr class='header-tr'>-->
        <!--<th></th>-->
        <?php foreach($colors as $index => $color): ?>
        <!--<th bgcolor="<?php //echo $color['hexcode'];?>"><?php //echo $color['name'];?></th>-->
        <?php endforeach; ?>
    <!--</tr>-->
<?php foreach($itemcolors as $index => $itemcolor): ?>
    <tr>
        <td><?php echo $itemcolor['color'];?></td>
        <?php foreach($colors as $index => $color): ?>
        <td bgcolor="<?php echo $color['hexcode'];?>">
            <input type="checkbox" name="cb_<?php echo $itemcolor['color']?>_<?php echo $color['id']?>" <?php if(stripos($itemcolor['color'], $color['nl']) !== false): echo 'checked'; endif; ?> <?php if(stripos($itemcolor['color'], $color['name']) !== false): echo 'checked'; endif; ?><?php if(in_array($color['id'], $itemcolor['mapping'])): echo 'checked'; endif; ?>/>
        </td>
        <?php endforeach; ?>
    </tr>
<?php endforeach; ?>
</table>
<input id="btn_search" name="btn_search" type="submit" class="btn btn-danger" value="Submit" />
<?php echo form_close(); ?>