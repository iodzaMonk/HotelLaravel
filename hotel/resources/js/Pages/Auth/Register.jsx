import GuestLayout from "@/Layouts/GuestLayout";
import { Head, Link, useForm } from "@inertiajs/react";

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
    });

    const submit = (e) => {
        e.preventDefault();

        post(route("register"), {
            onFinish: () => reset("password", "password_confirmation"),
        });
    };

    const errorMessages = Object.values(errors ?? {});

    return (
        <GuestLayout>
            <Head title="Register" />

            <div className="grid gap-10 lg:grid-cols-[minmax(0,1.1fr),minmax(0,0.9fr)] lg:items-center">
                <div className="space-y-6">
                    <span className="inline-flex items-center gap-2 rounded-full bg-blue-50 px-4 py-2 text-xs font-semibold uppercase text-blue-600 dark:bg-blue-500/20 dark:text-blue-200">
                        HotelHub
                        <span className="h-1 w-1 rounded-full bg-blue-400 dark:bg-blue-300" />
                        Create your stay account
                    </span>
                    <h1 className="text-4xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-5xl">
                        Unlock member-only rates in a few clicks
                    </h1>
                    <p className="text-lg leading-relaxed text-slate-600 dark:text-slate-300">
                        Sign up to manage future bookings, track rewards, and
                        receive offers tailored to your travel style.
                    </p>

                    <dl className="grid gap-6 sm:grid-cols-2">
                        <div className="rounded-2xl border border-slate-200 bg-white/80 p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800/80 dark:shadow-none">
                            <dt className="text-sm font-semibold uppercase text-blue-600 dark:text-blue-300">
                                Flexible changes
                            </dt>
                            <dd className="mt-2 text-sm text-slate-600 dark:text-slate-300">
                                Modify your reservations without hidden fees on
                                eligible stays.
                            </dd>
                        </div>
                        <div className="rounded-2xl border border-slate-200 bg-white/80 p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800/80 dark:shadow-none">
                            <dt className="text-sm font-semibold uppercase text-blue-600 dark:text-blue-300">
                                Early check-in perks
                            </dt>
                            <dd className="mt-2 text-sm text-slate-600 dark:text-slate-300">
                                Enjoy priority check-in and late checkout when
                                availability allows.
                            </dd>
                        </div>
                    </dl>
                </div>

                <div className="relative">
                    <div className="absolute -inset-1 rounded-[28px] bg-gradient-to-br from-blue-500/25 via-blue-400/20 to-purple-400/25 blur-lg dark:from-blue-500/20 dark:via-blue-400/15 dark:to-purple-400/15" />

                    <form
                        onSubmit={submit}
                        className="relative rounded-[26px] bg-white/90 p-10 shadow-2xl ring-1 ring-slate-200 backdrop-blur dark:bg-slate-800/95 dark:ring-slate-700"
                    >
                        {errorMessages.length > 0 && (
                            <div className="mb-6 rounded-2xl border border-red-200 bg-red-50/80 p-5 text-sm text-red-700 dark:border-red-400/40 dark:bg-red-500/10 dark:text-red-200">
                                <p className="font-semibold">
                                    We couldn't create your account
                                </p>
                                <ul className="mt-2 list-inside list-disc space-y-1">
                                    {errorMessages.map((message) => (
                                        <li key={message}>{message}</li>
                                    ))}
                                </ul>
                            </div>
                        )}

                        <div className="grid gap-6">
                            <div>
                                <label
                                    htmlFor="name"
                                    className="block text-sm font-semibold text-slate-700 dark:text-slate-200"
                                >
                                    Full name
                                </label>
                                <input
                                    id="name"
                                    name="name"
                                    value={data.name}
                                    onChange={(e) =>
                                        setData("name", e.target.value)
                                    }
                                    autoComplete="name"
                                    required
                                    placeholder="E.g. Jordan Carter"
                                    className="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-base font-medium text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:placeholder:text-slate-500 dark:focus:border-blue-400 dark:focus:ring-blue-400"
                                />
                            </div>

                            <div>
                                <label
                                    htmlFor="email"
                                    className="block text-sm font-semibold text-slate-700 dark:text-slate-200"
                                >
                                    Email address
                                </label>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value={data.email}
                                    onChange={(e) =>
                                        setData("email", e.target.value)
                                    }
                                    autoComplete="email"
                                    required
                                    placeholder="you@email.com"
                                    className="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-base font-medium text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:placeholder:text-slate-500 dark:focus:border-blue-400 dark:focus:ring-blue-400"
                                />
                            </div>

                            <div>
                                <label
                                    htmlFor="password"
                                    className="block text-sm font-semibold text-slate-700 dark:text-slate-200"
                                >
                                    Password
                                </label>
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    value={data.password}
                                    onChange={(e) =>
                                        setData("password", e.target.value)
                                    }
                                    autoComplete="new-password"
                                    required
                                    className="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-base font-medium text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:placeholder:text-slate-500 dark:focus:border-blue-400 dark:focus:ring-blue-400"
                                />
                                <p className="mt-2 text-xs text-slate-500 dark:text-slate-400">
                                    Use at least 8 characters with a number and
                                    a symbol.
                                </p>
                            </div>

                            <div>
                                <label
                                    htmlFor="password_confirmation"
                                    className="block text-sm font-semibold text-slate-700 dark:text-slate-200"
                                >
                                    Confirm password
                                </label>
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    value={data.password_confirmation}
                                    onChange={(e) =>
                                        setData(
                                            "password_confirmation",
                                            e.target.value
                                        )
                                    }
                                    autoComplete="new-password"
                                    required
                                    className="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-base font-medium text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:placeholder:text-slate-500 dark:focus:border-blue-400 dark:focus:ring-blue-400"
                                />
                            </div>
                        </div>

                        <button
                            type="submit"
                            disabled={processing}
                            className="mt-8 inline-flex w-full items-center justify-center rounded-full bg-blue-600 px-6 py-3 text-base font-semibold text-white shadow-lg shadow-blue-500/30 transition hover:bg-blue-700 focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-not-allowed disabled:opacity-70 dark:bg-blue-500 dark:hover:bg-blue-400 dark:shadow-blue-500/20"
                        >
                            Create account
                        </button>

                        <p className="mt-6 text-center text-sm text-slate-600 dark:text-slate-300">
                            Already registered?{" "}
                            <Link
                                href={route("login")}
                                className="font-semibold text-blue-600 transition hover:text-blue-700 dark:text-blue-300 dark:hover:text-blue-200"
                            >
                                Sign in instead
                            </Link>
                        </p>
                    </form>
                </div>
            </div>
        </GuestLayout>
    );
}
