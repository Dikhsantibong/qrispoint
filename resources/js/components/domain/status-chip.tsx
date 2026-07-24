import { cn } from '@/lib/utils';
import { MERCHANT_STATUS_META, type MerchantStatus } from '@/lib/constants';

type StatusChipProps = {
    status: MerchantStatus;
    className?: string;
};

export default function StatusChip({ status, className }: StatusChipProps) {
    const meta = MERCHANT_STATUS_META[status];

    return (
        <span
            className={cn(
                'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold whitespace-nowrap',
                meta.className,
                className,
            )}
        >
            {meta.label}
        </span>
    );
}
