import { Form, Head, Link } from '@inertiajs/react';
import { ArrowLeft, Banknote, QrCode } from 'lucide-react';
import { useState } from 'react';
import HabitMeter from '@/components/domain/habit-meter';
import StatusChip from '@/components/domain/status-chip';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Sheet, SheetContent, SheetDescription, SheetFooter, SheetHeader, SheetTitle } from '@/components/ui/sheet';
import { Spinner } from '@/components/ui/spinner';
import { formatRupiah } from '@/lib/formatters';
import type { MerchantStatus } from '@/lib/constants';
import { dashboard } from '@/routes/agent';
import { storeCashout, storeTransaction } from '@/actions/App/Http/Controllers/Agent/AgentMerchantController';

type Props = {
    merchant: {
        id: number;
        name: string;
        category: string;
        status: MerchantStatus;
    };
    stats: {
        txInWindow: number;
        habitThresholdTx: number;
        totalTx: number;
        todayOmzet: number;
        totalCashout: number;
    };
};

export default function MerchantDetail({ merchant, stats }: Props) {
    const [transactionOpen, setTransactionOpen] = useState(false);
    const [cashoutOpen, setCashoutOpen] = useState(false);

    return (
        <div className="min-h-screen bg-qp-surface pb-10">
            <Head title={merchant.name} />

            <header className="rounded-b-3xl bg-qp-navy px-5 pt-6 pb-8 text-white">
                <Link href={dashboard()} className="mb-4 flex items-center gap-1 text-sm text-white/70">
                    <ArrowLeft className="size-4" />
                    Kembali
                </Link>

                <div className="flex items-center justify-between gap-3">
                    <div className="min-w-0">
                        <h1 className="truncate text-xl font-bold tracking-tight">{merchant.name}</h1>
                        <p className="text-sm text-white/70">{merchant.category}</p>
                    </div>
                    <StatusChip status={merchant.status} />
                </div>

                <div className="mt-6 text-center">
                    <p className="text-6xl font-bold tracking-tight text-qp-gold">
                        {Math.min(stats.txInWindow, stats.habitThresholdTx)}
                        <span className="text-3xl text-white/50"> / {stats.habitThresholdTx}</span>
                    </p>
                    <p className="mt-1 text-xs text-white/70">transaksi menuju status RUTIN</p>
                </div>

                <HabitMeter filled={stats.txInWindow} total={stats.habitThresholdTx} size="lg" className="mt-4" />
            </header>

            <main className="px-5 pt-5">
                <div className="grid grid-cols-3 gap-3">
                    <StatCard label="Total transaksi" value={stats.totalTx.toString()} />
                    <StatCard label="Omzet hari ini" value={formatRupiah(stats.todayOmzet)} />
                    <StatCard label="Tarik tunai" value={stats.totalCashout.toString()} />
                </div>

                <div className="mt-6 space-y-3">
                    <Button className="h-12 w-full justify-start gap-3 bg-qp-navy text-base hover:bg-qp-navy-light" onClick={() => setTransactionOpen(true)}>
                        <QrCode className="size-5" />
                        Catat transaksi QRIS
                    </Button>

                    <Button variant="outline" className="h-12 w-full justify-start gap-3 text-base" onClick={() => setCashoutOpen(true)}>
                        <Banknote className="size-5" />
                        Tarik tunai hari ini
                    </Button>
                </div>
            </main>

            <Sheet open={transactionOpen} onOpenChange={setTransactionOpen}>
                <SheetContent side="bottom">
                    <SheetHeader>
                        <SheetTitle>Catat transaksi QRIS</SheetTitle>
                        <SheetDescription>Masukkan nominal transaksi QRIS yang baru saja terjadi di {merchant.name}.</SheetDescription>
                    </SheetHeader>

                    <Form
                        {...storeTransaction.form(merchant.id)}
                        resetOnSuccess
                        onSuccess={() => setTransactionOpen(false)}
                        options={{ preserveScroll: true }}
                        className="space-y-4 px-4"
                    >
                        {({ processing, errors }) => (
                            <>
                                <div className="grid gap-2">
                                    <Label htmlFor="amount">Nominal (Rp)</Label>
                                    <Input id="amount" name="amount" type="number" min={1000} step={500} required autoFocus placeholder="50000" />
                                    {errors.amount && <p className="text-sm text-qp-red">{errors.amount}</p>}
                                </div>

                                <SheetFooter className="p-0">
                                    <Button type="submit" disabled={processing} className="bg-qp-navy hover:bg-qp-navy-light">
                                        {processing && <Spinner />}
                                        Simpan transaksi
                                    </Button>
                                </SheetFooter>
                            </>
                        )}
                    </Form>
                </SheetContent>
            </Sheet>

            <Sheet open={cashoutOpen} onOpenChange={setCashoutOpen}>
                <SheetContent side="bottom">
                    <SheetHeader>
                        <SheetTitle>Tarik tunai hari ini</SheetTitle>
                        <SheetDescription>Catat nominal penarikan tunai merchant hari ini.</SheetDescription>
                    </SheetHeader>

                    <Form
                        {...storeCashout.form(merchant.id)}
                        resetOnSuccess
                        onSuccess={() => setCashoutOpen(false)}
                        options={{ preserveScroll: true }}
                        className="space-y-4 px-4"
                    >
                        {({ processing, errors }) => (
                            <>
                                <div className="grid gap-2">
                                    <Label htmlFor="cashout_amount">Nominal (Rp)</Label>
                                    <Input id="cashout_amount" name="amount" type="number" min={1000} step={500} required autoFocus placeholder="100000" />
                                    {errors.amount && <p className="text-sm text-qp-red">{errors.amount}</p>}
                                </div>

                                <SheetFooter className="p-0">
                                    <Button type="submit" disabled={processing} className="bg-qp-navy hover:bg-qp-navy-light">
                                        {processing && <Spinner />}
                                        Simpan tarik tunai
                                    </Button>
                                </SheetFooter>
                            </>
                        )}
                    </Form>
                </SheetContent>
            </Sheet>
        </div>
    );
}

function StatCard({ label, value }: { label: string; value: string }) {
    return (
        <div className="rounded-2xl border border-qp-border bg-white p-3 text-center dark:bg-card">
            <p className="text-lg font-bold tracking-tight">{value}</p>
            <p className="mt-0.5 text-[11px] text-muted-foreground">{label}</p>
        </div>
    );
}
