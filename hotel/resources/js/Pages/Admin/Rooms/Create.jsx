import AppLayout from "@/Layouts/AppLayout";
import { Head, Link, useForm } from "@inertiajs/react";

export default function CreateRoom({ hotels = [], copy }) {
    const {
        headTitle = "Create Room",
        heading = "Create a room",
        description = "Fill in the details below to add a new room to the collection.",
        backLabel = "Back",
        cancelLabel = "Cancel",
        submitLabel = "Create room",
        typeLabel = "Room type",
        typePlaceholder = "Grand deluxe",
        priceLabel = "Price per night",
        pricePlaceholder = "120",
        numberLabel = "Room number",
        numberPlaceholder = "23",
        hotelLabel = "Hotel",
        noHotelsNotice = "You need to create a hotel before you can add rooms.",
    } = copy ?? {};

    const hasHotels = hotels.length > 0;
    const { data, setData, post, processing, errors } = useForm({
        room_type: "",
        price_per_night: "",
        room_number: "",
        hotel_id: hasHotels ? hotels[0].id : "",
    });

    const errorMessages = Object.values(errors ?? {});

    const submit = (event) => {
        event.preventDefault();

        post(route("admin.rooms.store"));
    };

    return (
        <AppLayout contentClassName="w-full max-w-7xl px-6 py-12">
            <Head title={headTitle} />

            <div className="flex items-center gap-4">
                <Link
                    href={route("admin.rooms.index")}
                    className="inline-flex items-center gap-2 rounded-full border border-transparent bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                >
                    <span aria-hidden="true">&larr;</span>
                    {backLabel}
                </Link>
            </div>

            <section className="mt-10">
                <div className="mx-auto max-w-3xl rounded-3xl bg-white p-10 shadow-xl ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-700">
                    <div className="mb-8">
                        <h1 className="text-3xl font-bold text-slate-900">
                            {heading}
                        </h1>
                        <p className="mt-2 text-sm text-slate-500">
                            {description}
                        </p>
                    </div>

                    {errorMessages.length > 0 && (
                        <div className="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                            <ul className="space-y-1">
                                {errorMessages.map((message) => (
                                    <li key={message}>{message}</li>
                                ))}
                            </ul>
                        </div>
                    )}

                    <form onSubmit={submit} className="space-y-6">
                        <div className="grid gap-6 md:grid-cols-2">
                            <div className="flex flex-col gap-2">
                                <label
                                    htmlFor="room_type"
                                    className="text-sm font-semibold text-slate-600 dark:text-slate-300"
                                >
                                    {typeLabel}
                                </label>
                                <input
                                    id="room_type"
                                    name="room_type"
                                    type="text"
                                    value={data.room_type}
                                    onChange={(event) =>
                                        setData("room_type", event.target.value)
                                    }
                                    placeholder={typePlaceholder}
                                    required
                                    className="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm transition focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:focus:border-blue-400 dark:focus:bg-slate-900 dark:focus:ring-blue-400"
                                />
                            </div>

                            <div className="flex flex-col gap-2">
                                <label
                                    htmlFor="price_per_night"
                                    className="text-sm font-semibold text-slate-600 dark:text-slate-300"
                                >
                                    {priceLabel}
                                </label>
                                <input
                                    id="price_per_night"
                                    name="price_per_night"
                                    type="number"
                                    min="0"
                                    step="0.01"
                                    value={data.price_per_night}
                                    onChange={(event) =>
                                        setData(
                                            "price_per_night",
                                            event.target.value,
                                        )
                                    }
                                    placeholder={pricePlaceholder}
                                    required
                                    className="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm transition focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:focus:border-blue-400 dark:focus:bg-slate-900 dark:focus:ring-blue-400"
                                />
                            </div>

                            <div className="flex flex-col gap-2">
                                <label
                                    htmlFor="room_number"
                                    className="text-sm font-semibold text-slate-600 dark:text-slate-300"
                                >
                                    {numberLabel}
                                </label>
                                <input
                                    id="room_number"
                                    name="room_number"
                                    type="text"
                                    value={data.room_number}
                                    onChange={(event) =>
                                        setData(
                                            "room_number",
                                            event.target.value,
                                        )
                                    }
                                    placeholder={numberPlaceholder}
                                    required
                                    className="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm transition focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:focus:border-blue-400 dark:focus:bg-slate-900 dark:focus:ring-blue-400"
                                />
                            </div>

                            <div className="flex flex-col gap-2">
                                <label
                                    htmlFor="hotel_id"
                                    className="text-sm font-semibold text-slate-600 dark:text-slate-300"
                                >
                                    {hotelLabel}
                                </label>
                                <select
                                    id="hotel_id"
                                    name="hotel_id"
                                    value={data.hotel_id}
                                    onChange={(event) =>
                                        setData("hotel_id", event.target.value)
                                    }
                                    required
                                    className="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm transition focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:focus:border-blue-400 dark:focus:bg-slate-900 dark:focus:ring-blue-400"
                                >
                                    {hotels.map((hotel) => (
                                        <option key={hotel.id} value={hotel.id}>
                                            {hotel.name}
                                        </option>
                                    ))}
                                </select>
                            </div>
                        </div>

                        <div className="flex items-center justify-end gap-3">
                            <Link
                                href={route("admin.rooms.index")}
                                className="inline-flex items-center justify-center rounded-full border border-slate-200 px-6 py-2 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:text-slate-900 dark:border-slate-700 dark:text-slate-300 dark:hover:border-slate-500 dark:hover:text-slate-100"
                            >
                                {cancelLabel}
                            </Link>
                            <button
                                type="submit"
                                disabled={processing || !hasHotels}
                                className="inline-flex items-center justify-center gap-2 rounded-full bg-blue-600 px-6 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-100 disabled:cursor-not-allowed disabled:opacity-70 dark:bg-blue-500 dark:hover:bg-blue-400 dark:focus:ring-blue-400"
                            >
                                {submitLabel}
                            </button>
                        </div>
                    </form>

                    {!hasHotels && (
                        <p className="mt-6 text-sm text-amber-600">
                            {noHotelsNotice}
                        </p>
                    )}
                </div>
            </section>
        </AppLayout>
    );
}
