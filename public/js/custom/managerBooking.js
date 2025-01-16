function bookingCalendar({ service, manager, shop }) {
  return {
    baseUrl: `${window.location.origin}`,
    events: [],
    init() {
      $("#calendar").evoCalendar({
        format: "mm/dd/yyyy",
        calendarEvents: [],
      });

      $("#calendar").on("selectDate", (event, newDate, oldDate) => {
        this.newDateSelected(newDate);

        $("#booking-form").addClass('d-none');
      });

      $("#calendar").on("selectEvent", (event, activeEvent) => {
        $("#booking-info").html(`${activeEvent.date} ${activeEvent.name}`);

        $("#input-date").val(activeEvent.date);
        $("#input-time").val(activeEvent.slot);

        $("#booking-form").removeClass('d-none');
      });

      this.fetchEvents($("#calendar").evoCalendar("getActiveDate"));
    },
    fetchEvents(date) {
      $.ajax({
        headers: {
          Accept: "application/json",
        },
        url: `${this.baseUrl}${window.location.pathname}?date=${date}`,
      }).done(({ events }) => {
        const eventIds = this.events.map((event) => event.id);

        $("#calendar").evoCalendar("removeCalendarEvent", eventIds);

        this.events = events;

        $("#calendar").evoCalendar("addCalendarEvent", events);
      });
    },
    newDateSelected(date) {
      this.fetchEvents(date);
    },
  };
}
