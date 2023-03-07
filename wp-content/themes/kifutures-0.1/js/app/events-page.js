/* Events, jQuery */
/**
 * Get Events using a ajex
 */

// ============= Events Page Functionality Start ============= //

// Get Today Month And Set in the Attr
setTimeout(() => {
  let ThisMonth = moment().format("MMMM");
  $(".events-header .events-month").text(ThisMonth);
  const M_firstDate = moment().startOf("month").format("YYYY-MM-DD");
  const M_lastDate = moment().endOf("month").format("YYYY-MM-DD");
  const arrows = $(".events-section .site-container .event-arrow");
  M_firstDate ? $(arrows).attr("start-date", M_firstDate) : "";
  M_lastDate ? $(arrows).attr("end-date", M_lastDate) : "";
  kifutures_Set_Event(M_firstDate, M_lastDate);
}, 1000);

// Left Right Arrow on click Changes Attr Values and send in ajax
$(document).on("click", ".event-arrow", function () {
  let N_startDate = $(this).attr("start-date");
  const arrows = $(".events-section .site-container .event-arrow");
  if ($(this).hasClass("pre-arrow")) {
    let Month = moment(N_startDate).subtract(1, "months").format("MMMM");
    $(".events-header .events-month").text(Month);
    const stratD = moment(N_startDate)
      .subtract(1, "months")
      .startOf("month")
      .format("YYYY-MM-DD");
    const endD = moment(N_startDate)
      .subtract(1, "months")
      .endOf("month")
      .format("YYYY-MM-DD");
    $(arrows).attr("start-date", stratD);
    $(arrows).attr("end-date", endD);
    kifutures_Set_Event(stratD, endD);
  } else if ($(this).hasClass("next-arrow")) {
    let Month = moment(N_startDate).add(1, "months").format("MMMM");
    $(".events-header .events-month").text(Month);
    const stratD = moment(N_startDate)
      .add(1, "months")
      .startOf("month")
      .format("YYYY-MM-DD");
    const endD = moment(N_startDate)
      .add(1, "months")
      .endOf("month")
      .format("YYYY-MM-DD");
    $(arrows).attr("start-date", stratD);
    $(arrows).attr("end-date", endD);
    kifutures_Set_Event(stratD, endD);
  }
});

// This ajex get the data from API and set in Events Page (" #events-data ") apeend in this DOM.
function kifutures_Set_Event(startDate = "", endDate = "") {
  // console.log(`${tld}/wp-json/kifutures/v1/get_events?start_date=${startDate}&end_date=${endDate}`);
  $.ajax({
    url: `${tld}/wp-json/kifutures/v1/get_events?start_date=${startDate}&end_date=${endDate}`,
    type: "GET",
    dataType: "json",
    beforeSend: function () {
      $("#events-data").html("");
      $(".events-section .loader").show();
    },
    complete: function () {
      $(".events-section .loader").hide();
    },
    success: function (res) {
      res = res.events;
      let eventHTML = "";
      var array = res;
      array.sort(function (a, b) {
        return new Date(a.start_date) - new Date(b.start_date);
      });
      res = array;
      for (let i = 0; i < res.length; i++) {
        let events_data = res[i];
        eventHTML +=
          `<div class="events eventNo_${i}" startDate="${events_data.start_date}">
          <div class="events-list">
            <div class="event">
              <p class="hide">${events_data.start_date}</p>
              <h3 class="event-title">${events_data.name}</h3>
              <span class="event-cat-data">
                <div class="color" style="background-color: #19486A;"></div>
                <div class="name">${events_data.category}</div>
              </span>`;
        let hosts_length = events_data.hosts.length >= 0 && events_data.hosts.length == 1 ? "d-flex" : "d-block";
        eventHTML += `<div class="descriptionAndHost ${hosts_length}">`;
        if (events_data.description != "") {
          eventHTML +=
            `<div class="event-description">
              <h6 class="text">${events_data.description}</h6>
            </div>`;
        }
        if (events_data.hosts.length >= 0 && events_data.hosts.length != "") {
          eventHTML += `<div class="event-organizer">`;
          events_data.hosts.forEach(function (host) {
            eventHTML +=
              `<div class="organizer-data" id="hostId_${host.id}">
                <div class="img"><img src="${host.profile_pic}" alt="${host.name} Profile Pic" title="Organizer" /></div>
                <div class="data">
                  <h6 class="name">${host.name}</h6>
                  <h6 class="title">${host.job_title_role}</h6>
                  ${host.biography && `<h7 class="bio">${host.biography}</h7>
                  <a href="javascript:void(0);" class="read-bio open-modal link_style_1 ">Read ${host.name} Bio</a>` }
                </div>
              </div>`;
          });
          eventHTML += `</div>`;
        }
        eventHTML += `</div>
            <hr class="event-bottom-line" />
            </div>
          </div>
        </div>`;
      }
      $("#events-data").html(eventHTML);
    },
  });
}
// ============= Events Page Functionality END ============= //

// On Click Coach Bio Modal Show
$(document).on("click", ".organizer-data .open-modal", function () {
  $("body").addClass("modal-open");
  let modalTitle = $(this).closest(".data").find(".name").text();
  let modalContent = $(this).closest(".data").find(".bio").text();
  let modalCloseText = "Close Bio";
  modalHtml(modalTitle, modalContent, modalCloseText);
});
