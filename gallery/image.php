<?php
  include '../Providers/AppServiceProvider.php';
  $q = $_REQUEST;
  $media = view_medias($_SESSION['id'], $q['offset'], $q['limit']);
  ?>
  <section id="gallery-container">
    <div class="" id="gallery-g">
      <div id="gallery" class="bxs"></div>
    </div>
  </section>
  <script src="../js/gallery.js" charset="utf-8"></script>
  <script type="text/javascript">
  const elements = [
    <?php foreach ($media as $key => $value): ?>
      {
        src: "<?php echo $value['_path']; ?>",
        type: "img",
        title: "<?php echo $value['titre']; ?>.",
        caption: "Image ajoutée le <?php echo $value['date']; ?>",
        priority: 1,
        },
      <?php endforeach; ?>
]
const mixgallery = MixGallery(document.querySelector("#gallery"), elements);
mixgallery.render();
  </script>
