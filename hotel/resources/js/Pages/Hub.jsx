import AppLayout from "@/Layouts/AppLayout";
import HotelSearchInput from "@/Components/HotelSearchInput";
import DatePicker, { useDateRange } from "@/Components/DatePicker";
import { addDays } from "date-fns";

export default function Hub({
    hero,
    search,
    collections,
    offers,
    testimonials,
    suggestUrl,
    destination = "",
}) {
    const { checkIn, checkOut, setCheckIn, setCheckOut } = useDateRange();
    const today = new Date();

    return (
        <AppLayout>
            <div className="flex flex-1 flex-col space-y-16">
                <section
                    className="admin-card relative overflow-hidden z-10 rounded-3xl bg-slate-900 text-white shadow-xl"
                    style={{
                        "--admin-card-bg": "url(/img/hero-image.jpg)",
                    }}
                >
                    <span className="absolute inset-0 bg-slate-900/60"></span>
                    <div className="relative px-8 py-16 md:px-14 lg:px-20">
                        <span className="inline-flex items-center gap-2 rounded-full bg-white/20 px-4 py-1 text-sm uppercase tracking-[0.3em] text-white">
                            {hero?.kicker}
                        </span>
                        <h2 className="mt-6 text-4xl font-bold leading-tight text-white sm:text-5xl">
                            {hero?.heading}
                        </h2>
                        <p className="mt-4 max-w-2xl text-lg text-slate-200">
                            {hero?.body}
                        </p>
                        <div className="mt-8 flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:items-center">
                            <a
                                href="/catalog"
                                className="inline-flex items-center justify-center gap-2 rounded-full bg-white px-6 py-3 font-semibold text-slate-900 shadow-sm transition hover:bg-slate-100 sm:justify-start"
                            >
                                {hero?.primaryCta}
                                <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </section>

                <form
                    method="GET"
                    action={search?.action ?? "#"}
                    className="relative z-10 grid gap-4 rounded-2xl bg-white p-6 shadow-lg ring-1 ring-black/5 sm:grid-cols-2 lg:grid-cols-[3fr_repeat(2,_1.5fr)_1fr_auto] lg:items-end dark:bg-slate-900 dark:ring-slate-800"
                >
                    <label className="flex flex-col gap-2">
                        <span className="text-sm font-semibold text-slate-600 dark:text-slate-300">
                            {search?.labels?.destination}
                        </span>
                        <HotelSearchInput
                            suggestUrl={suggestUrl}
                            defaultValue={destination}
                            placeholder={search?.placeholders?.destination}
                            inputId="hub-hotel-search"
                        />
                    </label>
                    <div className="flex flex-col gap-2 lg:min-w-[12rem]">
                        <DatePicker
                            id="check-in"
                            name="check_in"
                            label={search?.labels?.checkIn}
                            placeholder={search?.placeholders?.date}
                            value={checkIn}
                            onValueChange={(date) => setCheckIn(date)}
                            minimumDate={today}
                        />
                    </div>
                    <div className="flex flex-col gap-2 lg:min-w-[12rem]">
                        <DatePicker
                            id="check-out"
                            name="check_out"
                            label={search?.labels?.checkOut}
                            placeholder={search?.placeholders?.date}
                            value={checkOut}
                            onValueChange={(date) => setCheckOut(date)}
                            minimumDate={
                                checkIn
                                    ? addDays(checkIn, 1)
                                    : addDays(today, 1)
                            }
                        />
                    </div>
                    <label className="flex flex-col gap-2 lg:min-w-[9rem]">
                        <span className="text-sm font-semibold text-slate-600 dark:text-slate-300">
                            {search?.labels?.guests}
                        </span>
                        <input
                            type="number"
                            min="1"
                            defaultValue={search?.defaults?.guests ?? 2}
                            className="rounded-xl border border-slate-200 px-4 py-3 text-base shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:focus:border-blue-400 dark:focus:ring-blue-400"
                        />
                    </label>
                    <button
                        className="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3 font-semibold text-white shadow-md transition hover:bg-blue-700 sm:col-span-2 lg:col-span-1 lg:w-auto dark:bg-blue-500 dark:hover:bg-blue-400"
                        type="submit"
                    >
                        {search?.labels?.submit}
                    </button>
                </form>

                <div className="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <section className="rounded-2xl bg-white p-6 shadow-lg ring-1 ring-black/5 dark:bg-slate-900 dark:ring-slate-700">
                        <h3 className="text-xl font-semibold text-slate-900 dark:text-slate-100">
                            {collections?.heading}
                        </h3>
                        <p className="mt-3 text-slate-600 dark:text-slate-300">
                            {collections?.body}
                        </p>
                        <a
                            className="mt-5 inline-flex items-center gap-2 font-semibold text-blue-600 transition hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                            href={route("hotels.catalog")}
                        >
                            {collections?.cta}
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    </section>

                    <section
                        id="offers"
                        className="rounded-2xl bg-gradient-to-br from-blue-600 to-blue-500 p-6 text-white shadow-lg"
                    >
                        <h3 className="text-xl font-semibold">
                            {offers?.heading}
                        </h3>
                        <p className="mt-3 text-blue-100">{offers?.body}</p>
                        <div className="mt-5 flex flex-wrap items-center gap-3 text-sm uppercase tracking-[0.25em] text-blue-100/80">
                            {(offers?.badges ?? []).map((badge) => (
                                <span
                                    key={badge}
                                    className="inline-flex items-center rounded-full bg-white/10 px-3 py-1"
                                >
                                    {badge}
                                </span>
                            ))}
                        </div>
                    </section>

                    <section className="rounded-2xl bg-white p-6 shadow-lg ring-1 ring-black/5 dark:bg-slate-900 dark:ring-slate-700">
                        <h3 className="text-xl font-semibold text-slate-900 dark:text-slate-100">
                            {testimonials?.heading}
                        </h3>
                        <ul className="mt-4 space-y-3 text-slate-600 dark:text-slate-300">
                            {(testimonials?.items ?? []).map((item) => (
                                <li key={item}>{item}</li>
                            ))}
                        </ul>
                    </section>
                </div>
            </div>
        </AppLayout>
    );
}
