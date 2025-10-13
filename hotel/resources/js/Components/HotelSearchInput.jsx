import { useEffect, useMemo, useRef, useState } from "react";

const MIN_QUERY_LENGTH = 2;
const FETCH_DEBOUNCE = 200;

const formatSuggestion = (item) => {
    if (!item) {
        return "";
    }

    if (item.label) {
        return item.label;
    }

    if (item.address && item.name) {
        return `${item.name} • ${item.address}`;
    }

    return item.name ?? "";
};

export default function HotelSearchInput({
    suggestUrl,
    defaultValue = "",
    inputId = "hub-hotel-search",
    inputName = "destination",
    placeholder = "Search destinations",
}) {
    const [query, setQuery] = useState(defaultValue);
    const [suggestions, setSuggestions] = useState([]);
    const [loading, setLoading] = useState(false);
    const [open, setOpen] = useState(false);
    const containerRef = useRef(null);
    const blurTimeoutRef = useRef();

    const listId = useMemo(
        () => `${inputId}-results-${Math.random().toString(36).slice(2)}`,
        [inputId],
    );

    useEffect(() => {
        const handleClick = (event) => {
            if (
                containerRef.current &&
                !containerRef.current.contains(event.target)
            ) {
                setOpen(false);
            }
        };

        window.addEventListener('mousedown', handleClick);

        return () => window.removeEventListener('mousedown', handleClick);
    }, []);

    useEffect(() => {
        if (!suggestUrl) {
            setSuggestions([]);
            return undefined;
        }

        const trimmed = query.trim();

        if (trimmed.length < MIN_QUERY_LENGTH) {
            setSuggestions([]);
            return undefined;
        }

        const controller = new AbortController();
        setLoading(true);

        const timeout = window.setTimeout(async () => {
            try {
                const response = await fetch(
                    `${suggestUrl}?q=${encodeURIComponent(trimmed)}`,
                    {
                        headers: {
                            Accept: 'application/json',
                        },
                        signal: controller.signal,
                    },
                );

                if (!response.ok) {
                    throw new Error(`Failed to fetch suggestions: ${response.status}`);
                }

                const payload = await response.json();
                setSuggestions(payload?.results ?? []);
                setOpen(true);
            } catch (error) {
                if (error.name !== 'AbortError') {
                    console.error(error);
                }
                setSuggestions([]);
            } finally {
                setLoading(false);
            }
        }, FETCH_DEBOUNCE);

        return () => {
            controller.abort();
            window.clearTimeout(timeout);
        };
    }, [query, suggestUrl]);

    const handleSelect = (item) => {
        const value = item?.name ?? '';
        setQuery(value);
        setOpen(false);
    };

    const showResults = open && suggestions.length > 0;

    return (
        <div className="relative" ref={containerRef}>
            <input
                id={inputId}
                name={inputName}
                type="text"
                value={query}
                onChange={(event) => setQuery(event.target.value)}
                onFocus={() => {
                    if (suggestions.length > 0) {
                        setOpen(true);
                    }
                }}
                onBlur={() => {
                    blurTimeoutRef.current = window.setTimeout(() => {
                        setOpen(false);
                    }, 150);
                }}
                onKeyDown={(event) => {
                    if (event.key === 'Escape') {
                        setOpen(false);
                        event.currentTarget.blur();
                    }
                }}
                autoComplete="off"
                placeholder={placeholder}
                className="w-full rounded-xl border border-slate-200 px-4 py-3 text-base shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:focus:border-blue-400 dark:focus:ring-blue-400"
                aria-autocomplete="list"
                aria-expanded={showResults}
                aria-controls={listId}
            />

            {loading && (
                <span className="absolute inset-y-0 right-3 flex items-center">
                    <svg
                        className="h-4 w-4 animate-spin text-slate-400"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            className="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            strokeWidth="4"
                        />
                        <path
                            className="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                        />
                    </svg>
                </span>
            )}

            {showResults && (
                <ul
                    id={listId}
                    className="absolute left-0 right-0 z-40 mt-2 max-h-64 overflow-y-auto rounded-2xl border border-slate-200 bg-white p-2 shadow-xl dark:border-slate-700 dark:bg-slate-900"
                    role="listbox"
                >
                    {suggestions.map((item) => (
                        <li key={item.id ?? item.label ?? item.name}>
                            <button
                                type="button"
                                className="w-full rounded-xl px-3 py-2 text-left text-sm text-slate-700 transition hover:bg-blue-50 hover:text-blue-700 dark:text-slate-200 dark:hover:bg-blue-500/20 dark:hover:text-blue-200"
                                onMouseDown={(event) => {
                                    event.preventDefault();
                                }}
                                onClick={() => handleSelect(item)}
                            >
                                <span className="font-semibold">
                                    {item.name}
                                </span>
                                {item.address && (
                                    <span className="block text-xs text-slate-500">
                                        {item.address}
                                    </span>
                                )}
                                {!item.address && item.label && (
                                    <span className="block text-xs text-slate-500">
                                        {item.label}
                                    </span>
                                )}
                            </button>
                        </li>
                    ))}
                </ul>
            )}
        </div>
    );
}
