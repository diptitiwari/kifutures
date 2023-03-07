<?php 
// Coaches Card Design Template
// Css File is " _mixins.scss "

// ACF Field Get
$color = get_field('border_color');
$pronouns = get_field('pronouns');
$state = get_field('state');
$country = get_field('country');
$language = get_field('language');
$specialities = pods_field_display('specialities');
$specialitiesArr = explode(", ", $specialities);
?>

<div class="coche"
  style="border-color: <?= !empty($color) ? $color : '#000000';?>;box-shadow: 7px 9px 0px 2px <?= !empty($color) ? $color : '#000000';?>;">

  <!-- Coache Image -->
  <?php if (get_the_post_thumbnail_url() != "") { ?>
  <div class="coche-image"
    style="background-image: url('<?= get_the_post_thumbnail_url() ?>');border-color: <?= !empty($color) ? $color : '#000000';?>;">
  </div>
  <?php } else { ?>
  <div class="coche-image"
    style="background-image: url('<?php echo get_template_directory_uri(); ?>/Images/Dummy_User.png');border-color: <?= !empty($color) ? $color : '#000000';?>;">
  </div>
  <?php } ?>

  <!-- Coache Name -->
  <h4 class="coche-title"><?= the_title(); ?></h4>

  <!-- Coache Pronouns -->
  <?php echo !empty($pronouns) ? '<p class="coche-pronouns">'.$pronouns.'</p>' : ''; ?>

  <!-- Coache Location -->
  <?php if (!empty($state) || !empty($country) ){ ?>
  <div class="coche-location">
    <span class="state"><?php echo !empty($state) ? $state : ''; ?></span>
    <span class="country"><?php echo !empty($country) ? $country : ''; ?></span>
  </div>
  <?php } ?>

  <!-- Coache Language -->
  <?php echo !empty($language) ? '<p class="coche-language">'.$language.'</p>' : ''; ?>

  <!-- Coache Specialities Tag -->
  <?php if(!empty($specialitiesArr)){ ?>
  <div class="coche-Specialities">
    <?php 
      $i = 0;
      foreach($specialitiesArr as $data) {
      $i++;
    ?>
    <div class="tag <?php if ($i > 2) {echo('hide');} ?>">
      <p>#<?= $data ?></p>
    </div>
    <?php 
      }
      $tag_count = count($specialitiesArr); 
      if ($tag_count > 2) {
      ?>
    <p class="more-tag">+<?= $tag_count - 2 ?> more</p>
    <?php } ?>
  </div>
  <?php } ?>

  <a href="<?php the_permalink() ?>" class="btn-md">Read More</a>

</div>