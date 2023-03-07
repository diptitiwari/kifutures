<?php
/*
The Template For Displaying Trainings & Workshops Pages.
Template Name: Trainings & Workshops Page
Css File is "trainings-and-workshops-page.scss "
*/

get_header();
$hero = get_field('hero_section');
$participants = get_field('participants_logo');
?>

<div class="main">

  <!-- Trainings & Workshops Page Hero Section 1 -->
  <section class="hero-section site-container hero-container">
    <?= !empty($hero['title']) ? '<h1 class="title">'.$hero['title'].'</h1>' : '' ?>
    <?= !empty($hero['text']) ? '<h3 class="subtitle">'.$hero['text'].'</h3>' : '' ?>
  </section>

  <section class="events-section">
    <div class="site-container">
      <h2 class="section-title">Upcoming Sessions</h2>
      <div class="events-header">
        <a href="javascript: void(0);" class="pre-arrow event-arrow">
          <svg width="100%" height="100%" viewBox="0 0 25 50" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M25 50V0L0 23.8095L25 50Z" fill="#2A2CA8" />
          </svg>
        </a>
        <h2 class="events-month"></h2>
        <a href="javascript: void(0);" class="next-arrow event-arrow">
          <svg width="100%" height="100%" viewBox="0 0 27 50" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 50L0 0L26.1905 23.8095L0 50Z" fill="#2A2CA8" />
          </svg>
        </a>
      </div>
      <div class="loader"></div>
      <div id="events-data"></div>
      <hr class="section-bottom-line" />
    </div>
  </section>

</div>

<?php
get_footer();