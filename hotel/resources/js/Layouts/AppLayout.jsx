import { Link, usePage } from "@inertiajs/react";
import { useEffect, useState } from "react";

export default function AppLayout({ children, contentClassName = "" }) {
    const { auth, appMeta } = usePage().props;
    const user = auth?.user;
    const isAdmin = Boolean(user?.is_admin);
    const brand = appMeta?.brand ?? "HotelHub";
    const nav = appMeta?.nav ?? {};
    const locale = appMeta?.locale ?? { current: "en", available: [] };
    const footer = appMeta?.footer ?? {};
    const [showUserMenu, setShowUserMenu] = useState(false);
    const [theme, setTheme] = useState(() =>
        typeof window !== "undefined" &&
        document.documentElement.classList.contains("dark")
            ? "dark"
            : "light"
    );

    useEffect(() => {
        if (theme === "dark") {
            document.documentElement.classList.add("dark");
        } else {
            document.documentElement.classList.remove("dark");
        }
        localStorage.setItem("theme", theme);
    }, [theme]);

    const toggleTheme = () =>
        setTheme((current) => (current === "dark" ? "light" : "dark"));

    const hasRoute = (name) =>
        typeof route !== "undefined" && route().has(name);

    return (
        <div className="flex min-h-screen flex-col bg-slate-50 text-slate-900 antialiased dark:bg-slate-950 dark:text-slate-100">
            <header className="relative z-40 border-b border-slate-200 bg-white/90 backdrop-blur dark:border-slate-800 dark:bg-slate-900/70">
                <div className="mx-auto flex h-20 w-full max-w-7xl items-center justify-between px-6">
                    <div className="flex items-center gap-10">
                        <Link
                            href={hasRoute("home") ? route("home") : "/"}
                            className="text-3xl font-black text-blue-700"
                        >
                            {brand}
                        </Link>

                        <nav className="hidden items-center gap-6 text-sm font-semibold text-slate-600 md:flex dark:text-slate-300">
                            {isAdmin && hasRoute("admin.dashboard") && (
                                <a
                                    className="transition hover:text-slate-900 dark:hover:text-slate-100"
                                    href={route("admin.dashboard")}
                                >
                                    {nav.explore ?? "Admin"}
                                </a>
                            )}
                        </nav>
                    </div>

                    <div className="flex items-center gap-4">
                        <button
                            type="button"
                            onClick={toggleTheme}
                            className="inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 text-slate-500 transition hover:border-blue-400 hover:text-blue-600 dark:border-slate-700 dark:text-slate-300 dark:hover:border-blue-400 dark:hover:text-blue-300"
                            aria-label="Toggle theme"
                        >
                            {theme === "dark" ? (
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    className="h-4 w-4"
                                >
                                    <path d="M12 3.25a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0V4a.75.75 0 0 1 .75-.75Zm4.95 2.02a.75.75 0 0 1 1.06 1.06l-1.06 1.06a.75.75 0 1 1-1.06-1.06l1.06-1.06ZM12 18.5a.75.75 0 0 1 .75.75V21a.75.75 0 0 1-1.5 0v-1.75a.75.75 0 0 1 .75-.75Zm6.5-6.5a.75.75 0 0 1 .75.75.75.75 0 0 1-.75.75H17a.75.75 0 0 1 0-1.5h1.5Zm-11 0a.75.75 0 0 1 .75.75H7A.75.75 0 0 1 7 12H5.5a.75.75 0 0 1 0-1.5H7Zm9.39 5.657a.75.75 0 0 1 1.06 1.06l-1.06 1.061a.75.75 0 0 1-1.06-1.06l1.06-1.061ZM6.01 6.36a.75.75 0 0 1 1.06 0l1.061 1.06A.75.75 0 1 1 7.07 8.48L6.01 7.42a.75.75 0 0 1 0-1.06Zm0 11.28 1.061-1.06a.75.75 0 1 1 1.06 1.06l-1.06 1.061a.75.75 0 1 1-1.061-1.06ZM12 6.5a5.5 5.5 0 1 1 0 11 5.5 5.5 0 0 1 0-11Z" />
                                </svg>
                            ) : (
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    className="h-4 w-4"
                                >
                                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79Z" />
                                </svg>
                            )}
                        </button>

                        <div className="flex gap-2 text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">
                            {locale.available?.map((lang) => {
                                const link = locale.links?.[lang];
                                if (!link) {
                                    return null;
                                }
                                return (
                                    <a
                                        key={lang}
                                        href={link}
                                        className={`transition ${
                                            locale.current === lang
                                                ? "rounded-full bg-blue-600 px-3 py-1 text-white"
                                                : "hover:text-slate-900 dark:hover:text-slate-100"
                                        }`}
                                    >
                                        {lang.toUpperCase()}
                                    </a>
                                );
                            })}
                        </div>

                        {!user && (
                            <>
                                {hasRoute("login") && (
                                    <a
                                        href={route("login")}
                                        className="inline-flex items-center justify-center rounded-full bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-400"
                                    >
                                        {nav.login ?? "Login"}
                                    </a>
                                )}
                                {hasRoute("register") && (
                                    <a
                                        href={route("register")}
                                        className="inline-flex items-center justify-center rounded-full bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-400"
                                    >
                                        {nav.register ?? "Register"}
                                    </a>
                                )}
                            </>
                        )}

                        {user && (
                            <div className="relative z-50">
                                <button
                                    type="button"
                                    onClick={() =>
                                        setShowUserMenu((prev) => !prev)
                                    }
                                    className="inline-flex h-11 w-11 items-center justify-center rounded-full bg-blue-600 text-base font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                >
                                    {user.name?.slice(0, 1)?.toUpperCase() ??
                                        "U"}
                                </button>
                                {showUserMenu && (
                                    <div
                                        className="absolute right-0 z-50 mt-3 w-56 rounded-2xl border border-slate-200 bg-white p-3 text-sm shadow-xl dark:border-slate-700 dark:bg-slate-800"
                                        onMouseLeave={() =>
                                            setShowUserMenu(false)
                                        }
                                    >
                                        <div className="rounded-xl bg-slate-50 px-3 py-2 text-xs font-semibold uppercase text-slate-500 dark:bg-slate-700/50 dark:text-slate-300">
                                            {user.name}
                                            <p className="mt-1 text-[11px] lowercase text-slate-400">
                                                {user.email}
                                            </p>
                                        </div>
                                        <div className="mt-2 flex flex-col gap-1 text-slate-700 dark:text-slate-200">
                                            {hasRoute("profile.edit") && (
                                                <Link
                                                    href={route("profile.edit")}
                                                    className="rounded-xl px-3 py-2 text-left transition hover:bg-blue-50 hover:text-blue-700 dark:hover:bg-blue-500/20 dark:hover:text-blue-200"
                                                    onClick={() =>
                                                        setShowUserMenu(false)
                                                    }
                                                >
                                                    Manage profile
                                                </Link>
                                            )}
                                            {isAdmin &&
                                                hasRoute(
                                                    "admin.hotels.index"
                                                ) && (
                                                    <Link
                                                        href={route(
                                                            "admin.hotels.index"
                                                        )}
                                                        className="rounded-xl px-3 py-2 text-left transition hover:bg-blue-50 hover:text-blue-700 dark:hover:bg-blue-500/20 dark:hover:text-blue-200"
                                                        onClick={() =>
                                                            setShowUserMenu(
                                                                false
                                                            )
                                                        }
                                                    >
                                                        Hotel management
                                                    </Link>
                                                )}
                                            <Link
                                                href={route("logout")}
                                                method="post"
                                                as="button"
                                                className="rounded-xl px-3 py-2 text-left transition hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-500/20 dark:hover:text-red-300"
                                                onClick={() =>
                                                    setShowUserMenu(false)
                                                }
                                            >
                                                {nav.logout ?? "Logout"}
                                            </Link>
                                        </div>
                                    </div>
                                )}
                            </div>
                        )}
                    </div>
                </div>
            </header>

            <main
                className={[
                    "mx-auto w-full max-w-6xl flex-1 px-6 py-12",
                    contentClassName,
                ]
                    .filter(Boolean)
                    .join(" ")}
            >
                {children}
            </main>

            <footer className="border-t border-slate-200 bg-white py-8 text-sm text-slate-600 dark:border-slate-800 dark:bg-slate-900/70 dark:text-slate-400">
                <div className="mx-auto flex max-w-7xl flex-col gap-3 px-6 md:flex-row md:items-center md:justify-between">
                    <p className="font-semibold text-slate-700 dark:text-slate-200">
                        {brand}
                    </p>
                    <p>
                        &copy; {new Date().getFullYear()} {brand}.{" "}
                        {footer.all_rights_reserved ?? "All rights reserved."}
                    </p>
                </div>
            </footer>
        </div>
    );
}
