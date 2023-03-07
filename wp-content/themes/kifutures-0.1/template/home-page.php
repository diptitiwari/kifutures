<?php
/*
  The Template For Displaying Home pages.
  Template Name: Home Page
  Css File is " home-page.scss "
*/

get_header();

$hero = get_field('hero_section');
$program = get_field('program_section');
$work = get_field('work_section');
$text = get_field('text_section');
$futures = get_field('futures_section');
$expect = get_field('expect_section');
$works = get_field('works_section');
$education = get_field('education_section');
$cta = get_field('cta_section');
$participants = get_field('participants_section');
$partner = get_field('partner_section');
$endorsed = get_field('endorsed_section');

?>

<div class="main">

  <!-- Home Page Hero Section 1 -->
  <section class="hero-section hero-container" style="background-image: url('<?= $hero['image']['url']?>');">
    <div class="site-container">
      <div class="contact-part">
        <?= !empty($hero['title']) ? '<h1 class="title">'.$hero['title'].'</h1>' : '' ?>
        <?= !empty($hero['text']) ? '<div class="text">'.$hero['text'].'</div>' : '' ?>
        <?= !empty($hero['title']) ? '<div class="btn">'.$hero['button'].'</div>' : '' ?>
      </div>
    </div>
  </section>

  <!-- Section 2 ( Program ) ( Images Left ) -->
  <section class="section2 lr-section"
    style="background: <?= !empty($program['background_color']) ? $program['background_color'] : '#ffffff' ?>">
    <div class="site-container grid-container-50">
      <div class="images-part">
        <?= !empty($program['image']['url']) ? '<img src="'.$program['image']['url'].'" class="images" alt="'.$program['title'].' Images" />' : '' ?>
      </div>
      <div class="contact-part">
        <?= !empty($program['title']) ? '<h2 class="title">'.$program['title'].'</h2>' : '' ?>
        <?= !empty($program['text']) ? '<div class="text">'.$program['text'].'</div>' : '' ?>
      </div>
    </div>
  </section>

  <!-- Section 3 ( Work ) ( Images Right ) -->
  <section class="section3 rl-section"
    style="background: <?= !empty($work['background_color']) ? $work['background_color'] : '#ffffff' ?>">
    <div class="site-container grid-container-50">
      <div class="contact-part">
        <?= !empty($work['title']) ? '<h2 class="title">'.$work['title'].'</h2>' : '' ?>
        <?= !empty($work['text']) ? '<div class="text">'.$work['text'].'</div>' : '' ?>
      </div>
      <div class="images-part">
        <?= !empty($work['image']['url']) ? '<img src="'.$work['image']['url'].'" class="images" alt="'.$work['title'].' Images" />' : '' ?>
      </div>
    </div>
  </section>

  <!-- Section 4 ( Plain Text ) -->
  <?php if (!empty($text['text'])){ ?>
  <section class="plaintext-section"
    style="background: <?= !empty($text["background_color"]) ? $text["background_color"] : "#ffffff" ?>">
    <div class="site-container">
      <div class="text"><?= $text['text'] ?></div>
    </div>
  </section>
  <?php } ?>

  <!-- Section 5 ( Ki Futures ) ( Images Left ) -->
  <section class="section5 lr-section"
    style="background: <?= !empty($futures['background_color']) ? $futures['background_color'] : '#ffffff' ?>">
    <div class="site-container grid-container-50">
      <div class="images-part">
        <?= !empty($futures['image']['url']) ? '<img src="'.$futures['image']['url'].'" class="images" alt="'.$futures['title'].' Images" />' : '' ?>
      </div>
      <div class="contact-part">
        <?= !empty($futures['title']) ? '<h2 class="title">'.$futures['title'].'</h2>' : '' ?>
        <?= !empty($futures['text']) ? '<div class="text">'.$futures['text'].'</div>' : '' ?>
      </div>
    </div>
  </section>

  <!-- Section 6 ( Expect ) -->
  <section class="section6"
    style="background: <?= !empty($expect['background_color']) ? $expect['background_color'] : '#ffffff' ?>">
    <div class="site-container">
      <?= !empty($expect['section_title']) ? '<h2 class="title">'.$expect['section_title'].'</h2>' : '' ?>
      <div class="expect-grid">
        <div class="grid-col">
          <?php
            $i = 0;
            foreach ($expect['page_list'] as $data){
            $i++;
            if ($i == 1) { 
          ?>
          <a href="<?= get_the_permalink($data->ID)?>" class="page-data data1">
            <?= get_the_post_thumbnail($data->ID)?>
            <h6 class="page-title"><?= $data->post_title ?></h6>
          </a>
          <div class="spaces"></div>
          <?php } if ($i == 2) { ?>
          <a href="<?= get_the_permalink($data->ID)?>" class="page-data data2">
            <?= get_the_post_thumbnail($data->ID)?>
            <h6 class="page-title"><?= $data->post_title ?></h6>
          </a>
          <?php }} ?>
        </div>
        <div class="grid-col">
          <img class="trophy-img" src="<?php echo $expect['middle_image']['url']; ?>"
            alt="<?php echo $expect['middle_text']; ?>" />
          <h3 class="trophy-text"><?php echo $expect['middle_text']; ?></h3>
          <?php 
            $i = 0;
            foreach ($expect['page_list'] as $data){
            $i++;
            if ($i == 3) { 
          ?>
          <a href="<?= get_the_permalink($data->ID)?>" class="page-data data3">
            <?= get_the_post_thumbnail($data->ID)?>
            <h6 class="page-title"><?= $data->post_title ?></h6>
          </a>
          <?php } } ?>
        </div>
        <div class="grid-col">
          <?php 
            $i = 0;
            foreach ($expect['page_list'] as $data){
            $i++;
            if ($i == 4) { 
          ?>
          <a href="<?= get_the_permalink($data->ID)?>" class="page-data data4">
            <?= get_the_post_thumbnail($data->ID)?>
            <h6 class="page-title"><?= $data->post_title ?></h6>
          </a>
          <div class="spaces"></div>
          <?php  } if ($i == 5) { ?>
          <a href="<?= get_the_permalink($data->ID)?>" class="page-data data5">
            <?= get_the_post_thumbnail($data->ID)?>
            <h6 class="page-title"><?= $data->post_title ?></h6>
          </a>
          <?php }} ?>
        </div>
      </div>
    </div>
  </section>

  <!-- Section 7 ( Works ) -->
  <section class="section7"
    style="background: <?= !empty($works['background_color']) ? $works['background_color'] : '#ffffff' ?>">
    <div class="site-container">
      <?= !empty($works['section_title']) ? '<h2 class="title">'.$works['section_title'].'</h2>' : '' ?>
      <div class="works-data-list">
        <?php if(!empty($works)) { ?>
        <?php foreach($works['works_data_list'] as $data) {?>
        <div class="data">
          <?= !empty($data['image']['url']) ? '<img src="'.$data['image']['url'].'" class="img" alt="Works Image" />' : '' ?>
          <?= !empty($data['text']) ? '<div class="text">'.$data['text'].'</div>' : '' ?>
        </div>
        <?php } ?>
        <?php } ?>
      </div>
    </div>
  </section>

  <!-- Section 8 ( Ki Education ) ( Images Left ) -->
  <section class="section8 lr-section"
    style="background: <?= !empty($education['background_color']) ? $education['background_color'] : '#ffffff' ?>">
    <div class="site-container grid-container-50">
      <div class="images-part">
        <?= !empty($education['image']['url']) ? '<img src="'.$education['image']['url'].'" class="images" alt="'.$education['title'].' Images" />' : '' ?>
      </div>
      <div class="contact-part">
        <?= !empty($education['title']) ? '<h2 class="title">'.$education['title'].'</h2>' : '' ?>
        <?= !empty($education['text']) ? '<div class="text">'.$education['text'].'</div>' : '' ?>
        <div class="linkes">
          <?= !empty($education['link_1']['url']) ? '<a href="'.$education['link_1']['url'].'" target="'.$education['link_1']['target'].'" class="link_style_1">'.$education['link_1']['title'].'</a>' : '' ?>
          <?= !empty($education['link_2']['url']) ? '<a href="'.$education['link_2']['url'].'" target="'.$education['link_2']['target'].'" class="link_style_1">'.$education['link_2']['title'].'</a>' : '' ?>
        </div>
      </div>
    </div>
  </section>

  <!-- Section 9 ( CTA ) -->
  <section class="cta-section"
    style="background: <?= !empty($cta['background_color']) ? $cta['background_color'] : '#ffffff' ?>">
    <div class="site-container">
      <?= !empty($cta['title']) ? '<h3 class="title">'.$cta['title'].'</h3>' : '' ?>
      <?= !empty($cta['button']) ? $cta['button'] : '' ?>
      <?= !empty($cta['link']['url']) ? '<div><a href="'.$cta['link']['url'].'" target="'.$cta['link']['target'].'" class="link_style_1">'.$cta['link']['title'].'</a></div>' : '' ?>
    </div>
  </section>

  <!-- Section 10 ( Participants ) -->
  <section class="logo-slider-section participants_logo">
    <div class="site-container">
      <?= !empty($participants['section_title']) ? '<h2 class="title">'.$participants['section_title'].'</h2>' : '' ?>
      <div class="logo-list">
        <?php if(!empty($participants)) { 
          foreach($participants['logo'] as $data) { ?>
          <a href="<?= !empty($data['image_link']['url']) ? $data['image_link']['url'] : '' ?>">
            <?= !empty($data['image']['url']) ? '<img src="'.$data['image']['url'].'" class="img" title="' .$data['image']['title']. '" alt="Participants Image" />' : '' ?>
            <?= !empty($data['name']) ? '<p class="brand-name" title="'.$data['name'].'">' .$data['name']. '</p>' : '' ?>
          </a>
        <?php } } ?>
      </div>
    </div>
  </section>

  <!-- Section 11 ( Partner ) -->
  <section class="logo-slider-section partner_logo">
    <div class="site-container">
      <?= !empty($partner['section_title']) ? '<h2 class="title">'.$partner['section_title'].'</h2>' : '' ?>
      <div class="logo-list">
        <?php if(!empty($partner)) { 
          foreach($partner['logo'] as $data) { ?>
          <a href="<?= !empty($data['image_link']['url']) ? $data['image_link']['url'] : '' ?>">
            <?= !empty($data['image']['url']) ? '<img src="'.$data['image']['url'].'" class="img" title="' .$data['image']['title']. '" alt="Partner Image" />' : '' ?>
            <?= !empty($data['name']) ? '<p class="brand-name" title="'.$data['name'].'">' .$data['name']. '</p>' : '' ?>
          </a>
        <?php } } ?>
      </div>
    </div>
  </section>

  <!-- Section 12 ( Endorsed ) -->
  <section class="logo-slider-section endorsed_logo">
    <div class="site-container">
      <?= !empty($endorsed['section_title']) ? '<h2 class="title">'.$endorsed['section_title'].'</h2>' : '' ?>
      <div class="logo-list">
        <?php if(!empty($endorsed)) { 
          foreach($endorsed['logo'] as $data) { ?>
          <a href="<?= !empty($data['image_link']['url']) ? $data['image_link']['url'] : '' ?>">
            <?= !empty($data['image']['url']) ? '<img src="'.$data['image']['url'].'" class="img" title="' .$data['image']['title']. '" alt="Endorsed Image" />' : '' ?>
            <?= !empty($data['name']) ? '<p class="brand-name" title="'.$data['name'].'">' .$data['name']. '</p>' : "" ?>
          </a>
        <?php } } ?>
      </div>
    </div>
  </section>

</div>

<?php
get_footer();