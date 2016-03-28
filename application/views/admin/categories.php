<h2>Categories</h2>
<?php 
$attr = array("class" => "form-horizontal", "role" => "form", "id" => "admin-category", "name" => "admin-category");
echo form_open("admin/categories/", $attr);?>
<table class="table admin-table">
    <tr>
        <th></th>
        <?php foreach($categories as $index => $category): ?>
        <th><?php echo $category['name'];?></th>
        <?php endforeach; ?>
    </tr>
<?php foreach($itemcategories as $index => $itemcategory): ?>
    <tr>
        <td><?php echo $itemcategory['category'];?></td>
        <?php foreach($categories as $index => $category): ?>
        <td>
            <input type="checkbox" name="cb_<?php echo $itemcategory['category']?>_<?php echo $category['id']?>" checked />
        </td>
        <?php endforeach; ?>
    </tr>
<?php endforeach; ?>
</table>
<input id="btn_search" name="btn_search" type="submit" class="btn btn-danger" value="Submit" />
<?php echo form_close(); ?>