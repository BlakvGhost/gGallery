<section id="section">
  <div class="dropzon cover">
    <p class="entt"><i class="mdi mdi-cloud-upload"></i> &nbsp;&nbsp; Importer des images,videos ou documents pour la gallery </p>
    <div class="full">
      <form class="dropzone" action="" method="post" id="g4l1l30">
      </form>
      <script type="text/javascript">
        const person = document.querySelector('.user_lg i');
        Dropzone.options.g4l1l30 = {
          init: function() {
            this.on("success", function() {
              person.innerHTML = null;
              person.classList = 'mdi mdi-cloud-check';
            });
            this.on("totaluploadprogress", function(percent) {
              person.classList = 'fa f28';
              person.innerHTML = Math.round(percent);
            });
            this.on("error", function(percent) {
              person.classList = 'mdi mdi-cloud-alert';
            });
          },
          url: "/ajax/add.gallery",
          paramName: "file",
          maxFilesize: 100,
          timeout: 100000,
          addRemoveLinks: true,
        };
        setTimeout(() => {
          person.classList = 'mdi mdi-account';
          person.innerHTML = ''
        }, 5000)
      </script>
    </div>
  </div>

</section>