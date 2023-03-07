<?php
/*
  The Template For Displaying Features Pages.
  Template Name: Features Page
  Css File is " features-page.scss "
*/

get_header();

$hero = get_field('hero_section');
$section2 = get_field('section_2');
$section3 = get_field('section_3');
$section4 = get_field('section_4');
$section5 = get_field('section_5');
$section6 = get_field('section_6');
$section7 = get_field('section_7');
$section8 = get_field('section_8');
$section9 = get_field('section_9');
$section10 = get_field('section_10');

?>

<div class="main">

  <!-- Features Page Hero Section 1 -->
  <section class="hero-section site-container hero-container">
    <?= !empty($hero['title']) ? '<h1 class="title">'.$hero['title'].'</h1>' : '' ?>
    <?= !empty($hero['text']) ? '<h3 class="subtitle">'.$hero['text'].'</h3>' : '' ?>
  </section>

  <!-- Section 2 ( Projects ) -->
  <section class="section2"
    style="background: <?= !empty($section2['background_color']) ? $section2['background_color'] : '#ffffff' ?>">
    <div class="site-container">
      <h2 class="title"><?php echo $section2['section_title']?></h2>
      <div class="section-text"><?php echo $section2['text']?></div>
      <div class="project-list">
        <?php if(!empty($section2)) { ?>
        <?php foreach($section2['project_card'] as $data) {?>
        <div class="data">
          <img src="<?php echo $data['images']['url']?>" alt="project Image" class="img">
          <div class="project-data">
            <h6 class="project-title"><?php echo $data['title']?></h6>
            <div class="text"><?php echo $data['text']?></div>
          </div>
        </div>
        <?php } ?>
        <?php } ?>
      </div>
    </div>
  </section>

  <!-- Section 3 ( Workshops ) ( Images Left ) -->
  <section class="section3 lr-section"
    style="background: <?= !empty($section3['background_color']) ? $section3['background_color'] : '#ffffff' ?>">
    <div class="site-container grid-container-50">
      <div class="images-part">
        <?= !empty($section3['image']['url']) ? '<img src="'.$section3['image']['url'].'" class="images" alt="'.$section3['title'].' Images" />' : '' ?>
      </div>
      <div class="contact-part">
        <?= !empty($section3['title']) ? '<h2 class="title">'.$section3['title'].'</h2>' : '' ?>
        <?= !empty($section3['text']) ? '<div class="text">'.$section3['text'].'</div>' : '' ?>
      </div>
    </div>
  </section>

  <!-- Section 4 ( Trainings ) ( Images Right ) -->
  <section class="section4 rl-section"
    style="background: <?= !empty($section4['background_color']) ? $section4['background_color'] : '#ffffff' ?>">
    <div class="site-container grid-container-50">
      <div class="contact-part">
        <?= !empty($section4['title']) ? '<h2 class="title">'.$section4['title'].'</h2>' : '' ?>
        <?= !empty($section4['text']) ? '<div class="text">'.$section4['text'].'</div>' : '' ?>
      </div>
      <div class="images-part">
        <?= !empty($section4['image']['url']) ? '<img src="'.$section4['image']['url'].'" class="images" alt="'.$section4['title'].' Images" />' : '' ?>
      </div>
    </div>
  </section>

  <!-- Section 5 ( Global Meeting ) ( Images Left ) -->
  <section class="section5 lr-section"
    style="background: <?= !empty($section5['background_color']) ? $section5['background_color'] : '#ffffff' ?>">
    <div class="site-container grid-container-50">
      <div class="images-part">
        <?= !empty($section5['image']['url']) ? '<img src="'.$section5['image']['url'].'" class="images" alt="'.$section5['title'].' Images" />' : '' ?>
      </div>
      <div class="contact-part">
        <?= !empty($section5['title']) ? '<h2 class="title">'.$section5['title'].'</h2>' : '' ?>
        <?= !empty($section5['text']) ? '<div class="text">'.$section5['text'].'</div>' : '' ?>
      </div>
    </div>
  </section>

  <!-- Section 6 ( Regional Meeting ) ( Images Right ) -->
  <section class="section6 rl-section"
    style="background: <?= !empty($section6['background_color']) ? $section6['background_color'] : '#ffffff' ?>">
    <div class="site-container grid-container-50">
      <div class="contact-part">
        <?= !empty($section6['title']) ? '<h2 class="title">'.$section6['title'].'</h2>' : '' ?>
        <?= !empty($section6['text']) ? '<div class="text">'.$section6['text'].'</div>' : '' ?>
      </div>
      <div class="images-part">
        <?= !empty($section6['image']['url']) ? '<img src="'.$section6['image']['url'].'" class="images" alt="'.$section6['title'].' Images" />' : '' ?>
      </div>
    </div>
  </section>

  <!-- Section 7 ( Office Hours ) ( Images Left ) -->
  <section class="section7 lr-section"
    style="background: <?= !empty($section7['background_color']) ? $section7['background_color'] : '#ffffff' ?>">
    <div class="site-container grid-container-50">
      <div class="images-part">
        <?= !empty($section7['image']['url']) ? '<img src="'.$section7['image']['url'].'" class="images" alt="'.$section7['title'].' Images" />' : '' ?>
      </div>
      <div class="contact-part">
        <?= !empty($section7['title']) ? '<h2 class="title">'.$section7['title'].'</h2>' : '' ?>
        <?= !empty($section7['text']) ? '<div class="text">'.$section7['text'].'</div>' : '' ?>
      </div>
    </div>
  </section>

  <!-- Section 8 ( Plain Text ) -->
  <?php if (!empty($section8['title'] || !empty($section8['text']))){ ?>
  <section class="section8 plaintext-section"
    style="background: <?= !empty($section8["background_color"]) ? $section8["background_color"] : "#ffffff" ?>">
    <div class="site-container">
      <?= !empty($section8['title']) ? '<h2 class="title">'.$section8['title'].'</h2>' : '' ?>
      <?= !empty($section8['text']) ? '<div class="text">'.$section8['text'].'</div>' : '' ?>
    </div>
  </section>
  <?php } ?>

  <!-- Section 9 ( Ki Port ) ( Images Right ) -->
  <section class="section9 rl-section"
    style="background: <?= !empty($section9['background_color']) ? $section9['background_color'] : '#ffffff' ?>">
    <div class="site-container grid-container-50">
      <div class="contact-part">
        <?= !empty($section9['title']) ? '<h2 class="title">'.$section9['title'].'</h2>' : '' ?>
        <?= !empty($section9['text']) ? '<div class="text">'.$section9['text'].'</div>' : '' ?>
      </div>
      <div class="images-part">
        <?= !empty($section9['image']['url']) ? '<img src="'.$section9['image']['url'].'" class="images" alt="'.$section9['title'].' Images" />' : '' ?>
      </div>
    </div>
  </section>

  <!-- Section 10 ( Ki Toolkit ) ( Images Left ) -->
  <section class="section10 lr-section"
    style="background: <?= !empty($section10['background_color']) ? $section10['background_color'] : '#ffffff' ?>">
    <div class="site-container grid-container-50">
      <div class="images-part">
        <?= !empty($section10['image']['url']) ? '<img src="'.$section10['image']['url'].'" class="images" alt="'.$section10['title'].' Images" />' : '' ?>
      </div>
      <div class="contact-part">
        <?= !empty($section10['title']) ? '<h2 class="title">'.$section10['title'].'</h2>' : '' ?>
        <?= !empty($section10['text']) ? '<div class="text">'.$section10['text'].'</div>' : '' ?>
      </div>
    </div>
  </section>

</div>

<?php
get_footer();