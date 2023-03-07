<?php
/*
  The Template For Displaying Features Pages.
  Template Name: Coaches Page
  Css File is " coaches-page.scss "
*/

get_header();
$hero = get_field('hero_section');
?>

<div class="main">

  <!-- Features Page Hero Section 1 -->
  <section class="hero-section" style="background-image: url('<?= !empty($hero['background_images']['url']) ? $hero['background_images']['url'] : '' ?>')">
    <div class="site-container">
      <?= !empty($hero['title']) ? '<h1 class="title">' . $hero['title'] . '</h1>' : '' ?>
    </div>
  </section>

  <!-- Coches Data -->
  <section class="coches">
    <div class="site-container">
      <form class="coach-form" method="post">
        <h2 class="form-title">Find Coaches</h2>
        <div class="form-group">
          <input type="text" name="keyword" placeholder="Keyword(s)" class="form-input" id="text">
        </div>
        <div class="select-fields">
          <div class="form-group">
            <select class="form-select" name="country" id="country">
              <option value="">Country</option>
            </select>
          </div>
          <div class="form-group">
            <select class="form-select" name="languages" id="cocheLanguage">
              <option value="">Languages</option>
            </select>
          </div>
          <div class="form-group">
            <select class="form-select" name="sustainabilityTag" id="sustainabilityTag">
              <option value="">Sustainability interest(s)</option>
            </select>
          </div>
          <div class="form-group">
            <select class="form-select" name="professionalTag" id="professionalTag">
              <option value="">Professional interest(s)</option>
            </select>
          </div>
        </div>
        <div class="form-btns">
          <!-- <input type="reset" name="reset" value="Reset" id="coache_reset" class="btn btn-default btn-sm"> -->
          <!-- <input type="hidden" name="submit" value="Search" id="coache_search" class="btn btn-default btn-sm"> -->
          <a href="javascript:void(0)" id="coache_reset" class="btn btn-default btn-sm">Reset</a>
          <a href="javascript:void(0)" id="coache_search" class="btn btn-default btn-sm">Search</a>
        </div>
        <h6 class="form-error hide"></h6>
      </form>
      <div class="loader"></div>
      <div id="coches-list" class="coches-list"></div>
    </div>
  </section>

  <!-- Coache modal -->
  <!-- <div class="modal coachModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <p></p>
        </div>
        <div class="modal-footer">
          <a href="javascript:void(0);" class="modal-closeBtn">Close bio</a>
        </div>
      </div>
    </div>
  </div> -->

</div>

<script>

</script>

<?php
get_footer();