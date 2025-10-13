import AppLayout from "@/Layouts/AppLayout";
import { Link } from "@inertiajs/react";

export default function Catalog({ copy, hotels = [], destination = "" }) {
    const {
        badge = "Explore stays",
        heading = "Find your next getaway",
        body = "",
        searchPlaceholder = "Search hotels or locations",
        searchButton = "Search",
        resultsPrefix = "Showing results for",
        availableRoomsBadge = "Available rooms",
        noImageLabel = "No image",
        viewDetailsLabel = "View details",
        emptyHeading = "No hotels yet",
        emptyBody = "We are curating new destinations. Check back soon for fresh stays.",
        searchAction = "#",
    } = copy ?? {};

    const trimmedFilter = destination?.trim() ?? "";

    return (
        <AppLayout>
            <div className="flex w-full flex-col">
                <section className="mb-12 space-y-4 text-center">
                    <span className="inline-flex items-center rounded-full bg-blue-500/15 px-4 py-1 text-sm font-semibold text-blue-600">
                        {badge}
                    </span>
                    <h1 className="text-4xl font-bold tracking-tight text-slate-900 dark:text-white">
                        {heading}
                    </h1>
                    <p className="mx-auto max-w-2xl text-base text-slate-600 dark:text-slate-300">
                        {body}
                    </p>
                    <form
                        method="GET"
                        action={searchAction}
                        className="mx-auto flex max-w-lg gap-3 pt-4"
                    >
                        <input
                            type="text"
                            name="destination"
                            defaultValue={trimmedFilter}
                            placeholder={searchPlaceholder}
                            className="flex-1 rounded-2xl border border-slate-200 dark:bg-blue-900/40 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                        />
                        <button
                            type="submit"
                            className="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-6 py-3 font-semibold text-white shadow-sm transition hover:bg-blue-700"
                        >
                            {searchButton}
                        </button>
                    </form>
                    {trimmedFilter !== "" && (
                        <p className="text-sm text-slate-500">
                            {resultsPrefix}{" "}
                            <span className="font-semibold text-slate-700">
                                “{trimmedFilter}”
                            </span>
                        </p>
                    )}
                </section>

                <section className="grid gap-8 sm:grid-cols-2 xl:grid-cols-3">
                    {hotels.length > 0 ? (
                        hotels.map((hotel) => {
                            const image =
                                hotel.temporaryImageUrl ?? hotel.imageUrl;

                            return (
                                <article
                                    key={hotel.id}
                                    className="group flex h-full flex-col overflow-hidden rounded-3xl bg-white dark:bg-slate-800 dark:ring-slate-800 shadow-sm ring-1 ring-slate-200 transition hover:-translate-y-1 hover:shadow-lg"
                                >
                                    <figure className="relative h-56 w-full overflow-hidden bg-slate-100">
                                        {image ? (
                                            <img
                                                src={image}
                                                alt={hotel.name}
                                                className="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                            />
                                        ) : (
                                            <div className="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-100 via-slate-100 to-indigo-100 text-blue-500">
                                                <span className="text-sm font-semibold uppercase tracking-[0.3em]">
                                                    {noImageLabel}
                                                </span>
                                            </div>
                                        )}

                                        <div className="absolute inset-x-4 bottom-4 flex items-center gap-2 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-slate-600 dark:bg-black/70 dark:text-slate-100 shadow">
                                            <span className="inline-flex h-2 w-2 rounded-full bg-emerald-400"></span>
                                            {availableRoomsBadge}
                                        </div>
                                    </figure>

                                    <div className="flex flex-1 flex-col gap-4 p-6">
                                        <div className="space-y-2">
                                            <h2 className="text-xl font-semibold text-slate-900 dark:text-slate-50">
                                                {hotel.name}
                                            </h2>
                                            <p className="line-clamp-2 text-sm text-slate-500 dark:text-slate-400">
                                                {hotel.address}
                                            </p>
                                        </div>

                                        <div className="mt-auto flex items-center justify-between text-sm font-medium dark:text-slate-200 text-slate-600">
                                            <span>
                                                {hotel.roomsCountLabel ??
                                                    `${hotel.roomsCount} rooms`}
                                            </span>
                                            {hotel.detailUrl ? (
                                                <Link
                                                    href={hotel.detailUrl}
                                                    className="inline-flex items-center gap-2 rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700"
                                                >
                                                    {viewDetailsLabel}
                                                    <span aria-hidden="true">
                                                        &rarr;
                                                    </span>
                                                </Link>
                                            ) : null}
                                        </div>
                                    </div>
                                </article>
                            );
                        })
                    ) : (
                        <div className="col-span-full flex flex-col items-center justify-center rounded-3xl border border-dashed border-slate-300 bg-white/60 p-16 text-center">
                            <h2 className="text-2xl font-semibold text-slate-800">
                                {emptyHeading}
                            </h2>
                            <p className="mt-2 text-sm text-slate-500">
                                {emptyBody}
                            </p>
                        </div>
                    )}
                </section>
            </div>
        </AppLayout>
    );
}
