<section>
  <div class="row page-header">
      <h1><?php echo $title; ?></h1>
      <hr/>
  </div>
  <div class="row page-content">
    <?php if(isset($snippets)): ?>
    <?php foreach($snippets as $index => $snippet): ?>
    <article>
      <h3><?php echo $snippet['title']; ?></h3>
			<?php echo ($snippet['description'] ? '<p>'.$snippet['description'].'</p>': '');?>
      <xmp class="prettyprint language-cmd"><?php echo $snippet['code']; ?></xmp>
    </article>
    <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>
<script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
