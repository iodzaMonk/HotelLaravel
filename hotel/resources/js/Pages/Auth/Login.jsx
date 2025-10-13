import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Login({ status }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('login'), {
            onFinish: () => reset('password'),
        });
    };

    const errorMessages = Object.values(errors ?? {});

    return (
        <GuestLayout>
            <Head title="Login" />

            <div className="grid gap-10 lg:grid-cols-[minmax(0,1.1fr),minmax(0,0.9fr)] lg:items-center">
                <div className="space-y-6">
                    <span className="inline-flex items-center gap-2 rounded-full bg-blue-50 px-4 py-2 text-xs font-semibold uppercase text-blue-600 dark:bg-blue-500/20 dark:text-blue-200">
                        HotelHub
                        <span className="h-1 w-1 rounded-full bg-blue-400 dark:bg-blue-300" />
                        Welcome back
                    </span>
                    <h1 className="text-4xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-5xl">
                        Ready for your next stay?
                    </h1>
                    <p className="text-lg leading-relaxed text-slate-600 dark:text-slate-300">
                        Sign in to pick up where you left off, review reservations, and unlock curated offers crafted for your travels.
                    </p>

                    <ul className="grid gap-4 text-sm text-slate-600 dark:text-slate-300 sm:grid-cols-2">
                        <li className="flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-800 dark:shadow-none">
                            <span className="flex h-9 w-9 items-center justify-center rounded-full bg-blue-600/10 text-blue-600 dark:bg-blue-500/20 dark:text-blue-200">
                                ✓
                            </span>
                            Securely manage bookings from any device.
                        </li>
                        <li className="flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-800 dark:shadow-none">
                            <span className="flex h-9 w-9 items-center justify-center rounded-full bg-blue-600/10 text-blue-600 dark:bg-blue-500/20 dark:text-blue-200">
                                ✓
                            </span>
                            Access saved preferences for smoother check-ins.
                        </li>
                    </ul>
                </div>

                <div className="relative">
                    <div className="absolute -inset-1 rounded-[28px] bg-gradient-to-br from-blue-500/25 via-blue-400/20 to-purple-400/20 blur-lg dark:from-blue-500/20 dark:via-blue-400/15 dark:to-purple-400/15" />

                    <form
                        onSubmit={submit}
                        className="relative rounded-[26px] bg-white/90 p-10 shadow-2xl ring-1 ring-slate-200 backdrop-blur dark:bg-slate-800/95 dark:ring-slate-700"
                    >
                        {status && (
                            <p className="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50/80 p-4 text-sm font-medium text-emerald-700 dark:border-emerald-400/40 dark:bg-emerald-500/10 dark:text-emerald-200">
                                {status}
                            </p>
                        )}

                        {errorMessages.length > 0 && (
                            <div className="mb-6 rounded-2xl border border-red-200 bg-red-50/80 p-5 text-sm text-red-700 dark:border-red-400/40 dark:bg-red-500/10 dark:text-red-200">
                                <p className="font-semibold">
                                    We could not sign you in
                                </p>
                                <ul className="mt-2 list-inside list-disc space-y-1">
                                    {errorMessages.map((message) => (
                                        <li key={message}>{message}</li>
                                    ))}
                                </ul>
                            </div>
                        )}

                        <div className="space-y-6">
                            <div>
                                <label
                                    htmlFor="email"
                                    className="block text-sm font-semibold text-slate-700 dark:text-slate-200"
                                >
                                    Email address
                                </label>
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    value={data.email}
                                    onChange={(e) =>
                                        setData('email', e.target.value)
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
                                    name="password"
                                    type="password"
                                    value={data.password}
                                    onChange={(e) =>
                                        setData('password', e.target.value)
                                    }
                                    autoComplete="current-password"
                                    required
                                    className="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-base font-medium text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:placeholder:text-slate-500 dark:focus:border-blue-400 dark:focus:ring-blue-400"
                                />
                            </div>

                            <label className="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-300">
                                <input
                                    type="checkbox"
                                    name="remember"
                                    checked={data.remember}
                                    onChange={(e) =>
                                        setData('remember', e.target.checked)
                                    }
                                    className="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-900 dark:focus:ring-blue-400"
                                />
                                <span>Keep me signed in on this device</span>
                            </label>
                        </div>

                        <button
                            type="submit"
                            disabled={processing}
                            className="mt-8 inline-flex w-full items-center justify-center rounded-full bg-blue-600 px-6 py-3 text-base font-semibold text-white shadow-lg shadow-blue-500/30 transition hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-not-allowed disabled:opacity-70 dark:bg-blue-500 dark:hover:bg-blue-400 dark:shadow-blue-500/20"
                        >
                            Sign in
                        </button>

                        <p className="mt-6 text-center text-sm text-slate-600 dark:text-slate-300">
                            Need an account?{' '}
                            <Link
                                href={route('register')}
                                className="font-semibold text-blue-600 transition hover:text-blue-700 dark:text-blue-300 dark:hover:text-blue-200"
                            >
                                Create one now
                            </Link>
                        </p>
                    </form>
                </div>
            </div>
        </GuestLayout>
    );
}
