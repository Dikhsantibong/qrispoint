export type MerchantStatus = 'baru' | 'mencoba' | 'hampir' | 'rutin';

/**
 * Presentation only — thresholds and incentive amounts are business rules
 * that live in config/qrispoint.php and are passed to pages as props, never
 * hardcoded here.
 */
export const MERCHANT_STATUS_META: Record<MerchantStatus, { label: string; className: string }> = {
    baru: {
        label: 'Baru',
        className: 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300',
    },
    mencoba: {
        label: 'Mencoba',
        className: 'bg-qp-gold/15 text-qp-gold',
    },
    hampir: {
        label: 'Hampir Rutin',
        className: 'bg-qp-gold/25 text-qp-navy dark:text-qp-gold',
    },
    rutin: {
        label: 'Rutin',
        className: 'bg-qp-green/15 text-qp-green',
    },
};
