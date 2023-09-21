import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
import interactionPlugin from "@fullcalendar/interaction";
import huLocale from "@fullcalendar/core/locales/hu";

Date.prototype.addHours = function (h) {
    this.setTime(this.getTime() + h * 60 * 60 * 1000);
    return this;
};

const calendarEl = document.getElementById("calendar");
const boxEl = document.getElementById("box");
const api = axios.create({
    baseURL: import.meta.env.VITE_API_URL,
});

const toggleBox = (message, className) => {
    boxEl.textContent = message;
    boxEl.classList.toggle('show');
    boxEl.classList.add(className);

    setTimeout(() => {
        boxEl.textContent = null;
        boxEl.classList.toggle('show');
        boxEl.classList.remove(className);
    }, 3000);
}

const success = (message) => {
    toggleBox(message, 'success');
}

const alert = (message) => {
    toggleBox(message, 'alert');
}

const calendar = new Calendar(calendarEl, {
    selectable: true,
    locale: huLocale,
    timeZone: "Europe/Budapest",
    plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
    initialView: "dayGridMonth",
    headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,timeGridDay",
    },
    startParam: "from",
    endParam: "to",
    eventSources: [
        { url: `${import.meta.env.VITE_API_URL}/booked-times` },
        { url: `${import.meta.env.VITE_API_URL}/opening-hours` },
    ],
    select: (info) => {
        if (
            new Date().addHours(1).getTime() < new Date(info.startStr).getTime()
        ) {
            const customerName = window.prompt(
                "Kérlek add meg az ügyfél nevét."
            );

            if (customerName !== null && customerName !== undefined) {
                api.post("/booked-times", {
                    customer_name: customerName,
                    start_at: info.startStr,
                    end_at: info.endStr,
                })
                    .then((response) => {
                        success('Sikeres foglalás!');
                        calendar.addEvent(response.data);
                    })
                    .catch((error) => {
                        alert(error.response.data.message);
                    });
            }
        }
    },
});

calendar.render();
