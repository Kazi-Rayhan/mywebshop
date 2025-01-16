import { Calendar } from '@fullcalendar/core';
import interactionPlugin from '@fullcalendar/interaction';
import resourceTimelinePlugin from '@fullcalendar/resource-timeline';
import axios from 'axios';

export const scheduleManagers = () => ({

  calendar: '',
  resources: [],
  events: [],
  init() {
    const calendarEl = document.getElementById('calendar');

    this.calendar = new Calendar(calendarEl, {
      plugins: [interactionPlugin, resourceTimelinePlugin],
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'resourceTimelineDay'
      },
      eventChange: ({ event }) => {

        const resources = event.getResources();

        const resourceIds = resources.map(function (resource) { return resource.id });

        const manager_id = resourceIds[0];

        const data = {
          id: event.id,
          manager_id: manager_id,
          start_at: event.start.toISOString(),
          end_at: event.end.toISOString(),
        };

        this.updateEvent(data);
      },
      timeZone: 'UTC',
      datesSet: (info) => { this.getEvents(info.start.toLocaleDateString()) },
      eventOverlap: false,
      initialView: 'resourceTimelineDay',
      editable: true,
      events: this.events,
      resources: this.resources,
      resourceAreaHeaderContent: "Manager's",
    });

    this.calendar.render();
  },

  getEvents(date) {
    axios({
      url: window.location.href,
      params: { date }
    })
      .then(({ data: { managers, bookings } }) => {
        this.calendar.setOption('resources', managers);
        this.calendar.setOption('events', bookings);
      })
      .catch((err) => {
        console.log('something went wrong');
      })
  },

  updateEvent(data) {
    axios({
      method: 'PUT',
      url: `${window.location.href}/${data.id}`,
      data: data,
    })
      .then((res) => {
        console.log(res)
      })
      .catch((err) => {
        console.log(err)
      })
  },
});
