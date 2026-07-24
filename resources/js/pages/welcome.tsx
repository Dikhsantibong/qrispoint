import { Head, Link, usePage } from '@inertiajs/react';
import AppLogoIcon from '@/components/app-logo-icon';
import { dashboard, login, register } from '@/routes';

export default function Welcome() {
    const { auth } = usePage().props;

    return (
        <>
            <Head title="Welcome to Qrispoint" />
            <div className="flex min-h-screen flex-col bg-background text-foreground dark:bg-zinc-950">
                {/* Navbar */}
                <header className="sticky top-0 z-50 w-full border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60">
                    <div className="container mx-auto flex h-16 items-center justify-between px-4 md:px-8">
                        <div className="flex items-center gap-2">
                            <AppLogoIcon className="h-6 w-6 fill-primary text-primary" />
                            <span className="text-lg font-bold tracking-tight">Qrispoint</span>
                        </div>
                        <nav className="flex items-center gap-4">
                            {auth.user ? (
                                <Link
                                    href={dashboard()}
                                    className="text-sm font-medium hover:text-primary transition-colors"
                                >
                                    Dashboard
                                </Link>
                            ) : (
                                <>
                                    <Link
                                        href={login()}
                                        className="text-sm font-medium hover:text-primary transition-colors"
                                    >
                                        Log in
                                    </Link>
                                    <Link
                                        href={register()}
                                        className="inline-flex h-9 items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90"
                                    >
                                        Register
                                    </Link>
                                </>
                            )}
                        </nav>
                    </div>
                </header>

                {/* Hero Section */}
                <main className="flex-1">
                    <section className="w-full py-12 md:py-24 lg:py-32 xl:py-48">
                        <div className="container mx-auto px-4 md:px-6">
                            <div className="flex flex-col items-center space-y-4 text-center">
                                <div className="space-y-2">
                                    <h1 className="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl lg:text-6xl/none">
                                        Modernisasi Pembayaran dengan <span className="text-primary">Qrispoint</span>
                                    </h1>
                                    <p className="mx-auto max-w-[700px] text-muted-foreground md:text-xl">
                                        Platform terbaik untuk mengelola merchant, memonitor transaksi QRIS, dan mendistribusikan insentif dengan cepat dan transparan.
                                    </p>
                                </div>
                                <div className="space-x-4">
                                    {auth.user ? (
                                        <Link
                                            href={dashboard()}
                                            className="inline-flex h-10 items-center justify-center rounded-md bg-primary px-8 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90"
                                        >
                                            Buka Dashboard
                                        </Link>
                                    ) : (
                                        <>
                                            <Link
                                                href={register()}
                                                className="inline-flex h-10 items-center justify-center rounded-md bg-primary px-8 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90"
                                            >
                                                Mulai Sekarang
                                            </Link>
                                            <Link
                                                href={login()}
                                                className="inline-flex h-10 items-center justify-center rounded-md border border-input bg-background px-8 text-sm font-medium shadow-sm transition-colors hover:bg-accent hover:text-accent-foreground"
                                            >
                                                Masuk ke Akun
                                            </Link>
                                        </>
                                    )}
                                </div>
                            </div>
                        </div>
                    </section>

                    {/* Features Section */}
                    <section className="w-full py-12 md:py-24 lg:py-32 bg-muted/50">
                        <div className="container mx-auto px-4 md:px-6">
                            <div className="grid gap-10 sm:grid-cols-2 lg:grid-cols-3">
                                <div className="flex flex-col items-center space-y-4 text-center">
                                    <div className="flex h-16 w-16 items-center justify-center rounded-full bg-primary/10">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-8 w-8 text-primary"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                    </div>
                                    <h3 className="text-xl font-bold">Transaksi Real-time</h3>
                                    <p className="text-muted-foreground">Pantau seluruh volume dan lalu lintas transaksi QRIS secara langsung tanpa delay.</p>
                                </div>
                                <div className="flex flex-col items-center space-y-4 text-center">
                                    <div className="flex h-16 w-16 items-center justify-center rounded-full bg-primary/10">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-8 w-8 text-primary"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                    </div>
                                    <h3 className="text-xl font-bold">Manajemen Agen & Merchant</h3>
                                    <p className="text-muted-foreground">Kelola jaringan agen Anda dan proses onboarding merchant baru dengan mudah dan terstruktur.</p>
                                </div>
                                <div className="flex flex-col items-center space-y-4 text-center">
                                    <div className="flex h-16 w-16 items-center justify-center rounded-full bg-primary/10">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="h-8 w-8 text-primary"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
                                    </div>
                                    <h3 className="text-xl font-bold">Pelaporan Akurat</h3>
                                    <p className="text-muted-foreground">Hasilkan laporan komprehensif untuk memantau performa bisnis dan mendistribusikan insentif.</p>
                                </div>
                            </div>
                        </div>
                    </section>
                </main>

                {/* Footer */}
                <footer className="w-full border-t py-6">
                    <div className="container mx-auto flex flex-col items-center justify-between gap-4 px-4 md:h-16 md:flex-row md:py-0">
                        <p className="text-center text-sm leading-loose text-muted-foreground md:text-left">
                            © 2026 Qrispoint. All rights reserved.
                        </p>
                    </div>
                </footer>
            </div>
        </>
    );
}
