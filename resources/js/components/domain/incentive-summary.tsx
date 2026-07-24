import { formatRupiah } from '@/lib/formatters';

type IncentiveSummaryProps = {
    totalCair: number;
    totalPending: number;
};

export default function IncentiveSummary({ totalCair, totalPending }: IncentiveSummaryProps) {
    return (
        <div className="grid grid-cols-2 gap-3">
            <div className="rounded-2xl bg-qp-gold/15 p-3">
                <p className="text-xs font-medium text-qp-gold">Insentif cair</p>
                <p className="text-xl font-bold tracking-tight text-qp-navy dark:text-qp-gold">{formatRupiah(totalCair)}</p>
            </div>

            <div className="rounded-2xl bg-white/10 p-3">
                <p className="text-xs font-medium text-white/70">Insentif pending</p>
                <p className="text-xl font-bold tracking-tight text-white">{formatRupiah(totalPending)}</p>
            </div>
        </div>
    );
}
