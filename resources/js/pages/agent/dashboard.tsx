import { Head, Link, router } from '@inertiajs/react';
import { ChevronRight, LogOut, MapPin, Store } from 'lucide-react';
import HabitMeter from '@/components/domain/habit-meter';
import IncentiveSummary from '@/components/domain/incentive-summary';
import StatusChip from '@/components/domain/status-chip';
import type { MerchantStatus } from '@/lib/constants';
import { logout } from '@/routes';
import { show } from '@/routes/agent/merchants';

type MerchantSummary = {
    id: number;
    name: string;
    category: string;
    status: MerchantStatus;
    tx_in_window: number;
};

type Props = {
    agentName: string;
    market: {
        name: string;
        city: string;
    };
    merchants: MerchantSummary[];
    incentiveSummary: {
        totalCair: number;
        totalPending: number;
    };
    habitThresholdTx: number;
};

export default function AgentDashboard({ agentName, market, merchants, incentiveSummary, habitThresholdTx }: Props) {
    return (
        <div className="min-h-screen bg-qp-surface pb-10">
            <Head title="Dashboard Agen" />

            <header className="rounded-b-3xl bg-qp-navy px-5 pt-6 pb-6 text-white">
                <div className="flex items-start justify-between">
                    <div>
                        <p className="text-sm text-white/70">Selamat bertugas,</p>
                        <h1 className="text-xl font-bold tracking-tight">{agentName}</h1>
                        <p className="mt-1 flex items-center gap-1 text-sm text-white/70">
                            <MapPin className="size-3.5" />
                            {market.name} — {market.city}
                        </p>
                    </div>

                    <Link
                        href={logout()}
                        as="button"
                        onClick={() => router.flushAll()}
                        className="flex items-center gap-1 rounded-full bg-white/10 px-3 py-1.5 text-xs font-medium text-white/80"
                    >
                        <LogOut className="size-3.5" />
                        Keluar
                    </Link>
                </div>

                <div className="mt-5">
                    <IncentiveSummary totalCair={incentiveSummary.totalCair} totalPending={incentiveSummary.totalPending} />
                </div>
            </header>

            <main className="px-5 pt-5">
                <h2 className="mb-3 text-sm font-semibold text-qp-navy dark:text-foreground">
                    Merchant dampingan ({merchants.length})
                </h2>

                {merchants.length === 0 ? (
                    <div className="rounded-2xl border border-qp-border bg-white p-6 text-center dark:bg-card">
                        <Store className="mx-auto size-8 text-muted-foreground" />
                        <p className="mt-3 text-sm font-medium">Belum ada merchant dampingan.</p>
                        <p className="mt-1 text-sm text-muted-foreground">
                            Hubungi koordinator program untuk mendapatkan penugasan merchant di pasar Anda.
                        </p>
                    </div>
                ) : (
                    <ul className="space-y-3">
                        {merchants.map((merchant) => (
                            <li key={merchant.id}>
                                <Link
                                    href={show(merchant.id)}
                                    className="block rounded-2xl border border-qp-border bg-white p-4 dark:bg-card"
                                >
                                    <div className="flex items-center justify-between gap-3">
                                        <div className="min-w-0">
                                            <p className="truncate font-semibold">{merchant.name}</p>
                                            <p className="text-xs text-muted-foreground">{merchant.category}</p>
                                        </div>

                                        <div className="flex shrink-0 items-center gap-2">
                                            <StatusChip status={merchant.status} />
                                            <ChevronRight className="size-4 text-muted-foreground" />
                                        </div>
                                    </div>

                                    <div className="mt-3 flex items-center gap-2">
                                        <HabitMeter filled={merchant.tx_in_window} total={habitThresholdTx} className="flex-1" />
                                        <span className="text-xs font-medium text-muted-foreground">
                                            {Math.min(merchant.tx_in_window, habitThresholdTx)}/{habitThresholdTx}
                                        </span>
                                    </div>
                                </Link>
                            </li>
                        ))}
                    </ul>
                )}
            </main>
        </div>
    );
}
