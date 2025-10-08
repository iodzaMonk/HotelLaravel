import "./bootstrap";
import flatpickr from "flatpickr";
import "flatpickr/dist/themes/airbnb.css";

document.addEventListener("DOMContentLoaded", () => {
    const checkInInput = document.querySelector("#check-in");
    const checkOutInput = document.querySelector("#check-out");

    if (!checkInInput || !checkOutInput) {
        return;
    }

    const formatDate = (date) => {
        const next = new Date(date.getTime());
        next.setDate(next.getDate() + 1);
        return next;
    };

    const checkOutPicker = flatpickr(checkOutInput, {
        minDate: "today",
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        disableMobile: true,
    });

    flatpickr(checkInInput, {
        minDate: "today",
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        disableMobile: true,
        onChange(selectedDates) {
            if (!selectedDates.length) {
                return;
            }

            const minCheckout = formatDate(selectedDates[0]);
            checkOutPicker.set("minDate", minCheckout);

            const currentCheckout = checkOutPicker.selectedDates[0];
            if (!currentCheckout || currentCheckout < minCheckout) {
                checkOutPicker.setDate(minCheckout, true);
            }
        },
    });
});
