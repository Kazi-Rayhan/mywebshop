
import { scheduleManagers } from './components/scheduleManagers';



import axios from 'axios';
import Alpine from 'alpinejs';

require('./bootstrap');

Alpine.data('scheduleManages', scheduleManagers);
Alpine.data('managerAvailability', () => (
  {
    formSpecial: {
      schedule_at: "",
      end_schedule_at: "",
      from_time: "00:00",
      to_time: "23:59",
      is_open: 0,
    },
    form: {
      day: "",
      from_time: "",
      to_time: "",
      schedule_id: "",
      parent_id: "",
    },
    onEditMode: false,
    breaks: [],
    init() {
      this.$nextTick(() => {
        $('#manager-break').on('hide.bs.modal', (e) => {
          this.form.day = "";
          this.form.from_time = "";
          this.form.to_time = "";
          this.form.schedule_id = "";
          this.breaks = [];
        })
      });
    },
    setOnEditMode(mode = false) {
      this.onEditMode = mode;
    },
    open(dayName, url) {
      axios.get(url)
        .then(({ data }) => {
          this.breaks = data.breaks;
          this.form.day = dayName.toLowerCase();
          this.form.parent_id = data.parent_id;
          $('#manager-break').modal('show');
        })
        .catch((err) => {
          console.error('something went wrong when getting breaks');
        });
    },
    edit(brk) {
      this.form.from_time = this._getTwentyFourHourTime(brk.from_time);
      this.form.to_time = this._getTwentyFourHourTime(brk.to_time);
      this.form.schedule_id = brk.id;
      this.setOnEditMode(true);

    },
    save(url) {
      axios({
        url,
        data: this.form,
        method: "POST",
      })
        .then(({ data }) => {
          this.breaks = data.breaks;
          this.form.from_time = "";
          this.form.to_time = "";
          this.form.schedule_id = "";
          this.setOnEditMode(false);
        })
        .catch((err) => { });
    },
    destroy(id, url) {
      url = url.replace('schedule-id', id);

      axios.delete(url)
        .then(({ data }) => {
          this.breaks = data.breaks;
        })
        .catch((err) => {
          console.error('something went wrong when getting breaks');
        });
    },
    _getTwentyFourHourTime(amPmString) {
      const d = new Date("1/1/2023 " + amPmString);
      const hour = d.getHours();
      const minutes = (d.getMinutes() < 10 ? '0' : '') + d.getMinutes();

      return `${hour}:${minutes}`;
    }
  }));

Alpine.start();
