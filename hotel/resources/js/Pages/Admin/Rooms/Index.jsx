import AppLayout from "@/Layouts/AppLayout";
import { Head, Link } from "@inertiajs/react";

export default function RoomsIndex({ rooms = [], copy }) {
    const {
        headTitle = "Browse Rooms",
        backLabel = "Back",
        createLabel = "Add room",
        viewLabel = "View details",
        emptyText = "No rooms available yet.",
        priceSuffix = "/ night",
        hotelLabel = "Hotel:",
        roomNumberPrefix = "Room :number",
    } = copy ?? {};

    const formatRoomNumber = (number) =>
        roomNumberPrefix.replace(":number", number);

    return (
        <AppLayout contentClassName="w-full max-w-7xl px-6 py-12">
            <Head title={headTitle} />

            <div className="flex w-full justify-between">
                <Link
                    href={route('admin.dashboard')}
                    className="rounded-full bg-blue-600 px-6 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                >
                    &larr; {backLabel}
                </Link>
                <Link
                    href={route('admin.rooms.create')}
                    className="rounded-full bg-green-600 px-6 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-green-500"
                >
                    {createLabel}
                </Link>
            </div>

            <section className="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                {rooms.length ? (
                    rooms.map((room) => (
                        <article
                            key={room.id}
                            className="rounded-2xl bg-white p-6 shadow ring-1 ring-black/5 dark:bg-slate-900 dark:ring-slate-700"
                        >
                            <h3 className="text-xl font-semibold text-slate-900">
                                {formatRoomNumber(room.roomNumber)}
                            </h3>
                            <p className="mt-2 text-slate-600 dark:text-slate-300">
                                {room.roomType}
                            </p>
                            <p className="mt-2 text-sm text-slate-500">
                                ${room.pricePerNight} {priceSuffix}
                            </p>
                            {room.hotelName && (
                                <p className="mt-2 text-sm text-slate-500">
                                    {hotelLabel} {room.hotelName}
                                </p>
                            )}
                            <Link
                                href={route('admin.rooms.show', room.id)}
                                className="mt-4 inline-flex items-center gap-2 font-semibold text-blue-600 hover:text-blue-700"
                            >
                                {viewLabel} <span aria-hidden="true">&rarr;</span>
                            </Link>
                        </article>
                    ))
                ) : (
                    <p className="col-span-full text-center text-slate-500">
                        {emptyText}
                    </p>
                )}
            </section>
        </AppLayout>
    );
}
