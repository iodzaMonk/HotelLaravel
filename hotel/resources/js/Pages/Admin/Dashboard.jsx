import AppLayout from "@/Layouts/AppLayout";
import { Head, Link } from "@inertiajs/react";

export default function Dashboard({ cards = [], copy }) {
    const {
        headTitle = "Admin Menu",
        heading = "Admin Controls",
        description = "Quickly jump to the area you want to manage.",
        enterLabel = "Enter dashboard",
    } = copy ?? {};

    const fallbackCards = [
        {
            title: "Hotels",
            description: "Manage properties",
            href: route("admin.hotels.index"),
            image: "/img/hero-image.jpg",
        },
        {
            title: "Rooms",
            description: "Set availability",
            href: route("admin.rooms.index"),
            image: "/img/rooms.jpg",
        },
    ];

    const items = cards.length > 0 ? cards : fallbackCards;

    return (
        <AppLayout contentClassName="w-full max-w-7xl px-6 py-12">
            <Head title={headTitle} />
            <section className="mx-auto max-w-4xl">
                <h1 className="text-3xl font-semibold text-slate-900 dark:text-slate-100">
                    {heading}
                </h1>
                <p className="mt-2 text-slate-600 dark:text-slate-300">
                    {description}
                </p>

                <div className="mt-8 grid gap-6 md:grid-cols-2">
                    {items.map((card) => (
                        <Link
                            key={card.href}
                            href={card.href}
                            className="admin-card group relative flex aspect-[4/3] items-center justify-center overflow-hidden rounded-3xl bg-slate-900 text-white shadow-lg transition-transform hover:-translate-y-1 hover:shadow-xl"
                            style={
                                card.image
                                    ? {
                                          "--admin-card-bg": `url(${card.image})`,
                                      }
                                    : undefined
                            }
                        >
                            <span className="absolute inset-0 bg-slate-900/60 transition-opacity group-hover:bg-slate-900/45" />
                            <div className="relative flex flex-col items-center gap-2 text-center">
                                <span className="inline-flex items-center justify-center rounded-full bg-white/20 px-4 py-1 text-xs font-semibold uppercase tracking-[0.25em]">
                                    {card.title}
                                </span>
                                <p className="text-xl font-semibold">
                                    {card.description}
                                </p>
                                <span className="inline-flex items-center text-sm text-blue-100 transition group-hover:text-white">
                                    {enterLabel}
                                    <span aria-hidden="true" className="ml-2">
                                        &rarr;
                                    </span>
                                </span>
                            </div>
                        </Link>
                    ))}
                </div>
            </section>
        </AppLayout>
    );
}
