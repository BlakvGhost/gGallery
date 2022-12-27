<section id="gallery-container">
  <div class="" id="gallery-g">
    <div id="gallery" class="bxs"></div>
  </div>
</section>
<script src="../vendors/gallery.js" charset="utf-8"></script>
<script type="text/javascript">

  const elements = [
    <?php foreach ($media as $key => $value): ?>
      {
        src: "<?php echo $value['_path']; ?>",
        type: "<?php echo $value['jsType']; ?>",
        title: "<?php echo $value['titre']; ?>",
        caption: "<?php echo $value['caption']; ?>",
        priority: 1,
        idDb:<?php echo $value['id']; ?>
        },
      <?php endforeach; ?>
]
  const mixgallery = MixGallery(document.querySelector("#gallery"), elements);
  mixgallery.render();
</script>
