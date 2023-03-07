/* Coach, jQuery */
/**
 * Get Data Form Api, Data Set and Form Funsanality
 */

// ============= Coach Page Form Select Add options [Start] ============= //
function kifutures_CoachSelectDataAppend(type, list) {
  list.forEach((item) => {
    $(`form.coach-form select#${type}`).append(`<option value="${item.value}">${item.label}</option>`);
  });
}
window.countries && kifutures_CoachSelectDataAppend("country", window.countries);
window.languages && kifutures_CoachSelectDataAppend("cocheLanguage", window.languages);
window.sustainability_interests && kifutures_CoachSelectDataAppend("sustainabilityTag", window.sustainability_interests);
window.professional_interests && kifutures_CoachSelectDataAppend("professionalTag",window.professional_interests);
// ============= Coach Page Form Select Add options [END] ============= //

// Select Field Secet2 JS Add
$(document).ready(function () {
  $("#country").select2({placeholder: "Select a Country",allowClear: true,});
  $("#cocheLanguage").select2({placeholder: "Select a Languages",allowClear: true,});
  $("#sustainabilityTag").select2({placeholder: "Sustainability interest(s)",allowClear: true,});
  $("#professionalTag").select2({placeholder: "Professional interest(s)",allowClear: true,});
});

// On Click Show All Tag
$(document).on("click", ".more-tag", function () {
  $(this).hide();
  $(this).closest(".coche-Specialities").find(".hide").removeClass("hide");
});

// Coach Card Design
let coacheHTML = "";
function coachHTML(Data) {
  coacheHTML += `<div class="coche">
    <div class="coche-image" style="background-image: url('${Data.profile_pic}');"></div>
    <h4 class="coche-title">${Data.name}</h4>
    <p class="coche-pronouns">${Data.pronouns}</p>
    <p class="cocheBio hide">${Data.biography}</p>
    <div class="coche-location">
      <span class="state">${Data.city}</span>
      <span class="country">${Data.country}</span>
    </div>`;

  // languages
  $i = 0;
  let len_count = Data.languages.length;
  if (len_count >= 0) {
    coacheHTML += `<p class="coche-language">`;
    Data.languages.forEach(function (language) {
      $i == len_count - 1
        ? (coacheHTML += `<span>${language}</span>`)
        : (coacheHTML += `<span>${language}, </span>`);
      $i++;
    });
    coacheHTML += `</p>`;
  }

  // Tag
  let sustainability_count = Data.sustainability_interests.length;
  let professional_count = Data.professional_interests.length;

  if (sustainability_count > 0 || professional_count > 0) {
    coacheHTML += `<div class="coche-Specialities">`;
    // sustainability_interests
    if (sustainability_count > 0) {
      i2 = 0;
      coacheHTML += `<p class="coche-tag sustainability-tag">`;
      Data.sustainability_interests.forEach(function (sustainability) {
        const hide = i2 >= 2 ? "hide" : "";
        coacheHTML += `<span class="${hide}" id="tag_${sustainability.id}">${sustainability.name}</span>`;
        i2++;
      });
      coacheHTML += `</p>`;
    }
    // professional_interests
    if (professional_count > 0) {
      i1 = 0;
      coacheHTML += `<p class="coche-tag professional-tag">`;
      Data.professional_interests.forEach(function (professional) {
        const hide = i1 >= 2 ? "hide" : "";
        coacheHTML += `<span class="${hide}" id="tag_${professional.id}">${professional.name}</span>`;
        i1++;
      });
      coacheHTML += `</p>`;
    }
    let moreTagCount = i1 - 2 + (i2 - 2);
    coacheHTML += `<p class="more-tag">+${moreTagCount} more</p></div>`;
  }

  if (Data.biography) {
    coacheHTML += `<a href="javascript:void(0);" class="btn-md open-modal">Read More</a>`;
  }
  coacheHTML += `</div>`;
}

// This ajex get the Coach data from API and set in Coaches Page (" #coches-list ") apeend in this DOM.
function kifutures_setCoachData() {
  $.ajax({
    url: `${tld}/wp-json/kifutures/v1/get_users?types=coach&pagination_size=20&pagination_page=1`,
    type: "GET",
    dataType: "json",
    beforeSend: function () {
      $(".coches .loader").show();
    },
    complete: function () {
      $(".coches .loader").hide();
    },
    success: function (res) {
      if (res.count === 0) {
        $("#coches-list").html("");
        $("form.coach-form .form-error")
          .removeClass("hide")
          .text("No Coach Available!");
      } else {
        coacheHTML = "";
        $("form.coach-form .form-error").addClass("hide").text("");
        res = res.users;
        for (let i = 0; i < res.length; i++) {
          let LoadData = res[i];
          coachHTML(LoadData);
        }
        $("#coches-list").html(coacheHTML);
      }
    },
    error: function () {
      $("form.coach-form .form-error")
        .removeClass("hide")
        .text("Oops! Something went wrong");
    },
  });
}
kifutures_setCoachData();

// ============= Coach Page Form Functionality Start ============= //
const coche_card = ".coches-list .coche",
  inputSelector = ".form-group input",
  selectSelector = ".form-group select",
  selector = `${inputSelector}, ${selectSelector}`;

// Coach Filter
$(document).on("click", "#coache_search", function () {
  $("#coches-list").html("");
  let search = $('.coach-form input[name="keyword"]').val().toLowerCase();
  let countries = $('.coach-form select[name="country"]').val();
  let languages = $('.coach-form select[name="languages"]').val();
  let sustainability = $('.coach-form select[name="sustainabilityTag"]').val();
  let professional = $('.coach-form select[name="professionalTag"]').val();
  kifutures_filterCoachData(search, countries, languages, sustainability, professional);
});

function kifutures_filterCoachData(search,countries,languages,sustainability,professional) {
  let SearchURL = `${tld}/wp-json/kifutures/v1/get_users?types=coach&per_page=10&page=1`
  if (search !== "") SearchURL += `&search=${search}`;
  if (countries !== "") SearchURL += `&countries=${countries}`;
  if (languages !== "") SearchURL += `&languages=${languages}`;
  if (sustainability !== "") SearchURL += `&sustainability_interests=${sustainability}`;
  if (professional !== "") SearchURL += `&professional_interests=${professional}`;
  console.log(encodeURI(SearchURL));
  $.ajax({
    url: encodeURI(SearchURL),
    type: "GET",
    dataType: "json",
    beforeSend: function () {
      $(".coches .loader").show();
    },
    complete: function () {
      $(".coches .loader").hide();
    },
    success: function (res) {
      if (res.count == 0) {
        $("#coches-list").html("");
        $("form.coach-form .form-error").removeClass("hide").text("Sorry, There are no Coach in this Filter.");
      } else {
        coacheHTML = "";
        $("form.coach-form .form-error").addClass("hide").text("");
        res = res.users;
        for (let i = 0; i < res.length; i++) {
          let searchData = res[i];
          coachHTML(searchData);
        }
        $("#coches-list").html(coacheHTML);
      }
    },
    error: function () {
      $("form.coach-form .form-error").removeClass("hide").text("Oops! Something went wrong");
    },
  });
}

$(document).on("click", "#coache_reset", function () {
  $("#coches-list").html("");
  $(".coach-form input, .coach-form select").val("");
  $("#country, #cocheLanguage, #sustainabilityTag, #professionalTag").val(null).trigger("change");
  kifutures_setCoachData();
  $("form.coach-form .form-error").addClass("hide").text("");
});
// ============= Coach Page Form Functionality END ============= //

// On Click Coach Bio Modal Show
$(document).on("click", ".coche .open-modal", function () {
  $("body").addClass("modal-open");
  let modalTitle = $(this).closest(".coche").find(".coche-title").text();
  let modalContent = $(this).closest(".coche").find(".cocheBio").text();
  let modalCloseText = "Close Bio";
  modalHtml(modalTitle, modalContent, modalCloseText);
});
