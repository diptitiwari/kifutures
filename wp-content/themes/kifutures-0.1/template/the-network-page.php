<?php
/*
  The Template For Displaying The Network Pages.
  Template Name: The Network Page
  Css File is "the-network-page.scss "
*/
get_header();
$hero = get_field('hero_section');
$participants = get_field('participants_logo');
?>

<div class="main">

  <!-- Participants Page Hero Section 1 -->
  <section class="hero-section site-container hero-container">
    <?= !empty($hero['title']) ? '<h1 class="title">'.$hero['title'].'</h1>' : '' ?>
    <?= !empty($hero['text']) ? '<h3 class="subtitle">'.$hero['text'].'</h3>' : '' ?>
  </section>

  <!-- Section 2 ( Participants Logo ) -->
  <section class="logo-grid-section participants_logo">
    <div class="site-container">
      <div class="logo-list">
        <?php if(!empty($participants)) { 
          foreach($participants as $data) {  
        ?>
          <a href="<?= !empty($data['image_link']['url']) ? $data['image_link']['url'] : '' ?>">
            <?= !empty($data['image']['url']) ? '<img src="'.$data['image']['url'].'" class="img" title="' .$data['image']['title']. '" alt="Participants Image" />' : '' ?>
          </a>
        <?php 
          }
        } 
        ?>
      </div>
    </div>
  </section>

</div>

<?php
get_footer();