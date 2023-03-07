/* global, jQuery */
/**
 *
 * This is The Global js.
 */

// console.log("=========== Global JS Load ===========");

// Get Windows Domain Name
let tld = window.location.origin;
tld.match("localhost") ? (tld = `${tld}/kifutures`) : tld;

// ====================== Slick Slider Start ====================== //
$(document).ready(function () {
  // Home Page Participants Logo Silder
  $(".participants_logo .logo-list").slick({
    slidesToShow: 6,
    slidesToScroll: 3,
    autoplay: true,
    autoplaySpeed: 2000,
    arrows: false,
    dots: false,
    pauseOnHover: false,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 4,
        },
      },
      {
        breakpoint: 520,
        settings: {
          slidesToShow: 3,
        },
      },
    ],
  });

  // Home Page Partner Logo Silder
  $(".partner_logo .logo-list").slick({
    slidesToShow: 4,
    slidesToScroll: 3,
    autoplay: true,
    autoplaySpeed: 2000,
    arrows: false,
    dots: false,
    pauseOnHover: false,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 4,
        },
      },
      {
        breakpoint: 520,
        settings: {
          slidesToShow: 3,
        },
      },
    ],
  });

  // Home Page Endorsed Logo Silder
  $(".endorsed_logo .logo-list").slick({
    slidesToShow: 4,
    slidesToScroll: 3,
    autoplay: true,
    autoplaySpeed: 2000,
    arrows: false,
    dots: false,
    pauseOnHover: false,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 4,
        },
      },
      {
        breakpoint: 520,
        settings: {
          slidesToShow: 3,
        },
      },
    ],
  });
});
// ====================== Slick Slider END ====================== //

// Modal JS START
function modalHtml(modalTitle, modalContent, modalCloseText) {
  let modalHTML = `<div class="modal coachModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">${modalTitle}</h4>
        </div>
        <div class="modal-body">
          <p>${modalContent}</p>
        </div>
        <div class="modal-footer">
          <a href="javascript:void(0);" class="modal-closeBtn">${modalCloseText}</a>
        </div>
      </div>
    </div>
  </div>`;
  $("#page").append(modalHTML);
}
$(document).on("click", ".modal-closeBtn", function () {
  $("body").removeClass("modal-open");
  $(this).closest(".modal.coachModal").remove();
});
// Modal JS END