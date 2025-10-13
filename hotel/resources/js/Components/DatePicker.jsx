import { useEffect, useMemo, useRef, useState } from "react";
import { DayPicker } from "react-day-picker";
import "react-day-picker/dist/style.css";
import { format, addDays, isBefore } from "date-fns";

function classNames(...values) {
    return values.filter(Boolean).join(" ");
}

export default function DatePicker({
    id,
    name,
    label,
    placeholder,
    value,
    onValueChange,
    minimumDate,
}) {
    const [open, setOpen] = useState(false);
    const triggerRef = useRef(null);
    const containerRef = useRef(null);

    const displayValue = useMemo(() => {
        if (!value) {
            return "";
        }

        try {
            return format(value, "MMM d, yyyy");
        } catch (error) {
            return "";
        }
    }, [value]);

    useEffect(() => {
        const handleClick = (event) => {
            if (!open) {
                return;
            }

            if (
                containerRef.current &&
                !containerRef.current.contains(event.target)
            ) {
                setOpen(false);
            }
        };

        window.addEventListener("mousedown", handleClick);

        return () => window.removeEventListener("mousedown", handleClick);
    }, [open]);

    const handleSelect = (date) => {
        if (!date) {
            return;
        }

        if (minimumDate && isBefore(date, minimumDate)) {
            onValueChange(minimumDate);
            setOpen(false);
            return;
        }

        onValueChange(date);
        setOpen(false);
    };

    return (
        <div className="relative flex flex-col gap-2" ref={containerRef}>
            {label && (
                <label
                    htmlFor={id}
                    className="text-sm font-semibold text-slate-600"
                >
                    {label}
                </label>
            )}

            <button
                type="button"
                ref={triggerRef}
                onClick={() => setOpen((prev) => !prev)}
                className={classNames(
                    "flex w-full items-center justify-between rounded-xl border border-slate-200 px-4 py-3 text-left text-base shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:focus:border-blue-400 dark:focus:ring-blue-400",
                    open &&
                        "border-blue-500 ring-2 ring-blue-200 dark:border-blue-400 dark:ring-blue-400",
                    !displayValue && "text-slate-400 dark:text-slate-500"
                )}
            >
                <span>{displayValue || placeholder || "Select date"}</span>
                <svg
                    className="h-4 w-4 text-slate-400"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    strokeWidth={1.5}
                    stroke="currentColor"
                >
                    <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        d="M8.25 4.5v2.25M15.75 4.5v2.25M4.5 9.75h15M6 19.5h12A1.5 1.5 0 0 0 19.5 18V7.5A1.5 1.5 0 0 0 18 6H6A1.5 1.5 0 0 0 4.5 7.5V18A1.5 1.5 0 0 0 6 19.5Z"
                    />
                </svg>
            </button>

            <input
                id={id}
                name={name}
                type="hidden"
                value={value ? format(value, "yyyy-MM-dd") : ""}
            />

            {open && (
                <div className="absolute left-0 top-full z-50 mt-3 w-[19rem] overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-[0_24px_60px_-20px_rgba(15,23,42,0.35)] dark:border-slate-700 dark:bg-slate-900 dark:shadow-[0_24px_60px_-20px_rgba(15,23,42,0.6)]">
                    <DayPicker
                        mode="single"
                        selected={value}
                        defaultMonth={value ?? minimumDate ?? new Date()}
                        onSelect={handleSelect}
                        disabled={
                            minimumDate
                                ? [
                                      {
                                          before: minimumDate,
                                      },
                                  ]
                                : undefined
                        }
                        modifiersClassNames={{
                            selected:
                                "bg-blue-600 text-white hover:bg-blue-600 dark:bg-blue-500 dark:hover:bg-blue-500",
                            today: "font-semibold text-blue-600 dark:text-blue-400",
                        }}
                        className="mx-auto text-slate-700 dark:text-slate-200 [--rdp-cell-size:2.4rem] [--rdp-caption-font-size:1rem]"
                    />
                </div>
            )}
        </div>
    );
}

export function useDateRange(initialCheckIn = null, initialCheckOut = null) {
    const [checkIn, setCheckIn] = useState(initialCheckIn);
    const [checkOut, setCheckOut] = useState(initialCheckOut);

    useEffect(() => {
        if (checkIn && checkOut && isBefore(checkOut, addDays(checkIn, 1))) {
            setCheckOut(addDays(checkIn, 1));
        }
    }, [checkIn, checkOut]);

    return {
        checkIn,
        checkOut,
        setCheckIn,
        setCheckOut,
    };
}
