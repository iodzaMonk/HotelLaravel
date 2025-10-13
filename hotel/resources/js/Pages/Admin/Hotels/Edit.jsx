import AppLayout from "@/Layouts/AppLayout";
import { Head, Link, useForm } from "@inertiajs/react";

export default function EditHotel({ hotel, copy }) {
    const {
        headTitle = hotel?.name
            ? `Edit ${hotel.name}`
            : "Edit Hotel",
        heading = "Edit hotel",
        description = "Update the details below and save your changes.",
        backLabel = "Back",
        cancelLabel = "Cancel",
        submitLabel = "Save changes",
        nameLabel = "Hotel name",
        addressLabel = "Hotel address",
        imageLabel = "Hotel image",
        currentImageHint = "Current image shown on the details page.",
    } = copy ?? {};

    const { data, setData, post, processing, errors, progress } = useForm({
        hotel_name: hotel?.name ?? "",
        hotel_address: hotel?.address ?? "",
        hotel_image: null,
        _method: "put",
    });

    const errorMessages = Object.values(errors ?? {});

    const submit = (event) => {
        event.preventDefault();

        post(route('admin.hotels.update', hotel.id), {
            forceFormData: true,
        });
    };

    return (
        <AppLayout contentClassName="w-full max-w-7xl px-6 py-12">
            <Head title={headTitle} />

            <div className="flex items-center gap-4">
                <Link
                    href={route('admin.hotels.show', hotel.id)}
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

                    <form
                        onSubmit={submit}
                        className="space-y-6"
                        encType="multipart/form-data"
                    >
                        <div className="grid gap-6 md:grid-cols-2">
                            <div className="flex flex-col gap-2">
                                <label
                                    htmlFor="hotel_name"
                                    className="text-sm font-semibold text-slate-600 dark:text-slate-300"
                                >
                                    {nameLabel}
                                </label>
                                <input
                                    id="hotel_name"
                                    name="hotel_name"
                                    type="text"
                                    value={data.hotel_name}
                                    onChange={(event) =>
                                        setData("hotel_name", event.target.value)
                                    }
                                    required
                                    className="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm transition focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:focus:border-blue-400 dark:focus:bg-slate-900 dark:focus:ring-blue-400"
                                />
                            </div>

                            <div className="flex flex-col gap-2">
                                <label
                                    htmlFor="hotel_address"
                                    className="text-sm font-semibold text-slate-600 dark:text-slate-300"
                                >
                                    {addressLabel}
                                </label>
                                <input
                                    id="hotel_address"
                                    name="hotel_address"
                                    type="text"
                                    value={data.hotel_address}
                                    onChange={(event) =>
                                        setData(
                                            "hotel_address",
                                            event.target.value,
                                        )
                                    }
                                    required
                                    className="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm transition focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:focus:border-blue-400 dark:focus:bg-slate-900 dark:focus:ring-blue-400"
                                />
                            </div>
                        </div>

                        <div className="flex flex-col gap-2">
                            <label
                                htmlFor="hotel_image"
                                className="text-sm font-semibold text-slate-600 dark:text-slate-300"
                            >
                                {imageLabel}
                            </label>
                            <input
                                id="hotel_image"
                                name="hotel_image"
                                type="file"
                                onChange={(event) =>
                                    setData(
                                        "hotel_image",
                                        event.target.files?.[0] ?? null,
                                    )
                                }
                                className="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm transition file:mr-4 file:rounded-full file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-600 hover:file:bg-blue-100 focus:border-blue-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:focus:border-blue-400 dark:focus:bg-slate-900 dark:focus:ring-blue-400 dark:file:bg-blue-500/20 dark:file:text-blue-200 dark:hover:file:bg-blue-500/30"
                            />
                            {progress && (
                                <progress
                                    className="h-1 w-full"
                                    value={progress.percentage}
                                    max="100"
                                />
                            )}
                            {hotel.image && (
                                <p className="text-xs text-slate-500">
                                    {currentImageHint}
                                </p>
                            )}
                        </div>

                        <div className="flex items-center justify-end gap-3">
                            <Link
                                href={route('admin.hotels.show', hotel.id)}
                                className="inline-flex items-center justify-center rounded-full border border-slate-200 px-6 py-2 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:text-slate-900 dark:border-slate-700 dark:text-slate-300 dark:hover:border-slate-500 dark:hover:text-slate-100"
                            >
                                {cancelLabel}
                            </Link>
                            <button
                                type="submit"
                                disabled={processing}
                                className="inline-flex items-center justify-center gap-2 rounded-full bg-blue-600 px-6 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-100 disabled:cursor-not-allowed disabled:opacity-70 dark:bg-blue-500 dark:hover:bg-blue-400 dark:focus:ring-blue-400"
                            >
                                {submitLabel}
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </AppLayout>
    );
}
