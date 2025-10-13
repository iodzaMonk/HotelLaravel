import AppLayout from "@/Layouts/AppLayout";
import { Head, Link } from "@inertiajs/react";

export default function HotelsIndex({ hotels = [], copy }) {
    const {
        headTitle = "Browse Hotels",
        backLabel = "Back",
        createLabel = "Add hotel",
        viewLabel = "View details",
        emptyText = "No hotels available yet.",
    } = copy ?? {};

    return (
        <AppLayout contentClassName="w-full max-w-7xl px-6 py-12">
            <Head title={headTitle} />

            <div className="flex w-full justify-between">
                <Link
                    href={route("admin.dashboard")}
                    className="rounded-full bg-blue-600 px-6 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                >
                    &larr; {backLabel}
                </Link>
                <Link
                    href={route("admin.hotels.create")}
                    className="rounded-full bg-green-600 px-6 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-green-500"
                >
                    {createLabel}
                </Link>
            </div>

            <section className="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                {hotels.length ? (
                    hotels.map((hotel) => (
                        <article
                            key={hotel.id}
                            className="rounded-2xl bg-white p-6 shadow ring-1 ring-black/5 dark:bg-slate-900 dark:ring-slate-700"
                        >
                            {hotel.image && (
                                <img
                                    src={hotel.image}
                                    alt={hotel.name}
                                    className="h-40 w-full rounded-xl object-cover"
                                />
                            )}
                            <h3 className="mt-4 text-xl font-semibold text-slate-900 dark:text-slate-100">
                                {hotel.name}
                            </h3>
                            <p className="mt-2 text-slate-600 dark:text-slate-300">
                                {hotel.address}
                            </p>
                            <Link
                                href={route("admin.hotels.show", hotel.id)}
                                className="mt-4 inline-flex items-center gap-2 font-semibold text-blue-600 hover:text-blue-700"
                            >
                                {viewLabel}{" "}
                                <span aria-hidden="true">&rarr;</span>
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
