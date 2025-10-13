import AppLayout from "@/Layouts/AppLayout";
import { Head, Link, useForm } from "@inertiajs/react";

export default function ShowRoom({
    room,
    canEdit = true,
    canDelete = true,
    copy,
}) {
    const {
        headTitle = room?.roomNumber
            ? `Room ${room.roomNumber} Details`
            : "Room Details",
        backLabel = "Back to rooms",
        idLabel = "Room ID",
        profileLabel = "Room profile",
        priceLabel = "Price per night",
        hotelLabel = "Hotel",
        createdLabel = "Created",
        updatedLabel = "Last updated",
        actionsTitle = "Actions",
        actionsDescription = "Manage this room right from here.",
        editLabel = "Edit room",
        deleteLabel = "Delete room",
        deleteUnavailable = "Delete option unavailable",
        editUnavailable = "Edit option unavailable",
        roomNumberPrefix = "Room :number",
        confirmDelete = `Are you sure you want to delete room ${
            room?.roomNumber ?? ""
        }?`,
    } = copy ?? {};

    const { post, processing } = useForm({ _method: "delete" });

    const roomLabel = room
        ? roomNumberPrefix.replace(":number", room.roomNumber)
        : roomNumberPrefix.replace(":number", "");

    const handleDelete = (event) => {
        event.preventDefault();

        if (!confirm(confirmDelete)) {
            return;
        }

        post(route("admin.rooms.destroy", room.id));
    };

    return (
        <AppLayout contentClassName="w-full max-w-7xl px-6 py-12">
            <Head title={headTitle} />

            <div className="flex flex-wrap items-center justify-between gap-4">
                <Link
                    href={route("admin.rooms.index")}
                    className="inline-flex items-center gap-2 rounded-full border border-transparent bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                >
                    <span aria-hidden="true">&larr;</span>
                    {backLabel}
                </Link>

                <div className="flex items-center gap-3 text-sm text-slate-500 dark:text-slate-400">
                    <span className="hidden font-semibold text-slate-400 sm:inline">
                        {idLabel}
                    </span>
                    <span className="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 font-semibold text-slate-600 dark:bg-slate-700/60 dark:text-slate-200">
                        #{room.id}
                    </span>
                </div>
            </div>

            <section className="mt-10 grid gap-8 lg:grid-cols-[2fr,1fr]">
                <article className="rounded-3xl bg-white p-10 shadow-xl ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-700">
                    <div className="flex flex-col gap-6">
                        <div className="flex flex-col gap-3">
                            <p className="text-xs font-semibold uppercase tracking-[0.2em] text-blue-500">
                                {profileLabel}
                            </p>
                            <h1 className="text-4xl font-bold tracking-tight text-slate-900">
                                {roomLabel}
                            </h1>
                            <p className="text-base text-slate-600 dark:text-slate-300">
                                {room.roomType}
                            </p>
                            <p className="text-base text-slate-600 dark:text-slate-300">
                                <span className="font-semibold">{priceLabel}</span>: $
                                {room.pricePerNight}
                            </p>
                            {room.hotelName && (
                                <p className="text-sm text-slate-500">
                                    <span className="font-semibold">
                                        {hotelLabel}
                                    </span>
                                    : {room.hotelName}
                                </p>
                            )}
                        </div>

                        <dl className="grid gap-6 sm:grid-cols-2">
                            <div className="rounded-3xl border border-slate-200 p-6">
                                <dt className="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">
                                    {createdLabel}
                                </dt>
                                <dd className="mt-2 text-lg font-semibold text-slate-900">
                                    {room.createdAt}
                                </dd>
                            </div>

                            <div className="rounded-3xl border border-slate-200 p-6">
                                <dt className="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">
                                    {updatedLabel}
                                </dt>
                                <dd className="mt-2 text-lg font-semibold text-slate-900">
                                    {room.updatedAt}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </article>

                <aside className="space-y-6">
                    <div className="rounded-3xl bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-500 p-8 text-white shadow-xl">
                        <h2 className="text-lg font-semibold">{actionsTitle}</h2>
                        <p className="mt-2 text-sm text-blue-100">
                            {actionsDescription}
                        </p>
                        <div className="mt-6 flex flex-col gap-3">
                            {canEdit ? (
                                <Link
                                    href={route("admin.rooms.edit", room.id)}
                                    className="inline-flex items-center justify-center gap-2 rounded-full bg-white px-5 py-2 text-sm font-semibold text-blue-600 shadow transition hover:text-blue-700 hover:shadow-md"
                                >
                                    {editLabel}
                                </Link>
                            ) : (
                                <span className="inline-flex items-center justify-center gap-2 rounded-full bg-white/20 px-5 py-2 text-sm font-semibold text-white/70">
                                    {editUnavailable}
                                </span>
                            )}

                            {canDelete ? (
                                <form onSubmit={handleDelete}>
                                    <button
                                        type="submit"
                                        disabled={processing}
                                        className="inline-flex items-center justify-center gap-2 rounded-full bg-white/10 px-5 py-2 text-sm font-semibold text-white transition hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/60 disabled:cursor-not-allowed disabled:opacity-70"
                                    >
                                        {deleteLabel}
                                    </button>
                                </form>
                            ) : (
                                <span className="inline-flex items-center justify-center gap-2 rounded-full bg-white/10 px-5 py-2 text-sm font-semibold text-white/70">
                                    {deleteUnavailable}
                                </span>
                            )}
                        </div>
                    </div>
                </aside>
            </section>
        </AppLayout>
    );
}
