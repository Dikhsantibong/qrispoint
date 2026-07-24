import { cn } from '@/lib/utils';

type HabitMeterProps = {
    /** Transactions recorded so far in the habit window. */
    filled: number;
    /** habit_threshold_tx from config/qrispoint.php — segment count. */
    total: number;
    size?: 'sm' | 'lg';
    className?: string;
};

export default function HabitMeter({ filled, total, size = 'sm', className }: HabitMeterProps) {
    const isComplete = filled >= total;
    const segments = Array.from({ length: total }, (_, index) => index < filled);

    return (
        <div
            className={cn('flex gap-1', className)}
            role="img"
            aria-label={`${Math.min(filled, total)} dari ${total} transaksi menuju status rutin`}
        >
            {segments.map((isFilled, index) => (
                <span
                    key={index}
                    className={cn(
                        'flex-1 rounded-full transition-colors',
                        size === 'lg' ? 'h-3' : 'h-1.5',
                        isComplete ? 'bg-qp-green' : isFilled ? 'bg-qp-gold' : 'bg-slate-200 dark:bg-slate-700',
                    )}
                />
            ))}
        </div>
    );
}
