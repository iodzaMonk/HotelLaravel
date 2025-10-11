import "./bootstrap";
import flatpickr from "flatpickr";
import "flatpickr/dist/themes/airbnb.css";

document.addEventListener("DOMContentLoaded", () => {
    const checkInInput = document.querySelector("#check-in");
    const checkOutInput = document.querySelector("#check-out");

    if (checkInInput && checkOutInput) {
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
    }

    const searchInput = document.querySelector("#hub-hotel-search");
    const suggestionsList = document.querySelector("#hub-hotel-suggestions");

    if (searchInput && suggestionsList) {
        const suggestUrl = searchInput.dataset.suggestUrl;
        const minimumQueryLength = 2;
        const debounceDelay = 200;
        let debounceId;
        let inFlightController;

        const clearSuggestions = () => {
            suggestionsList.innerHTML = "";
        };

        const populateSuggestions = (results) => {
            clearSuggestions();

            results.forEach((item) => {
                const option = document.createElement("option");
                option.value = item.name || "";

                if (item.label) {
                    option.label = item.label;
                } else if (item.address) {
                    option.label = `${item.name} • ${item.address}`;
                }

                suggestionsList.appendChild(option);
            });
        };

        const fetchSuggestions = async (query) => {
            if (!suggestUrl) {
                return;
            }

            if (inFlightController) {
                inFlightController.abort();
            }

            inFlightController = new AbortController();

            try {
                const response = await fetch(
                    `${suggestUrl}?q=${encodeURIComponent(query)}`,
                    {
                        headers: {
                            Accept: "application/json",
                        },
                        signal: inFlightController.signal,
                    },
                );

                if (!response.ok) {
                    throw new Error(`Failed to fetch suggestions: ${response.status}`);
                }

                const payload = await response.json();
                populateSuggestions(payload?.results ?? []);
            } catch (error) {
                if (error.name === "AbortError") {
                    return;
                }

                console.error(error);
                clearSuggestions();
            }
        };

        searchInput.addEventListener("input", (event) => {
            const value = event.target.value.trim();

            if (value.length < minimumQueryLength) {
                clearSuggestions();

                if (inFlightController) {
                    inFlightController.abort();
                    inFlightController = undefined;
                }

                return;
            }

            window.clearTimeout(debounceId);
            debounceId = window.setTimeout(() => {
                fetchSuggestions(value);
            }, debounceDelay);
        });
    }
});
