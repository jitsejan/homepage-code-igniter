<h2>Brands</h2>
<table class="table">
<?php foreach($brands as $index => $brand): ?>
    <tr>
        <td><?php echo $brand['name'];?></td>
    </tr>
<?php endforeach; ?>
</table>