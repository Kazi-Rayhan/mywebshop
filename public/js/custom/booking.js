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
            });

            $("#calendar").on("selectEvent", (event, activeEvent) => {
                const url = `${this.baseUrl}/shop/${shop}/confirm-booking/${service.slug}/${manager.id}`;

                window.location.href = `${url}?date=${activeEvent.date}&time=${activeEvent.slot}`;
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
